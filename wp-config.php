<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "xv460566_db" );

/** Database username */
define( 'DB_USER', "xv460566_db" );

/** Database password */
define( 'DB_PASSWORD', "XtYyBsWt" );

/** Database hostname */
define( 'DB_HOST', "xv460566.mysql.tools" );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '0khphkfz3gm5tdx7w9wrh3bv5dtofrkvxmddjos6zt4zpsdzeesx22zfzvnbzimr' );
define( 'SECURE_AUTH_KEY',  'nekuujeqaxqfr37qgzt9bokoq2fetkt2gvqukzgoegovnlmq4xmzmgztxbm7odqt' );
define( 'LOGGED_IN_KEY',    'gswj6gqk2wnpc8lz2bcgjgrniyhcj8uobdtshzcwg9fqb098pabeb8zdwzkf4w50' );
define( 'NONCE_KEY',        'brkrnc2uf5nzj7sqysxa0epdzryixp0hthstfwq11aczaxav46qtwapnse9klct9' );
define( 'AUTH_SALT',        'go6jtexlugfgw7nmo7ap0ucclnuknyzoswicmmj0kbi0hcp9joq4e2xguktpgck6' );
define( 'SECURE_AUTH_SALT', 'tvqqvz4eybexpktyiebwrdoe6kbcnwaqnwtymaqcwphykzn9skq6uprzvcmbfzen' );
define( 'LOGGED_IN_SALT',   '1n61wdxpxlqdwbylxftip6bu5cunmpbs8qfiiv2jieid0bpyx7nox5mzdkwq09da' );
define( 'NONCE_SALT',       'wmrwmmfx8j8j4ysrsbhgadsolckwi7budlxc4g94ihzphs8zdspq1kmpnl33ezll' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpqp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';


