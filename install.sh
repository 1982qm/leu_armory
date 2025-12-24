rm -rf /var/www/html/armory/css/*
rm -rf /var/www/html/armory/database/*
rm -rf /var/www/html/armory/img/*
rm -rf /var/www/html/armory/js/*
rm -rf /var/www/html/armory/lib/*
rm -rf /var/www/html/armory/php/*
rm -rf /var/www/html/armory/*.*
cp -r * /var/www/html/armory
cp favicon.ico /var/www/html/
chown -R www-data:www-data /var/www/html/armory/
