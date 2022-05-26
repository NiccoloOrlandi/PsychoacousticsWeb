<?php
session_start();
include "config.php";
// connessione al database
$conn = new mysqli($host, $user, $password, $dbname);
		if ($conn->errno)
			die("Problemi di connessione" . $conn->error);
		mysqli_set_charset($conn, "utf8");
// query 
$oldPsw = $_POST['oldPsw'];
$newPsw = $_POST['newPsw'];
$sql = "SELECT password , email FROM account WHERE Username ='".$_SESSION['usr']."' AND password=SHA2('$oldPsw', 256)";             
$result=$conn->query($sql);
$row = $result->fetch_assoc();
$psw = $row['password'];
$email =$row['email'];


if($result->num_rows>0){
   
    $sql ="UPDATE account SET password = SHA2('$newPsw', 256)  WHERE username= '".$_SESSION['usr']."'";
    $conn->query($sql);
    header('Location: userSettings.php?err=3');
}
else
    header('Location: userSettings.php?err=2');
//mail($email,'Password changing','you have correctly changed the password');
?>