<?php 
$message_notif = new Interraction_bdd();
$messages_notif = $message_notif->nouvelle_notif();



foreach ($messages_notif as $notif) {
    echo $notif['id_post'], $notif['id_u'], $notif['message'], $notif['date_message'];
}

?>