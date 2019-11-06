# owp
apt update && apt upgrade
apt-get install git-core
git config --global user.name "qguillou"
apt-get install nginx
/etc/init.d/nginx start
apt-get install mysql-server
systemctl start mysql
mysql_secure_installation
LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php
apt install php7.3 php7.3-cli php7.3-common php7.3-zip php7.3-mbstring php7.3-xml php7.3-gd php7.3-mysql php7.3-fpm php7.3-intl
apt install wget unzip
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
HASH="$(wget -q -O - https://composer.github.io/installer.sig)"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
mkdir /var/www/quimper-orientation
git clone https://github.com/qguillou/owp.git /var/www/quimper-orientation
cd /var/www/quimper-orientation
git checkout dev
vi .env.local
composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update –force
cd /etc/apache2/sites-availables
vi quimper-orientation.conf
mysql
GRANT ALL PRIVILEGES ON *.* TO 'owp'@'localhost' IDENTIFIED BY 'OWPpassword2019&';
sudo apt-get install curl
sudo apt-get install curl
curl -sL https://deb.nodesource.com/setup_12.x | sudo -E bash – 
apt-get install nodejs
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
apt-get update  
apt-get install yarn
yarn install
yarn add @symfony/webpack-encore –dev
yarn run encore dev
yarn add ckeditor@^4.0.0
php bin/console assets:install public
