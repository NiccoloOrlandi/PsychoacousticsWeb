<!doctype html>
<html lang="en">
    
	<head>
		<?php 
			session_start();
			if(!isset($_SESSION['usr']) || !isset($_SESSION['idGuest'])) 
				header("Location: index.php");
			include "php/config.php";
		?>
		
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/x-icon" href="files/logo.png">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<link rel ="stylesheet" href="css/style.css<?php if (isset($_SESSION['version'])) echo "?{$_SESSION['version']}"; ?>">

		<title>Psychoacoustics-web - Test results</title>
	</head>
	<body>
	
		<nav class="navbar navbar-dark bg-dark">
			<div class="container-fluid" >
			  <a class="navbar-brand" href="index.php" >
				<img src="files/logo.png" alt="" width="25" height="25" class="d-inline-block align-text-top" >
				PSYCHOACOUSTICS
				
			  </a>
			  <form class="container-fluid logButtons">
				<?php				
					echo "<label class='welcomeMessage'>Welcome ".$_SESSION['usr']."</label>";
					echo "<button class=\"btn btn-outline-danger logout\" type=\"button\" onclick=\"location.href='php/logout.php'\">Log Out</button>";
				?>
			  </form>
			 
			</div>
		</nav>
		
		<h1>Welcome <?php echo $_SESSION['usr'];?></h1>
		
		<button type='button' class='btn btn-primary btn-lg m-3' onclick='location.href="php/downloadYours.php?all=1"'>Download all your data</button>
		<button type='button' class='btn btn-primary btn-lg m-3' onclick='location.href="php/downloadYours.php?all=0"'>Download all your guest's data</button>
		
		<?php
			try{
				$conn = new mysqli($host, $user, $password, $dbname);
				
				if ($conn->connect_errno)
					throw new Exception('DB connection failed');
				
				mysqli_set_charset($conn, "utf8");
				
				$usr = $_SESSION['usr'];
				$id = $_SESSION['idGuest'];
				
				$sql = "SELECT Type FROM account WHERE Guest_ID='$id' AND Username='$usr'";
				$result=$conn->query($sql);
				$row=$result->fetch_assoc();
				if($row['Type'] == 1){
					echo "<button type='button' class='btn btn-primary btn-lg m-3' onclick='location.href=\"php/downloadAll.php\"'>Download all the data in the database</button>";
				}
			}catch(Exception $e){
				header("Location: index.php?err=db");
			}
		?>
		
		<h3>Your results</h3>
		
		<table>
			<tr class="tableHeader">
				<td>Test</td>
				<td>Time</td>
				<td>Type</td>
			</tr>
			<?php
				try{
					$sql = "SELECT Test_count, Timestamp, Type FROM test WHERE Guest_ID='$id'";
					$result=$conn->query($sql);
					while($row=$result->fetch_assoc()){
						echo "<tr>";
						echo "<td>".$row["Test_count"]."</td>";
						echo "<td>".$row["Timestamp"]."</td>";
						echo "<td>".$row["Type"]."</td>";
						echo "</tr>";
					}
				}catch(Exception $e){
					header("Location: index.php?err=db");
				}
			?>
		</table>
		
		<h3>Your guest's results</h3>
		
		<table>
			<tr class="tableHeader">
				<td>Name</td>
				<td>Test</td>
				<td>Time</td>
				<td>Type</td>
			</tr>
			<?php
				try{
					$sql = "SELECT Name, Test_count, Timestamp, Type FROM test INNER JOIN guest ON Guest_ID=ID WHERE fk_guest='{$_SESSION['usr']}'";
					$result=$conn->query($sql);
					while($row=$result->fetch_assoc()){
						echo "<tr>";
						echo "<td>".$row["Name"]."</td>";
						echo "<td>".$row["Test_count"]."</td>";
						echo "<td>".$row["Timestamp"]."</td>";
						echo "<td>".$row["Type"]."</td>";
						echo "</tr>";
					}
				}catch(Exception $e){
					header("Location: index.php?err=db");
				}
			?>
		</table>
		
		<button type="button" class="btn btn-primary btn-lg m-3" id="home" onclick = "location.href='index.php'">Home</button>
	</body>
</html>


