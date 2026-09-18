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
    public $is_utilisateur_connecte ;
    ///STOCKER L'ID utilisateur dans des cookies !

    public function __construct(){
        $connect_bdd = new Connexion_bdd();
        $this->mysqlClient = $connect_bdd->get_connexion() ;
        $this->is_utilisateur_connecte = False ;
    }

    public function inscrire_utilisateur($new_email, $newpseudo, $new_mot_de_passe) {

    ///verifie si l email est dans la BDD
        $requete_sql = $this->mysqlClient->prepare("SELECT email FROM Utilisateur WHERE email = :email ");
        $requete_sql->execute([':email' => $new_email]);
        /// si besoin de traiter les donnes en tableau php : $resulat_requete = $requete_sql->fetchAll();
        if ($requete_sql->rowCount() != 0) {
            echo 'vous avez déja un compte avec cet email !';
            return;
        }

    ///verifie si le pseudo est deja dans la BDD
        $requete_sql = $this->mysqlClient->prepare("SELECT pseudo FROM Utilisateur WHERE pseudo = :pseudo");
        $requete_sql->execute([':pseudo' => $newpseudo]);
        /// si besoin de traiter les donnes en tableau php : $resulat_requete = $requete_sql->fetchAll();
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
        $resulat_requete = $requete_sql->fetch();

        ///insertion du mot de passe dans la BDD
        $requete_sql = $this->mysqlClient->prepare("INSERT INTO Authentification(id_u, mot_de_passe) VALUES( :id_u, :mot_de_passe)");
        $requete_sql->execute([':id_u' => $resulat_requete['id_u'] ,':mot_de_passe' => $new_mot_de_passe]) ;
        echo "vous êtes desormais inscrit $newpseudo ";
        
        //connecte l'utilisateur
        $this->connecter_utilisateur($new_email, $new_mot_de_passe);

        return ;
    }


    public function connecter_utilisateur($email, $mot_de_passe) {
        ///verifie si un compte correspond a l email dans la BDD
        $requete_sql = $this->mysqlClient->prepare("SELECT id_u, email FROM Utilisateur WHERE email = :email ;");
        $requete_sql->execute([':email' => $email]);
        if ($requete_sql->rowCount() == 0) {
            echo "ous n'avez pas de compte ou l'email n'est pas bon !"; 
            return ;
        }
        $resulat_requete = $requete_sql->fetch();

        $requete_sql = $this->mysqlClient->prepare('SELECT mot_de_passe from Authentification WHERE id_u = :identifiant AND mot_de_passe = :mot_de_passe');
        $requete_sql->execute([':identifiant' => $resulat_requete['id_u'] , ':mot_de_passe' => $mot_de_passe]) ;
        if ($requete_sql->rowCount()==0) {
            echo 'Votre mot de passe n\'est pas bon ';
            return;
        }
        echo 'Vous êtes connecté !' ;
        $this->is_utilisateur_connecte = True ;
        return;
    }


    public function supprimer_utilisateur($id) {
        ///STOCKER L'ID utilisateur dans des cookies !
        $requete_sql = $this->mysqlClient('DELETE FROM Utilisateur WHERE id_u = :id_u');
        $requete_sql->execute([':id_u' => $id]) ; 
        echo 'Utilisateur supprimé' ;
        return ;
    }



    /* fin de classe !
    fin de classe !
    fin de classe ! */
}

?>