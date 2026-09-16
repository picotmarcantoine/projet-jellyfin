<?php
require_once(__DIR__ . '/mysql.php');


try {
    $mysqlClient = new PDO (
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    return $mysqlClient ;
    
}catch (Exception $e) {
    die('Erreur de connexion' . $e->getMessage());
}

?>