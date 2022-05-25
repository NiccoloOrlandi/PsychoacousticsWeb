<!doctype html>
<html lang="en">
    
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/x-icon" href="logo.png">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<link rel ="stylesheet" href="yourTests.css">

		<title>Psychoacoustics-web - Test results</title>
		<?php 
			session_start();
			if(!isset($_SESSION['usr']) || !isset($_SESSION['idGuest'])) 
				header("Location: index.php");
			include "config.php";
		?>
	</head>
	<body>
	
		<nav class="navbar navbar-dark bg-dark">
			<div class="container-fluid" >
			  <a class="navbar-brand" href="index.php" >
				<img src="colore.png" alt="" width="30" height="24" class="d-inline-block align-text-top" >
				PSYCHOACOUSTICS
				
			  </a>
			  <form class="container-fluid logButtons">
				<?php				
					echo "<label class='welcomeMessage'>Benvenuto ".$_SESSION['usr']."</label>";
					echo "<button class=\"btn btn-outline-danger logout\" type=\"button\" onclick=\"location.href='logout.php'\">Log Out</button>";
				?>
			  </form>
			 
			</div>
		</nav>
		
		<h1>Benvenuto <?php echo $_SESSION['usr'];?></h1>
		
		<button type='button' class='btn btn-primary btn-lg m-3' onclick='location.href="downloadYours.php?all=1"'>Download all your datas</button>
		<button type='button' class='btn btn-primary btn-lg m-3' onclick='location.href="downloadYours.php?all=0"'>Download all your guest's datas</button>
		
		<?php
			$conn = new mysqli($host, $user, $password, $dbname);
			
			if ($conn->errno)
				die("Problemi di connessione" . $conn->error);
			
			mysqli_set_charset($conn, "utf8");
			
			$usr = $_SESSION['usr'];
			$id = $_SESSION['idGuest'];
			
			$sql = "SELECT Type FROM account WHERE Guest_ID='$id' AND Username='$usr'";
			$result=$conn->query($sql);
			$row=$result->fetch_assoc();
			if($row['Type'] == 1){
				echo "<button type='button' class='btn btn-primary btn-lg m-3' onclick='location.href=\"downloadAll.php\"'>Download all the datas in the database</button>";
			}
		?>
		
		<h3>I tuoi risultati</h3>
		
		<table>
			<tr class="tableHeader">
				<th>Test</th>
				<th>Time</th>
				<th>Type</th>
			</tr>
			<?php
				$sql = "SELECT Test_count, Timestamp, Type FROM test WHERE Guest_ID='$id'";
				$result=$conn->query($sql);
				while($row=$result->fetch_assoc()){
					echo "<tr>";
					echo "<th>".$row["Test_count"]."</th>";
					echo "<th>".$row["Timestamp"]."</th>";
					echo "<th>".$row["Type"]."</th>";
					echo "</tr>";
				}
			?>
		</table>
		
		<h3>I risultati dei Guest collegati</h3>
		
		<table>
			<tr class="tableHeader">
				<th>Name</th>
				<th>Test</th>
				<th>Time</th>
				<th>Type</th>
			</tr>
			<?php
				$conn = new mysqli($host, $user, $password, $dbname);
				
				if ($conn->errno)
					die("Problemi di connessione" . $conn->error);
				
				mysqli_set_charset($conn, "utf8");
				
				$usr = $_SESSION['usr'];
				$id = $_SESSION['idGuest'];
				
				$sql = "SELECT Name, Test_count, Timestamp, Type FROM test INNER JOIN guest ON Guest_ID=ID WHERE fk_guest='{$_SESSION['usr']}'";
				$result=$conn->query($sql);
				while($row=$result->fetch_assoc()){
					echo "<tr>";
					echo "<th>".$row["Name"]."</th>";
					echo "<th>".$row["Test_count"]."</th>";
					echo "<th>".$row["Timestamp"]."</th>";
					echo "<th>".$row["Type"]."</th>";
					echo "</tr>";
				}
			?>
		</table>
		
		<button type="button" class="btn btn-primary btn-lg m-3" id="home" onclick = "location.href='index.php'">Home</button>
	</body>
</html>


