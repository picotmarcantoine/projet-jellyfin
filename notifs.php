<div class="posts-list">
    <?php 
    $message_notif = new Interraction_bdd();
    $messages_notif = $message_notif->affiche_notif();

    if (!empty($messages_notif)){
    ?>

        <form action="" method="post">
            <input type="hidden" name="provenance" value="marquer-tout-lu">
            <button type="submit" name="bouton-tout_lu" class="button button-primary"> Tout marquer comme lu </button>
        </form>    

        <?php
        foreach ($messages_notif as $notifs) {
            $username = $message_notif->get_username($notifs['id_u']); ?>
            <div class="post-header">
                <div class="post-author">
                    <span class="pseudo_utilisateur">
                        <?php 
                        if (!isset($username) || empty($username)) {
                            echo "CET UTILISATEUR N'EXISTE PLUS";
                        } else {
                            echo htmlspecialchars($username);
                        }
                        ?>
                    </span>
                </div>
                <time class="post-date">
                    <?= htmlspecialchars($notifs['date_message']); ?>
                </time>
            </div>
            <div class="post-content">
                <?= nl2br(htmlspecialchars($notifs['message'])), '</br>'; ?>
                <form action="" method="post">
                    <input type="hidden" name="id_notif" value="<?= $notifs['id_post']; ?>">
                    <input type="hidden" name="provenance" value='marquer-vu'>
                    <button type="submit" name="bouton-vu" class="post-action post-action-danger"> Marquer comme Vu </button>
                </form>
            </div>     
        <?php   
        }
    }else{
        echo "Vous n'avez aucune notification" ;
    }
        ?>

</div>
