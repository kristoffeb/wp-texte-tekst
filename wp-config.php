<?php


// ** MySQL settings ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp-texte-tekst');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('AUTH_KEY',         'auE)K?afv2|D]LgdJDDTyj^k9+o KV90^oQJr,6y/pG-h3o++?07T+$w;WT8$I}Z');
define('SECURE_AUTH_KEY',  'L.Pi,ME-J567l!}o[mvs1X.+-n+<<=z]*7QNL&3t-ew(No,^@G3eZvCbPZp9r=Y ');
define('LOGGED_IN_KEY',    '*W(in8P~t(kMYOxvXsa8H }h4$b%|d*qbzsls|^GG!{9Eeqn_9M-1+Vc0MDmfTu1');
define('NONCE_KEY',        'R7s4{p}cYS%c4k ?=4`TFvSqRdt!K&!2GeM)y?`4-6H&M`]C|b;eRD1m= n8R4A1');
define('AUTH_SALT',        '|+`ld(%HL3}1b0-w_ljqtfm_PX.-$Lh=!jl09w[U?M:%(rLqtl|LR7}M(Edmkr=g');
define('SECURE_AUTH_SALT', 'rUTZeD}QYy>/1xee4 O=IT#X7#--&aO(Nbc?}+zcre3C2UZ8:|0ETbKex/U=7J^b');
define('LOGGED_IN_SALT',   'fGVUGi.7#jVYazwHJmBTbq(gKA2E}5JUo4]|~cNdCSO[+z`F]n|kzeMq,m2<;aa/');
define('NONCE_SALT',       'Hs76_OXE9V:SqF{*;s~3G(j03_,zd;A_jZW`yZ|5XjVyd^KM,n-B0G|sOn^t+a=F');


$table_prefix = 'wp_';


define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', true);
define('WP_DEBUG_LOG', true);
define('SCRIPT_DEBUG', true);
define('JETPACK_DEV_DEBUG', true);

// Move content directory
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/wp-content' );


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
