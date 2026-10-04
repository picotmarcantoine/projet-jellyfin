<?php 

?>

<div class="posts-list">
    <?php 
    $message_notif = new Interraction_bdd();
    $messages_notif = $message_notif->nouvelle_notif();
    ?>

    <button class="button button-primary"> Tout marquer comme lu </button>

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

            <button class="button button-secondary"> Vu </button>
        </div>
        
    <?php   
    }
    ?>

</div>
