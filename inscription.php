<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Inscription - Suivi Jellyfin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <?php include('header.php'); ?>
    </header>

    <main class="page-container">

        <section class="auth-page">

            <div class="auth-header">
                <h1>Créer un compte</h1>

                <p>
                    Rejoignez la communauté Suivi Jellyfin.
                </p>
            </div>

            <form method="post" action="" class="auth-form">

                <div class="form-field">
                    <label for="new_user_mail">Adresse email</label>

                    <input
                        type="email"
                        id="new_user_mail"
                        name="new_user_mail"
                        placeholder="Votre adresse email"
                        required
                    >
                </div>

                <div class="form-field">
                    <label for="new_user_pseudo">Pseudo</label>

                    <input
                        type="text"
                        id="new_user_pseudo"
                        name="new_user_pseudo"
                        placeholder="Votre pseudo"
                        maxlength="25"
                        required
                    >
                </div>

                <div class="form-field">
                    <label for="new_user_password">Mot de passe</label>

                    <input
                        type="password"
                        id="new_user_password"
                        name="new_user_password"
                        placeholder="Votre mot de passe"
                        required
                    >
                </div>

                <input
                    type="hidden"
                    name="provenance"
                    value="inscription"
                >

                <button
                    type="submit"
                    class="button button-primary"
                >
                    Créer mon compte
                </button>

            </form>

            <p class="auth-footer">
                Vous avez déjà un compte ?
                <a href="connexion.php">Se connecter</a>
            </p>

        </section>

    </main>

    <?php
    include('action_database.php');
    ?>

    <footer></footer>

</body>

</html>