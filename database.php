<?php
ini_set('error_reporting', E_ALL);
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$host = "localhost";

$user = "postgres";

$password = "12345";

$db = "transfermate";

try {
    $dsn = "pgsql:host=$host;port=5432;dbname=$db;";
    // make a database connection
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

} catch (PDOException $e) {
    die($e->getMessage());
}
?>
