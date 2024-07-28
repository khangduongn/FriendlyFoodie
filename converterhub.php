<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/converthub.css">
  <link rel="stylesheet" href="./css/navbar.css">
	<link rel="stylesheet" href="./css/searcher.css">
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
  <title>Unit Converter</title>
        
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
			<a class="active" href="converterhub.php">Unit Converter</a>
			<a href="searcher.php">Recipe Finder</a>
			<a href="setting.php"><img  id="gear-icon" src="images/settings.png"></a>
			<a href="logout.php"><img  id="logout-icon" src="images/logoutlogout2.png"></a>
			</div>
			
		</nav>
	</div>
  <div class="hero">
		<p> Convert Units Here</p>
	</div>
      
<div class="convert">
  <h2> Convert Pounds </h2>
    <input id="inputpounds" type="number" placeholder="Pounds" oninput="unitconverter(this.value)" onchange="unitconverter(this.value)">

    <p>Ounces: <span id="u1"></span></p>
    <p>Grams: <span id="u2"></span></p>
    <p>Kilograms: <span id="u3"></span></p>

    <script>
    function unitconverter(valNum) {
      document.getElementById("u1").innerHTML=valNum*16;
      document.getElementById("u2").innerHTML=valNum*(56699/125);
      document.getElementById("u3").innerHTML=valNum*(56699/125000);
    }
    </script>
    
    
    <h2> Convert Ounces </h2>
    <input id="inputounces" type="number" placeholder="Ounces" oninput="ounceConverter(this.value)" onchange="ounceConverter(this.value)">

    <p>Pounds: <span id="u4"></span></p>
    <p>Grams: <span id="u5"></span></p>
    <p>Kilograms: <span id="u6"></span></p>

    <script>
    function ounceConverter(valNum) {
      document.getElementById("u4").innerHTML=valNum/16;
      document.getElementById("u5").innerHTML=valNum*(56699/2000);
      document.getElementById("u6").innerHTML=valNum*(56699/2000000);
    }
  </script>


  <h2> Convert Grams </h2>

    <input id="inputgrams" type="number" placeholder="Grams" oninput="gramConverter(this.value)"
      onchange="gramConverter(this.value)">

    <p>Pounds: <span id="u7"></span></p>
    <p>Ounces: <span id="u8"></span></p>
    <p>Kilograms: <span id="u9"></span></p>

    <script>
      function gramConverter(valNum) {
        document.getElementById("u7").innerHTML = valNum / (56699 / 125);
        document.getElementById("u8").innerHTML = valNum / (56699 / 2000);
        document.getElementById("u9").innerHTML = valNum / 1000;
      }
    </script>



  <h2> Convert Kilograms </h2>
    <input id="inputkgram" type="number" placeholder="Kilograms" oninput="kiloconverter(this.value)" onchange="kiloconverter(this.value)">

    <p>Pounds: <span id="uA"></span></p>
    <p>Ounces: <span id="uB"></span></p>
    <p>Grams: <span id="uC"></span></p>

    <script>
      function kiloconverter(valNum) {
        document.getElementById("uA").innerHTML=valNum/(56699/125000);
        document.getElementById("uB").innerHTML=valNum/(56699/2000000);
        document.getElementById("uC").innerHTML=valNum*1000;
      }
    </script>
</div>
</body>

<!-- This page was created with assitance from this W3schools tutorial https://www.w3schools.com/howto/howto_js_length_converter.asp-->

</html>



