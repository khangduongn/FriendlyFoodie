<!DOCTYPE html>
<!--login page-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/login.css">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
   
    <title>Login</title>
</head>
<body>
    <!-- this is for the nav bar -->
    <div class="nav-parent">
        <nav class="navigation-bar">
            <div class="nav-logo">
                <a href="index.html"><img class="logo" src="images/Food Icon.jpg"></a>
            </div>
        
            <div class="nav-buttons">
            
            <a href="signup.php">Sign Up</a>
            <a href="login.php">Login</a>
            </div>
            
        </nav>

    </div>

    <?php  
    session_start();
    require_once('database.php');
    
    if (isset($_POST['login'])){

        $username = $_POST['username'];
        $password = MD5($_POST['password']);


    
        $sql_query = "SELECT id FROM users WHERE 
            (username = '$username' AND
            password = '$password')";

        $res = $database->query($sql_query);

        $id = $res->fetchArray()['id'];
            
        if (isset($id)){
            $_SESSION['id'] = $id;
         

            header('Location: dashboard.php');

        } else {

            $incorrect_login = True;
        }
        


    }
    
    ?>

    

    <div class="login-box">
        <form action="login.php" method="POST">
        <?php 
        if (isset($incorrect_login)){
    
            echo "<p class='error-message'>Incorrect username and/or password. Try again.</p>";
        }
        ?>

        <h1 class="login-h1">Login Here</h1>

        <label for="username">Username</label>
        <input class = "text-inside" type = "text" name = "username" >
        
        <label for="password">Password</label>
        <input class = "text-inside" type = "password" name="password" >

        <input type="submit" class="submit-button" name = "login" value="Login">
        </form>


        

        <p>New user? <a href="signup.php">Create Account here!</a></p>
        <p>Forgot password? <a href="passwordresetemail.html">Reset your password here!</a></p>


    </div>
    
    
</body>
</html>
