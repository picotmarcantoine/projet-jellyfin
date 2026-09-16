<?php
require_once(__DIR__ . '/config/databaseconnect.php');
require_once(__DIR__ . '/fonctions_database.php');

?>

<?php 
    $nouvel_utilisateur = new Gestion_utilisateur();
    $nouvel_utilisateur->inscrire_utilisateur($_POST['new_user_mail'], $_POST['new_user_pseudo'] , $_POST['new_user_password']);


?>