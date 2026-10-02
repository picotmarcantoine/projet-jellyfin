<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Modifier un message - Suivi Jellyfin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <?php include('header.php'); ?>
    </header>

    <main class="page-container">

        <?php
        if (isset($_SESSION['is_utilisateur_connecte'])) {

            if ($_SESSION['is_utilisateur_connecte'] == True) {
        ?>

                <section class="form-page">

                    <div class="form-header">
                        <h1>Modifier votre message</h1>

                        <p>
                            Bonjour <?= htmlspecialchars($_SESSION['pseudo']); ?> 👋
                        </p>
                    </div>

                    <form method="post" action="" class="post-form">

                        <input
                            type="hidden"
                            name="provenance"
                            value="modifier-message"
                        >

                        <input
                            type="hidden"
                            name="message_id_u"
                            value="<?= $_POST['message_id_u']; ?>"
                        >

                        <input
                            type="hidden"
                            name="id_post"
                            value="<?= $_POST['id_post']; ?>"
                        >

                        <textarea
                            name="post_utilisateur"
                            placeholder="Modifiez votre message..."
                            class="text-area"
                            required
                        ><?php
                            if (isset($_POST['ancien_message'])) {
                                echo htmlspecialchars($_POST['ancien_message']);
                            }
                        ?></textarea>

                        <button
                            type="submit"
                            class="button button-primary"
                        >
                            Enregistrer les modifications
                        </button>

                    </form>

                    <a href="index.php" class="back-link">
                        ← Retour aux discussions
                    </a>

                </section>

        <?php
                include('action_database.php');

            } else {
                echo "Veuillez d'abord vous connecter !";
            }

        } else {
            echo "Veuillez vous connecter";
        }
        ?>

    </main>

    <footer></footer>

</body>

</html>