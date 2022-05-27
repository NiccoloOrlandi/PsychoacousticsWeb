<?php
	try{
		session_start(); 
		include "config.php";
		
		//sql injections handling
		$elements = ['usr', 'email', 'oldPsw', 'newPsw', "name", "surname", "notes"];
		$characters = ["'", '"', "\\", chr(0)];
		$specialCharacters = false;
		foreach($elements as $elem){
			str_replace("'","''",$_POST[$elem]);
			foreach($characters as $char)
				$specialCharacters |= is_numeric(strpos($_POST[$elem], $char));
		}
		
		if($specialCharacters)
			header("Location: userSettings.php?&err=0");
		else{
			$conn = new mysqli($host, $user, $password, $dbname);
			if ($conn->connect_errno)
				throw new Exception('DB connection failed');
			mysqli_set_charset($conn, "utf8");
			
			//TODO
			
			header("Location: userSettings.php");
		}
	}catch(Exception $e){
		header("Location: index.php?err=db");
	}
?>