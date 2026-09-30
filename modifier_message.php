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
                    <p> Bonjour <?php echo $_SESSION['pseudo']; ?> vous pouvez modifier votre message </p>
                    <form method='post' action =''>
                        <input type='hidden' name='provenance' value='modifier-message'>
                        <input type='hidden' name='message_id_u' value='<?= $_POST['message_id_u'] ; ?>'>
                        <input type='hidden' name='id_post' value='<?= $_POST["id_post"] ?>'>

                        <textarea name='post_utilisateur' placeholder='Veuillez entrer votre message' 
                        class='champ_post_utilisateur'> <?php if (isset($_POST['ancien_message'])){ echo $_POST['ancien_message'] ; } ?>
                        </textarea>

                        <input type ='submit' class='submit_post'>
                    </form>
                </div>

                <?php
                include('action_database.php') ;
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