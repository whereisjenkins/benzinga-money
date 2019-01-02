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
define('DB_NAME', 'benzingamoney');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'V}T1@<KAN2%BGN@]&Ar9~pW1qAS~dWnZS0--hQtVuP&A[b~p,YxTsZP~90l1L[CR');
define('SECURE_AUTH_KEY',  ':4EfqJ*t[9s6+:OiZQW?56#}rA6J^+}oK9qL/rMOA[HXy$gva+(Z$_LPaXa{Eojp');
define('LOGGED_IN_KEY',    'aRd_7Pu]Qst.~%_mXe8fe3: M.W-pl;%)wA1QC!h#y.]6A;/y~Uo0z4^_kWK8{an');
define('NONCE_KEY',        'zUIUb8un%.8Z~k~/|uaYZm=+**`Qm*/5a)XPq!ef|`37AY%Nbl$+Jd/1x;5H^OfG');
define('AUTH_SALT',        '[DOtn|C57D]T ^hgjJ+(NhhuX{!|x0[*{jXW2WdN2?SMmZpn~o0%A_MM2++YN ^,');
define('SECURE_AUTH_SALT', '-QC~tZnw}fQ9+|GZVjR*9gCxq64 KLjSR_WlA9_B673}SOaP2C)^w<|cV+&KM)&_');
define('LOGGED_IN_SALT',   'P_Kt^[rX9<fYWA=K!@>rWcP98VJ p?]5aMnwl#MLc+3[ER[=w)n3s! =IDq.NdF^');
define('NONCE_SALT',       '$dw}sOJ5[n>l;[}5_C1<%1^(L9RO;+e($g,YDqfNo+yW )^Js1|wncZq$wrDpILL');

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
