#!/usr/bin/env bash
# cloud-init.sh — provision a fresh Debian/Ubuntu VPS for jordan.shurmer.family.
#
# jordan.shurmer.family and shurmer.family share the same server, so this
# script is identical to the shurmer-family repo's cloud-init.sh except
# for the "Web root" section near the bottom, which is site-specific. If you
# change anything above that section, copy the change to the other repo too.
#
# Run as root. Safe to re-run.
# It only needs to be run once (from either repo) to provision the shared
# server for both sites.
set -euo pipefail

log() { echo "[cloud-init] $*"; }

# ── System ────────────────────────────────────────────────────────────────────

log "Updating packages..."
export DEBIAN_FRONTEND=noninteractive
apt-get update -y -q
apt-get upgrade -y -q

# ── PHP 8.5 repo (handles both Ubuntu + Debian) ───────────────────────────────
# The ondrej/php PPA is being merged into packages.sury.org and no longer
# publishes for current Ubuntu releases (404s with "does not have a Release
# file"), so use sury.org for Ubuntu and Debian alike.

if ! php8.5 --version &>/dev/null; then
    . /etc/os-release
    if [ "$ID" = "ubuntu" ] || [ "$ID" = "debian" ]; then
        log "Adding sury.org PHP repo ($ID)..."
        apt-get install -y -q curl ca-certificates apt-transport-https lsb-release gnupg
        curl -sSL https://packages.sury.org/php/apt.gpg | gpg --dearmor -o /usr/share/keyrings/sury-php.gpg
        echo "deb [signed-by=/usr/share/keyrings/sury-php.gpg] https://packages.sury.org/php/ $(lsb_release -sc) main" \
            > /etc/apt/sources.list.d/sury-php.list
        apt-get update -y -q
    fi
fi

# ── Install packages ──────────────────────────────────────────────────────────

log "Installing nginx, PHP 8.5, sqlite3..."
apt-get install -y -q \
    nginx \
    php8.5-fpm \
    php8.5-sqlite3 \
    php8.5-mbstring \
    php8.5-xml \
    php8.5-curl \
    php8.5-cli \
    sqlite3 \
    ufw \
    fail2ban \
    unzip \
    curl

# ── Node.js ──────────────────────────────────────────────────────────────────
# shurmer-family's install.sh runs `npm ci && npm run build` to bundle the
# Svelte/JS frontend (esbuild + esbuild-svelte + svelte), which requires Node >=18.

if ! command -v node &>/dev/null; then
    log "Installing Node.js (NodeSource, 22.x LTS)..."
    curl -fsSL https://deb.nodesource.com/setup_22.x | bash -
    apt-get install -y -q nodejs
fi

# ── Tailscale ────────────────────────────────────────────────────────────────

log "Installing Tailscale..."
if ! command -v tailscale &>/dev/null; then
    curl -fsSL https://tailscale.com/install.sh | sh
fi
systemctl enable tailscaled
systemctl start tailscaled

# Enable Tailscale SSH so tailnet connections authenticate via Tailscale
# identity — no root password or authorized_keys needed over the tailnet.
if tailscale status &>/dev/null; then
    log "Tailscale already authenticated — enabling Tailscale SSH..."
    tailscale set --ssh
elif [ -n "${TS_AUTHKEY:-}" ]; then
    log "Authenticating Tailscale with auth key and enabling Tailscale SSH..."
    tailscale up --ssh --auth-key="$TS_AUTHKEY"
else
    log "Tailscale not authenticated yet — 'tailscale up --ssh' must be run manually (see below)."
fi

# ── Firewall ──────────────────────────────────────────────────────────────────

log "Configuring UFW firewall..."
ufw --force reset
ufw default deny incoming
ufw default allow outgoing
ufw allow ssh  # locked down to Tailscale only after 'tailscale up'
ufw allow 'Nginx Full'
ufw --force enable

# ── nginx ─────────────────────────────────────────────────────────────────────

log "Configuring nginx..."

# Remove default site — other sites will live in sites-available/sites-enabled
rm -f /etc/nginx/sites-enabled/default

# Tune nginx worker count to match CPU cores
CORES=$(nproc)
sed -i "s/^worker_processes.*/worker_processes $CORES;/" /etc/nginx/nginx.conf

# ── Web root ──────────────────────────────────────────────────────────────────
# This is the only site-specific section — the rest of this script is shared
# byte-for-byte with the shurmer-family repo's cloud-init.sh.

log "Creating web root and partials directory..."
mkdir -p /var/www/jordan.shurmer.family/html
chown -R www-data:www-data /var/www/jordan.shurmer.family
mkdir -p /usr/local/share/php/partials

# ── PHP-FPM ───────────────────────────────────────────────────────────────────

log "Configuring PHP-FPM..."

# Increase upload/execution limits
PHP_INI="/etc/php/8.5/fpm/php.ini"
sed -i 's/^upload_max_filesize.*/upload_max_filesize = 32M/' "$PHP_INI"
sed -i 's/^post_max_size.*/post_max_size = 32M/'             "$PHP_INI"
sed -i 's/^max_execution_time.*/max_execution_time = 60/'    "$PHP_INI"

# jordan.shurmer.family includes its partials as "jordan/global_head.php"
# (not a relative path), which requires /usr/local/share/php/partials on the
# include_path. Both sites share this one php.ini, so set it here once rather
# than each site's install.sh installing/overwriting the whole file.
sed -i 's|^;\?include_path.*|include_path = ".:..:../..:/usr/local/share/php/partials"|' "$PHP_INI"

# ── Services ──────────────────────────────────────────────────────────────────

log "Enabling and starting services..."
systemctl enable nginx php8.5-fpm fail2ban
systemctl restart nginx php8.5-fpm fail2ban

# ── Done ──────────────────────────────────────────────────────────────────────

log ""
log "✓ Provisioning complete."
log ""
log "  Installed:"
nginx -v 2>&1 | sed 's/^/    /'
php8.5 --version | head -1 | sed 's/^/    /'
sqlite3 --version | sed 's/^/    sqlite3 /'
node --version | sed 's/^/    node /'
npm --version | sed 's/^/    npm /'
log ""
if tailscale status &>/dev/null; then
    log "  Tailscale is up with Tailscale SSH enabled — connect with:"
    log "    ssh root@\$(tailscale ip -4)  (no password needed over the tailnet)"
    log ""
    log "  !! ACTION REQUIRED: lock down public SSH:"
    log "    ssh root@<tailscale-ip> ufw delete allow ssh"
else
    log "  !! ACTION REQUIRED: authenticate Tailscale (with SSH), then lock down public SSH:"
    log ""
    log "  1. ssh root@<server-ip> tailscale up --ssh"
    log "  2. ssh root@<tailscale-ip> ufw delete allow ssh"
fi
log ""
log "  After removing the ufw rule, SSH is only reachable over Tailscale,"
log "  authenticated by Tailscale identity — no root password required."
log "  Then run each site's ./deploy.sh from your local machine."
