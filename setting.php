<!DOCTYPE html>
<html lang="en">
    <head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>Settings</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="./css/setting.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
		<link rel="stylesheet" href="./css/navbar.css">
	</head>
    
	<body>
        <div class="nav-parent">
		<nav class="navigation-bar">
			<div class="nav-logo">
				<a href="dashboard.php"><img class="logo" src="images/Food Icon.jpg"></a>
			</div>
		
			<div class="nav-buttons">
			
				<a href="dashboard.php">Dashboard</a>
				<a href="shoppinglist.php">Shopping List</a>
				<a href="converterhub.php">Unit Converter</a>
				<a href="searcher.php">Recipe Finder</a>
				<a class="active" href="setting.php"><img  id="gear-icon" src="images/settings.png"></a>
				<a href="logout.php"><img  id="logout-icon" src="images/logoutlogout2.png"></a>
			</div>
			
			
		</nav>
	</div>
        <div class="hero">
		<p>Settings</p>
	</div>
		<?php
			session_start();
			require_once('database.php');
			$id = $_SESSION['id'];

		?>
		
		<br>
		<script>
			function checkNotify() {
                        
                        	$.getScript("updateNotification.php");
                	}

			function checkAutoAdd() {
                                
                                $.getScript("updateAutoAdd.php");
                        }
		</script>

		<div class="list-group">
		  <li class="list-group-item">Web notifications</li>
		  <div class="form-check form-switch">
                        <br>
                <?php

                        if (getNotificationToggle($database, $id) == 1) {
                
                                echo '<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked onclick="checkNotify();" />';

                        } else {

                                echo '<input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" onclick="checkNotify();" />';

                        }

                ?>
                        
                <label class="form-check-label" for="flexSwitchCheckDefault">Notify when an ingredient is
                        running low</label>
                <br><br>

                


                </div>
		  <li class="list-group-item">Auto-add</li>
		  <div class="form-check form-switch">
                                <br>
                                <?php

                                if (getAutoAddToggle($database, $id) == 1) {
                        
                                        echo '<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked onclick="checkAutoAdd();" />';

                                } else {

                                        echo '<input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" onclick="checkAutoAdd();" />';

                                }


                                ?>     
                                <label class="form-check-label" for="flexSwitchCheckDefault">Automatically add low-stock ingredient</label>        
           
                                <br><br>
                        </div>
		</div>

		
	</body>
	
</html>
