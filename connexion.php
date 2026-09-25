<?php
session_start() ;
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
        <link rel="stylesheet" href="style_page_alt.css">
    </header>

    <form method='post' action='' class='connexion_inscription'>
        <p> Veillez à ne pas utiliser les caractères suivants : </br>
        < > </p>
        <input type='email' name='user_mail' placeholder='entrez votre email ici' required>  
        <input type='password' name='user_password' placeholder='entrez votre mot de passe ici' required> 
        <input type="hidden" name='provenance' value='connexion'> 
        <input type='submit'> 
    </form>


    <?php 
    include('action_database.php') ;

    ///A BOSSER


    ?>

    <footer>
    </footer>
</html>