<?php

?>

<a href='index.php' class='bouton_home'> <h3>Home</h3> </a>

<p class="etat_site"> <?php 
echo "etat du site" ; ?> </p>

<form>    
    <ul><li>
        <a href='inscription.php'> 
            <input type="button" name="inscription_utilisateur"  value="Inscription" class='bouton-connexion'> 
            </input> 
        </a>
    </li>

    <li> 
        <a href='connexion.php'> 
            <input type="button" name="connexion_utilisateur" action="" method="post" value="Connexion" class='bouton-connexion'>
            </input> 
        </a>
    </li>
    </ul>
</form>