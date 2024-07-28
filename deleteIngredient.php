<?php 

require_once('database.php');

$ingredientID = $_GET['id'];


$deleteIngredientQuery = "DELETE FROM ingredients WHERE ingredientId = '$ingredientID'";

$database->exec($deleteIngredientQuery);
header('Location: dashboard.php');
?>