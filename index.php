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


        <div class="corps_page">
            
            <a href='creer_post.php' class='bouton-creer-post'> 
            <input type="button" name="post_utilisateur"  value="Ecrire un post"> </a> 
            <?php
                $messages = new Interraction_bdd() ;
                $posts = $messages->lire_message(25,1) ;
                foreach ($posts as $message){
                    $username = $messages->get_username($message['id_u']) ;
                    ?> 
                    
                    <div class="post">
                        <div class='en-tete-message'>
                            <div class="pseudo_utilisateur">
                                <?php echo $username['pseudo'] ;
                                ?>
                            </div>

                            <div class="date_post">
                                <?php 
                                    ///utilisation de la fonction date sur le resultat de la requete SQL puisque la table enregistre des timestamp
                                    ///la fonction sert a convertir ce timestamp en date 
                                    ///elle prend en argument le format de la date souhaité puis le timestamp a convertir (optionnel)
                                    echo $message['date_message'] ; 
                                ?>
                            </div>
                        </div>
                        
                        <div class='message_utilisateur'>
                            <?php
                            echo $message['message'],"</br>";
                            ?>
                        </div>
                    </div>

                    <?php } ?>
            
        </div>
        
        
        <footer>
        </footer>

    </body>

</html>