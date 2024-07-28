<!DOCTYPE html>
<html lang="en">

<head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Notifications</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
        <ul class="nav nav-pills">
                <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                        <a class="nav-link" href="shoppinglist.php">Shopping List</a>
                </li>
                <li class="nav-item">
                        <a class="nav-link" href="converterhub.html">Unit Converter</a>
                </li>
                <li class="nav-item">
                        <a class="nav-link" href="searcher.html">Recipe Finder</a>
                </li>
                <li class="nav-item">
                        <a class="nav-link active" href="setting.php">Settings</a>
                </li>
                <li class="nav-item">
                        <a class="nav-link" href="logout.php">Log Out</a>
                </li>
        </ul>

        <?php

                session_start();
                require_once('database.php');
                $id = $_SESSION['id'];
                
              
                
        ?>

        <h1>Settings</h1>
        <br>
        <script>
                       
                function checkNotify() {
                        
                        $.getScript("updateNotification.php");
                }

        </script>
        <div class="list-group">
                <a href="notification.php" class="list-group-item list-group-item-action active">Web notifications</a>
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
                <a href="autoadd.php" class="list-group-item list-group-item-action">Auto-add</a>
        </div>
</body>

</html>