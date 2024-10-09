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
    $sourceFolder = 'D:/server/htdocs/Projects/plugins/wordpress/';
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
        $stmt = $pdo->prepare("INSERT INTO site_name (site_name, database_, explain_, kind) VALUES (:siteName, :database, :explain_, 'wordpress')");
        $stmt->execute([
            ':siteName' => $siteName,
            ':database' => $dbName,
            ':explain_' => $explain_
        ]);

        echo "تم إنشاء الموقع بنجاح. <a href='$siteUrl/wp-admin' target='_blank'>افتح لوحة التحكم</a>";

    } catch(PDOException $e) {
        echo "حدث خطأ أثناء إنشاء الموقع: " . $e->getMessage();
    }

    $pdo = null;
} else {
    echo "خطأ في الطلب!";
}
?>