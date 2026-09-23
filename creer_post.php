<?php 
session_start() ;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Suivi Jellyfin.</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style_page_alt.css">
    </head>

    <body>

        <header>
            <?php
            include('header.php');
            ?>
        </header>

        <?php
        if (isset($_SESSION['is_utilisateur_connecte'])) {
            if ($_SESSION['is_utilisateur_connecte'] == True){

        ?>
                <div class='creation_de_post'>
                    <p> Bonjour <?php echo $_SESSION['pseudo']; ?> quelle est votre question ? </p>
                    <form method='post' action =''>
                        <input type='hidden' name='provenance' value='creer_post'>
                        <textarea name='post_utilisateur' placeholder='Veuillez entrer votre message' class='champ_post_utilisateur'>
                        </textarea>
                        <input type ='submit' class='submit_post'>
                    </form>
                </div>

            <?php include('action_database.php') ;
            }
            else {
                echo "veuillez d'abbord vous connecter ! </br>";
            }
        }
        else {
            echo "veuillez vous connecter" ;
        }
            ?>

        <footer>
        </footer>

    </body>

</html>