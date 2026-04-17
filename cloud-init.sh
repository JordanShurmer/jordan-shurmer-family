#!/usr/bin/env bash
# cloud-init.sh — provision a fresh Debian/Ubuntu VPS for jordan.shurmer.family
# Run as root. Safe to re-run.
set -euo pipefail

log() { echo "[cloud-init] $*"; }

# ── System ────────────────────────────────────────────────────────────────────

log "Updating packages..."
export DEBIAN_FRONTEND=noninteractive
apt-get update -y -q
apt-get upgrade -y -q

# ── PHP 8.4 repo (handles both Ubuntu + Debian) ───────────────────────────────

if ! php8.4 --version &>/dev/null; then
    . /etc/os-release
    if [ "$ID" = "ubuntu" ]; then
        log "Adding ondrej/php PPA (Ubuntu)..."
        apt-get install -y -q software-properties-common
        add-apt-repository -y ppa:ondrej/php
        apt-get update -y -q
    elif [ "$ID" = "debian" ]; then
        log "Adding sury.org PHP repo (Debian)..."
        apt-get install -y -q curl ca-certificates apt-transport-https lsb-release gnupg
        curl -sSL https://packages.sury.org/php/apt.gpg | gpg --dearmor -o /usr/share/keyrings/sury-php.gpg
        echo "deb [signed-by=/usr/share/keyrings/sury-php.gpg] https://packages.sury.org/php/ $(lsb_release -sc) main" \
            > /etc/apt/sources.list.d/sury-php.list
        apt-get update -y -q
    fi
fi

# ── Install packages ──────────────────────────────────────────────────────────

log "Installing nginx, PHP 8.4..."
apt-get install -y -q \
    nginx \
    php8.4-fpm \
    php8.4-mbstring \
    php8.4-xml \
    php8.4-curl \
    php8.4-cli \
    ufw \
    fail2ban \
    unzip \
    curl

# ── Tailscale ────────────────────────────────────────────────────────────────

log "Installing Tailscale..."
curl -fsSL https://tailscale.com/install.sh | sh
systemctl enable tailscaled
systemctl start tailscaled

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

# Remove default site
rm -f /etc/nginx/sites-enabled/default

# Tune nginx worker count to match CPU cores
CORES=$(nproc)
sed -i "s/^worker_processes.*/worker_processes $CORES;/" /etc/nginx/nginx.conf

# ── Web root ──────────────────────────────────────────────────────────────────

log "Creating web root and partials directory..."
mkdir -p /var/www/jordan.shurmer.family/html
chown -R www-data:www-data /var/www/jordan.shurmer.family
mkdir -p /usr/local/share/php/partials

# ── PHP-FPM ───────────────────────────────────────────────────────────────────

log "Configuring PHP-FPM..."

PHP_INI="/etc/php/8.4/fpm/php.ini"
sed -i 's/^upload_max_filesize.*/upload_max_filesize = 32M/' "$PHP_INI"
sed -i 's/^post_max_size.*/post_max_size = 32M/'             "$PHP_INI"
sed -i 's/^max_execution_time.*/max_execution_time = 60/'    "$PHP_INI"

# ── Services ──────────────────────────────────────────────────────────────────

log "Enabling and starting services..."
systemctl enable nginx php8.4-fpm fail2ban
systemctl restart nginx php8.4-fpm fail2ban

# ── Done ──────────────────────────────────────────────────────────────────────

log ""
log "✓ Provisioning complete."
log ""
log "  Installed:"
nginx -v 2>&1 | sed 's/^/    /'
php8.4 --version | head -1 | sed 's/^/    /'
log ""
log "  !! ACTION REQUIRED: authenticate Tailscale, then lock down SSH:"
log ""
log "  1. ssh root@<server-ip> tailscale up"
log "  2. ssh root@<tailscale-ip> ufw delete allow ssh"
log ""
log "  After step 2, SSH is only reachable over Tailscale."
log "  Then run ./deploy.sh from your local machine."
