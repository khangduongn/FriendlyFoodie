<?php
    session_start();
    require_once('database.php');
    $id = $_SESSION['id'];


    if (getAutoAddToggle($database, $id) == 1) {

        $sql_query = "UPDATE users SET autoAddToggle = FALSE WHERE id = '$id'";
            
    } else {
            
        $sql_query = "UPDATE users SET autoAddToggle = TRUE WHERE id = '$id'";
            
    }

    $database->exec($sql_query);



?>