<?php
/**
 * اتصال قاعدة البيانات
 * 
 * يقوم بإنشاء اتصال PDO مع قاعدة البيانات.
 * 
 * @package ProjectManagement
 */

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wp";

try {
    // إنشاء اتصال
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // إنشاء قاعدة البيانات إذا لم تكن موجودة
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    $conn->exec($sql);
    
    // الاتصال بقاعدة البيانات
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // إنشاء الجدول إذا لم يكن موجودًا
    $sql = "CREATE TABLE IF NOT EXISTS site_name (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        site_name VARCHAR(30) NOT NULL,
        database_ VARCHAR(30) NOT NULL,
        explain_ TEXT,
        kind VARCHAR(30) NOT NULL,
        path VARCHAR(255) NOT NULL,
        url VARCHAR(255) NOT NULL
    )";
    $conn->exec($sql);
} catch(PDOException $e) {
    echo "خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage();
}