<?php
require_once(__DIR__ . '/config/databaseconnect.php');
?>



<!DOCTYPE html>
<html>
    <head>
        <title>Suivi Jellyfin.</title>
        <meta charset="utf-8" />
    </head>

    <header>
        <form>    
            <ul><li>
                <a href='inscription.php'> 
                    <input type="button" name="inscription_utilisateur"  value="inscription"> 
                    </input> 
                </a>
            </li>

            <li> 
                <a href='connexion.php'> 
                    <input type="button" name="connexion_utilisateur" action="" method="post" value="connexion">
                    </input> 
                </a>
            </li>
            </ul>
        </form>

    </header>

    <body>
        <?php
        if ($utilisateur->is_utilisateur_connecte == True) {
            echo 'salut !' ;
        }
        echo 'au revoir' ;
        ?>

        



    </body>
    
    <footer>
    </footer>

</html>