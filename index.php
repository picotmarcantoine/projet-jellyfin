<?php
session_start() ;
$id_session = session_id() ;

require_once('config/databaseconnect.php');
require_once('fonctions_database.php');
require_once('action_database.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Suivi Jellyfin.</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <header>
            <?php
            include('header.php');
            ?>
        </header>
        
        <?php include('message_index.php'); ?>

        <footer>
        </footer>
    </body>
</html>