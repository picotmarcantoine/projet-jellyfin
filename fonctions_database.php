<?php


require_once('config/databaseconnect.php');
require_once(__DIR__ . '/config/mysql.php');


class Connexion_bdd {
    private $mysqlClient ;

    public function __construct(){
        $host = 'localhost';
        $dbname = 'jellyfin_site';
        $user = 'root';
        $password = '';
        try {
            $this->mysqlClient = new PDO (
                "mysql:host=$host;dbname=$dbname;charset=utf8",
                $user,
                $password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            }catch (Exception $e) {
                die('Erreur de connexion' . $e->getMessage());
        }
    }

    public function get_connexion(){
        return $this->mysqlClient;
    }
    ///fin class !
    /// !!!
    /// !!!
}


class Gestion_utilisateur {
    public $mysqlClient ;

    ///STOCKER L'ID utilisateur dans des cookies !

    public function __construct(){
        $connect_bdd = new Connexion_bdd();
        $this->mysqlClient = $connect_bdd->get_connexion() ;
    }

    public function inscrire_utilisateur($new_email, $newpseudo, $new_mot_de_passe) {
        ///verifie que l utilisateur n utilise pas des balises html
        if (htmlspecialchars($new_email, ENT_QUOTES, 'UTF-8') !== $new_email OR htmlspecialchars($newpseudo, ENT_QUOTES, 'UTF-8') !== $newpseudo OR htmlspecialchars($new_mot_de_passe, ENT_QUOTES, 'UTF-8') !== $new_mot_de_passe) {
            echo 'Erreur, les caractères suivants : </br> < > </br> sont interdits !' ;
            return ;
        }
    ///ajouter try/catch / transaction (suggere par claude) pour faure soit reussir toutes les requetes soit aucune !
        try{
            
            $this->mysqlClient->beginTransaction();
        ///verifie si l email est dans la BDD
            $requete_sql = $this->mysqlClient->prepare("SELECT email FROM Utilisateur WHERE email = :email ");
            $requete_sql->execute([':email' => $new_email]);
            /// si besoin de traiter les donnes en tableau php : $resultat_requete = $requete_sql->fetchAll();
            if ($requete_sql->rowCount() != 0) {
                echo 'vous avez déja un compte avec cet email !';
                return;
            }

        ///verifie si le pseudo est deja dans la BDD
            $requete_sql = $this->mysqlClient->prepare("SELECT pseudo FROM Utilisateur WHERE pseudo = :pseudo");
            $requete_sql->execute([':pseudo' => $newpseudo]);
            /// si besoin de traiter les donnes en tableau php : $resultat_requete = $requete_sql->fetchAll();
            if ($requete_sql->rowCount() != 0) {
                echo 'Ce pseudo est deja utilise !' ;
                return ;
            }

            $requete_sql = $this->mysqlClient->prepare("INSERT INTO Utilisateur(pseudo, email) VALUES( :pseudo , :email)");
            $requete_sql->execute([':pseudo' => $newpseudo, ':email' => $new_email]);

            ///recuperer le Utilisateur.id_u qui vient detre cree (en auto increment) 
            ///pour inserer le meme dans la table d'authentification
            $requete_sql = $this->mysqlClient->prepare("SELECT id_u FROM Utilisateur WHERE email = :email ");
            $requete_sql->execute([':email' => $new_email]);
            $resultat_requete = $requete_sql->fetch();

            /* Insertion du nouvel utilisateur dans la table Utilisateur_grade avec le grade membre*/
            $requete_sql = $this->mysqlClient->prepare('SELECT id_grade FROM Grade WHERE nom_grade = :nom_grade') ;
            $requete_sql->execute([':nom_grade' => 'membre']) ;
            $resultat_requete2 = $requete_sql->fetch() ;

            $requete_sql = $this->mysqlClient->prepare('INSERT INTO Utilisateur_grade(id_u, id_grade) VALUES (:id_u, :id_grade)') ;
            $requete_sql->execute([':id_u' => $resultat_requete['id_u'], ':id_grade' => $resultat_requete2['id_grade']]) ;

            ///insertion du mot de passe dans la BDD
            $requete_sql = $this->mysqlClient->prepare('INSERT INTO Authentification(id_u, mot_de_passe) VALUES( :id_u, :mot_de_passe)');
            $requete_sql->execute([':id_u' => $resultat_requete['id_u'] ,':mot_de_passe' => $new_mot_de_passe]) ;
            echo "vous êtes desormais inscrit <strong> $newpseudo </strong> </br>";
            
            $this->mysqlClient->commit() ;

        }
        catch (Exception $e) {
            $this->mysqlClient->rollBack();
            echo "Il y a eu une erreur surl'inscription, veuillez reessayer plus tard ou contacter le gestionnaire du site </br>" ;
            print_r($e) ;
            return ;
        }

        //connecte l'utilisateur
        $this->connecter_utilisateur($new_email, $new_mot_de_passe);
        return ;
    }


    public function connecter_utilisateur($email, $mot_de_passe) {
        ///verifie que l utilisateur n utilise pas des balises html
        if (htmlspecialchars($email, ENT_QUOTES, 'UTF-8') !== $email OR htmlspecialchars($mot_de_passe, ENT_QUOTES, 'UTF-8') !== $mot_de_passe) {
            echo 'Erreur, les caractères suivants : </br> < > </br> sont interdits !' ;
            return ;
        }
        try {
            ///verifie si un compte correspond a l email dans la BDD
            $requete_sql = $this->mysqlClient->prepare("SELECT id_u, pseudo, email FROM Utilisateur WHERE email = :email ;");
            $requete_sql->execute([':email' => $email]);
            if ($requete_sql->rowCount() == 0) {
                echo "Vous n'avez pas de compte ou l'email n'est pas bon !"; 
                return ;
            }
            $resultat_requete = $requete_sql->fetch();

            $requete_sql = $this->mysqlClient->prepare('SELECT mot_de_passe from Authentification WHERE id_u = :identifiant AND mot_de_passe = :mot_de_passe');
            $requete_sql->execute([':identifiant' => $resultat_requete['id_u'] , ':mot_de_passe' => $mot_de_passe]) ;
            if ($requete_sql->rowCount()==0) {
                echo 'Votre mot de passe n\'est pas bon ';
                return;
            }

            $requete_sql = $this->mysqlClient->prepare('SELECT Grade.nom_grade FROM Grade
                JOIN Utilisateur_grade ON Utilisateur_grade.id_grade = Grade.id_grade
                JOIN Utilisateur ON Utilisateur.id_u = Utilisateur_grade.id_u
                WHERE Utilisateur_grade.id_u = :id_u') ;
            $requete_sql->execute([':id_u' => $resultat_requete['id_u']]) ;
            $grade_utilisateur = $requete_sql->fetch() ;

            $_SESSION['grade'] = $grade_utilisateur['nom_grade'] ;
            $_SESSION['id_u'] = $resultat_requete['id_u'] ;
            $_SESSION['pseudo'] = $resultat_requete['pseudo'] ;
            $_SESSION['mail'] = $resultat_requete['email'] ;
            $_SESSION['is_utilisateur_connecte'] = True ;

            echo 'Vous êtes connecté' . ' <strong>' . $resultat_requete['pseudo'] . '</strong> ! </br>' ;
        } catch (Exception $e ){
            echo "Il y a eu une erreur sur la connexion, veuillez reessayer plus tard ou contacter le gestionnaire du site </br>" ;
            throw $e ;
        }
        return;
    }


    public function supprimer_utilisateur($id) {
        ///STOCKER L'ID utilisateur dans des cookies !
        $requete_sql = $this->mysqlClient->prepare('DELETE FROM Utilisateur WHERE id_u = :id_u');
        $requete_sql->execute([':id_u' => $id]) ; 
        echo 'Utilisateur supprimé' ;
        return ;
    }



    /* fin de classe !
    fin de classe !
    fin de classe ! */
}


Class Interraction_bdd {
    public $mysqlClient ;
    public function __construct(){
        $connect_bdd = new Connexion_bdd();
        $this->mysqlClient = $connect_bdd->get_connexion() ;
        }
    
    public function get_grade($user_id){
        $requete_sql = $this->mysqlClient->prepare('SELECT Grade.nom_grade FROM Grade 
        INNER JOIN Utilisateur_grade ON Grade.id_grade = Utilisateur_grade.id_grade
        INNER JOIN Utilisateur ON Utilisateur_grade.id_u = Utilisateur.id_u
        WHERE Utilisateur.id_u = :id_u');
        $requete_sql->execute([':id_u' => $user_id]) ;
        $resultat_requete = $requete_sql->fetch() ;
        return $resultat_requete ;
    }

    
    public function get_username($user_id){
        $requete_sql = $this->mysqlClient->prepare('SELECT pseudo FROM Utilisateur WHERE id_u = :id_u') ;
        $requete_sql->execute([':id_u'=>$user_id]) ;
        $resultat_requete = $requete_sql->fetchColumn() ;
        return $resultat_requete ;
    }

    public function lire_message_epingle(){
        $requete_sql = $this->mysqlClient->prepare('SELECT * FROM Message_utilisateur 
        INNER JOIN Message_epingle ON Message_utilisateur.id_post = Message_epingle.id_post 
        WHERE Message_epingle.is_epingle = TRUE ORDER BY date_message DESC') ;
        $requete_sql->execute() ;
        $resultat_requete = $requete_sql->fetchAll() ;
        return $resultat_requete ;
    }
    

    public function lire_message($nombre_message, $page){
        /*$nombre_message indique le nombre de message que l'on veut afficher sur une page, 
        et $nombre_page la page actuelle (pour la pagination)
        */

        ///en multipliant le nombre de message par page par la page actuelle,
        ///j obtiens la propriete "OFFSET" a remplir pour avoir une bonne pagination
        $n_page = $nombre_message*$page - $nombre_message;
        $requete_sql = $this->mysqlClient->prepare('SELECT Message_utilisateur.id_post, Message_utilisateur.id_u, 
        Message_utilisateur.message, Message_utilisateur.date_message
        FROM Message_utilisateur 
        LEFT JOIN Message_epingle ON Message_utilisateur.id_post = Message_epingle.id_post
        WHERE Message_epingle.id_post IS NULL
        ORDER BY date_message DESC
        LIMIT :nombre_entree OFFSET :nombre_page') ;

        /* Utilisation de bind value, car l'assignation des parametres dans exectue (comme habituellement)
        associe les valeurs en tant que chaine de caractere ca qui pose probleme puisque SQL attend des INT
        bind value en specifiant le type regle ce probleme */
        $requete_sql->bindValue(':nombre_entree', $nombre_message, PDO::PARAM_INT);
        $requete_sql->bindValue(':nombre_page', $n_page, PDO::PARAM_INT);

        $requete_sql->execute() ;

        $resultat_requete = $requete_sql->fetchAll() ;
        return $resultat_requete ;
    }

    public function lire_message_id($id_post){
        $requete_sql = $this->mysqlClient->prepare('SELECT * FROM Message_utilisateur WHERE id_post = :id_post') ;
        $requete_sql->execute(['id_post' => $id_post]);
        $resultat_requete = $requete_sql->fetch();
        return $resultat_requete ;
    }

    public function lire_reponses($id_post){
        $requete_sql = $this->mysqlClient->prepare('SELECT * FROM Reponse_message 
        WHERE id_post = :id_post ORDER BY date_reponse DESC');
        $requete_sql->execute([':id_post' => $id_post]) ;
        $resultat_requete = $requete_sql->fetchAll();
        return $resultat_requete ;
    }

    public function envoyer_message($message){
        ///desactive les characteres html
        $message_secure = htmlspecialchars($message, ENT_SUBSTITUTE ) ;
        ///Test si le code fonctionne avant d'envoyer le message dans la BDD
        ///sinon renvoie une erreur
        
        try {
            $this->mysqlClient->beginTransaction();
            $requete_sql = $this->mysqlClient->prepare('INSERT INTO Message_utilisateur(id_u, message) VALUES (:id_u, :message)') ;
            $requete_sql->execute([':id_u'=>$_SESSION['id_u'], ':message'=>$message_secure]) ;
            $this->mysqlClient->commit();
            echo 'Votre message est posté ' . $_SESSION['pseudo'] . ' !' ;
        } catch (Exception $e) {
            $this->mysqlClient->rollBack();
            echo "Impossible d'envoyer le message" ;
            print_r($e) ;
        }
        return ;
    }

    public function modifier_message($id_post, $nouveau_message){
        $message_secure = htmlspecialchars($nouveau_message, ENT_SUBSTITUTE ) ;
        try {
            $this->mysqlClient->beginTransaction();
            $requete_sql = $this->mysqlClient->prepare('UPDATE Message_utilisateur SET message  = :message 
            WHERE id_post = :id_post') ;
            $requete_sql->execute([':message'=>$message_secure, ':id_post' => $id_post ]) ;
            $this->mysqlClient->commit();
            echo 'Votre message est modifié ' . $_SESSION['pseudo'] . ' !' ;
        } catch (Exception $e) {
            $this->mysqlClient->rollBack();
            echo "Impossible de modifier le message" ;
            print_r($e) ;
        }
        return ;
    }

    public function repondre_message($id_base_message, $reponse_utilisateur){
        $message_secure = htmlspecialchars($reponse_utilisateur, ENT_SUBSTITUTE ) ;
        try {
            $this->mysqlClient->beginTransaction() ;
            $requete_sql = $this->mysqlClient->prepare('INSERT INTO Reponse_message(id_post, id_u, message) 
            VALUES(:id_base_message, :id_u, :reponse_utilisateur)') ;
            $requete_sql->execute([':id_base_message' => $id_base_message, ':id_u' => $_SESSION['id_u'], ':reponse_utilisateur' => $message_secure]) ;
            $this->mysqlClient->commit() ;
        } catch (Exception $e) {
            $this->mysqlClient->rollBack() ;
            echo "Il y a eu une erreur, veuillez reessayer ulterieurement </br>" ;
            echo '<pre>' ;
            print_r($e) ;
            echo '<pre>' ;
        }
        return ;
    }

    public function epingler_message($id_post){
        try {
            $this->mysqlClient->beginTransaction();

            $requete_sql = $this->mysqlClient->prepare('INSERT INTO Message_epingle(id_post, is_epingle) VALUES(:id_post, TRUE)') ;
            $requete_sql->execute([':id_post' => $id_post]);
            $this->mysqlClient->commit() ;
        } catch(Exception $e){
            $this->mysqlClient->rollBack();
            echo "Impossible d'epingler le message !";
            print_r($e); 
        }
        return ;
    }

    public function desepingler_message($id_post){
        try {
            $this->mysqlClient->beginTransaction();
            $requete_sql = $this->mysqlClient->prepare('DELETE FROM Message_epingle WHERE id_post = :id_post') ;
            $requete_sql->execute([':id_post'=> $id_post]) ;
            $this->mysqlClient->commit() ;
        } catch(Exception $e){
            $this->mysqlClient->rollBack();
            echo "Impossible d'epingler le message !";
            print_r($e); 
        }
        return ;
    }


    public function supprimer_message($id_post){
        try {
            $this->mysqlClient->beginTransaction();
            $requete_sql = $this->mysqlClient->prepare('DELETE FROM Message_utilisateur WHERE id_post = :id_post') ;
            $requete_sql->execute([':id_post'=> $id_post]) ;
            $this->mysqlClient->commit() ;
        } catch(Exception $e){
            $this->mysqlClient->rollBack();
            echo "Impossible d'e supprimer la réponse !";
            print_r($e); 
        }
        return ;
    }

        public function supprimer_reponse($id_reponse){
        try {
            $this->mysqlClient->beginTransaction();
            $requete_sql = $this->mysqlClient->prepare('DELETE FROM Reponse_message WHERE id_reponse = :id_reponse') ;
            $requete_sql->execute([':id_reponse' => $id_reponse]);
            $this->mysqlClient->commit() ;
        } catch(Exception $e){
            $this->mysqlClient->rollBack();
            echo "Impossible de supprimer la réponse !";
            print_r($e); 
        }
        return ;
    }

    public function affiche_notif(){
        /* jointure compliquée, merci l'IA ; A travailler */

        ///Sert a selectionner les post non lus par l'utilisateur, pour les afficher sur la page Notif
        ///Les posts qui doivent laisser une notif
        // donc NON LUS ne sont pas entrés dans la table Notifications
        
        /*
        Je selectionne les champs de la table Message_utilisateur
        Et je joins la ou il n'y a pas de correspondances(left outer join)a la table notifications
        en comparant le post notfication et le post message_u
        et en comparant l'id_u avec celui du lecteur (session id_u)
        la ou post is null (donc post non lu pour l utilisateur)
        */
        $requete_sql = $this->mysqlClient->prepare('SELECT Message_utilisateur.id_post, Message_utilisateur.id_u, 
        Message_utilisateur.message, Message_utilisateur.date_message FROM Message_utilisateur 
        LEFT OUTER JOIN Notifications 
        ON Notifications.id_post = Message_utilisateur.id_post AND Notifications.id_u = :id_u
        WHERE Notifications.id_post IS NULL');

        $requete_sql->execute([':id_u' => $_SESSION['id_u']]);
        $resultat_requete = $requete_sql->fetchAll();
        return $resultat_requete ;
    }

    public function lire_notif($id_post){
        ///faire une boucle foreach et rentrer l'id du post en argument
        try {
            $this->mysqlClient->beginTransaction();
            $requete_sql = $this->mysqlClient->prepare('INSERT INTO Notifications(id_u, id_post, est_lu) 
            Values(:id_u, :id_post, True)');
            $requete_sql->execute([':id_u' => $_SESSION['id_u'], ':id_post' => $id_post]);
            $this->mysqlClient->commit();
        } catch (Exception $e){
            $this->mysqlClient->rollBack();
            echo 'Impossible de lire la notification';
            print_r($e) ;
        }
        return;
    }

    public function lire_toutes_notif(){
        $notif_a_lire = $this->affiche_notif();
        foreach ($notif_a_lire as $notifs){
            $this->lire_notif($notifs['id_post']);
        }
        return;
    }

    /* fin de classe !
    fin de classe !
    fin de classe ! */
}

?>