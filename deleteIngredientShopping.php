<?php 

require_once('database.php');

$ingredientID = $_GET['id'];


$deleteIngredientQuery = "DELETE FROM shoppinglist WHERE shoppingItemId = '$ingredientID'";

$database->exec($deleteIngredientQuery);
header('Location: shoppinglist.php');
?>