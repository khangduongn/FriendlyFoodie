<?php
    session_start();
    require_once('database.php');
    $id = $_SESSION['id'];


    if (getNotificationToggle($database, $id) == 1) {

        $sql_query = "UPDATE users SET notifyToggle = FALSE WHERE id = '$id'";
            
    } else {
            
        $sql_query = "UPDATE users SET notifyToggle = TRUE WHERE id = '$id'";
            
    }

    $database->exec($sql_query);



?>