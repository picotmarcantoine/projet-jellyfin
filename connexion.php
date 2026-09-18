<?php
require_once('config/databaseconnect.php');

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Connexion Suivi Jellyfin.</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style.css">
    </head>

    <header>
        <?php
        include('header.php');
        ?>
    </header>

    <form method='post' action=''>
        <input type='email' name='user_mail' placeholder='entrez votre email ici'>  </input>
        <input type='password' name='user_password' placeholder='entrez votre mot de passe ici'> </input>
        <input type="hidden" name='provenance' value='connexion'> </input>
        <input type='submit'> </input>
    </form>


    <?php 
    include('action_database.php') ;

    ///A BOSSER


    ?>

    <footer>
    </footer>
</html>