<!doctype html>
<html lang="en">
	<head>
		<?php 
			session_start(); 
			include "config.php";
		?>
		
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/x-icon" href="logo.png">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<link rel ="stylesheet" href="style.css<?php if (isset($_SESSION['version'])) echo "?{$_SESSION['version']}"; ?>">
		<script type="text/javascript" src="funzioni.js<?php if (isset($_SESSION['version'])) echo "?{$_SESSION['version']}"; ?>"></script>

		<title>Psychoacoustics-web - User settings</title>

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
				<label class='welcomeMessage'>Welcome <?php echo $_SESSION['usr'];?></label>
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
				if ($_GET['err']==3)
					echo "<div class='alert alert-success'>Password changed</div>";
			}
			try{
				$conn = new mysqli($host, $user, $password, $dbname);
				if ($conn->connect_errno)
					throw new Exception('DB connection failed');
				mysqli_set_charset($conn, "utf8");
				
				$sql = "SELECT referral, name, surname, date, gender, notes, email 
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
				$email = $row['email'];
			}catch(Exception $e){
				header("Location: index.php?err=db");
			}
		?>
		
		<form action="newReferral.php" class="settingForm ref">
			<div class="input-group mb-3">
				<span class="input-group-text title" onclick="copy('ref')" title="click to copy">Invite code</span>
				<span class="input-group-text link" id="ref" onclick="copy('ref')" title="click to copy"><?php echo $ref; ?></span>
			</div>
			<div class="input-group mb-3">
				<span class="input-group-text title" onclick="copy('link')" title="click to copy">Link</span>
				<span class="input-group-text link" id="link" onclick="copy('link')" title="click to copy">
					psychoacoustics.dpg.psy.unipd.it/sito/demographicData.php?test=amp&amp;ref=<?php echo $ref; ?>
				</span>
			</div>
			<button type="submit" class="btn btn-primary btn-lg m-1">Change invite code</button>
			<div class="input-group mb-3">
				<span class="input-group-text title" onclick="copy('link')" title="click to copy">Link's test type</span>
				<select onchange="updateLink()" id="testType">
					<option value="amp" selected>Amplitude test</option>
					<option value="freq">Frequency test</option>
					<option value="dur">Duration test</option>
				</select>
			</div>
			
		</form>
		<?php
			try{
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
			}catch(Exception $e){
				header("Location: index.php?err=db");
			}
		?>

		<form action="changePsw.php" method= "post" class="settingForm">
			<div class="input-group mb-3">
				<span class="input-group-text">Old password</span>
				<input type="password" class="form-control" placeholder="Old password" name="oldPsw">
			</div>
			<div class="input-group mb-3">
				<span class="input-group-text">New password</span>
				<input type="password" class="form-control" placeholder="New password" name="newPsw">
			</div>
			<button type="submit" class="btn btn-primary btn-lg m-1">Change Password</button>
		</form>

		<form method="post" action="saveSettings.php" class="settingForm">
			<div class="input-group mb-3">
				<span class="input-group-text">Username</span>
				<input type="text" class="form-control" name="usr" value="<?php echo $_SESSION['usr']; ?>">
			</div>
			<div class="input-group mb-3">
				<span class="input-group-text">Email</span>
				<input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
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
					try{
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
			<div class="input-group mb-3 notes">
				<span class="input-group-text">Notes</span>
				<input type="text" class="form-control" placeholder="Notes" name="notes" value="<?php echo $notes; ?>">
			</div>
			<button type="submit" class="btn btn-primary btn-lg m-1">Save</button>
		</form>
	</body>
</html>