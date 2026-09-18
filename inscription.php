<?php

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
        <input type='email' name='new_user_mail' placeholder='entrez votre email ici' required>  </input>
        <input type='text' name='new_user_pseudo' placeholder='entrez votre pseudo ici' maxlength="25" required>  </input>
        <input type='password' name='new_user_password' placeholder='entrez votre mot de passe ici' required> </input>
        <input type="hidden" name='provenance' value='inscription'> </input>
        <input type='submit'> </input>
    </form>

    <?php 
    include('action_database.php') ;

    ///A BOSSER

    ?>

    <footer>
    </footer>
</html>