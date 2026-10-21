#!/usr/bin/env bash
set -euo pipefail

SERVER="${SERVER:-root@shurmer-family-2}"  # Tailscale MagicDNS hostname, shared with shurmer.family
REMOTE_WEBROOT="/var/www/jordan.shurmer.family/html"
REMOTE_PARTIALS="/usr/local/share/php/partials/jordan"
NGINX_AVAILABLE="/etc/nginx/sites-available/jordan.shurmer.family"
NGINX_ENABLED="/etc/nginx/sites-enabled/jordan.shurmer.family"

echo "→ Creating remote directories..."
ssh "$SERVER" "mkdir -p '$REMOTE_WEBROOT' '$REMOTE_PARTIALS'"

echo "→ Syncing content to $SERVER..."
rsync -az --delete \
    content/ "$SERVER:$REMOTE_WEBROOT/"

echo "→ Syncing partials to $SERVER..."
rsync -az --delete \
    partials/ "$SERVER:$REMOTE_PARTIALS/"

echo "→ Uploading nginx config..."
rsync -az config/nginx.conf "$SERVER:$NGINX_AVAILABLE"

echo "→ Configuring server..."
ssh "$SERVER" bash <<'REMOTE'
set -euo pipefail

WEBROOT="/var/www/jordan.shurmer.family/html"

# keep PHP on the newest 8.5.x: apt installs these if missing and upgrades them
# when sury.org has a newer build (8.5.12 closed two remote code execution holes)
export DEBIAN_FRONTEND=noninteractive
apt-get update -q
apt-get install -y -q php8.5-fpm php8.5-mbstring php8.5-xml php8.5-curl php8.5-cli

# php.ini is shared with shurmer.family on this server and is set up once by
# cloud-init.sh (include_path, upload limits), so it is not uploaded here.

mkdir -p "$WEBROOT"
chown -R www-data:www-data /var/www/jordan.shurmer.family
mkdir -p /usr/local/share/php/partials

# Enable site via symlink (idempotent; also replaces a plain file left by install.sh)
ln -sfn /etc/nginx/sites-available/jordan.shurmer.family /etc/nginx/sites-enabled/jordan.shurmer.family

# Ensure php-fpm is running
if ! systemctl is-active --quiet php8.5-fpm; then
    systemctl start php8.5-fpm
    echo "  php8.5-fpm started"
fi

systemctl reload php8.5-fpm
nginx -t && systemctl reload nginx
echo "  nginx reloaded"
php8.5 --version | head -1
REMOTE

echo "✓ Deploy complete → http://jordan.shurmer.family"
