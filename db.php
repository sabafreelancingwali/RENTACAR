<?php
// db.php
$DB_HOST = 'localhost';
$DB_NAME = 'dbzgyfkose5c6k';
$DB_USER = 'uei4bkjtcem6s';
$DB_PASS = 'wmhalmspfjgz';
 
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    die("DB Connect failed: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");
?>
 
