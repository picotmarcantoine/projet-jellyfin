<?php
require_once(__DIR__ . 'mysql.php');

try {
    $mysqlClient = new PDO (
        "mysql:host=$host;dbname=$dbname;charset=utf8",
    )
}

?>