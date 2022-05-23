<!DOCTYPE html>
<html>
    <head>
        <title>Registrazione</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
                <link rel="stylesheet" href="formStyle.css"> 
		<?php include "config.php"; ?>
    </head>
    <body>
		<?php
			//se si sceglie un username già esistente verrà messo "?err=1" nell'url
			if(isset($_GET['err']) && $_GET['err']==1)
				echo "<div class='alert alert-danger'>Username already taken</div>";
		?>
        <form method="post" action="registering.php" onsubmit="validation()">
            <h1>Registrazione</h1>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Username</span>
                <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required name="usr">
            </div>            
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Password</span>
                <input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required name="psw">
            </div>
			<div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Email</span>
                <input type="text" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" required name="Email">
            </div> 
			<div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Name</span>
                <input type="text" class="form-control" placeholder="Name" aria-label="Name" aria-describedby="basic-addon1" required name="name">
            </div> 
			<div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Surname</span>
                <input type="text" class="form-control" placeholder="Surname" aria-label="Surname" aria-describedby="basic-addon1" name="surname">
            </div> 
			<div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Birth date</span>
                <input type="date" class="form-control" aria-label="Date" aria-describedby="basic-addon1" name="date">
            </div> 
			<select name='gender' class="form-select">
				<option disabled="disabled" selected value="null" id="NullGender">Select your gender</option>
				<?php 
					
					$conn = new mysqli($host, $user, $password, $dbname);
					
					if ($conn->errno){
						
						die("Problemi di connessione" . $conn->error);
					}
						
					mysqli_set_charset($conn, "utf8");
					
					$sql="SELECT COLUMN_TYPE AS ct FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'psychoacoustics_db' AND TABLE_NAME = 'guest' AND COLUMN_NAME = 'Gender';";
					$result=$conn->query($sql);
					$row=$result->fetch_assoc();//questa query da un risultato di tipo enum('Male','Female','Unspecified')
					
					//metto i valori in un array
					$values = substr($row['ct'], 5);
					$list = array();
					$initialPos = -1;
					for($i=0;str_split($values)[$i]!=')';$i++){
						if(str_split($values)[$i]=="'" and $initialPos==-1)
							$initialPos = $i+1;
						else if(str_split($values)[$i]=="'"){
							$list[] = substr($values, $initialPos, $i-$initialPos);
							$initialPos = -1;
						}
					}
					
					//creo un'opzione per ogni possibile valore
					foreach($list as $elem){
						echo "<option value='".strtoupper($elem)."'>".strtoupper($elem)."</option>";
					}
				?>
			</select>
			<div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Notes</span>
                <input type="text" class="form-control" placeholder="Notes" aria-label="Notes" aria-describedby="basic-addon1" name="notes">
            </div>
            <button type="submit" class="btn btn-primary btn-lg m-1">Registrati</button>
        </form>
    </body>
	
	<script>
		function validation(){
			document.getElementById("NullGender").disabled=false;
		}
	</script>
</html>
