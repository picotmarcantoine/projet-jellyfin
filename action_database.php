<?php

require_once('config/databaseconnect.php');
require_once('fonctions_database.php');


///si une redirection a ete faite pour l inscription (on le sait grace au champ caché dans le formulaire)
if (isset($_POST['provenance'])){
    if ($_POST['provenance'] == 'inscription'){
        if (!isset($_POST['new_user_mail']) OR !isset($_POST['new_user_pseudo'])
        OR empty($_POST['new_user_mail']) OR empty($_POST['new_user_pseudo'])){
            echo "Vous n'avez pas rempli tous les champs demandés !" ;
            ///PAS DE EXIT car sinon le script html ne s execute plus et donc n affiche pas la page comme je veux
            return;
        }

        ///evite les espaces et autres caracteres invalides (qui pourraient etre dus aux fautes de frappes ?)
        $email_corrige = filter_var($_POST['new_user_mail'], FILTER_SANITIZE_EMAIL) ;
        if (filter_var($email_corrige, FILTER_VALIDATE_EMAIL) === false){
            echo "Votre e-mail n'est pas valide !" ;
            return ;
        }

        ///grace aux returns au dessus, si les conditions sont fausses alors on ajoute l utilisateur dans la bdd
        $user_mail = $email_corrige ;
        $user_name = $_POST['new_user_pseudo'] ;
        $user_pwd = $_POST['new_user_password'] ;
        $nouvel_utilisateur = new Gestion_utilisateur();
        $nouvel_utilisateur->inscrire_utilisateur($user_mail, $user_name , $user_pwd);
    }
}



///si la redirection vient de la page de connexion
if (isset($_POST['provenance'])){
    if ($_POST['provenance'] == 'connexion'){
        if (!isset($_POST['user_mail']) OR empty($_POST['user_mail'])){
            echo "Vous n'avez pas rempli tous les champs demandés !" ;
            ///PAS DE EXIT car sinon le script html ne s execute plus et donc n affiche pas la page comme je veux
            return;
        }

        $user_mail = $_POST['user_mail'];
        $user_pwd = $_POST['user_password'] ;
        $utilisateur = new Gestion_utilisateur() ;
        $utilisateur->connecter_utilisateur($user_mail, $user_pwd);

    }
}


if (isset($_POST['provenance'])){
    if ($_POST['provenance'] == 'creer_post'){
        if (isset($_POST['post_utilisateur']) and !empty($_POST['post_utilisateur'])){

            $message = new Interraction_bdd() ;
            $message->envoyer_message($_POST['post_utilisateur']);
        }
        else {
            echo "Veuillez ecrire un message." ;
        }
        
    }
}

if (isset($_POST['provenance'])){
    $action_message = new Interraction_bdd() ;
    if ($_POST['provenance'] == 'supprimer-post'){
        $action_message->supprimer_message($_POST['id_post']);
        header('Location:index.php') ;
        exit();
    }
    if ($_POST['provenance'] == 'epingler-post'){ 
        $action_message->epingler_message($_POST['id_post']);
        header('Location:index.php') ;
        exit();
    }
    if ($_POST['provenance'] == 'desepingler-post'){
        $action_message->desepingler_message($_POST['id_post']);
        header('Location:index.php') ;
        exit();
    }
    if ($_POST['provenance'] == 'envoyer_reponse'){
        $action_message->repondre_message($_POST['post_base'],$_POST['reponse_utilisateur']);
        $url = "message.php?id_post=" . $_POST['post_base'] ;
        header('Location:' . $url ) ;
        exit();
    }
    if ($_POST['provenance'] == 'supprimer-reponse'){
        $action_message->supprimer_reponse($_POST['id_reponse']);
        $url = "message.php?id_post=" . $_POST['id_post_base'] ;
        header('Location:' . $url ) ;
        exit();
    }
    if($_POST['provenance'] == 'modifier-message'){
        ///verifie cote servveur que lutilisateur connecte est bien celui qui a envoye le post
        if ($_SESSION['id_u'] == $_POST['message_id_u'] ) {
            $action_message->modifier_message($_POST['id_post'], $_POST['post_utilisateur']) ;
            header('Location:index.php') ;
        } else {
            echo "Vous n'etes pas a l'origine de ce post !" ;
        }
        exit() ;
    }
    if($_POST['provenance'] == 'marquer-vu'){
        $action_message->lire_notif($_POST['id_notif']);
    }

    if($_POST['provenance'] == 'marquer-tout-lu'){
        $action_message->lire_toutes_notif();
    }
}

?>