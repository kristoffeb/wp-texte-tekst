
if [ ! -d "frontend/wp-admin" ]; then
	echo 'Installing WordPress (release version) in wp-texte-tekst/frontend...'
	if [ ! -d "./frontend" ]; then
		mkdir ./frontend
	fi
	cd ./frontend
	wp core download --locale=en_US --allow-root
	wp core config --dbname="wp-texte-tekst" --dbuser=wp --dbpass=wp --dbhost="localhost" --dbprefix=wp_ --locale=en_US --allow-root --extra-php <<PHP
define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', false);
define('WP_DEBUG_LOG', true);
define('SCRIPT_DEBUG', true);
define('JETPACK_DEV_DEBUG', true);
PHP
	wp core install --url=wp-texte-tekst.test --title="wp-texte-tekst" --admin_user=admin --admin_password=password --admin_email=admin@localhost.dev --allow-root
	curl -s https://raw.githubusercontent.com/manovotny/wptest/master/wptest.xml > import.xml && wp plugin install wordpress-importer --allow-root  && wp plugin activate wordpress-importer --allow-root  && wp import import.xml --authors=skip --allow-root && rm import.xml

  wp theme delete twentythirteen --allow-root; wp theme delete twentyfourteen --allow-root; wp theme delete twentyfifteen --allow-root; wp theme delete twentysixteen --allow-root; wp plugin delete hello --allow-root; wp plugin delete akismet --allow-root; git checkout HEAD .



	cd -

fi
