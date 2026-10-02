<?php
session_start();
require_once('config/databaseconnect.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Connexion - Suivi Jellyfin</title>
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
                <h1>Connexion</h1>

                <p>
                    Connectez-vous à votre compte pour participer aux discussions.
                </p>
            </div>

            <form method="post" action="" class="auth-form">

                <div class="form-field">
                    <label for="user_mail">Adresse email</label>

                    <input
                        type="email"
                        id="user_mail"
                        name="user_mail"
                        placeholder="Votre adresse email"
                        required
                    >
                </div>

                <div class="form-field">
                    <label for="user_password">Mot de passe</label>

                    <input
                        type="password"
                        id="user_password"
                        name="user_password"
                        placeholder="Votre mot de passe"
                        required
                    >
                </div>

                <input
                    type="hidden"
                    name="provenance"
                    value="connexion"
                >

                <button
                    type="submit"
                    class="button button-primary"
                >
                    Se connecter
                </button>

            </form>

            <p class="auth-footer">
                Vous n'avez pas encore de compte ?
                <a href="inscription.php">Créer un compte</a>
            </p>

        </section>

    </main>

    <?php
    include('action_database.php');
    ?>

    <footer></footer>

</body>

</html>