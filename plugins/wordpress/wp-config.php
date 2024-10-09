<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpressX' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'M][[+{lxA)IAZV.J^_z+#6(VhIJ-^Ksbo,*y}!r3hci7f0);p-3N>Clbnwt&tt(!' );
define( 'SECURE_AUTH_KEY',  '8h+I9Rf~B=<lix]R=LQ/h2][oQf4@vx+C;2bbs&B,K_XJ0]#&:z&eWzCG;Mh+Wo[' );
define( 'LOGGED_IN_KEY',    '%2iwgr^XAAU*l_)rK`5o$zd:^L4H.2[b|id0!/|4QXGr&b5Ln[-XAJMG&@kx<Oh]' );
define( 'NONCE_KEY',        '#9zA]ILtP6QoZ/P=pd!MD0GSU#y&Zi73kEE[wKWaF,3z](Mx^=*oJ25gs7gXn3-4' );
define( 'AUTH_SALT',        'T}$ i{zFA(_y<huh12i{VH XFDD.{ndt:o>*j:EW5Bfp&~$t!&YG@1UUlQYHYu%7' );
define( 'SECURE_AUTH_SALT', 'PW$a.glHWZwrRg*)lMY&6$.=CUef`eWT?,74U8geI(1Sy>8EHp(r=!i~BK-!SFN`' );
define( 'LOGGED_IN_SALT',   'iXfoSORT%v;3/HkggnR_M7}p2+f)qu|e)_-D*_(qP0Do(c/Rny7+;j[t/6sV*m^,' );
define( 'NONCE_SALT',       'Qm=)m6kd6 5`-Kj$U04eI=pj+(n}seo[~t}lFQze0acy>u0[wO<f^}8>`:,UtwPE' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
