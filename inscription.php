<?php
require_once(__DIR__ . '/config/databaseconnect.php');

?>


<form method='post' action='action_database.php'>
    <input type='email' name='new_user_mail' placeholder='entrez votre email ici'>  </input>
    <input type='password' name='new_user_password' placeholder='entrez votre mot de passe ici'> </input>
    <input type='submit'> </input>
</form>