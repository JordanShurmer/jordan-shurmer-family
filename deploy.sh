#!/usr/bin/env bash
set -euo pipefail

SERVER="${SERVER:-root@hetzner-1}"  # Tailscale MagicDNS hostname
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

echo "→ Uploading php.ini..."
rsync -az config/php.ini-production "$SERVER:/etc/php/8.3/fpm/php.ini"

echo "→ Configuring server..."
ssh "$SERVER" bash <<'REMOTE'
set -euo pipefail

WEBROOT="/var/www/jordan.shurmer.family/html"

mkdir -p "$WEBROOT"
chown -R www-data:www-data /var/www/jordan.shurmer.family
mkdir -p /usr/local/share/php/partials

# Enable site via symlink (idempotent)
if [ ! -L /etc/nginx/sites-enabled/jordan.shurmer.family ]; then
    ln -s /etc/nginx/sites-available/jordan.shurmer.family /etc/nginx/sites-enabled/jordan.shurmer.family
    echo "  site enabled in nginx"
fi

# Ensure php-fpm is running
if ! systemctl is-active --quiet php8.3-fpm; then
    systemctl start php8.3-fpm
    echo "  php8.3-fpm started"
fi

systemctl reload php8.3-fpm
nginx -t && systemctl reload nginx
echo "  nginx reloaded"
REMOTE

echo "✓ Deploy complete → http://jordan.shurmer.family"
