<?php
require_once(__DIR__ . '/config/databaseconnect.php');
require_once(__DIR__ . '/fonctions_database.php');


if ($_POST['provenance'] == 'inscription'){
    
    header('Location:/mise_a_jour_jellyfin/index.php');

}

if (!isset($user_mail) or !isset($user_name)){
    echo '<script> alert("Vous n\'avez pas rempli tous les champs !"):</script>' ;
    
    exit();
}

if ($user_mail) {
    
}

    $nouvel_utilisateur = new Gestion_utilisateur();
    $nouvel_utilisateur->inscrire_utilisateur($user_mail, $user_name , $user_pwd);


?>