<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	

	
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

	<link rel="stylesheet" href="./css/dashboard.css">
	<link rel="stylesheet" href="./css/navbar.css">
	<link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
</head>
<body>
	<?php
	session_start();
    require_once('database.php');
   
    $id = $_SESSION['id'];

	$sql_query = "SELECT firstName FROM users WHERE 
                id = '$id'";

    

    $res = $database->query($sql_query);

    $firstName = $res->fetchArray()['firstName'];

	?>


    
	<body>
	<!-- this is for the nav bar -->
	<div class="nav-parent">
		<nav class="navigation-bar">
			<div class="nav-logo">
				<a href="dashboard.php"><img class="logo" src="images/Food Icon.jpg"></a>
			</div>
		
			<div class="nav-buttons">
			
				<a class="active" href="dashboard.php">Dashboard</a>
				<a href="shoppinglist.php">Shopping List</a>
				<a href="converterhub.php">Unit Converter</a>
				<a href="searcher.php">Recipe Finder</a>
				<a href="setting.php"><img  id="gear-icon" src="images/settings.png"></a>
				<a href="logout.php"><img  id="logout-icon" src="images/logoutlogout2.png"></a>
			</div>
			
		</nav>
	</div>

	
    <?php 

    
    

    
	

	if (isset($_POST['saveIngredient'])) {

		
		$name = $_POST['ingredient'];
		$allergen = $_POST['allergen'];
		$type = $_POST['ingredientType'];
		$calories = $_POST['calories'];
		$amount = $_POST['amount'];
		$unit = $_POST['unit'];
		$expDate = $_POST['expDate'];
		
		$sql_query = "INSERT INTO ingredients (ingredientName, allergen, ingredientType, calories, amount, unit, expDate, userId)
			VALUES ('$name', '$allergen', '$type', '$calories', '$amount', '$unit', '$expDate', '$id')";
		

		$database->exec($sql_query);

		

	} 

	if (isset($_POST['updateIngredient'])) {

		
		$name = $_POST['ingredient'];
		$allergen = $_POST['allergen'];
		$type = $_POST['ingredientType'];
		$calories = $_POST['calories'];
		$amount = $_POST['amount'];
		$unit = $_POST['unit'];
		$expDate = $_POST['expDate'];
		$ingredientId =  $_POST['ingredientId'];

		
		$updateIngredientQuery = "UPDATE ingredients SET ingredientName = '$name', allergen = '$allergen', ingredientType = '$type', calories = '$calories', amount = '$amount', unit = '$unit', expDate = '$expDate' WHERE userId = '$id' AND ingredientId = '$ingredientId'";


		$database->exec($updateIngredientQuery);
				
		


	} 
		
		


	if (isset($_POST['AddShoppingList'])) {

		
		$name = $_POST['ingredient'];
		$amount = $_POST['amount'];
		$unit = $_POST['unit'];
		
		addToShoppingList($name, $amount, $unit, $id, $database);

		

	} 
    
    ?>
	<div class="hero">
		<p>Current Ingredients</p>
	</div>

	



	
	


	<div class='d-flex justify-content-center gap-2'>
		<button title="Low-Stock Ingredients" data-toggle="popover" data-trigger="hover" data-content="
		
		<?php
			
			$dateToday = date("Y-m-d");

			$sql_query = "SELECT ingredientName, expDate, amount, unit, ingredientId FROM ingredients WHERE (userId = '$id')";


			$res = $database->query($sql_query);

			$showHeader = TRUE;
				
			$count = 1;

			while ($row = $res->fetchArray()) {

				if ($row['amount'] <= 2) {


					if (getAutoAddToggle($database, $id) == 1) {
						addToShoppingList($row['ingredientName'], null, null, $id, $database, $row['ingredientId'], FALSE);
					}


					if ($count == 1) {
						echo $row['ingredientName'];
					} else {
						echo ', '. $row['ingredientName'];
					}
					

					$count++;
					$notificationBool = TRUE;
				}
			}

		?>" class="btn btn-primary"><i class="fa fa-bell"></i></button>

		<button title="Expired Ingredients" data-toggle="popover" data-trigger="hover" data-content="
		
		<?php

			$count = 1;
			while ($row = $res->fetchArray()) {

				
				if ( strtotime($row['expDate']) < time() && !empty($row['expDate'])) {
						
					if (getAutoAddToggle($database, $id) == 1) {
						addToShoppingList($row['ingredientName'], null, null, $id, $database, $row['ingredientId'], FALSE);
					}

					if ($count == 1) {
						echo $row['ingredientName'];
					} else {
						echo  ', '. $row['ingredientName'];
					}
					
					$count++;
					$notificationBool = TRUE;
				}
			}
				
		

				
		?>" class="btn btn-primary"><i class="fa fa-clock-o"></i></button>

		<?php
			if ($notificationBool == TRUE && !isset($_SESSION['notificationBool']) && getNotificationToggle($database, $id) == 1) {
					
				if (getAutoAddToggle($database, $id) == 1) {
					echo '<script>alert("One or more of your ingredients are running low and/or expiring. These ingredients will be added to your shopping list.");</script>';
				} else {
					echo '<script>alert("One or more of your ingredients are running low and/or expiring");</script>';
				}
				
				
				
				$_SESSION['notificationBool'] = TRUE;
				
			}
		?>
			
		

		<!-- Button that triggers the popup that asks you to add an ingredient -->
		<button type="button" class="btn btn-primary shadow-none" data-toggle="modal" data-target="#add-ingredient-form-container"><i class="fa fa-plus"></i></button>

		<!-- Modal -->
		<div class="modal fade" id="add-ingredient-form-container" tabindex="-1" role="dialog" aria-labelledby="addIngredientModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" >Add Ingredient</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="dashboard.php" method="POST">
					<div class="modal-body">
						

							<label for="ingredient">Ingredient Name:</label>
							<input type="text" id = "ingredient" name="ingredient" required><br>

							<label for="allergen" class="label">Allergens:</label>
							<select name="allergen" id="allergen">
								<option value="" disabled selected>Choose an allergen</option>
								<option value="none">None</option>
								<option value="dairy">Dairy</option>
								<option value="eggs">Eggs</option>
								<option value="fish">Fish</option>
								<option value="shellfish">Shellfish</option>
								<option value="treenuts">Tree nuts</option>
								<option value="peanuts">Peanuts</option>
								<option value="soy">Soy</option>
								<option value="sesame">Sesame</option>
								<option value="mustard">Mustard</option>
								<option value="wheat">Wheat</option>
								<option value="celery">Celery</option>
							</select><br>
							

							<label for="ingredientType" class="label">Type:</label>
							<select name="ingredientType" id="ingredientType">
								
								<option value="" disabled selected>Choose a food type</option>
								<option value="veggies">Vegetables</option>
								<option value="fruits">Fruits</option>
								<option value="grains">Grains</option>
								<option value="redmeat">Red Meat</option>
								<option value="poultry">Poultry</option>
								<option value="seafood">Seafood</option>
								<option value="dairy">Dairy</option>
								<option value="nuts">Nuts</option>
								<option value="fats">Fats & Oil</option>
								<option value="spices">Spices & Herbs</option>
								<option value="sugar">Sugar</option>
								<option value="processed">Processed</option>
							</select><br>
							


							<label for="calories" class="label" width=200>Calories per Serving:</label>
							<input type="number" step="1" id="calories" name="calories" min="0" max="99999" size="5"><br>

							<label for="amount" class="label" width=150>Amount:</label>
							<input type="number" step="1" id="amount" name="amount" min="0" max="99999" size="5" required><br>

							<label for="unit" class="label">Unit:</label>
							<select name="unit" id="unit">
								<option value="" disabled selected>Choose a unit</option>
								<option value="g">g</option>
								<option value="kg">kg</option>
								<option value="mg">mg</option>
								<option value="lb">lb</option>
								<option value="oz">oz</option>
								<option value="L">L</option>
								<option value="mL">mL</option>
								<option value="tsp">tsp</option>
								<option value="tbsp">tbsp</option>
								<option value="fl oz">fl oz</option>
								<option value="cup">cup</option>
								<option value="pt">pt</option>
								<option value="qt">qt</option>
								<option value="gal">gal</option>
							</select>
							<br>
							
							<label for="expDate" class="label">Expiration Date:</label>
							<input type="date" id="expDate" name="expDate">



							<br>
							

						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						
						<input type="submit" class="btn btn-primary" name = "saveIngredient" value="Save Ingredient">
					</div>
					</form>
				</div>
			</div>
		</div>
		
		
		<button class="btn btn-primary" id="btn-add-shopping"><i class="fa fa-shopping-cart"></i></button>
	</div>
	
	<div class="search">
		<input id="searchIngredient"  class = "text-inside" type = "text" placeholder = "Search for ingredient">
		
	</div>
	

	<script>
		$(document).ready(function(){
		$('[data-toggle="popover"]').popover({sanitize: false});   
		});
	</script>

	<div class='w-75 mx-auto'>
    <table class="table table-striped table-bordered table-hover table-sm table-fixed">
	    <thead>
			<tr>
				<th class="hidden">Add to Shopping List</th>
				<th>Food names</th>
				<th>Allergens</th>
				<th>Type of cuisines</th>
				<th>Calories (per serving)</th>
				<th>Amount</th>
				<th>Expiration Date</th>
				<th></th>
			</tr>
		</thead>
		<tbody id="searchTable">
		<?php
		

		
			$sql_query = "SELECT ingredientId, ingredientName, allergen, ingredientType, calories, amount, unit, expDate FROM ingredients WHERE (userId = '$id')";
			
			
			$res = $database->query($sql_query);
			
			while ($row = $res->fetchArray()) {
				echo '<tr>';
				echo '<td class="hidden">
					<form method="POST">
					
					<input style="display: none;" type="text" name="ingredient" value="'. $row['ingredientName'].'">
					<input type="number" step="1" id="amount" name="amount" min="0" max="99999" size="5" required>
					<select name="unit" id="unit">

						<option value="" disabled selected>Choose a unit</option>
                                		<option value="g">g</option>
                                		<option value="kg">kg</option>
                                		<option value="mg">mg</option>
                                		<option value="lb">lb</option>
                                		<option value="oz">oz</option>
                                		<option value="L">L</option>
                                		<option value="mL">mL</option>
                                		<option value="tsp">tsp</option>
                                		<option value="tbsp">tbsp</option>
                                		<option value="fl oz">fl oz</option>
                                		<option value="cup">cup</option>
                                		<option value="pt">pt</option>
                                		<option value="qt">qt</option>
                                		<option value="gal">gal</option>
					</select>
					<input type="submit" name="AddShoppingList" value="Add">
					
					</form>
				</td>';

				echo '<td class="td-display'. $row["ingredientId"]. '">'. $row["ingredientName"]. '</td>';
				echo '<td class="td-display'. $row["ingredientId"]. '">'. $row["allergen"]. '</td>';
				echo '<td class="td-display'. $row["ingredientId"]. '">'. $row["ingredientType"]. '</td>';
				echo '<td class="td-display'. $row["ingredientId"]. '">'. $row["calories"]. '</td>';
				echo '<td class="td-display'. $row["ingredientId"]. '">'. $row["amount"]. ' '. $row["unit"]. '</td>';
				echo '<td class="td-display'. $row["ingredientId"]. '">'. $row["expDate"]. '</td>';

				


				echo '<form id="edit-ingredient-form'. $row["ingredientId"]. '" action="dashboard.php" method="POST"></form>';

				echo '<td class="hidden-td td-input'. $row["ingredientId"]. '"><input form="edit-ingredient-form'. $row["ingredientId"]. '" type="text" id="ingredient" name="ingredient" value="'. $row["ingredientName"].'" required></td>';

				echo '<td class="hidden-td td-input'. $row["ingredientId"]. '">
				<select form="edit-ingredient-form'. $row["ingredientId"]. '" name="allergen" id="allergen">
					<option value="" '. ($row["allergen"] == "" ? "selected" : ""). '  disabled>Choose an allergen</option>
					<option value="none" '. ($row["allergen"] == "none" ? "selected" : ""). ' >None</option>
					<option value="dairy" '. ($row["allergen"] == "dairy" ? "selected" : ""). ' >Dairy</option>
					<option value="eggs" '. ($row["allergen"] == "eggs" ? "selected" : ""). ' >Eggs</option>
					<option value="fish" '. ($row["allergen"] == "fish" ? "selected" : ""). ' >Fish</option>
					<option value="shellfish" '. ($row["allergen"] == "shellfish" ? "selected" : ""). ' >Shellfish</option>
					<option value="treenuts" '. ($row["allergen"] == "treenuts" ? "selected" : ""). ' >Tree nuts</option>
					<option value="peanuts" '. ($row["allergen"] == "peanuts" ? "selected" : ""). ' >Peanuts</option>
					<option value="soy" '. ($row["allergen"] == "soy" ? "selected" : ""). ' >Soy</option>
					<option value="sesame" '. ($row["allergen"] == "sesame" ? "selected" : ""). ' >Sesame</option>
					<option value="mustard" '. ($row["allergen"] == "mustard" ? "selected" : ""). ' >Mustard</option>
					<option value="wheat" '. ($row["allergen"] == "wheat" ? "selected" : ""). ' >Wheat</option>
					<option value="celery" '. ($row["allergen"] == "celery" ? "selected" : ""). ' >Celery</option>
				</select>
				</td>';


				echo '<td class="hidden-td td-input'. $row["ingredientId"]. '">
				<select form="edit-ingredient-form'. $row["ingredientId"]. '" name="ingredientType" id="ingredientType">
				
					<option value="" '. ($row["ingredientType"] == "" ? "selected" : ""). ' disabled>Choose a food type</option>
					<option value="veggies" '. ($row["ingredientType"] == "veggies" ? "selected" : ""). ' >Vegetables</option>
					<option value="fruits" '. ($row["ingredientType"] == "fruits" ? "selected" : ""). ' >Fruits</option>
					<option value="grains" '. ($row["ingredientType"] == "grains" ? "selected" : ""). ' >Grains</option>
					<option value="redmeat" '. ($row["ingredientType"] == "redmeat" ? "selected" : ""). ' >Red Meat</option>
					<option value="poultry" '. ($row["ingredientType"] == "poultry" ? "selected" : ""). ' >Poultry</option>
					<option value="seafood" '. ($row["ingredientType"] == "seafood" ? "selected" : ""). ' >Seafood</option>
					<option value="dairy" '. ($row["ingredientType"] == "dairy" ? "selected" : ""). ' >Dairy</option>
					<option value="nuts" '. ($row["ingredientType"] == "nuts" ? "selected" : ""). ' >Nuts</option>
					<option value="fats" '. ($row["ingredientType"] == "fats" ? "selected" : ""). ' >Fats & Oil</option>
					<option value="spices" '. ($row["ingredientType"] == "spices" ? "selected" : ""). ' >Spices & Herbs</option>
					<option value="sugar" '. ($row["ingredientType"] == "sugar" ? "selected" : ""). ' >Sugar</option>
					<option value="processed" '. ($row["ingredientType"] == "processed" ? "selected" : ""). ' >Processed</option>
				</select></td>';

				echo '<td class="hidden-td td-input'. $row["ingredientId"]. '"><input form="edit-ingredient-form'. $row["ingredientId"]. '" type="number" step="1" id="calories" name="calories" min="0" max="99999" size="5" value="'. $row["calories"]. '"></td>';


				echo '<td class="hidden-td td-input'. $row["ingredientId"]. '"><input form="edit-ingredient-form'. $row["ingredientId"]. '" type="number" step="1" id="amount" name="amount" min="0" max="99999" size="5" value="'. $row["amount"]. '"required>
				<select form="edit-ingredient-form'. $row["ingredientId"]. '" name="unit" id="unit">
					<option value="" '. ($row["unit"] == "" ? "selected" : ""). ' disabled>Choose a unit</option>
					<option value="g" '. ($row["unit"] == "g" ? "selected" : ""). ' >g</option>
					<option value="kg" '. ($row["unit"] == "kg" ? "selected" : ""). ' >kg</option>
					<option value="mg" '. ($row["unit"] == "mg" ? "selected" : ""). ' >mg</option>
					<option value="lb" '. ($row["unit"] == "lb" ? "selected" : ""). ' >lb</option>
					<option value="oz" '. ($row["unit"] == "oz" ? "selected" : ""). ' >oz</option>
					<option value="L" '. ($row["unit"] == "L" ? "selected" : ""). ' >L</option>
					<option value="mL" '. ($row["unit"] == "mL" ? "selected" : ""). ' >mL</option>
					<option value="tsp" '. ($row["unit"] == "tsp" ? "selected" : ""). ' >tsp</option>
					<option value="tbsp" '. ($row["unit"] == "tbsp" ? "selected" : ""). ' >tbsp</option>
					<option value="fl oz" '. ($row["unit"] == "fl oz" ? "selected" : ""). ' >fl oz</option>
					<option value="cup" '. ($row["unit"] == "cup" ? "selected" : ""). ' >cup</option>
					<option value="pt" '. ($row["unit"] == "pt" ? "selected" : ""). ' >pt</option>
					<option value="qt" '. ($row["unit"] == "qt" ? "selected" : ""). ' >qt</option>
					<option value="gal" '. ($row["unit"] == "gal" ? "selected" : ""). ' >gal</option>
				</select>
				</td>';

				echo '<td class="hidden-td td-input'. $row["ingredientId"]. '"><input form="edit-ingredient-form'. $row["ingredientId"]. '" type="date" id="expDate" name="expDate" value="'. $row["expDate"]. '"></td>';


				echo '<td style="display:none;"><input form="edit-ingredient-form'. $row["ingredientId"]. '" type="number" name="ingredientId" value="'. $row["ingredientId"].'"></td>';
				
				echo '<td><a class="btn btn-primary btn-edit" id="edit-ingredient-btn-'. $row["ingredientId"]. '"><i class="fa fa-edit"></i></a>
				<a class="btn btn-danger btn-delete" id="delete-ingredient-btn'. $row["ingredientId"]. '" href="deleteIngredient.php?id='.$row["ingredientId"].'"><i class="fa fa-trash-o"></i></a>
				
				<button form="edit-ingredient-form'. $row["ingredientId"]. '" type="submit" name="updateIngredient" id="update-ingredient-btn'. $row["ingredientId"]. '" class="btn btn-success btn-save"><i class="fa fa-save"></i></button></td>';

				

				
				
				echo '</tr>';
				
			}
			
			
			

		
		?>
		</tbody>
		

	</table>
	</div>
	

	<script src="toggle.js"></script>
	<script>




		

		$('#btn-add-shopping').click(function()  {
			ToggleContainer('#btn-add-shopping', '.hidden', '<i class="fa fa-shopping-cart"></i>', '<i class="fa fa-close"></i>');


		});	

		



		$('.btn-edit').click(function(){

			var ingredientId = $(this).attr('id').split('-')[3];
			console.log($(this).attr('id'))
			ToggleEdit('#' + $(this).attr('id'), '#delete-ingredient-btn' + ingredientId, '#update-ingredient-btn' + ingredientId, "td[class='hidden-td td-input" + ingredientId + "']", "td[class='td-display" + ingredientId + "']", '<i class="fa fa-edit"></i>', '<i class="fa fa-close"></i>');

		});

	
	//Used from https://www.w3schools.com/jquery/tryit.asp?filename=tryjquery_filters_table
        $(document).ready(function(){
          $("#searchIngredient").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#searchTable tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
          });
        });
        
	</script>

</body>
</html>
