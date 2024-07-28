<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="./css/searcher.css">

	<link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
	<link rel="stylesheet" href="./css/navbar.css">
	<title>Recipe Finder</title>
</head>
<body>
	<!-- this is for the nav bar -->
    <div class="nav-parent">
		<nav class="navigation-bar">
			<div class="nav-logo">
				<a href="dashboard.php"><img class="logo" src="images/Food Icon.jpg"></a>
			</div>
		
			<div class="nav-buttons">
			
			<a href="dashboard.php">Dashboard</a>
			<a href="shoppinglist.php">Shopping List</a>
			<a href="converterhub.php">Unit Converter</a>
			<a class="active" href="searcher.php">Recipe Finder</a>
			<a href="setting.php"><img  id="gear-icon" src="images/settings.png"></a>
			<a href="logout.php"><img  id="logout-icon" src="images/logoutlogout2.png"></a>
			</div>
			
			
		</nav>
	</div>
  	<div class="hero">
		<p> Recipe Finder</p>
	</div>

	<div class="search">
		<input type = "text" placeholder = "Search for recipe" id="searchRecipes">
		
	</div>
	<?php 
		session_start();
		require_once('database.php');
		$id = $_SESSION['id'];
		

		
		




		$sql_query = "SELECT recipeName, recipeType, calories, prepTime, ingredients, dietaryRestrictions, directions FROM recipes";
		
				
		$res = $database_recipes->query($sql_query);
		
		


	?>

	<div class='w-75 mx-auto'>
    <table class="table table-striped table-bordered table-hover table-sm table-fixed">
		<thead>
			<tr>
				<th>Recipe</th>
				<th>Type</th>
				<th>Calories</th>
				<th>Preparation Time</th>
				<th>Ingredients</th>
				<th>Dietary Restrictions</th>
				<th>Directions</th>
			

			</tr>
		</thead>
		<tbody id="recipes">
			<?php

				while ($row = $res->fetchArray()) {
					echo '<tr>';
					

					echo '<td>'. $row['recipeName']. '</td>';
					echo '<td>'. $row['recipeType'].' </td>';
					echo '<td>'. $row['calories'].' </td>';
					echo '<td>'. $row['prepTime'].' </td>';

					$ingredientsArray = explode(",", $row['ingredients']); 
					
					echo '<td><ul>';
					foreach($ingredientsArray as $ingredient) {
						echo '<li>'. $ingredient .'</li>';
					}
					echo '</ul></td>';

					$restrictionsArray = explode(",", $row['dietaryRestrictions']); 

					echo '<td><ul>';
					foreach($restrictionsArray as $dietaryRestriction) {
						echo '<li>'. $dietaryRestriction .'</li>';
					}
					echo '</ul></td>';


					$directionsArray = explode(";", $row['directions']); 

					echo '<td><ul>';
					foreach($directionsArray as $direction) {
						echo '<li>'. $direction .'</li>';
					}
					echo '</ul></td>';

					echo '</tr>';

				}

			?>
		</tbody>
	</table>
	</div>

	<!--Used from https://www.w3schools.com/jquery/tryit.asp?filename=tryjquery_filters_table-->
	<script>
		$(document).ready(function(){
			$("#searchRecipes").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$("#recipes tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			});
		});
	</script>
</body>
</html>



    
	
	

