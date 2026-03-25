#### Installazione
sudo apt install apache2 -y
sudo apt install sqlite3
sudo apt install php php-sqlite3

#### Encrypt Password
<?php
echo hash('sha512', 'pwd');
?>
