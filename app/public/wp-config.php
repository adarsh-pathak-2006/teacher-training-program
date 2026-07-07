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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'g=VA+2jC#&&:m[>I2I9RKH6gRe8D~>x?Y8K0>j~uET+ilg/9*d/s*6e3!o-cJ1S+' );
define( 'SECURE_AUTH_KEY',   '5g]gQ#2[|pBEx2{73`bW:L[t6Bq3*+;~jrInEMon[,M1oU  d]a!0xl)dB6HRy|q' );
define( 'LOGGED_IN_KEY',     '~*jJMn(XbJrX_B(~iVj`[cxuemX65r4[ej91y]y,wI;uSb]*iG*1wymhTV?s39i1' );
define( 'NONCE_KEY',         'vIn9uM^1= nh(e,{7ybYwg5j*.vtor&*BnT0OS*;qop:=A:~#rHmw.!OfNc>m-P(' );
define( 'AUTH_SALT',         'fXzf-14[Bu<MGz|&Kb=BNl:{CJq}4|q1`,U~!J]Ph%BF$R,vr$4;/Rq8w_RM)|=0' );
define( 'SECURE_AUTH_SALT',  'b:IK}<Z~8c;bD=%fT6B}%DW6/T%`iUW)@GNXvB*F$/X@i&tNzE00QH:#wlC_1}tQ' );
define( 'LOGGED_IN_SALT',    'Z!V2xr[y X_L<f Fz<Q@OZ)#}=zpHd]y0e8/-8+,h@$W(<8/:T@oa/wi!>|cPNE8' );
define( 'NONCE_SALT',        '6#mZ_rn{C8l+.f w ;,rOEwuO5xM+oYwp,:./NMC3nJAUFaAS9~(:46N~n3=?:rv' );
define( 'WP_CACHE_KEY_SALT', 'Y:Tty%P~T`:pn{aC;&cd. ?9 nC7hj.:xE/H@A?&mzKVNjY<8h;!xrxns{y|3Nj+' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
