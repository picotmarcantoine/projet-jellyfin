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
    </header>

    <body>

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

    </body>
    
    <footer>
    </footer>

</html>