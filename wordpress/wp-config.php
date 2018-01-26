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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'oracle');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'W jHf=]nA;uHx+JIAbq y3vOTTa7>Y6*Z&vJ{XueS_uYicE#RoM.kCx4laB/o^cf');
define('SECURE_AUTH_KEY',  'eg]&6#w$Ng/*|=z~`!ZN@ADxGU)!I(-bLnYJMEnzi?_QnKrnq?z0L^<z/f=mGxBF');
define('LOGGED_IN_KEY',    'JTR;o%s4[BQ lh ?$uvtY(?n5;3-oa-K`SW/Dj[8(jAKqK>rw>#EYU3f.-[m0KJz');
define('NONCE_KEY',        'U|.nc7,M}Iz{-Zqy!6in,4:Q(H7LXl gi2Kk}{@UzbPBDTG|AAC/bYp_cckP(;qQ');
define('AUTH_SALT',        '(+x$+<oM@OkE&:HxY zW%B3iW(}a4_8wvgi;}iF{%~~p-#-y zej7zxAEjTd(4+$');
define('SECURE_AUTH_SALT', 'f60q[%!3J/-[6PjGS.!~4Hd|i7;[y82_/pCDCHBdTmBxwP)XMeRI-.rZ_BSog}+}');
define('LOGGED_IN_SALT',   'kLI@/,N[dGC+G3(?p;,|wP[?5;8=VcYUK0A=$,uO]vXFItD3{OBpb_H3I.-pJ1I.');
define('NONCE_SALT',       '_{=aQ#xi`e}H^4pWA<-X#E<7{N%[//`nWe;>WoPsF;XqP8<OV{il^;7Nspno%(DI');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
