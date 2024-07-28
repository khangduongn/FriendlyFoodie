<!DOCTYPE html>
<head>
	<title>Shopping List</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

	<link rel="stylesheet" href="./css/shoppinglist.css">
	<link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
	<link rel="stylesheet" href="./css/navbar.css">
</head>
<body>
	<?php
		session_start();
		require_once('database.php');
		$id = $_SESSION['id'];
	?>
	<div class="nav-parent">
		<nav class="navigation-bar">
			<div class="nav-logo">
				<a href="dashboard.php"><img class="logo" src="images/Food Icon.jpg"></a>
			</div>
		
			<div class="nav-buttons">
			
				<a href="dashboard.php">Dashboard</a>
				<a class="active" href="shoppinglist.php">Shopping List</a>
				<a href="converterhub.php">Unit Converter</a>
				<a href="searcher.php">Recipe Finder</a>
				<a href="setting.php"><img  id="gear-icon" src="images/settings.png"></a>
				<a href="logout.php"><img  id="logout-icon" src="images/logoutlogout2.png"></a>
			</div>
			
		</nav>
	</div>

	<div class="hero">
		<p>Shopping List</p>
	</div>

	<div class='d-flex justify-content-center gap-2'>
		<!-- Button that triggers the popup that asks you to add an ingredient -->
		<button type="button" class="btn btn-primary shadow-none" data-toggle="modal" data-target="#add-shoppinglist-form-container"><i class="fa fa-plus"></i></button>

		<!-- Modal -->
		<div class="modal fade" id="add-shoppinglist-form-container" tabindex="-1" role="dialog" aria-labelledby="addShoppingListModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" >Add Ingredient</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="shoppinglist.php" method="POST">
					<div class="modal-body">
						

							<label for="ingredient">Ingredient Name:</label>
							<input type="text" id = "ingredient" name="ingredient" required><br>

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
							<br>
							

						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						
						<input type="submit" class="btn btn-primary" name = "addShoppingList" value="Save Ingredient">
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="search">
		<input id="shoppingListSearch" type = "text" placeholder = "Search the shopping list">
	</div>

	
	<table class="table table-striped table-bordered table-hover table-sm">
		<thead>
			<tr>
				
				<th>Ingredients</th>
				<th>Amount</th>
				<th></th>
			</tr>
		</thead>
		<tbody id="ShoppingListTable">
	
	

		<?php 
			
			

			if (isset($_POST['updateIngredientShoppingList'])) {

		
				$name = $_POST['ingredient'];
				$amount = $_POST['amount'];
				$unit = $_POST['unit'];
				$shoppingItemId =  $_POST['shoppingItemId'];
		
				
				$updateShoppingListQuery = "UPDATE shoppinglist SET ingredientName = '$name', amount = '$amount', unit = '$unit' WHERE userId = '$id' AND shoppingItemId = '$shoppingItemId'";
		
		
				$database->exec($updateShoppingListQuery);
						
				
		
		
			} 
			if (isset($_POST['addShoppingList'])) {

		
				$name = $_POST['ingredient'];
				$amount = $_POST['amount'];
				$unit = $_POST['unit'];
				
				$sql_query = "INSERT INTO shoppinglist (ingredientName, amount, unit, userId)
					VALUES ('$name','$amount', '$unit', '$id')";
		
				
				
		
		
				$database->exec($sql_query);
						
				
		
		
			} 
			




			$sql_query = "SELECT shoppingItemId, ingredientName, amount, unit, ingredientId FROM shoppinglist WHERE (userId = '$id')";
					
					
			$res = $database->query($sql_query);
			
			while ($row = $res->fetchArray()) {
				echo '<tr>';
				

				
				if ($row['ingredientId'] != "") {
					
					$ingredientColor='style="color: blue;"';
				} else {
					$ingredientColor='';
				}

				//ingredient name display
				echo '<td class="td-display'. $row["shoppingItemId"]. '" '. $ingredientColor. '>'. $row["ingredientName"]. '</td>';

				//ingredient amount and unit display
				echo '<td class="td-display'. $row["shoppingItemId"]. '">'. $row["amount"]. ' '. $row["unit"].'</td>';

				
				//form used for updating ingredient in shopping list
				echo '<form id="edit-ingredient-form'. $row["shoppingItemId"]. '" action="shoppinglist.php" method="POST"></form>';

				//ingredient name input element
				echo '<td class="hidden-td td-input'. $row["shoppingItemId"]. '"><input form="edit-ingredient-form'. $row["shoppingItemId"]. '" type="text" id="ingredient" name="ingredient" value="'. $row["ingredientName"].'" required></td>';


				//ingredient amount and unit input elements
				echo '<td class="hidden-td td-input'. $row["shoppingItemId"]. '"><input form="edit-ingredient-form'. $row["shoppingItemId"]. '" type="number" step="1" id="amount" name="amount" min="0" max="99999" size="5" value="'. $row["amount"]. '"required>
				<select form="edit-ingredient-form'. $row["shoppingItemId"]. '" name="unit" id="unit">
					<option value="" '. ($row["unit"] == "" ? "selected" : ""). ' disabled>Choose a unit</option>
					<option value="g" '. ($row["unit"] == 'g' ? "selected" : ""). '>g</option>
					<option value="kg" '. ($row["unit"] == 'kg' ?  "selected" : ""). '>kg</option>
					<option value="mg" '. ($row["unit"] == 'mg' ?  "selected" : ""). '>mg</option>
					<option value="lb" '. ($row["unit"] == 'lb' ?  "selected" : ""). '>lb</option>
					<option value="oz" '. ($row["unit"] == 'oz' ?  "selected" : ""). '>oz</option>
					<option value="L" '. ($row["unit"] == 'L' ?  "selected" : ""). '>L</option>
					<option value="mL" '. ($row["unit"] == 'mL' ?  "selected" : ""). '>mL</option>
					<option value="tsp" '. ($row["unit"] == 'tsp' ?  "selected" : ""). '>tsp</option>
					<option value="tbsp" '. ($row["unit"] == 'tbsp' ?  "selected" : ""). '>tbsp</option>
					<option value="fl oz" '. ($row["unit"] == 'fl oz' ?  "selected" : ""). '>fl oz</option>
					<option value="cup" '. ($row["unit"] == 'cup' ?  "selected" : ""). '>cup</option>
					<option value="pt" '. ($row["unit"] == 'pt' ?  "selected" : ""). '>pt</option>
					<option value="qt" '. ($row["unit"] == 'qt' ?  "selected" : ""). '>qt</option>
					<option value="gal" '. ($row["unit"] == 'gal' ? "selected" : ""). '>gal</option>
				</select></td>';
				// echo '<td><a href="deleteIngredientShopping.php?id='.$row["shoppingItemId"].'">&#10006;</a></td>';
				
				echo '<td style="display:none;"><input form="edit-ingredient-form'. $row["shoppingItemId"]. '" type="number" name="shoppingItemId" value="'. $row["shoppingItemId"].'"></td>';

				
				echo '<td><a class="btn btn-primary btn-edit" id="edit-ingredient-btn-'. $row["shoppingItemId"]. '"><i class="fa fa-edit"></i></a>
				<a class="btn btn-danger btn-delete" id="delete-ingredient-btn'. $row["shoppingItemId"]. '" href="deleteIngredientShopping.php?id='.$row["shoppingItemId"].'"><i class="fa fa-trash-o"></i></a>
				
				<button form="edit-ingredient-form'. $row["shoppingItemId"]. '" type="submit" name="updateIngredientShoppingList" id="update-ingredient-btn'. $row["shoppingItemId"]. '" class="btn btn-success btn-save"><i class="fa fa-save"></i></button></td>';

				
				
				
				
				echo '</tr>';

			}
		
			
		
		
		?>
		</tbody>
	</table>

	<!--Used from https://www.w3schools.com/jquery/tryit.asp?filename=tryjquery_filters_table-->
	<script>
		$(document).ready(function(){
          $("#shoppingListSearch").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#ShoppingListTable tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
          });
        });
	</script>

	<script src="toggle.js"></script>

	<script>


		$('.btn-edit').click(function(){

			var shoppingListId = $(this).attr('id').split('-')[3];
			console.log($(this).attr('id'));
			ToggleEdit('#' + $(this).attr('id'), '#delete-ingredient-btn' + shoppingListId, '#update-ingredient-btn' + shoppingListId, "td[class='hidden-td td-input" + shoppingListId + "']", "td[class='td-display" + shoppingListId + "']", '<i class="fa fa-edit"></i>', '<i class="fa fa-close"></i>');

		});

	</script>
</body>
</html>
