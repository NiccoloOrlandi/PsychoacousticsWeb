<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/x-icon" href="logo.png">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<link rel="stylesheet" href="staircaseStyle.css">


		<title>Psychoacoustics-web - Personal info</title>

		<?php 
			include "config.php"; 
			session_start();
			if(!isset($_GET["test"]))
				header("Location: index.php");
		?>
	</head>
	<body>

		<?php
			//se si sceglie un username già esistente verrà messo "?err=1" nell'url
			if(isset($_GET['err'])){
				if($_GET['err']==0)
					echo "<div class='alert alert-danger'>Some inserted characters aren't allowed</div>";
				if($_GET['err']==1)
					echo "<div class='alert alert-danger'>The name field is required</div>";
				else if($_GET['err']==2)
					echo "<div class='alert alert-danger'>The name field is required when using a referral code</div>";
			}
					
		?>

		<div class="container p-4" style="margin-top:15%" >
			<div class="row gx-4">
				<div class="col">
					<div class=" p-3 border bg-light">
					  <form name="staircase" method="post" action="personalInfoValidation.php<?php echo "?test=".$_GET["test"];?>">
						<!-- Contenuto dello slot, qui vanno inseriti tutti i bottoni e i check box del primo slot -->

						<h1>Personal Informations</h1>
						
						<!-- Label -->
						<div class="input-group flex-nowrap">
							<span class="input-group-text" id="name" >Name<?php if(!isset($_SESSION['usr'])) echo "*"; ?></span>
							<input type="text" class="form-control" id="inputName" placeholder="Name" name="name">
						</div>
						
						<div class="input-group flex-nowrap">
						  <span class="input-group-text" id="surname"  >Surname</span>
						  <input type="text" class="form-control" id="inputSurname" placeholder="Surname" name="surname">
						</div>
						
						<div class="input-group flex-nowrap">
						  <span class="input-group-text" id="age" >Age</span>
						  <input type="text" class="form-control" id="inputAge" placeholder="Age" name="age">
						</div>
						
						<div class="input-group flex-nowrap">
						  <span class="input-group-text" id="gender" >Gender</span>
						  <select name='gender' class="form-select">
							<option disabled="disabled" selected value="null" id="NullGender">Select your gender</option>
							<?php 
								$conn = new mysqli($host, $user, $password, $dbname);
								if ($conn->errno)
									die("Problemi di connessione" . $conn->error);
								mysqli_set_charset($conn, "utf8");

								$sql="SELECT COLUMN_TYPE AS ct FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'psychoacoustics_db' AND TABLE_NAME = 'guest' AND COLUMN_NAME = 'gender';";
								$result=$conn->query($sql);
								$row=$result->fetch_assoc();//questa query da un risultato di tipo enum('Male','Female','Non-Binary')

								//metto i valori in un array
								$values = substr($row['ct'], 5, -1);//tolgo "enum(" e ")"
								$values = str_replace("'", "", $values);//tolgo gli apici
								$list = explode(",", $values);//divido in una lista in base alle virgole
								
								//creo un'opzione per ogni possibile valore
								foreach($list as $elem)
									echo "<option value='".strtoupper($elem)."'>".strtoupper($elem)."</option>";
							?>
						  </select>
						</div>
						
						<div class="input-group flex-nowrap" id="notesDiv">
						  <span class="input-group-text" id="notes">Notes</span>
						  <input type="text" class="form-control" id="inputNotes" placeholder="Notes" name="notes">
						</div>
						
						<div class="input-group flex-nowrap referral">
						  <span class="input-group-text" id="notes">Referral code</span>
						  <input type="text" class="form-control" id="ref" name="ref" onchange="verifyRef()" value="<?php if(isset($_GET['ref'])) echo $_GET['ref']; ?>">
						</div>
						
						<?php
						  if(isset($_SESSION['usr'])){
							echo ' <div class="form-check">
								  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name= "checkSave" checked>
								  <label class="form-check-label" for="flexCheckDefault">
									Save results
								  </label>
							  </div>';
						  }
						?>
						
						<button type="button" class="btn btn-primary btn-lg m-3" onclick = "location.href='index.php'">BACK</button>
						<button type="submit" class="btn btn-primary btn-lg m-3" >NEXT</button>
						
					  </form>
					</div>
				</div>
			</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
		<script>
			function verifyRef(){
				if(document.getElementById("ref").value != "" && <?php if(isset($_SESSION['usr'])) echo "true"; else echo "false"; ?>)
					document.getElementById("name").innerHTML += "*";
			}
		</script>
	</body>
</html>
