<!doctype html>
<html lang="en">
	<head>

		<?php 
			include "php/config.php"; 
			session_start();
			if(!isset($_GET["test"]) && !isset($_GET['ref']))
				header("Location: index.php");
		?>
		
		
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/x-icon" href="files/logo.png">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<link rel="stylesheet" href="css/staircaseStyle.css<?php if (isset($_SESSION['version'])) echo "?{$_SESSION['version']}"; ?>">
		<script type="text/javascript" src="js/funzioni.js<?php if (isset($_SESSION['version'])) echo "?{$_SESSION['version']}"; ?>"></script>

		<title>Psychoacoustics-web - Personal info</title>
		
		<script>
			function verifyRef(){
				var display = true;
				var logged = <?php if(isset($_SESSION['usr'])) echo "true"; else echo "false"; ?>;
				if(document.getElementById("ref").value != "" && logged){
					if(document.getElementById("name").innerHTML.slice(-1)!="*")
						document.getElementById("name").innerHTML += "*";
					display = true;
				}else if(document.getElementById("ref").value == "" && logged){
					display = false;
				}
				updatePage(display);
			}
			
			function insertRef(){
				<?php
					if(isset($_SESSION['usr'])){
						try{
							$conn = new mysqli($host, $user, $password, $dbname);
							if ($conn->connect_errno)
								throw new Exception('DB connection failed');
							mysqli_set_charset($conn, "utf8");
							
							$sql="SELECT Referral as ref FROM account WHERE Username='{$_SESSION['usr']}'";
							
							$result = $conn->query($sql);
							$row = $result->fetch_assoc();
						}catch(Exception $e){
							header("Location: index.php?err=db");
						}
					}
				?>
				document.getElementById("ref").value=<?php echo "'".$row['ref']."'"; ?>;
				verifyRef();
			}
		</script>
	</head>
	<body onload="verifyRef()">

		<?php
			//se si sceglie un username già esistente verrà messo "?err=1" nell'url
			if(isset($_GET['err'])){
				if($_GET['err']==0)
					echo "<div class='alert alert-danger'>Some inserted characters aren't allowed</div>";
				if($_GET['err']==1)
					echo "<div class='alert alert-danger'>The name field is required</div>";
				if($_GET['err']==2)
					echo "<div class='alert alert-danger'>The name field is required when using a referral code</div>";
				else if($_GET['err']==3)
					echo "<div class='alert alert-danger'>Invalid referral code</div>";
				
			}
		?>
		
		
		<div class="container p-4" style="margin-top:10%" >
			<div class="row gx-4">
				<div class="col">
					<div class=" p-3 border bg-light">
					  <form name="staircase" method="post" action="php/personalInfoValidation.php<?php 
						if(isset($_GET["test"]))
							echo "?test=".$_GET["test"];
						?>">
						<!-- Contenuto dello slot, qui vanno inseriti tutti i bottoni e i check box del primo slot -->

						<h1>Personal Informations</h1>
						
						<!-- Label -->
						<div class="input-group flex-nowrap conditionalDisplay">
							<span class="input-group-text" id="name" >Name<?php if(!isset($_SESSION['usr'])) echo "*"; ?></span>
							<input type="text" class="form-control" id="inputName" placeholder="Name" name="name">
						</div>
						
						<div class="input-group flex-nowrap conditionalDisplay">
						  <span class="input-group-text" id="surname"  >Surname</span>
						  <input type="text" class="form-control" id="inputSurname" placeholder="Surname" name="surname">
						</div>
						
						<div class="input-group flex-nowrap conditionalDisplay">
						  <span class="input-group-text" id="age" >Age</span>
						  <input type="text" class="form-control" id="inputAge" placeholder="Age" name="age">
						</div>
						
						<div class="input-group flex-nowrap conditionalDisplay">
						  <span class="input-group-text" id="gender" >Gender</span>
						  <select name='gender' class="form-select">
							<option disabled="disabled" selected value="null" id="NullGender">Select your gender</option>
							<?php 
								try{
									$conn = new mysqli($host, $user, $password, $dbname);
									if ($conn->connect_errno)
										throw new Exception('DB connection failed');
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
								}catch(Exception $e){
									header("Location: index.php?err=db");
								}
							?>
						  </select>
						</div>
						
						<div class="input-group flex-nowrap conditionalDisplay" id="notesDiv">
						  <span class="input-group-text" id="notes">Notes</span>
						  <input type="text" class="form-control" id="inputNotes" placeholder="Notes" name="notes">
						</div>
						
						<?php if(isset($_SESSION['usr'])) echo '<button type="button" class="btn btn-primary btn-lg m-3 refButton" onclick="insertRef()">USE MINE</button>'; ?>
						<div class="input-group flex-nowrap referral">
						  <span class="input-group-text" id="notes">Invite code</span>
						  <input type="text" class="form-control" id="ref" name="ref" onkeyup="verifyRef()" value="<?php if(isset($_GET['ref'])) {echo $_GET['ref'];}?>">
						</div>
						
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name= "checkSave" checked>
							<label class="form-check-label" for="flexCheckDefault">Save results</label>
						</div>
						
						<button type="button" class="btn btn-primary btn-lg m-3" onclick = "location.href='index.php'">BACK</button>
						<button type="submit" class="btn btn-primary btn-lg m-3" >NEXT</button>
						
					  </form>
					</div>
				</div>
			</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	</body>
</html>
