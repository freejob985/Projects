<?php
/**
 * process.php
 * 
 * هذا الملف مسؤول عن إنشاء موقع WordPress جديد، بما في ذلك:
 * - نسخ ملفات WordPress إلى مجلد جديد
 * - إنشاء قاعدة بيانات جديدة
 * - تحديث إعدادات WordPress في قاعدة البيانات
 * - إنشاء ملف التكوين wp-config.php
 *
 * المدخلات:
 * - $_POST['site_name']: اسم الموقع الجديد
 * - $_POST['database']: اسم قاعدة البيانات الجديدة
 * - $_POST['explain_']: وصف الموقع
 *
 * المخرجات:
 * - رسالة نجاح مع رابط للوحة تحكم WordPress الجديدة، أو رسالة خطأ
 *
 * التبعيات:
 * - PHP 7.0+
 * - PDO extension
 * - MySQL/MariaDB
 *
 * @author Your Name
 * @version 1.0
 */

// تعيين إعدادات PHP لتحسين الأداء والأمان
ini_set('display_errors', 'Off');
ini_set('log_errors', 'On');
ini_set('error_log', 'D:/server/htdocs/error_log.txt');
ini_set('max_execution_time', 300);

/**
 * دالة لكتابة المحتوى إلى ملف
 *
 * @param string $file_path مسار الملف
 * @param string $content المحتوى المراد كتابته
 * @return string رسالة نجاح أو فشل العملية
 */
function writeToFile($file_path, $content)
{
    $result = file_put_contents($file_path, $content);
    return ($result !== false) ? "تمت الكتابة في الملف بنجاح." : "حدث خطأ أثناء محاولة الكتابة في الملف.";
}


/**
 * دالة لنسخ مجلد وكل محتوياته
 *
 * @param string $source المجلد المصدر
 * @param string $destination المجلد الهدف
 */
function copyFolder($source, $destination)
{
    if (!file_exists($destination)) {
        mkdir($destination, 0755, true);
    }

    $dir = opendir($source);
    while (($file = readdir($dir)) !== false) {
        if ($file != '.' && $file != '..') {
            $src = $source . '/' . $file;
            $dst = $destination . '/' . $file;
            if (is_dir($src)) {
                copyFolder($src, $dst);
            } else {
                copy($src, $dst);
            }
        }
    }
    closedir($dir);
}

/**
 * دالة لإنشاء slug من النص
 *
 * @param string $text النص المدخل
 * @return string النص المحول إلى slug
 */
function generateSlug($text)
{
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return $text;
}

// التحقق من أن الطلب هو POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $siteName = $_POST["site_name"];
    $database = $_POST["database"];
    $explain_ = $_POST["explain_"];

    // 1. نسخ الملفات من المجلد المصدر إلى المجلد الهدف
    $sourceFolder = 'D:/server/htdocs/Projects/Projects/wordpress/';
    $destinationFolder = 'D:/server/htdocs/Projects/wordpress/' . $siteName;

    copyFolder($sourceFolder, $destinationFolder);

    try {
        // 2. إنشاء قاعدة البيانات الجديدة
        $dsn = "mysql:host=localhost;";
        $pdo = new PDO($dsn, "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $dbName = $database;
        $sql = "CREATE DATABASE IF NOT EXISTS `$dbName`";
        $pdo->exec($sql);

        // استيراد قاعدة البيانات
        $pdo->exec("USE `$dbName`");
        $sqlFile = 'D:/server/htdocs/Projects/plugins/wordpressx.sql';
        $sql = file_get_contents($sqlFile);
        $pdo->exec($sql);

        // 3. تحديث جدول wp_options
        $siteUrl = "http://localhost/Projects/wordpress/" . $siteName;
        
        $updateQueries = [
            "UPDATE wp_options SET option_value = :value WHERE option_id = 2",
            "UPDATE wp_options SET option_value = :value WHERE option_id = 3",
            "UPDATE wp_options SET option_value = :siteName WHERE option_id = 4"
        ];

        foreach ($updateQueries as $query) {
            $stmt = $pdo->prepare($query);
            if (strpos($query, 'option_id = 4') !== false) {
                $stmt->bindParam(':siteName', $siteName);
            } else {
                $stmt->bindParam(':value', $siteUrl);
            }
            $stmt->execute();
        }

        // إنشاء ملف wp-config.php
        $configContent = "<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to \"wp-config.php\"
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
define( 'DB_NAME', '$dbName' );

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

/* Add any custom values between this line and the \"stop editing\" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';";

        file_put_contents($destinationFolder . '/wp-config.php', $configContent);

        // إضافة السجل إلى جدول site_name
        $stmt = $pdo->prepare("INSERT INTO site_name (site_name, database_, explain_, kind, path, url) VALUES (:siteName, :database, :explain_, 'wordpress', :path, :url)");
        $stmt->execute([
            ':siteName' => $siteName,
            ':database' => $dbName,
            ':explain_' => $explain_,
            ':path' => $destinationFolder,
            ':url' => $siteUrl
        ]);

        echo "تم إنشاء الموقع بنجاح. <a href='$siteUrl/wp-admin' target='_blank'>افتح لوحة التحكم</a>";
        echo "<br>Path: $destinationFolder";
        echo "<br>URL: $siteUrl";

    } catch(PDOException $e) {
        echo "حدث خطأ أثناء إنشاء الموقع: " . $e->getMessage();
    }

    $pdo = null;
} else {
    echo "خطأ في الطلب!";
}
?>