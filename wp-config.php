<?php
define( 'WP_CACHE', false ); // Added by WP Rocket

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
define( 'DB_NAME', 'leyva_1717751275' );

/** Database username */
define( 'DB_USER', 'leyva_1717751275' );

/** Database password */
define( 'DB_PASSWORD', 'gAp8n2U1jKUgCwzxIaEcJwZFfXrJLjqCoC3JOEJ3Tfe79vlXyIq0o' );

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
define( 'AUTH_KEY',          'rZZNwOTgA8G,R=/+ETDD/NZ42j_fJcS.kRq5Cr`>lO ohe?I kp-TS_r1uLLNYv]' );
define( 'SECURE_AUTH_KEY',   'g9Ax}?>`t<sQ`@Bxsz14sv]LX?3;+BHq85hSu.nT8k?p@3rY?~}PTd,R]_=ZCR9v' );
define( 'LOGGED_IN_KEY',     'V5P[0Uo>-.4?Fd6+hykHkjcLHu2(nYith;ciFcjR1hbQ$<S-ehM0f~7{|JT ?nys' );
define( 'NONCE_KEY',         'jZwRfX)%xH!X[7OrJ&]4ePHkf=Z`.e,l,R1LH^6*M3+KEY3%AW4:/{478#jld4+n' );
define( 'AUTH_SALT',         've5%*OeBG-5+a[g^n&O/Hm>GeXG`hpSG&0 x9ZxCl$H&j[hHk c.RnD![h=HD+_N' );
define( 'SECURE_AUTH_SALT',  '%lq[E8~jd*JeE/z0:du}Hpl|`5*5(15!uir=JOnP)I6%u4XL19M1+6[s#~jn&*y:' );
define( 'LOGGED_IN_SALT',    '|;v}$hb~XMTt+@M?sN@T^tWN)jf3o~^nxO]wND}GDkfC>?z^D--oN:VJzi}X^T73' );
define( 'NONCE_SALT',        '+4Vdw1T:R#UF{)}gJ93nG/zF%%}66fP=NTr{9CQD{v:;|epP9x60uT JWjF&MWb4' );
define( 'WP_CACHE_KEY_SALT', '#Y0L/f3b^Ks{QwD3BoPLT{`+cgm]2n?gws|%>lE*K8J:sQj>sc6(ToC%]]+t}p|9' );


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

define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );
define( 'SCRIPT_DEBUG', true );
define( 'WP_DEBUG_LOG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
