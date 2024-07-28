<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="./css/signup.css">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <title>Sign Up</title>
</head>





<body>
        <!-- this is for the nav bar -->
    <div class="nav-parent">
        <nav class="navigation-bar">
            <div class="nav-logo">
                <a href="index.html"><img class="logo" src="images/Food Icon.jpg"></a>
            </div>
        
            <div class="nav-buttons">
            
            <a class="active" href="signup.php">Sign Up</a></li>
            <a href="login.php">Login</a>
            </div>
            
        </nav>

    </div>

    <!-- <ul>
        <li><a href="index.html">Home</a></li>
        <li>
        <li><a href="login.php">Login</a></li>
    
    </ul> -->

    <?php 
    session_start();
    require_once('database.php');
    

    if (isset($_POST['submit'])) {
        $fname = $_POST["firstname"];
        $lname =  $_POST["lastname"];
        $username = $_POST["username"];
        $email =  $_POST["email"];
        $password1 = $_POST["password1"];
        $password2 =  $_POST["password2"];
        $notifyToggle = TRUE;
        $autoAddToggle = TRUE;

        $sql_query = "SELECT id FROM users WHERE (username = '$username')";

        $res = $database->query($sql_query);
            
        $id = $res->fetchArray()['id'];
        
        

        if ($password1 == $password2 && !isset($id)) {

            $password = MD5($password1);
            
            $sql_query = "INSERT INTO users (firstName, lastName, username, email, password, notifyToggle, autoAddToggle)
                VALUES ('$fname', '$lname', '$username', '$email', '$password', '$notifyToggle', '$autoAddToggle')";
            

            $database->exec($sql_query);

            $sql_query = "SELECT id FROM users WHERE 
                (firstName = '$fname' AND 
                lastName = '$lname' AND
                username = '$username' AND
                email = '$email' AND
                password = '$password')";

            $res = $database->query($sql_query);
            
            $id = $res->fetchArray()['id'];
            
            $_SESSION['id'] = $id;



            header("Location: dashboard.php");





        } else {

            if ($password1 !== $password2) {
                $pass_mismatch = True;
            }

            if (isset($id)) {
                $username_exists = True;
            }

            

        
        } 
            
    

    }
    
    ?>



    
    
    <div class="signup-box">
        <div><h1 class="signup-h1">Sign Up</h1></div>
        
        
        
        <form action="signup.php" method="POST">
            
            <label for="firstname">First name</label><br>
            <input type="text" id="firstname" name="firstname" value="<?php if (isset($_POST['firstname'])) echo $_POST['firstname']; ?>" placeholder="" required><br>

            <label for="lastname">Last name</label><br>
            <input type="text" id="lastname" name="lastname" value="<?php if (isset($_POST['lastname'])) echo $_POST['lastname']; ?>" placeholder="" required><br>

            
            <label for="username">Username</label><br>
            <input type="text" id="username" name="username" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>" placeholder="" required><br>


            <label for="email">Email</label><br>
            <input type="email" name="email" id="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" placeholder="" required><br>

            <label for="password1">Password</label><br>
            <input type="password" name="password1" id="password1" placeholder="" required><br>

            <label for="password2">Confirm password</label><br>
            <input type="password" name="password2" id="password2" placeholder="" required><br>
            
            <?php 
            if (isset($pass_mismatch)){
                echo "<p class='error-message'>Passwords do not match. Try again.</p>";
            }
            if (isset($username_exists)){
                echo "<p class='error-message'>Username already exists. Try again.</p>";
            }
            ?>
        


            <input class="submit-button" type="submit" name = 'submit' value="Join now">
          


        </form>


    </div>

</body>
</html>