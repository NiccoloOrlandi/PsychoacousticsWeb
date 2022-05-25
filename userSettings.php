<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/x-icon" href="logo.png">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<link rel ="stylesheet" href="style.css">
		<script type="text/javascript" src="funzioni.js"></script>

		<title>Psychoacoustics-web - User settings</title>

		<?php 
			session_start(); 
			include "config.php";
		?>
	</head>
 
	<body>
		
		<!-- Barra navigazione -->
		<nav class="navbar navbar-dark bg-dark">
			<div class="container-fluid" >
			  <a class="navbar-brand" href="index.php" >
				<img src="colore.png" alt="" width="30" height="24" class="d-inline-block align-text-top" >
				PSYCHOACOUSTICS
			  </a>
			  <form class="container-fluid logButtons">
				<label class='welcomeMessage'>Benvenuto <?php echo $_SESSION['usr'];?></label>
				<button class="btn btn-outline-primary yourTests" type="button" onclick="location.href='yourTests.php'">Your tests</button>
				<button class="btn btn-outline-danger logout" type="button" onclick="location.href='logout.php'">Log Out</button>
			  </form>
			</div>
		</nav>
		
		<?php
			//se si sceglie un username già esistente verrà messo "?err=1" nell'url
			if(isset($_GET['err'])){
				if ($_GET['err']==0)
					echo "<div class='alert alert-danger'>Some inserted characters aren't allowed</div>";
				if ($_GET['err']==1)
					echo "<div class='alert alert-danger'>Username already taken</div>";
				if ($_GET['err']==2)
					echo "<div class='alert alert-danger'>Wrong password</div>";
			}
			
			$conn = new mysqli($host, $user, $password, $dbname);
			if ($conn->errno)
				die("Problemi di connessione" . $conn->error);
			mysqli_set_charset($conn, "utf8");
			
			$sql = "SELECT referral, name, surname, date, gender, notes 
				FROM account INNER JOIN guest ON account.Guest_ID = guest.ID 
				WHERE username='".$_SESSION['usr']."'";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			$ref = $row['referral'];
			$name = $row['name'];
			$sur = $row['surname'];
			$date = $row['date'];
			$gender = $row['gender'];
			$notes = $row['notes'];
		?>
		
		<form action="newReferral.php" class="settingForm ref">
			<div class="input-group mb-3">
				<span class="input-group-text title" onclick="copy('ref')" title="click to copy">Referral</span>
				<span class="input-group-text link" id="ref" onclick="copy('ref')" title="click to copy"><?php echo $ref; ?></span>
			</div>
			<div class="input-group mb-3">
				<span class="input-group-text title" onclick="copy('link')" title="click to copy">Link</span>
				<span class="input-group-text link" id="link" onclick="copy('link')" title="click to copy">http://psychoacoustics.dpg.psy.unipd.it/sito/demographicData.php?test=freq&ref=<?php echo $ref; ?></span>
			</div>
			<button type="submit" class="btn btn-primary btn-lg m-1">Cambia referral</button>
			
		</form>
		<?php
			$sql = "SELECT Type FROM account WHERE Guest_ID='{$_SESSION['idGuest']}' AND Username='{$_SESSION['usr']}'";
			$result=$conn->query($sql);
			$row=$result->fetch_assoc();
			if($row['Type'] == 1){
				echo '<form action="newUsername.php" method="POST" class="settingForm ref">
					<div class="input-group mb-3">
						<span class="input-group-text title" onclick="copy(\'ref\')" title="Username">Username</span>
						<input type="text" class="form-control" placeholder="Username"  name="username">
					</div>
				
					<button type="submit"  class="btn btn-primary btn-lg m-1">Create new Superuser</button>
				</form>';
			}
		?>
		<form method="post" action="saveSettings.php" class="settingForm">
			<div class="input-group mb-3">
				<span class="input-group-text">Username</span>
				<input type="text" class="form-control" name="usr" value="<?php echo $_SESSION['usr']; ?>">
			</div>
			<div class="input-group mb-3">
				<span class="input-group-text">Email</span>
				<input type="text" class="form-control" placeholder="E-mail"  name="email">
			</div> 
			<div class="input-group mb-3">
				<span class="input-group-text">Vecchia password</span>
				<input type="password" class="form-control" placeholder="Vecchia password" name="oldPsw">
			</div>
			<div class="input-group mb-3">
				<span class="input-group-text">Nuova password</span>
				<input type="password" class="form-control" placeholder="Nuova password" name="newPsw">
			</div>
			<div class="input-group mb-3">
				<span class="input-group-text">Name</span>
				<input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
			</div> 
			<div class="input-group mb-3">
				<span class="input-group-text">Surname</span>
				<input type="text" class="form-control" name="surname" value="<?php echo $sur; ?>">
			</div> 
			<div class="input-group mb-3">
				<span class="input-group-text">Birth date</span>
				<input type="date" class="form-control" name="date" value="<?php echo $date; ?>">
			</div> 
			<select name='gender' class="form-select">
				<option disabled="disabled" value="null" id="NullGender" <?php if($gender=="NULL") echo "selected"; ?>>Select your gender</option>
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
			<div class="input-group mb-3 notes">
				<span class="input-group-text">Notes</span>
				<input type="text" class="form-control" placeholder="Notes" name="notes" value="<?php echo $notes; ?>">
			</div>
			<button type="submit" class="btn btn-primary btn-lg m-1">Salva Dati</button>
		</form>
	</body>
</html>