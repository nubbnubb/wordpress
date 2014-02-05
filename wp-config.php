<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp');

/** MySQL database username */
define('DB_USER', 'wordpress');

/** MySQL database password */
define('DB_PASSWORD', 'wordpress');

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
define('AUTH_KEY',         '9l2>Mg;fdJ:[G#<B`YP#QyU}r.Pv;R!=5t5EnOk`C,N!z}H9]^WXX6=h>mE6{)DL');
define('SECURE_AUTH_KEY',  'nF@Gj~kH E`l;A)tJ+/z9k12i,drEp=&V($lHp(}m,+6+wMGVH!l!$cVbXJ:D/g$');
define('LOGGED_IN_KEY',    'R&f$E_vi&-;EVEXTT4t&46$bX<]~VPjSH-0kWfJms!|R+J`AI;%?T1/LxvN!/+_7');
define('NONCE_KEY',        '=/v_B*4kmf$[)^y;;8b-mNxlj47GYVoHOrMWGSb~u@3rx<rvh[8qEBRSA#jYrK},');
define('AUTH_SALT',        'BA-S<~c=d$jclGjZnc}aAdx|Df9CRHV%r+B}JarJxVM)x}vD|B*05GlHFR|M W-W');
define('SECURE_AUTH_SALT', 'ZKd FH >Z$Eoq-Hz`w[PX1|VQ}f8l!I}--g<rbR])pfr-yf9,gxtGstoI!+PirBx');
define('LOGGED_IN_SALT',   'A4r*ahY~wpql#ic,)mS5ckAUp|mFy~#9[YrFmkLLlHOzm,[nLi#fOL^~V7j3B>9=');
define('NONCE_SALT',       'Uap{2{21CeyJ.B&HIw==>Cm+y?<+.MICVb?%u9E?2CQj&`q,3fy^j15J6DAOUphf');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
