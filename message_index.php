<?php 
if (isset($_SESSION['is_utilisateur_connecte'])
    && $_SESSION['is_utilisateur_connecte'] === True) {
?>
    <div class="new-post-container">

        <button onclick="ouvrirPopup()" class="button button-primary"> Notifications </button>  
            <script>
                function ouvrirPopup() {
                    document.getElementById('notifications').showModal();
                }  
            </script>

            <dialog id='notifications'> 
                <p> <?php include('notifs.php') ?> </p> 
                <button class="button button-primary" onclick="document.getElementById('notifications').close()">X</button>
            </dialog>


        <a href="creer_post.php" class="button button-primary">
            + Nouveau message
        </a>
    </div>
<?php 
} 
?>


<main class="forum-container">


    <!-- =====================================================
        MESSAGES ÉPINGLÉS
        ===================================================== -->

    <?php
    $messages_epingle = new Interraction_bdd();
    $posts_epingles = $messages_epingle->lire_message_epingle();
    ?>

    <?php if (!empty($posts_epingles)) { ?>

        <section class="forum-section">

            <div class="section-header">
                <h1>Messages épinglés</h1>
                <p>Informations importantes de la communauté</p>
            </div>

            <div class="posts-list">

                <?php
                foreach ($posts_epingles as $message) {
                    $username = $messages_epingle->get_username($message['id_u']);
                ?>
                    <article class="post post-pinned">
                        <div class="post-header">
                            <div class="post-author">
                                <span class="post-pin">
                                    📌
                                </span>
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
                                <?= htmlspecialchars($message['date_message']); ?>
                            </time>
                        </div>

                        <div class="post-content">
                            <?= nl2br(htmlspecialchars($message['message'])); ?>
                        </div>

                        <div class="post-footer">
                            <div class="post-management">
                                <?php 
                                if ((isset($_SESSION['grade'])&& ($_SESSION['grade'] === 'admin'|| $_SESSION['grade'] === 'super_admin'))
                                    ||(isset($_SESSION['id_u'])&& $_SESSION['id_u'] == $message['id_u'])) {
                                ?>
                                    <form action="action_database.php" method="post">
                                        <input type="hidden" name="id_post" value="<?= $message['id_post']; ?>">
                                        <input type="hidden" name="provenance" value="supprimer-post">
                                        <button type="submit" name="bouton-supprimer" value="supprimer" class="post-action post-action-danger">
                                            Supprimer
                                        </button>
                                    </form>
                                <?php 
                                }


                                if (isset($_SESSION['grade']) && ($_SESSION['grade'] === 'admin'
                                || $_SESSION['grade'] === 'super_admin')) {
                                ?>

                                    <form action="action_database.php" method="post">
                                        <input type="hidden" name="id_post" value="<?= $message['id_post']; ?>">
                                        <input type="hidden" name="provenance" value="desepingler-post">
                                        <button type="submit" name="bouton-epingler" value="Désepingler" class="post-action">
                                            Désepingler
                                        </button>
                                    </form>
                                <?php
                                }
                                ?>

                                <?php
                                if (isset($_SESSION['is_utilisateur_connecte']) 
                                    && $_SESSION['is_utilisateur_connecte'] === True && $_SESSION['id_u'] == $message['id_u']) {
                                ?>

                                    <form action="modifier_message.php" method="post">
                                        <input type="hidden" name="id_post" value="<?= $message['id_post']; ?>">
                                        <input type="hidden" name="message_id_u" value="<?= $message['id_u']; ?>">
                                        <input type="hidden" name="ancien_message" value="<?= htmlspecialchars($message['message']); ?>">
                                        <button type="submit" class="post-action">
                                            Modifier
                                        </button>
                                    </form>
                                <?php
                                }
                                ?>
                            </div>


                            <form action="message.php" method="get" class="post-replies-form">
                                <input type="hidden" name="id_post" value="<?= $message['id_post']; ?>" >
                                <button type="submit" class="button button-secondary">
                                    Voir les réponses →
                                </button>
                            </form>
                        </div>
                    </article>
                <?php
                }
                ?>
            </div>
        </section>
    <?php } ?>


    <!-- =====================================================
        MESSAGES NORMAUX
        ===================================================== -->

    <section class="forum-section">

        <div class="section-header">
            <h1>Discussions</h1>
            <p>Les dernières discussions de la communauté</p>
        </div>

        <div class="posts-list">
            <?php
            $messages = new Interraction_bdd();
            $posts = $messages->lire_message(25, 1);

            foreach ($posts as $message) {
                $username = $messages->get_username($message['id_u']);
            ?>

                <article class="post">
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
                            <?= htmlspecialchars($message['date_message']); ?>
                        </time>
                    </div>

                    <div class="post-content">
                        <?= nl2br(htmlspecialchars($message['message'])); ?>
                    </div>

                    <div class="post-footer">
                        <div class="post-management">
                            <?php
                            if ((isset($_SESSION['grade'])&& ($_SESSION['grade'] === 'admin'|| $_SESSION['grade'] === 'super_admin'))
                                        ||(isset($_SESSION['id_u'])&& $_SESSION['id_u'] == $message['id_u'])) {
                            ?>

                                <form action="action_database.php" method="post">
                                    <input type="hidden" name="id_post"value="<?= $message['id_post']; ?>">
                                    <input type="hidden" name="provenance" value="supprimer-post">
                                    <button type="submit" name="bouton-supprimer" value="supprimer" class="post-action post-action-danger">
                                        Supprimer
                                    </button>
                                </form>
                            <?php
                            }

                            if (isset($_SESSION['grade'])
                                && ($_SESSION['grade'] === 'admin'|| $_SESSION['grade'] === 'super_admin')) {
                            ?>

                                <form action="action_database.php" method="post">
                                    <input type="hidden" name="id_post" value="<?= $message['id_post']; ?>">
                                    <input type="hidden" name="provenance" value="epingler-post">
                                    <button type="submit" name="bouton-epingler" value="epingler" class="post-action">
                                        Épingler
                                    </button>
                                </form>
                            <?php
                            }
                            ?>

                            <?php
                            if (isset($_SESSION['is_utilisateur_connecte']) 
                                && $_SESSION['is_utilisateur_connecte'] === True && $_SESSION['id_u'] == $message['id_u']) {
                            ?>

                                <form action="modifier_message.php" method="post">

                                    <input type="hidden" name="id_post" value="<?= $message['id_post']; ?>">

                                    <input type="hidden" name="message_id_u" value="<?= $message['id_u']; ?>">
                                    <input type="hidden" name="ancien_message" value="<?= htmlspecialchars($message['message']); ?>">
                                    <button type="submit" class="post-action" >
                                        Modifier
                                    </button>
                                </form>
                            <?php
                            }
                            ?>
                        </div>

                        <form action="message.php" method="get" class="post-replies-form">
                            <input type="hidden" name="id_post" value="<?= $message['id_post']; ?>">
                            <button type="submit" class="button button-secondary">
                                Voir les réponses →
                            </button>
                        </form>
                    </div>
                </article>
            <?php
            }
            ?>
        </div>
    </section>
</main>