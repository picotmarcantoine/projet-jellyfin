<?php
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

    <header>
        <?php
        include('header.php');
        ?>
    </header>

    <body>
    <?php
        $messages = new Interraction_bdd() ;
        $posts = $messages->lire_message(25,1) ;
        foreach ($posts as $message){
            $username = $messages->get_username($message['id_u']) ;
            echo $username['pseudo'] . ' ', date('d/m/Y H:i:s', intval($message['date_message'])), "</br>" ;
            ///utilisation de la fonction date sur le resultat de la requete SQL puisque la table enregistre des timestamp
            ///la fonction sert a convertir ce timestamp en date 
            ///elle prend en argument le format de la date souhaité puis le timestamp a convertir (optionnel)
            echo $message['message'],"</br> </br> </br> ";
        }

    
    ?>

    </body>
    
    <footer>
    </footer>

</html>