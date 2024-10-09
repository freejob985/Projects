<?php
ini_set('display_errors', 'Off');
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/error_log_file');
ini_set('max_execution_time', 300);


function writeToFile($file_path, $content)
{
    // كتابة المحتوى إلى الملف
    $result = file_put_contents($file_path, $content);

    // التحقق من نجاح الكتابة
    if ($result !== false) {
        return "تمت الكتابة في الملف بنجاح.";
    } else {
        return "حدث خطأ أثناء محاولة الكتابة في الملف.";
    }
}


function copyFolder($source, $destination)
{
    if (!file_exists($destination)) {
        mkdir($destination, 0755, true);
    }

    $files = glob($source . '/*');

    foreach ($files as $file) {
        $target = $destination . '/' . basename($file);

        if (is_dir($file)) {
            copyFolder($file, $target);
        } else {
            copy($file, $target);
        }
    }
}

function generateSlug($text)
{
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\-]/', '-', $text);
    $text = preg_replace('/-+/', '-', $text);
    $text = trim($text, '-');

    return $text;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $siteName = $_POST["site_name"];
    $database = $_POST["database"];
    $explain_ = $_POST["explain_"];



    $sourceFolder = 'D:/server/htdocs/wp/'; // المجلد المصدر
    $destinationFolder = $siteName; // المجلد الهدف

    if (!file_exists('plugins/' . generateSlug($siteName))) {
        if (mkdir('plugins/' . generateSlug($siteName), 0777, true)) {
            // echo "تم إنشاء الفولدر بنجاح!";
        } else {
            // echo "فشل في إنشاء الفولدر!";
        }
    } else {
        // echo "الفولدر موجود بالفعل!";
    }

    copyFolder($sourceFolder, 'plugins/' . generateSlug($destinationFolder));

    try {
        // Database connection using PDO
        $dsn = "mysql:host=localhost;dbname=wp";
        $pdo = new PDO($dsn, "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Insert data into the site_name table using prepared statements
        $sql = "INSERT INTO site_name (site_name, database_,explain_) VALUES (:siteName, :database, :explain_)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':siteName', generateSlug($siteName));
        $stmt->bindParam(':database', generateSlug($database));
        $stmt->bindParam(':explain_', $explain_);


        $stmt->execute();
        // Create a new database
        $db = generateSlug($database);

        $createDbSql = "CREATE DATABASE IF NOT EXISTS `$db`";
        $pdo->exec($createDbSql);
        // Use the new database
        $pdo->exec("USE `$db`");
        // Import SQL file into the new database
        $importSqlFile = 'dev.sql';
        $importSql = file_get_contents($importSqlFile);
        $pdo->exec($importSql);


try {
    $pdo->beginTransaction();

    // Update option with option_id 1
    $updateOption1Sql = "UPDATE wp_options SET option_value = :new_value WHERE option_id = 1";
    $stmt = $pdo->prepare($updateOption1Sql);
    $newOption1Value = "http://localhost/plugins/".generateSlug($siteName); // Replace with the desired new value
    $stmt->bindParam(':new_value', $newOption1Value);
    $stmt->execute();

    // Update option with option_id 2
    $updateOption2Sql = "UPDATE wp_options SET option_value = :new_value WHERE option_id = 2";
    $stmt = $pdo->prepare($updateOption2Sql);
    $newOption2Value = "http://localhost/plugins/".generateSlug($siteName); // Replace with the desired new value
    $stmt->bindParam(':new_value', $newOption2Value);
    $stmt->execute();

    $pdo->commit();
} catch (PDOException $e) {
    $pdo->rollBack();
    echo "حدث خطأ أثناء تحديث البيانات في جدول wp_options: " . $e->getMessage();
}

        $dbs = generateSlug($database);

        $content_to_write = "<?php\n" .
            "/**\n" .
            " * The base configuration for WordPress\n" .
            " *\n" .
            " * The wp-config.php creation script uses this file during the installation.\n" .
            " * You don't have to use the web site, you can copy this file to \"wp-config.php\"\n" .
            " * and fill in the values.\n" .
            " *\n" .
            " * This file contains the following configurations:\n" .
            " *\n" .
            " * * Database settings\n" .
            " * * Secret keys\n" .
            " * * Database table prefix\n" .
            " * * ABSPATH\n" .
            " *\n" .
            " * @link https://wordpress.org/documentation/article/editing-wp-config-php/\n" .
            " *\n" .
            " * @package WordPress\n" .
            " */\n" .
            "\n" .
            "// ** Database settings - You can get this info from your web host ** //\n" .
            "/** The name of the database for WordPress */\n" .
            "define( 'DB_NAME', '$dbs' );\n" .
            "\n" .
            "/** Database username */\n" .
            "define( 'DB_USER', 'root' );\n" .
            "\n" .
            "/** Database password */\n" .
            "define( 'DB_PASSWORD', '' );\n" .
            "\n" .
            "/** Database hostname */\n" .
            "define( 'DB_HOST', 'localhost' );\n" .
            "\n" .
            "/** Database charset to use in creating database tables. */\n" .
            "define( 'DB_CHARSET', 'utf8mb4' );\n" .
            "\n" .
            "/** The database collate type. Don't change this if in doubt. */\n" .
            "define( 'DB_COLLATE', '' );\n" .
            "\n" .
            "/**#@+\n" .
            " * Authentication unique keys and salts.\n" .
            " *\n" .
            " * Change these to different unique phrases! You can generate these using\n" .
            " * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.\n" .
            " *\n" .
            " * You can change these at any point in time to invalidate all existing cookies.\n" .
            " * This will force all users to have to log in again.\n" .
            " *\n" .
            " * @since 2.6.0\n" .
            " */\n" .
            "define( 'AUTH_KEY',         '~:7!=%nbn.e&*/\$pJCkfhU9f1hijW\$vy[}?KUyPDaZ*MAC*^}MQi-<+tSq~hE.Kv' );\n" .
            "define( 'SECURE_AUTH_KEY',  'pGaxA&ZS}t=/HA2^FjRoXtDgX*Xm_!Fp9ZX3i4j5&S|7vhC2bK-q-T_J\$G*sR3Z;' );\n" .
            "define( 'LOGGED_IN_KEY',    '4m9FY-1Qn+/zRcy]I&[,01:*LV@|jd>EzT!j#:L!SI37]j,iT.&eF<NIzaOh7!o~' );\n" .
            "define( 'NONCE_KEY',        'H~[85UPr5c_`\$awcRd^VfoHnT+dZQ(u_EU0auIbX(#nL(*}X&nSR5jx=)rS5`sm%' );\n" .
            "define( 'AUTH_SALT',        'w}fY0Zu@*UA&aN{7#\$ZO!S{0x-@]a_++U4Eus}g#5kA%*!{4kbPE1q](\$glOyI`z' );\n" .
            "define( 'SECURE_AUTH_SALT', 'sJGV31>=r(,\$VI6Rp^()U-w^mU2\$MtfA-M._?9Dj znL.D?Q0#?-c}L7|Jw[(<@t' );\n" .
            "define( 'LOGGED_IN_SALT',   'K,4x}bHpBJ@#PBB4b&5])=u?;1v{q0z\$ge1%p,Kt>H}#t=2EhD;QnY-e<@(d*UiK' );\n" .
            "define( 'NONCE_SALT',       'v9s^w~ri,W9QYQGVlo{)S[:dz5N+`v39eO:Qhah1Kxr{E~I^p&Y2R+9BZM 4*UKJ' );\n" .
            "\n" .
            "/**#@-*/\n" .
            "\n" .
            "/**\n" .
            " * WordPress database table prefix.\n" .
            " *\n" .
            " * You can have multiple installations in one database if you give each\n" .
            " * a unique prefix. Only numbers, letters, and underscores please!\n" .
            " */\n" .
            "\$table_prefix = 'wp_';\n" .
            "\n" .
            "/**\n" .
            " * For developers: WordPress debugging mode.\n" .
            " *\n" .
            " * Change this to true to enable the display of notices during development.\n" .
            " * It is strongly recommended that plugin and theme developers use WP_DEBUG\n" .
            " * in their development environments.\n" .
            " *\n" .
            " * For information on other constants that can be used for debugging,\n" .
            " * visit the documentation.\n" .
            " *\n" .
            " * @link https://wordpress.org/documentation/article/debugging-in-wordpress/\n" .
            " */\n" .
            "define( 'WP_DEBUG', false );\n" .
            "\n" .
            "/* Add any custom values between this line and the \"stop editing\" line. */\n" .
            "\n" .
            "\n" .
            "\n" .
            "/* That's all, stop editing! Happy publishing. */\n" .
            "\n" .
            "/** Absolute path to the WordPress directory. */\n" .
            "if ( ! defined( 'ABSPATH' ) ) {\n" .
            "    define( 'ABSPATH', __DIR__ . '/' );\n" .
            "}\n" .
            "\n" .
            "/** Sets up WordPress vars and included files. */\n" .
            "require_once ABSPATH . 'wp-settings.php';";


        // header("Location: http://localhost/plugins/".generateSlug($siteName)."/wp-login.php");




        $result_message = writeToFile("plugins/" . generateSlug($siteName) . "/wp-config.php", $content_to_write);

      ///  echo "Data inserted successfully and SQL file imported!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $pdo = null;
    $url = "http://localhost/plugins/" . generateSlug($siteName) . "/wp-login.php";
    echo "تم انشاء الموقع &nbsp;&nbsp;<a href='$url' target='_blank'>  للدخول للموقع</a>";
} else {
    echo "خطأ في الطلب!";
}
?>
