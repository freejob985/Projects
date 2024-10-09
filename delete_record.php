<?php
// اتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wp";

function generateSlug($text)
{
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\-]/', '-', $text);
    $text = preg_replace('/-+/', '-', $text);
    $text = trim($text, '-');

    return $text;
}

function deleteFolder($folderPath)
{
    // فحص محتويات الفولدر
    $contents = scandir($folderPath);
    unset($contents[0], $contents[1]); // إزالة '.' و '..'

    // حذف الملفات والفولدرات داخل الفولدر
    foreach ($contents as $content) {
        $contentPath = $folderPath . DIRECTORY_SEPARATOR . $content;

        if (is_dir($contentPath)) {
            // إذا كان المحتوى داخل الفولدر هو فولدر، قم بحذفه بشكل متكرر
            deleteFolder($contentPath);
        } else {
            // إذا كان المحتوى داخل الفولدر هو ملف، قم بحذفه
            unlink($contentPath);
        }
    }

    // حذف الفولدر نفسه بعد التأكد من أنه فارغ
    if (count(scandir($folderPath)) == 2) {
        rmdir($folderPath);
     //   echo "تم حذف الفولدر بنجاح.";
    } else {
     //   echo "فشل في حذف الفولدر. يرجى التحقق من الصلاحيات.";
    }
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $record_id = $_POST['record_id'];
    $siteName = $_POST["site_name"];
    $database = $_POST["database_"];



    $folderPath = 'plugins/' . generateSlug($siteName);
    // استدعاء الدالة لحذف الفولدر
    deleteFolder($folderPath);

    // استعلام لحذف السجل
    $stmt = $conn->prepare("DELETE FROM site_name WHERE id = :id");
    $stmt->bindParam(':id', $record_id);
    $stmt->execute();
    $dbs = generateSlug($database);
    $conn->exec("USE `$dbs`");

    // قم بحذف قاعدة البيانات بناءً على اسمها
    $sqlDeleteDatabase = "DROP DATABASE IF EXISTS   $dbs";
    $conn->exec($sqlDeleteDatabase);

    header("Location: http://localhost/wordpress.php");
} catch (PDOException $e) {
    echo "Failed to connect to the database: " . $e->getMessage();
}

// إغلاق اتصال PDO
$conn = null;
?>