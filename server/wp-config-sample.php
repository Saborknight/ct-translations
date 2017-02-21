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
define('DB_NAME', 'ct_dev2');

/** MySQL database username */
define('DB_USER', 'ct_dev');

/** MySQL database password */
define('DB_PASSWORD', 'password_here');

/** MySQL hostname */
define('DB_HOST', '18fd2.webhost.ee');

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
define('AUTH_KEY',         'd5Bq%Nd^&4l?e&|qE]se;n7=At<cFR;!m%}V$x -j+-(Tm3*S%e-Ejo UL0V25[h');
define('SECURE_AUTH_KEY',  'I@s;&#km,4|1_#*red?}svr}Ure$i2*75nFD4CyxHFqnv,zjdf|P8p$8}SV**w@q');
define('LOGGED_IN_KEY',    '|YdX2M]SBekdWp`0qWp.(Pxt%58Brs]a]zcA4V14e6v!*9LgIe# jOjjV?UHnP=u');
define('NONCE_KEY',        'h6c@@}pB>9`Olb1y xa/LvM}Sy:%5S_O+# =**lO-dL}-Sl8m+Qm/u$w;|wt%?;}');
define('AUTH_SALT',        '{z|S,hTMA>A-Ya:geKFoUV4f-zO^u|j!c{[uO&u-|yeRw,*+-@|~QEV@4c&?K!9(');
define('SECURE_AUTH_SALT', 'bz7Od,ZOk89=S^ 73Z;2@.[gyp}j]y@gP+8o2go%?*dY++ECw x3d&:;Qum}*JL.');
define('LOGGED_IN_SALT',   'QgOD?}MF?XN7;rWCUlSKC!rhBb;?fNDKIh0h|t[[jZHxt@=+^^bjF I+| 2HMrt_');
define('NONCE_SALT',       '4fS%o.vpkjUm9@O?+i%A#}ceR R5Ewt2(J|jk%w4O-.ZF`WzhOEkOFaS%G:PMN$,');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ct_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
