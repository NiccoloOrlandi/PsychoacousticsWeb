<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/x-icon" href="logo.png">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel ="stylesheet" href="style.css">
		<script type="text/javascript" src="funzioni.js"></script>

		<title>Psychoacoustics-web</title>

		<?php session_start(); ?>
	</head>

	<body>

		<!-- Barra navigazione -->
		<nav class="navbar navbar-dark bg-dark">
			<div class="container-fluid" >
			  <a class="navbar-brand" href="index.php" >
				<img src="logo.png" alt="" width="25" height="25" class="d-inline-block align-text-top" >
				PSYCHOACOUSTICS
				
			  </a>
			  <form class="container-fluid logButtons">
				<?php 
					if(!isset($_SESSION["usr"])){
						if(isset($_SESSION["idGuest"]))
							unset($_SESSION["idGuest"]);
						echo "<button class=\"btn btn-outline-danger \" type=\"button\" onclick=\"location.href='registrazione.php'\" >Sign Up</button>";
						echo "<button class=\"btn btn-outline-success me-2\" type=\"button\" onclick=\"location.href='login.php'\">Log In</button>";
					}else{
						echo "<label class='welcomeMessage'>Welcome ".$_SESSION['usr']."</label>";
						echo "<a class='settings' href='userSettings.php'><i class='material-icons rotate'>settings</i></a>";
						echo "<button class=\"btn btn-outline-primary yourTests\" type=\"button\" onclick=\"location.href='yourTests.php'\">Your tests</button>";
						echo "<button class=\"btn btn-outline-danger logout\" type=\"button\" onclick=\"location.href='logout.php'\">Log Out</button>";
					}
				?>
			  </form>
			 
			</div>
		</nav>

		<?php
		if(isset($_GET['err'])){
			if($_GET['err']==1)
				echo "<div class='alert alert-danger'>Access denied, attempt logged</div>";
			if($_GET['err']==2)
				echo "<div class='alert alert-danger'>Something went wrong</div>";
			if($_GET['err']=="db")
				echo "<div class='alert alert-danger'>Something went wrong while trying to connect to the database, please contact an administator</div>";
		}
		?>
		<!-- Descrizione e presentazione -->

		<div class="container-fluid" style="background-color: #fff; ">

			<h3 class="display-3 descriptionTitle"> 
				Welcome to PSYCHOACOUSTICS WEB
			</h3>  
			<h5 class="display-8 description"> 
				PSYCHOACOUSTICS-WEB is a web developed tool to measure auditory sensory thresholds for a 
				variety of classic tasks. You can run each test as a gues or you can create your personal 
				account and costumize the toolbox for your own research. Please refer to the <a href="">instruction 
				manual</a> for further info on how to use the toolbox.
			</h5>
		</div>

		<!-- cards -->

		<div class="card">
			<div class="card-body">
				<h5 class="card-title" >Pure tone intensity discrimination</h5>
				<p class="card-text" >
					This task estimate the intensity discrimination threshold for a pure tone. 
					In the task you can set up the characteristics of the tone as well as 
					the characteristics of the adaptive staircase. The test implements the 
					following adaptive staircase algorithms: simple up-down, 2-down 1-up, 
					and 3-down 1-up. Please refer to Levitt (JASA, 1971) for more info on 
					these adaptive staircases.
				</p>
				<a href="#" class="btn btn-primary darkred" id="test-button" onmouseover="changeColor()" onmouseleave="leave()" onclick="location.href='demographicData.php?test=amp'" >Run the test</a>
			</div>
		</div>



		<div class="card">
			<div class="card-body">
				<h5 class="card-title">Pure tone frequency discrimination</h5>
				<p class="card-text">
					This task estimate the frequency discrimination threshold for a pure tone. 
					In the task you can set up the characteristics of the tone as well as 
					the characteristics of the adaptive staircase. The test implements the 
					following adaptive staircase algorithms: simple up-down, 2-down 1-up, 
					and 3-down 1-up. Please refer to Levitt (JASA, 1971) for more info on 
					these adaptive staircases.
				</p>
				<!-- passo il tipo di test come parametro nell'url -->
				<a href="#" class="btn btn-primary darkred" id="test-button" onmouseover="changeColor()" onmouseleave="leave()" onclick="location.href='demographicData.php?test=freq'" >Run the test</a>
			</div>
		</div>


		<div class="card">
			<div class="card-body">
				<h5 class="card-title">Pure tone duration discrimination</h5>
				<p class="card-text">
					This task estimate the duration discrimination threshold for a pure tone. 
					In the task you can set up the characteristics of the tone as well as 
					the characteristics of the adaptive staircase. The test implements the 
					following adaptive staircase algorithms: simple up-down, 2-down 1-up, 
					and 3-down 1-up. Please refer to Levitt (JASA, 1971) for more info on 
					these adaptive staircases.
				</p>
				<a href="#" class="btn btn-primary darkred" id="test-button" onmouseover="changeColor()" onmouseleave="leave()" onclick="location.href='demographicData.php?test=dur'" >Run the test</a>
			</div>
		</div>

		<!-- Option 1: Bootstrap Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	</body>
</html>
