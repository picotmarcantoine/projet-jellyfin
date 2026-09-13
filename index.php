<?php
require_once(__DIR__ . '/config/databaseconnect.php');
?>



<!DOCTYPE html>
<html>
    <head>
        <title>Suivi Jellyfin.</title>
        <meta charset="utf-8" />
    </head>

    <header>
    </header>

    <body>
        <p> yoyo
        <?php 
            $requetesql = $mysqlClient->prepare('SELECT * FROM Utilisateur');

            $requetesql -> execute();

            $utilisateurs = $requetesql->fetchAll();
            
            foreach ($utilisateurs as $utilisateur){
                echo $utilisateur ;
            }
        ?>
        </p>

    </body>
    
    <footer>
    </footer>

</html>