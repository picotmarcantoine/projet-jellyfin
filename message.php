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
        <link rel="stylesheet" href="style_reponses.css">
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
                    echo nl2br($message['message']),"</br>";
                    ?></p>




                    <!--  -->
                    <div class="gestion_admin">

                    <?php 
                        if (isset($_SESSION['is_utilisateur_connecte']) AND $_SESSION['is_utilisateur_connecte'] === True ){
                            if ($_SESSION['id_u'] == $message['id_u']){
                                ?>
                                <form action='modifier_message.php' method='post'>
                                    <input type='hidden' name='id_post' value='<?= $message['id_post']?>'>
                                    <input type='hidden' name='message_id_u' value='<?= $message['id_u'] ?>'>
                                    <input type='hidden' name='ancien_message' value='<?= $message['message'] ?>'>
                                    <input type='submit' value='Modifier message' >
                                </form>

                                <?php
                            }
                        }
                        ?>

                        <?php 
                        if ( (isset($_SESSION['grade']) AND ($_SESSION['grade'] === 'admin' or $_SESSION['grade'] === 'super_admin'))
                            OR (isset($_SESSION['id_u']) AND $_SESSION['id_u'] == $message['id_u'] )) {
                                ?>
                                <form action='action_database.php' method ='post'>
                                    <input type='hidden' name='id_post' value='<?= $message['id_post'];?>' >
                                    <input type='hidden' name='provenance' value='supprimer-post'>
                                    <input type='submit' name='bouton-supprimer' value='supprimer'>
                                </form>
                                <?php 
                            }?>
                    </div>
                </div>
            </div>

        <?php
        }else{
            echo "Il y a eu une erreur" ;
        }
        ?>

        <?php 
        if (isset($_SESSION['is_utilisateur_connecte']) AND $_SESSION['is_utilisateur_connecte'] === True ){
            ?>
            <div class='champ_reponse_utilisateur'> 
                <form method='post' action=''>
                    <input type='hidden' name='provenance' value='envoyer_reponse'>
                    <input type='hidden' name='post_base' value='<?=$_GET['id_post']?>'>
                    <textarea name='reponse_utilisateur' placeholder="Vous pouvez ecrire une reponse à l'utilisateur '<?= $username ?>'" class='champ_reponse_utilisateur'></textarea>
                    <input type ='submit' class='submit_post'>
                </form>
                <?php include('action_database.php'); ?>
            </div>
            <?php 
            }?>




        <div class='post_reponses_utilisateurs'>
            
            <?php 
            $messages_reponses = new Interraction_bdd() ;
            $reponses = $messages_reponses->lire_reponses($_GET['id_post']) ;


            foreach ($reponses as $message){
                $pseudo = $messages_reponses->get_username($message['id_u']);
            ?>
            <div class='reponses'>
                <div class='en-tete_reponses'>
                    <div class='pseudo_utilisateur'>
                        <?php 
                        echo $pseudo ;
                        ?>
                    </div>
                    <div class='date_post'>
                        <?= $message['date_reponse'] ; ?>
                    </div>
                </div>
                <div class='reponses_utilisateurs'>
                    <p>
                    <?php
                    echo nl2br($message['message']),"</br>";
                    ?></p>


                    <div class="gestion_admin">
                        <?php 
                        if ( (isset($_SESSION['grade']) AND ($_SESSION['grade'] === 'admin' or $_SESSION['grade'] === 'super_admin'))
                            OR (isset($_SESSION['id_u']) AND $_SESSION['id_u'] == $message['id_u'] )) {
                                ?>
                                <form action='action_database.php' method ='post'>
                                    <input type='hidden' name='id_post' value='<?= $message['id_post'];?>' >
                                    <input type='hidden' name='provenance' value='supprimer-post'>
                                    <input type='submit' name='bouton-supprimer' value='supprimer'>
                                </form>
                                <?php 
                            }
                                
                            ?>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>

        </div>
        
        
        <footer>
        </footer>

    </body>

</html>