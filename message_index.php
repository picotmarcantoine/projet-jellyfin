<?php 
    if (isset($_SESSION['is_utilisateur_connecte']) AND $_SESSION['is_utilisateur_connecte'] === True ){
    ?>
        <div class='bouton-post'>
            <a href='creer_post.php' class='bouton-creer-post'> 
                <input type="button" name="post_utilisateur"  value="Ecrire un post"> </a> 
        </div>
    <?php 
    } 
?>

<div class="message_epingle">
    
    <?php
        $messages_epingle = new Interraction_bdd() ;
        $posts_epingles = $messages_epingle->lire_message_epingle() ;
        
        foreach ($posts_epingles as $message){
            $username = $messages_epingle->get_username($message['id_u']) ;

            ?> 
            <div class="post_epingle">
                <div class='en-tete-message'>
                    <div class="pseudo_utilisateur">
                        <?php 
                        if (!isset($username) or empty($username)){
                            echo 'CET UTILISATEUR N\'EXISTE PLUS' ;
                        } else {
                            echo $username ;
                        }
                        ?>
                    </div>

                    <div class="date_post">
                        <?php 
                            ///utilisation de la fonction date sur le resultat de la requete SQL puisque la table enregistre des timestamp
                            ///la fonction sert a convertir ce timestamp en date 
                            ///elle prend en argument le format de la date souhaité puis le timestamp a convertir (optionnel)
                            echo 'Ce message a été épinglé -' . ' ' . $message['date_message'] ; 
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
                                
                                if (isset($_SESSION['grade']) AND ($_SESSION['grade'] === 'admin' or $_SESSION['grade'] === 'super_admin')) {
                                ?>
                                    <form action='action_database.php' method ='post'>
                                        <input type='hidden' name='id_post' value='<?= $message['id_post'];?>' >
                                        <input type='hidden' name='provenance' value='desepingler-post'>
                                        <input type='submit' name='bouton-epingler' value='Désepingler'>
                                    </form>
                                <?php 
                            }?>
                    
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
                    </div>
                </div>

                <?php if (isset($_SESSION['is_utilisateur_connecte']) AND $_SESSION['is_utilisateur_connecte'] === True ){ 
                    ?>
                    <form action='message.php' method='get'>
                        <input type='hidden' name='id_post' value='<?= $message['id_post']?>'>
                        <input type='submit' value='Répondre - Voir les réponses' >
                    </form>
                    <?php 
                    } else { ?>
                        <form action='message.php' method='get'>
                            <input type='hidden' name='id_post' value='<?= $message['id_post']?>'>
                            <input type='submit' value='Voir les réponses' >
                        </form>
                    <?php } ?>

            </div>


            <?php } ?>
</div>




<div class="corps_page">

    <?php
        $messages = new Interraction_bdd() ;
        $posts = $messages->lire_message(25,1) ;
        foreach ($posts as $message){
            $username = $messages->get_username($message['id_u']) ;
            ?> 
            
            <div class="post">
                <div class='en-tete-message'>
                    <div class="pseudo_utilisateur">
                        <?php 
                        if (!isset($username) or empty($username)){
                            echo 'CET UTILISATEUR N\'EXISTE PLUS' ;
                        } else {
                            echo $username ;
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
                                
                                if (isset($_SESSION['grade']) AND ($_SESSION['grade'] === 'admin' or $_SESSION['grade'] === 'super_admin')) {
                                ?>
                                    <form action='action_database.php' method ='post'>
                                        <input type='hidden' name='id_post' value='<?= $message['id_post'];?>' >
                                        <input type='hidden' name='provenance' value='epingler-post'>
                                        <input type='submit' name='bouton-epingler' value='epingler'>
                                    </form>
                                <?php 
                            }?>

                    <?php /*
                    ajouter le bouton modifier ici !
                    ajouter le bouton modifier ici !
                    ajouter le bouton modifier ici !
                    ajouter le bouton modifier ici !
                    ajouter le bouton modifier ici !
                    
                    */ ?>

                    </div>
                
                </div>

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
                        ?>
                    <form action='message.php' method='get'>
                        <input type='hidden' name='id_post' value='<?= $message['id_post']?>'>
                        <input type='submit' value='Répondre - Voir les réponses' >
                    </form>
                <?php 
                } else { ?>
                    <form action='message.php' method='get'>
                        <input type='hidden' name='id_post' value='<?= $message['id_post']?>'>
                        <input type='submit' value='Voir les réponses' >
                    </form>
                <?php } ?>





                <!-- adad
                -->

            </div>

            <?php } ?>
    
</div>