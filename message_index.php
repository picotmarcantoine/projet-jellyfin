<div class="message_epingle">
    <?php
        $messages_epingle = new Interraction_bdd() ;
        $posts_epingles = $messages_epingle->lire_message_epingle() ;
        
        echo '<pre>' ;
        print_r($posts_epingles) ;
        echo '<pre>' ;

        foreach ($posts_epingles as $message){

            print_r($message);

            $username = $messages_epingle->get_username($message['id_u']) ;
            ?> 
            <div class="post">
                <div class='en-tete-message'>
                    <div class="pseudo_utilisateur">
                        <?php 
                        if (!isset($username['pseudo']) or empty($username['pseudo'])){
                            echo 'CET UTILISATEUR N\'EXISTE PLUS' ;
                        } else {
                            echo $username['pseudo'] ;
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

            <?php } ?>
</div>




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
                        <?php 
                        if (!isset($username['pseudo']) or empty($username['pseudo'])){
                            echo 'CET UTILISATEUR N\'EXISTE PLUS' ;
                        } else {
                            echo $username['pseudo'] ;
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

            <?php } ?>
    
</div>