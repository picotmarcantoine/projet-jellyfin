
<head>
    <link rel="stylesheet" href="style_header.css">
</head>

<a href='index.php' class='bouton_home'> <h3>Home</h3> </a>

<p class="etat_site"> <?php 
echo "etat du site" ; ?> </p>

<?php
if (isset($_SESSION['is_utilisateur_connecte']) and $_SESSION['is_utilisateur_connecte'] == true){ ?>
    <form>
        <ul>
        <li>
            <a href='deconnexion.php'>
                <input type='button' name='deconnexion' value ='Deconnexion' class='bouton-connexion'>
            </a>   
        </li>
        </ul>
    </form>
<?php
}

if (!isset($_SESSION['is_utilisateur_connecte']) or $_SESSION['is_utilisateur_connecte'] == false) { ?>
    <form>    
        <ul><li>
            <a href='inscription.php'> 
                <input type="button" name="inscription_utilisateur"  value="Inscription" class='bouton-connexion'> 
            </a>
        </li>

        <li> 
            <a href='connexion.php'> 
                <input type="button" name="connexion_utilisateur" value="Connexion" class='bouton-connexion'>
            </a>
        </li>
        </ul>
    </form>
<?php 
}
?>
