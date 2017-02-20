<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'database_name_here');

/** MySQL database username */
define('DB_USER', 'username_here');

/** MySQL database password */
define('DB_PASSWORD', 'password_here');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Y5gbcG`WdZzuu &c=#!0R+7WE1!I{GKh&3-g-J1*oD3I<~jHC=!tW=-ics:tX:8z');
define('SECURE_AUTH_KEY',  'hi;C)2+vtEl;C2zMi[Cfz{PD4MfPS~w-&A<j+xQ3_B~:|7%SJ7inaIM.-2+|Z,it');
define('LOGGED_IN_KEY',    'lC:QZknrxIRz(v//|S=oZ[M9<vn}t7P5-)IJz~yp:jIQ-+N;QpB-qIOf%}$6+8:*');
define('NONCE_KEY',        'mfH.Ew,os>s.HC9-oH+6T/s1O]OeGE5~V2gsuAR&$d#HUKpWW+^-M-)h6Q4jP ro');
define('AUTH_SALT',        'J>yAAZYx.i.<lEz%iP$+0(.8x#+-9`|-t)Ic(egGfp&QZk<+-[k0<C|=kLhM`T*v');
define('SECURE_AUTH_SALT', 'H:ccAeE<W}HxPA:P*/zVo(5y+{3oEpaRXc(92LQ65B1^>^=@(+i),oGPe}djnsu@');
define('LOGGED_IN_SALT',   'S&0O<9oHwk05Kem<$kXX-70s!FRTLS/}1D0}IC-|9y?#I9Nrr%@_`(yviOL|[oyk');
define('NONCE_SALT',       'Zy|,gW$K9L*Feuf*x GW*d@loEC|>j+_gQKs[7I,uFGL[zf>M:=QnDwU@D9>|6t:');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ct_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', 'et');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* Multisite */
define( 'WP_ALLOW_MULTISITE', true );

define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'ct.avocado.dev');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

// Source: https://premium.wpmudev.org/blog/move-multisite-new-domain/

define('WP_HOME','http://ct.avocado.dev');
define('WP_SITEURL','http://ct.avocado.dev');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
