<?php


$checkSave = 0;
	if(isset($_POST["checkSave"]))
		$checkSave = 1;

$_SESSION["checkSave"] = $checkSave;


$_SESSION["name"] = $_POST["name"];
$_SESSION["surname"] = $_POST["surname"];
$_SESSION["age"] = $_POST["age"];
$_SESSION["gender"] = $_POST["gender"];
$_SESSION["notes"] = $_POST["notes"];


?>