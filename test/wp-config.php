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
define('DB_NAME', 'test');

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
define('AUTH_KEY',         'S424> QXKM<vEn8k4J*rDM.MzF?9Dsk3NvAj;~-$;hJXnnEx)?c{6@SNSykYOYJ#');
define('SECURE_AUTH_KEY',  'D+_{T-w,m:q*d9{`<(Z.EP=|A|Sbm^x|] ,1SYeXc%#^o.a+9)!VpIA{^>EfE!wD');
define('LOGGED_IN_KEY',    '3}15,0k`&S_q#QahC_i,y`I{Z{!d8uxS,a%:_i`}Qe-;RC^>Ua!AJ(ls;]DVUh@w');
define('NONCE_KEY',        '~Ll8!7DRJ?OpskY>T[0lq7uTc%yF`sz??K1p)jCemG<(?Rm)UVHR|s2x3PE;g`0.');
define('AUTH_SALT',        'N1NiyxN /}ChDbBcIv|2A$DerF[|v:06Fw7w- 6!]v6z+;ekHb7yW-@,KdQg9*r8');
define('SECURE_AUTH_SALT', 'I=D<:Pexvno)&hv@8N:zDp/^^2}>}uKSi~S~s,%/c](2zbd|a:s]@l[*1:Uv[dv`');
define('LOGGED_IN_SALT',   '/,Ht]M{YY!17IXD|5$Tv(uwX^^FeA_#98JQ`?_ `:|`DA>]EUa8|:I<b5QY4TO!`');
define('NONCE_SALT',       ';N%6?<jwy,*zt<H<6L5_@*n9TPO**B;|*5-f)$nxOh8l-8^_!?NZ]dGHiKd!X&)b');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'p1_';

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
