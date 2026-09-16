<?php
require_once(__DIR__ . '/config/databaseconnect.php');
require_once(__DIR__ . '/fonctions_database.php');



///si une redirection a ete faite pour l inscription (on le sait grace au champ caché dans le formulaire)
if ($_POST['provenance'] == 'inscription'){

    if (!isset($_POST['new_user_mail']) OR !isset($_POST['new_user_pseudo'])
    OR empty($_POST['new_user_mail']) OR empty($_POST['new_user_pseudo'])){



    ///PAS FINI !!!
        $erreur = True ;
        $code_erreur = "Vous n\'avez pas rempli tous les champs demandés !" ;
        header("Location:/mise_a_jour_jellyfin/inscription.php?erreur=$erreur&code_erreur=$code_erreur") ;
        exit();
    }

    ///ajout condition email valide ?


    else {
        $user_mail = $_POST['new_user_mail'] ;
        $user_name = $_POST['new_user_pseudo'] ;
        $user_pwd = $_POST['new_user_password'] ;
        $nouvel_utilisateur = new Gestion_utilisateur();
        $nouvel_utilisateur->inscrire_utilisateur($user_mail, $user_name , $user_pwd);
    }
    
}



?>