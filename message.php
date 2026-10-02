<?php
session_start();

$id_session = session_id();

require_once('config/databaseconnect.php');
require_once('fonctions_database.php');
require_once('action_database.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <title>Discussion - Suivi Jellyfin</title>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <link rel="stylesheet" href="style.css">

</head>

<body>

<header>

    <?php include('header.php'); ?>

</header>


<main class="page-container">


<?php

if (isset($_GET['id_post']) && !empty($_GET['id_post'])) {

    $message_infos = new Interraction_bdd();

    $message = $message_infos->lire_message_id($_GET['id_post']);

    $username = $message_infos->get_username($message['id_u']);

?>

    <a href="index.php" class="back-link">
        ← Retour aux discussions
    </a>


    <!-- =====================================================
         MESSAGE PRINCIPAL
         ===================================================== -->

    <article class="single-post">

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


        <div class="single-post-content">

            <?= nl2br(htmlspecialchars($message['message'])); ?>

        </div>


        <div class="post-management">

            <?php
            if (
                isset($_SESSION['is_utilisateur_connecte'])
                && $_SESSION['is_utilisateur_connecte'] === True
                && $_SESSION['id_u'] == $message['id_u']
            ) {
            ?>

                <form
                    action="modifier_message.php"
                    method="post"
                >

                    <input
                        type="hidden"
                        name="id_post"
                        value="<?= $message['id_post']; ?>"
                    >

                    <input
                        type="hidden"
                        name="message_id_u"
                        value="<?= $message['id_u']; ?>"
                    >

                    <input
                        type="hidden"
                        name="ancien_message"
                        value="<?= htmlspecialchars($message['message']); ?>"
                    >

                    <button
                        type="submit"
                        class="post-action"
                    >
                        Modifier
                    </button>

                </form>

            <?php
            }


            if (
                (
                    isset($_SESSION['grade'])
                    && (
                        $_SESSION['grade'] === 'admin'
                        || $_SESSION['grade'] === 'super_admin'
                    )
                )
                ||
                (
                    isset($_SESSION['id_u'])
                    && $_SESSION['id_u'] == $message['id_u']
                )
            ) {
            ?>

                <form
                    action="action_database.php"
                    method="post"
                >

                    <input
                        type="hidden"
                        name="id_post"
                        value="<?= $message['id_post']; ?>"
                    >

                    <input
                        type="hidden"
                        name="provenance"
                        value="supprimer-post"
                    >

                    <button
                        type="submit"
                        name="bouton-supprimer"
                        value="supprimer"
                        class="post-action post-action-danger"
                    >
                        Supprimer
                    </button>

                </form>

            <?php
            }
            ?>

        </div>

    </article>


    <!-- =====================================================
         REPONSE
         ===================================================== -->

    <?php
    if (
        isset($_SESSION['is_utilisateur_connecte'])
        && $_SESSION['is_utilisateur_connecte'] === True
    ) {
    ?>

        <section class="reply-section">

            <div class="section-header">

                <h2>Répondre</h2>

                <p>
                    Votre réponse sera visible par les autres utilisateurs.
                </p>

            </div>


            <form
                method="post"
                action=""
                class="reply-form"
            >

                <input
                    type="hidden"
                    name="provenance"
                    value="envoyer_reponse"
                >

                <input
                    type="hidden"
                    name="post_base"
                    value="<?= $_GET['id_post']; ?>"
                >

                <textarea
                    name="reponse_utilisateur"
                    placeholder="Écrivez votre réponse..."
                    class="text-area reply-text-area"
                    required
                ></textarea>

                <button
                    type="submit"
                    class="button button-primary"
                >
                    Répondre
                </button>

            </form>

            <?php include('action_database.php'); ?>

        </section>

    <?php
    }
    ?>


    <!-- =====================================================
         REPONSES
         ===================================================== -->

    <section class="replies-section">

        <?php

        $messages_reponses = new Interraction_bdd();

        $reponses = $messages_reponses->lire_reponses($_GET['id_post']);

        ?>

        <div class="section-header">

            <h2>
                Réponses
            </h2>

        </div>


        <div class="replies-list">

            <?php
            foreach ($reponses as $message) {

                $pseudo = $messages_reponses->get_username($message['id_u']);
            ?>

                <article class="reply">

                    <div class="post-header">

                        <div class="post-author">

                            <span class="pseudo_utilisateur">

                                <?php
                                if (!isset($pseudo) || empty($pseudo)) {
                                    echo "CET UTILISATEUR N'EXISTE PLUS";
                                } else {
                                    echo htmlspecialchars($pseudo);
                                }
                                ?>

                            </span>

                        </div>

                        <time class="post-date">

                            <?= htmlspecialchars($message['date_reponse']); ?>

                        </time>

                    </div>


                    <div class="reply-content">

                        <?= nl2br(htmlspecialchars($message['message'])); ?>

                    </div>


                    <div class="post-management">

                        <?php
                        if (
                            (
                                isset($_SESSION['grade'])
                                && (
                                    $_SESSION['grade'] === 'admin'
                                    || $_SESSION['grade'] === 'super_admin'
                                )
                            )
                            ||
                            (
                                isset($_SESSION['id_u'])
                                && $_SESSION['id_u'] == $message['id_u']
                            )
                        ) {
                        ?>

                            <form
                                action="action_database.php"
                                method="post"
                            >

                                <input
                                    type="hidden"
                                    name="id_post"
                                    value="<?= $message['id_post']; ?>"
                                >

                                <input
                                    type="hidden"
                                    name="provenance"
                                    value="supprimer-reponse"
                                >

                                <button
                                    type="submit"
                                    name="bouton-supprimer"
                                    value="supprimer"
                                    class="post-action post-action-danger"
                                >
                                    Supprimer
                                </button>

                            </form>

                        <?php
                        }
                        ?>

                    </div>

                </article>

            <?php
            }
            ?>

        </div>

    </section>

<?php

} else {

    echo "Il y a eu une erreur";

}

?>

</main>


<footer></footer>

</body>

</html>