<?php
// ini_set('display_errors', 'Off');
// ini_set('log_errors', 'On');
// ini_set('error_log', '/path/to/error_log_file');
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

    $files = scandir($source);

    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $sourcePath = $source . '/' . $file;
            $targetPath = $destination . '/' . $file;

            if (is_dir($sourcePath)) {
                copyFolder($sourcePath, $targetPath);
            } else {
                copy($sourcePath, $targetPath);
            }
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
    $explain_ = $_POST["explain_"];



    $sourceFolder = 'D:/server/htdocs/Chrome/Chrome'; // المجلد المصدر
    $destinationFolder = $siteName; // المجلد الهدف

    if (!file_exists('plugins/' . $siteName)) {
        if (mkdir('plugins/' . $siteName, 0777, true)) {
            // echo "تم إنشاء الفولدر بنجاح!";
        } else {
            // echo "فشل في إنشاء الفولدر!";
        }
    } else {
        // echo "الفولدر موجود بالفعل!";
    }

    copyFolder($sourceFolder, 'plugins/' . $destinationFolder);

    try {
        // Database connection using PDO
        $dsn = "mysql:host=localhost;dbname=wp";
        $pdo = new PDO($dsn, "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Insert data into the site_name table using prepared statements
        $kind = "Google";

        $sql = "INSERT INTO site_name (site_name,explain_,kind) VALUES (:siteName, :explain_,:kind)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':siteName', $siteName);
        $stmt->bindParam(':explain_', $explain_);
  $stmt->bindParam(':kind', $kind);

        $stmt->execute();
        // Create a new database


  



        $Des=generateSlug($destinationFolder);
$version = "1.0";

$content_to_write = '{
  "manifest_version": 2,
  "name": "' . $siteName . '",
  "version": "' . $version . '",
  "description": "' . $explain_ . '",
  "permissions": ["notifications", "storage", "audio"],
  "browser_action": {
    "default_popup": "popup.html",
    "default_icon": {
      "16": "icons/icon16.png",
      "48": "icons/icon48.png",
      "128": "icons/icon128.png"
    }
  }
}';





        // header("Location: http://localhost/plugins/".generateSlug($siteName)."/wp-login.php");




        $result_message = writeToFile("plugins/" . $siteName . "/manifest.json", $content_to_write);

        ///  echo "Data inserted successfully and SQL file imported!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $pdo = null;

    $url = "http://localhost/plugins/" . $siteName. "/a.php";
    echo "تم انشاء الاضافة &nbsp;&nbsp;<a href='$url' target='_blank'>  فتح الاضافة  </a>";
} else {
    echo "خطأ في الطلب!";
}
?>