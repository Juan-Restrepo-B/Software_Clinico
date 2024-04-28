<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
}

// Define database
if (!defined('dbhost')) {
    define('dbhost', '45.169.100.25');
}
if (!defined('dbuser')) {
    define('dbuser', 'juanpres_pruebas');
}
if (!defined('dbpass')) {
    define('dbpass', 'pruebas123}'); // Asegúrate de que la contraseña sea correcta y no tenga el '}' al final a menos que sea parte de ella
}
if (!defined('dbname')) {
    define('dbname', 'juanpres_citas_medicas');
}

try {
    $connect = new PDO("mysql:host=".dbhost.";dbname=".dbname, dbuser, dbpass);
    $connect->query("SET NAMES utf8;");
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo $e->getMessage();
}
?>
