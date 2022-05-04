<!doctype html>
<html lang="en">
    
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link rel ="stylesheet" href="test.css">

		<title>Test results</title>
		<?php 
			session_start();
			include "config.php";
		?>
	</head>
	<body>
		<?php
			$conn = new mysqli($host, $user, $password, $dbname);
			
			if ($conn->errno)
				die("Problemi di connessione" . $conn->error);
			
			mysqli_set_charset($conn, "utf8");
			
			$usr = $_SESSION['usr'];
			$id = $_SESSION['idGuest'];
			
			$sql = "SELECT * FROM test WHERE Guest_ID='$id'";
			$result=$conn->query($sql);
			while($row=$result->fetch_assoc()){
				echo "#test: ".$row["Test_count"]." - ";
				echo "time: ".$row["Timestamp"]." - ";
				echo "type: ".$row["Type"]." - ";
				
				//calcolo risultato
				$results = $row["Result"];
				$posSemicolon = 0;
				for($i=0;$i<strlen($results)-1;$i++){//trovo l'ultima riga di risultati
					if($results[$i]==';')
						$posSemicolon = $i;
				}
				$results = substr($results, $posSemicolon, strlen($results)-$posSemicolon);
				$posComma = 0;
				$delta = "";
				for($i=0, $j=0;$j<3;$i++){//trovo il valore di delta in quella riga
					if($results[$i]==','){
						$delta = substr($results, $posComma+1, $i-$posComma-1);
						$posComma = $i;
						$j++;
					}
				}
		
				echo "result: ".$delta."<br>";
			}
		?>
						<button type="button" class="btn btn-primary btn-lg m-3" id="home" onclick = "location.href='index.php'">Home</button>
	</body>
</html>


