# keep PHP on the newest 8.5.x: apt installs these if missing and upgrades them
# when sury.org has a newer build (8.5.12 closed two remote code execution holes)
export DEBIAN_FRONTEND=noninteractive
apt-get update -q
apt-get install -y -q php8.5-fpm php8.5-mbstring php8.5-xml php8.5-curl php8.5-cli

# install (i.e. copy) the config files
# php.ini is shared with shurmer.family on this server and is set up once by
# cloud-init.sh (include_path, upload limits), so it is not installed here.
install -D ./config/nginx.conf /etc/nginx/sites-enabled/jordan.shurmer.family

# mount the content directories
mkdir -p /var/www/jordan.shurmer.family/html
mount --bind $(pwd)/content /var/www/jordan.shurmer.family/html
mkdir -p /usr/local/share/php/partials/jordan
mount --bind $(pwd)/partials /usr/local/share/php/partials/jordan

# restart the servers
systemctl restart php8.5-fpm
systemctl restart nginx

# say which PHP the deploy left running, so the run log shows the patch level
php8.5 --version | head -1
