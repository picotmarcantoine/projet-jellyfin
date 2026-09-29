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
        <title></title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

        <header>
            <?php
            include('header.php');
            ?>
        </header>



        <?php
        if (isset($_GET['id_post']) and !empty($_GET['id_post'])){

            $message_infos = new Interraction_bdd() ;
            $message = $message_infos->lire_message_id($_GET['id_post']);
            $username = $message_infos->get_username($message['id_u']);
            ?>
            
            <div class="post">
                <div class='en-tete-message'>
                    <div class="pseudo_utilisateur">
                        <?php 
                        if (!isset($username) or empty($username)){
                            echo 'CET UTILISATEUR N\'EXISTE PLUS' ;
                        } else {
                            echo $username;
                        }
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
                    <p>
                    <?php
                    echo $message['message'],"</br>";
                    ?></p>

                    <!--  -->
                    <div class="gestion_admin">
                        <?php 
                        if (isset($_SESSION['grade'])) {
                            if ($_SESSION['grade'] === 'admin' or $_SESSION['grade'] === 'super_admin') {
                                ?>
                                <form action='action_database.php' method ='post'>
                                    <input type='hidden' name='id_post' value='<?= $message['id_post'];?>' >
                                    <input type='hidden' name='provenance' value='supprimer-post'>
                                    <input type='submit' name='bouton-supprimer' value='supprimer'>
                                </form>
                                
                                <form action='action_database.php' method ='post'>
                                    <input type='hidden' name='id_post' value='<?= $message['id_post'];?>' >
                                    <input type='hidden' name='provenance' value='epingler-post'>
                                    <input type='submit' name='bouton-epingler' value='epingler'>
                                </form>
                                <?php 
                                } 
                            }?>
                    </div>
                </div>
            </div>

        <?php
        }else{
            echo "Il y a eu une erreur" ;
        }
        ?>
    
        <div name='champ_reponse_utilisateur'> 
            <form method='post' action=''>
                <input type='hidden' name='provenance' value='envoyer_reponse'>
                <textarea name='reponse_utilisateur' placeholder="Vous pouvez eecrire une reponse à l'utilisateur '<?= $username ?>'" class='champ_reponse_utilisateur'></textarea>
                <input type ='submit' class='submit_post'>
            </form>
            <?php include('action_database.php'); ?>

        </div>

        
        
        
        <footer>
        </footer>

    </body>

</html>