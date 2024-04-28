<?php
require '../backend/bd/Conexion.php';

$settings = $connect->prepare("SELECT nomem, foto FROM settings");
$settings->execute();
$setting = $settings->fetch(PDO::FETCH_ASSOC);

ini_set('display_errors', 1);
error_reporting(E_ALL);

echo 'Hello, World!';

phpinfo();
?>
