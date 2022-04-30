<?php
$conn = new mysqli("localhost", "test", "", "psychoacoustics_db");
					
if ($conn->errno){
	die("Problemi di connessione" . $conn->error);
}						
mysqli_set_charset($conn, "utf8");

$sql="SELECT max(ID) as max FROM guest ";
$result=$conn->query($sql);
$row=$result->fetch_assoc();

$checkSave = 0;
	if(isset($_POST["checkSave"]))
		$checkSave = 1;

$_SESSION["checkSave"] = $checkSave;

$sql="INSERT into guest VALUES ( '".$row["max"]+1 ."' , '" .$_POST["name"] ."',";


if($_POST["name"] == "")
{
    header("Location: demographicData.php?test=".$_GET["test"]."&err=1");
}
else{
    $_SESSION["name"] = $_POST["name"];
}
if($_POST["surname"] == "")
{
    $_SESSION["surname"] = null;
	$sql .= "NULL, ";
}
else{
    $_SESSION["surname"] = $_POST["surname"];
	$sql .= "'".$_SESSION["surname"]."', ";
}
if($_POST["age"] == "")
{
    $_SESSION["age"] = null;
	$sql .= "NULL, ";
}
else{
    $_SESSION["age"] = $_POST["age"];
	$sql .= "'".$_SESSION["age"]."', ";
}
if(!isset($_POST["gender"]))
{
    $_SESSION["gender"] = null;
	$sql .= "NULL, ";
}
else{
    $_SESSION["gender"] = $_POST["gender"];
	$sql .= "'".$_SESSION["gender"]."', ";
}
if($_POST["notes"] == "")
{
    $_SESSION["notes"] = null;
	$sql .= "NULL) ";
}
else{
    $_SESSION["notes"] = $_POST["notes"];
	$sql .= "'".$_SESSION["notes"]."') ";
}

$conn->query($sql);
$_SESSION["idGuest"] = $row["max"]+1;

header("Location: soundSettings.php?test=".$_GET["test"]);

?>