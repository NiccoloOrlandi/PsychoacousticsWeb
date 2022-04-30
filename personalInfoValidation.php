<?php


$checkSave = 0;
	if(isset($_POST["checkSave"]))
		$checkSave = 1;

$_SESSION["checkSave"] = $checkSave;

if($_POST["name"] == "")
{
    alert("campo nome vuoto");
    header("Location: demographicData.php");
}
else{
    $_SESSION["name"] = $_POST["name"];
}
if($_POST["surname"] == "")
{
    $_SESSION["surname"] = null;
}
else{
    $_SESSION["surname"] = $_POST["surname"];
}
if($_SESSION["age"] == "")
{
    $_SESSION["age"] = null;
}
else{
    $_SESSION["age"] = $_POST["age"];
}
if($_SESSION["gender"] == "")
{
    $_SESSION["gender"] = null
}
else{
    $_SESSION["gender"] = $_POST["gender"];
}
if($_SESSION["notes"] == "")
{
    $_SESSION["notes"] = null;
}
else{
    $_SESSION["notes"] = $_POST["notes"];
}

$conn = new mysqli("localhost", "test", "", "psychoacoustics_db");
					
if ($conn->errno){
	die("Problemi di connessione" . $conn->error);
}						
mysqli_set_charset($conn, "utf8");

$sql="SELECT max(ID) as max FROM guest ";
$result=$conn->query($sql);
$row=$result->fetch_assoc();

$sql="INSERT into guest VALUES ( ".$row["max"]+1 ." , " .$_SESSION["name"] ." , " .$row["surname"] ." , " .$_SESSION["age"] ." , " .$_SESSION["gender"] ." , " .$row["notes"] . " )";
$conn->query($sql);
$_SESSION["idGuest"] = $row["max"]+1;



?>