<?php
require_once(__DIR__ . '/config/databaseconnect.php');

?>

<?php 

function inscrire_utilisateur($new_email, $newpseudo, $new_motdepasse) {
    $requete_sql = $mysqlClient->prepare("SELECT email FROM Utilisateur WHERE email = :email ");
    $requete_sql->execute([':email' => $new_email]);

    /// si besoin de traiter les donnes en tableau php : $resulat_requete = $requete_sql->fetchAll();
    if ($requete_sql->rowCount() != 0) {
        echo 'vous avez déja un compte !';
        return;
    }
    $requete_sql = $mysqlClient->prepare("SELECT pseudo FROM Utilisateur WHERE pseudo = :pseudo ");
    $requete_sql->execute([':pseudo' => $newpseudo]);

    /// si besoin de traiter les donnes en tableau php : $resulat_requete = $requete_sql->fetchAll();
    if ($requete_sql->rowCount() != 0) {
        echo 'vous avez déja un compte !' ;
        return ;
    }

    $requete_sql = $mysqlClient->prepare("INSERT INTO Utilisateur(pseudo, email) VALUES( :pseudo , :email)");
    $requete_sql->execute([':pseudo' => $newpseudo, ':email' => $new_email]);

    ///recuperer le Utilisateur.id_u qui vient detre cree (en auto increment) 
    ///pour inserer le meme dans la table d'authentification
    $requete_sql = $mysqlClient->prepare("SELECT id_u FROM Utilisateur WHERE email = :email ");
    $requete_sql->execute([':email' => $new_email]);
    $resulat_requete = $requete_sql->fetch()

    ///insertion du mot de passe
    $requete_sql = $mysqlClient->prepare("INSERT INTO Authentification(id_u, mot_de_passe) VALUES( :id_u, :mot_de_passe)");
    $requete_sql->execute([':id_u' => $resulat_requete['id_u'] ,':mot_de_passe' => $new_motdepasse]) ;
    echo "vous êtes desormais inscrit $newpseudo ";
    return ;
}

?>