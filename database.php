<?php

//This file initializes the sqlite database that stores user data
$database = new SQLite3('./database/user_info.sqlite');
$database_recipes = new SQLite3('./database/recipes.sqlite');

//query to create table storing user data
$create_table_query = "CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY,
        firstName VARCHAR(255),
        lastName VARCHAR(255),
        username VARCHAR(255),
        email VARCHAR(255),
        notifyToggle BOOLEAN,
        autoAddToggle BOOLEAN,
        password VARCHAR(255))";

$database->exec($create_table_query);


//query to create table of ingredients to store ingredient info belonging to a specific user
$create_table_query = "CREATE TABLE IF NOT EXISTS ingredients (
        ingredientId INTEGER PRIMARY KEY,
        ingredientName VARCHAR(255),
        allergen VARCHAR(255),
        ingredientType VARCHAR(255),
        calories DECIMAL(10,5),
        amount VARCHAR(255),
        unit VARCHAR(255),
        expDate DATETIME,
        userId INTEGER,
        FOREIGN KEY (userId) REFERENCES users(id))";

$database->exec($create_table_query);


//query to create table of ingredients to store ingredient info belonging to a specific user
$create_table_query = "CREATE TABLE IF NOT EXISTS shoppinglist (
        shoppingItemId INTEGER PRIMARY KEY,
        ingredientName VARCHAR(255),
        amount VARCHAR(255),
        unit VARCHAR(255),
        userId INTEGER,
        ingredientId INTEGER,
        UNIQUE(ingredientId),
        FOREIGN KEY (userId) REFERENCES users(id))";

$database->exec($create_table_query);



function addToShoppingList($name, $amount, $unit, $id, $database, $ingredientId=null, $default=TRUE) {


        if ($default) {

                if ($ingredientId == null) {

                        $sql_query = "INSERT INTO shoppinglist (ingredientName, amount, unit, userId)
                        VALUES ('$name', '$amount', '$unit', '$id')";

                } else {
                        
                        $sql_query = "INSERT INTO shoppinglist (ingredientName, amount, unit, ingredientId, userId)
                        VALUES ('$name', '$amount', '$unit', '$ingredientId', '$id')";

                }
                
        } else {
                $sql_query = "INSERT OR IGNORE INTO shoppinglist (ingredientName, amount, unit, ingredientId, userId)
                VALUES ('$name', '$amount', '$unit', '$ingredientId', '$id')";
        }
        
        
        
        
        $database->exec($sql_query);
        
}

function getNotificationToggle($database, $id) {

        $sql_query = "SELECT notifyToggle FROM users WHERE id = '$id'";

        
        $res = $database->query($sql_query);

        $notifyToggle = $res->fetchArray()['notifyToggle'];
    
        return $notifyToggle;
}       

function getAutoAddToggle($database, $id) {

        $sql_query = "SELECT autoAddToggle FROM users WHERE id = '$id'";

        
        $res = $database->query($sql_query);

        $autoAddToggle = $res->fetchArray()['autoAddToggle'];
    
        return $autoAddToggle;
}     
