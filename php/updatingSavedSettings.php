<?php
	try{
		include "config.php";
		session_start();

		//apro la connessione con il db
		$conn = new mysqli($host, $user, $password, $dbname);

		//controllo se è andata a buon fine
		if ($conn->connect_errno)
			throw new Exception('DB connection failed');

		//uso codifica utf8 per comunicare col db
		mysqli_set_charset($conn, "utf8");

		$id = $_SESSION['idGuest'];

		//trova il numero di test effettuati fin'ora
		$sql = "SELECT Max(Test_count) as count FROM test WHERE Guest_ID='$id'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();

		//il test corrente è il numero di test già effettuati + 1
		$count = $row['count']+1;

		$checkFb = 0;
		if(isset($_POST["checkFb"]))
			$checkFb = 1;

		//inserisci i dati del nuovo test
		$sql = "INSERT INTO test VALUES ('$id', '$count', current_timestamp(), '{$_GET['test']}', ";
		$sql .= "'{$_POST["amplitude"]}', '{$_POST["frequency"]}', '{$_POST["duration"]}', ";
		$sql .= "'{$_POST["modulation"]}', '{$_POST['blocks']}', '{$_POST['delta']}', ";
		$sql .= "'{$_POST['nAFC']}', '{$_POST['ITI']}', '{$_POST['ISI']}', '{$_POST['factor']}', '{$_POST['reversals']}', ";
		$sql .= "'{$_POST['secFactor']}', '{$_POST['secReversals']}', '{$_POST['threshold']}', '{$_POST['algorithm']}', '', '0', '$checkFb')";
		$conn->query($sql);
		echo $sql."<br>";
		
		$sql = "UPDATE account SET fk_guestTest = '$id', fk_testCount = '$count' WHERE username = '{$_SESSION['usr']}' ";
		$conn->query($sql);
		echo $sql."<br>";
		
		unset($_SESSION['updatingSavedSettings']);
		
		//header("Location: ../userSettings.php?err=4");
	}catch(Exception $e){
		header("Location: ../index.php?err=db");
	}
?>
