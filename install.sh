# install (i.e. copy) the config files
install -D ./config/php.ini-production /etc/php/8.4/fpm/php.ini
install -D ./config/nginx.conf /etc/nginx/sites-enabled/jordan.shurmer.family

# mount the content directories
mkdir -p /var/www/jordan.shurmer.family/html
mount --bind $(pwd)/content /var/www/jordan.shurmer.family/html
mkdir -p /usr/local/share/php/partials/jordan
mount --bind $(pwd)/partials /usr/local/share/php/partials/jordan

# restart the servers
systemctl restart php8.4-fpm
systemctl restart nginx
