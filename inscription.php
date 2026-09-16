<?php
require_once(__DIR__ . '/config/databaseconnect.php');


?>


<form method='post' action='action_database.php'>
    <input type='email' name='new_user_mail' placeholder='entrez votre email ici'>  </input>
    <input type='text' name='new_user_pseudo' placeholder='entrez votre pseudo ici'>  </input>
    <input type='password' name='new_user_password' placeholder='entrez votre mot de passe ici'> </input>
    <input type="hidden" name='provenance' value='inscription'> </input>
    <input type='submit'> </input>
</form>

<?php 
///A BOSSER
if (isset($erreur) AND !empty($erreur)) {
    echo $code_erreur ;
}

?>