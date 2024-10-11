<?php
/**
 * process.php
 * 
 * This file is responsible for creating a new WordPress site, including:
 * - Copying WordPress files to a new folder
 * - Creating a new database
 * - Updating WordPress settings in the database
 * - Creating the wp-config.php configuration file
 *
 * Inputs:
 * - $_POST['site_name']: Name of the new site (folder name)
 * - $_POST['database']: Name of the new database
 * - $_POST['explain_']: Site description
 *
 * Outputs:
 * - Success message with a link to the new WordPress admin panel, or an error message
 * - Logs errors and important events to a log file
 *
 * Dependencies:
 * - PHP 7.0+
 * - PDO extension
 * - MySQL/MariaDB
 *
 * @author Your Name
 * @version 1.1
 */

// Set PHP settings for better performance and security
ini_set('display_errors', 'Off');
ini_set('log_errors', 'On');
ini_set('error_log', 'D:/server/htdocs/wordpress_creator_error.log');
ini_set('max_execution_time', 300);

/**
 * Function to log messages
 *
 * @param string $message The message to log
 * @param string $type The type of log message (e.g., 'INFO', 'ERROR')
 */
function logMessage($message, $type = 'INFO') {
    $logFile = 'D:/server/htdocs/wordpress_creator.log';
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[$timestamp] [$type] $message" . PHP_EOL;
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}

/**
 * Function to write content to a file
 *
 * @param string $file_path Path to the file
 * @param string $content Content to be written
 * @return string Success or failure message
 */
function writeToFile($file_path, $content)
{
    $result = file_put_contents($file_path, $content);
    if ($result !== false) {
        logMessage("File written successfully: $file_path");
        return "File written successfully.";
    } else {
        logMessage("Error writing to file: $file_path", 'ERROR');
        return "Error writing to file.";
    }
}

/**
 * Function to copy a folder and all its contents
 *
 * @param string $source Source folder
 * @param string $destination Destination folder
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
    logMessage("Folder copied from $source to $destination");
}

/**
 * Function to generate a slug from text
 *
 * @param string $text Input text
 * @return string Slug
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

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $siteName = $_POST["site_name"];
    $database = $_POST["database"];
    $explain_ = $_POST["explain_"];

    logMessage("Starting WordPress site creation for: $siteName");

    // 1. Copy files from source folder to destination folder
    $sourceFolder = 'D:/server/htdocs/Projects/Projects/wordpress/';
    $destinationFolder = 'D:/server/htdocs/Projects/wordpress/' . $siteName;

    copyFolder($sourceFolder, $destinationFolder);

    try {
        // 2. Create the new database
        $dsn = "mysql:host=localhost;";
        $pdo = new PDO($dsn, "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $dbName = $database;
        $sql = "CREATE DATABASE IF NOT EXISTS `$dbName`";
        $pdo->exec($sql);
        logMessage("Database created: $dbName");

        // Import the database
        $pdo->exec("USE `$dbName`");
        $sqlFile = 'D:/server/htdocs/Projects/Projects/wordpressx.sql';
        $sql = file_get_contents($sqlFile);
        $pdo->exec($sql);
        logMessage("Database imported from: $sqlFile");

        // 3. Update wp_options table
        $siteUrl = "http://localhost/Projects/wordpress/" . $siteName;
        
        $updateQueries = [
            "UPDATE wp_options SET option_value = :value WHERE option_name = 'siteurl'",
            "UPDATE wp_options SET option_value = :value WHERE option_name = 'home'",
            "UPDATE wp_options SET option_value = :siteName WHERE option_name = 'blogname'"
        ];

        foreach ($updateQueries as $query) {
            $stmt = $pdo->prepare($query);
            if (strpos($query, 'option_name = \'blogname\'') !== false) {
                $stmt->bindParam(':siteName', $siteName);
            } else {
                $stmt->bindParam(':value', $siteUrl);
            }
            $stmt->execute();
        }
        logMessage("wp_options table updated");

        // Create wp-config.php file
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

/**#@+
 * Authentication unique keys and salts.
 */
define( 'AUTH_KEY',         'put your unique phrase here' );
define( 'SECURE_AUTH_KEY',  'put your unique phrase here' );
define( 'LOGGED_IN_KEY',    'put your unique phrase here' );
define( 'NONCE_KEY',        'put your unique phrase here' );
define( 'AUTH_SALT',        'put your unique phrase here' );
define( 'SECURE_AUTH_SALT', 'put your unique phrase here' );
define( 'LOGGED_IN_SALT',   'put your unique phrase here' );
define( 'NONCE_SALT',       'put your unique phrase here' );

/**#@-*/

/**
 * WordPress database table prefix.
 */
\$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 */
define( 'WP_DEBUG', false );

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';";

        $wpConfigPath = $destinationFolder . '/wp-config.php';
        file_put_contents($wpConfigPath, $configContent);
        logMessage("wp-config.php created: $wpConfigPath");

        // Add record to site_name table
        $stmt = $pdo->prepare("INSERT INTO site_name (site_name, database_, explain_, kind, path, url) VALUES (:siteName, :database, :explain_, 'wordpress', :path, :url)");
        $stmt->execute([
            ':siteName' => $siteName,
            ':database' => $dbName,
            ':explain_' => $explain_,
            ':path' => $destinationFolder,
            ':url' => $siteUrl
        ]);
        logMessage("Record added to site_name table");

        echo "Site created successfully. <a href='$siteUrl/wp-admin' target='_blank'>Open admin panel</a>";
        echo "<br>Path: $destinationFolder";
        echo "<br>URL: $siteUrl";
        logMessage("WordPress site creation completed successfully for: $siteName");

    } catch(PDOException $e) {
        $errorMessage = "Error creating site: " . $e->getMessage();
        echo $errorMessage;
        logMessage($errorMessage, 'ERROR');
    }

    $pdo = null;
} else {
    echo "Invalid request!";
    logMessage("Invalid request received", 'WARNING');
}
?>