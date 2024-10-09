<?php
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log', 'D:/server/htdocs/error_log.txt');
ini_set('max_execution_time', 300);

/**
 * Function to write content to a file
 *
 * @param string $file_path The path to the file
 * @param string $content The content to write
 * @return string Success or error message
 */
function writeToFile($file_path, $content)
{
    $result = file_put_contents($file_path, $content);
    return ($result !== false) ? "تمت الكتابة في الملف بنجاح." : "حدث خطأ أثناء محاولة الكتابة في الملف.";
}

/**
 * Function to generate a slug from text
 *
 * @param string $text The input text
 * @return string The generated slug
 */
function generateSlug($text)
{
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\-]/', '-', $text);
    $text = preg_replace('/-+/', '-', $text);
    return trim($text, '-');
}

/**
 * Function to execute a command and return the output
 *
 * @param string $command The command to execute
 * @return array An array containing the output and return value
 */
function executeCommand($command)
{
    $output = array();
    $returnVar = 0;
    exec($command . " 2>&1", $output, $returnVar);
    return array('output' => $output, 'returnVar' => $returnVar);
}

/**
 * Function to install Composer if not installed
 *
 * @param string $installDir The directory to install Composer in
 * @param string $phpPath The path to the PHP executable
 * @return bool True if Composer is installed or successfully installed, false otherwise
 */
function ensureComposerInstalled($installDir, $phpPath)
{
    $composerPath = $installDir . '/composer.phar';
    
    // Check if Composer is already installed
    $composerCheck = executeCommand("{$phpPath} {$composerPath} --version");
    if ($composerCheck['returnVar'] === 0) {
        return true;
    }

    // Download and install Composer if not installed
    echo "Composer not found. Installing Composer...<br>";
    $downloadCommand = "{$phpPath} -r \"copy('https://getcomposer.org/installer', 'composer-setup.php');\"";
    $downloadResult = executeCommand($downloadCommand);
    if ($downloadResult['returnVar'] !== 0) {
        echo "Error downloading Composer setup. Details:<br>";
        echo implode("<br>", $downloadResult['output']);
        return false;
    }

    // Run the installer
    $installCommand = "{$phpPath} composer-setup.php --install-dir={$installDir} --filename=composer.phar";
    $installResult = executeCommand($installCommand);
    if ($installResult['returnVar'] !== 0) {
        echo "Error installing Composer. Details:<br>";
        echo implode("<br>", $installResult['output']);
        return false;
    }

    // Remove the setup file
    unlink('composer-setup.php');

    echo "Composer installed successfully.<br>";
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $siteName = $_POST["site_name"];
    $database = $_POST["database"];
    $explain_ = $_POST["explain_"];

    // Generate slugs for site name and database
    $siteNameSlug = generateSlug($siteName);
    $databaseSlug = generateSlug($database);

    // Set the project directory
    $projectDir = "D:/server/htdocs/Projects/laravel/{$siteNameSlug}";
    $installDir = "D:/server";

    // Set PHP path to the existing PHP installation in the specified directory
    $phpPath = $installDir . '/php/php.exe';

    // Ensure PHP is available
    $phpCheck = executeCommand("{$phpPath} -v");
    if ($phpCheck['returnVar'] !== 0) {
        echo "Error: PHP is not available in the specified path: {$phpPath}. Please ensure PHP is installed correctly.";
        exit;
    }

    // Ensure Composer is installed
    if (!ensureComposerInstalled($installDir, $phpPath)) {
        echo "Failed to install Composer. Please try again.";
        exit;
    }

    // Create Laravel project using Composer
    $command = "{$phpPath} {$installDir}/composer.phar create-project --prefer-dist laravel/laravel {$projectDir}";
    $result = executeCommand($command);

    if ($result['returnVar'] !== 0) {
        echo "Error creating Laravel project. Details:<br>";
        echo implode("<br>", $result['output']);
        exit;
    }

    try {
        // Database connection using PDO
        $dsn = "mysql:host=localhost;";
        $pdo = new PDO($dsn, "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create the database
        $sql = "CREATE DATABASE IF NOT EXISTS `{$databaseSlug}`";
        $pdo->exec($sql);

        // Connect to the newly created database
        $pdo = new PDO("mysql:host=localhost;dbname={$databaseSlug}", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert data into the site_name table
        $kind = "Laravel";
        $sql = "INSERT INTO site_name (site_name, database_, explain_, kind) VALUES (:siteName, :database, :explain_, :kind)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':siteName', $siteNameSlug);
        $stmt->bindParam(':database', $databaseSlug);
        $stmt->bindParam(':explain_', $explain_);
        $stmt->bindParam(':kind', $kind);
        $stmt->execute();

        // Update .env file
        $envFile = "{$projectDir}/.env";
        $envContent = file_get_contents($envFile);
        $envContent = preg_replace('/DB_DATABASE=.*/', "DB_DATABASE={$databaseSlug}", $envContent);
        file_put_contents($envFile, $envContent);

        // Run database migrations
        chdir($projectDir);
        $migrationResult = executeCommand("{$phpPath} artisan migrate");

        if ($migrationResult['returnVar'] !== 0) {
            echo "Error running database migrations. Details:<br>";
            echo implode("<br>", $migrationResult['output']);
            exit;
        }

        $url = "http://localhost/Projects/laravel/{$siteNameSlug}/public/";
        echo "تم إنشاء المشروع بنجاح. <a href='{$url}' target='_blank'>افتح المشروع</a>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $pdo = null;
} else {
    echo "خطأ في الطلب!";
}
?>