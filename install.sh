rm -rf /var/www/html/leu/css/*
rm -rf /var/www/html/leu/database/*
rm -rf /var/www/html/leu/img/*
rm -rf /var/www/html/leu/js/*
rm -rf /var/www/html/leu/lib/*
rm -rf /var/www/html/leu/php/*
rm -rf /var/www/html/leu/*.*
cp -r * /var/www/html/leu
cp favicon.ico /var/www/html/
chown -R www-data:www-data /var/www/html/leu/
