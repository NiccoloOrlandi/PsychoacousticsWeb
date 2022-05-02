<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="staircaseStyle.css">
    

    <title>Hello, world!</title>

    <?php include "config.php"; ?>
  </head>
  <body>
    
    <?php
		//se si sceglie un username già esistente verrà messo "?err=1" nell'url
		if(isset($_GET['err']) && $_GET['err']==1)
			echo "<div class='alert alert-danger'>The name field is required</div>";
	?>

    <div class="container p-4" style="margin-top:15%" >
        <div class="row gx-4">
            <div class="col">
                <div class=" p-3 border bg-light">
                  <form name="staircase" method="post" action="personalinfoValidation.php<?php echo "?test=".$_GET["test"];?>">
                    <!-- Contenuto dello slot, qui vanno inseriti tutti i bottoni e i check box del primo slot -->

                    <h1>Personal Informations</h1>
                    
                    <!-- Label -->
                    <div class="input-group flex-nowrap">
                      <span class="input-group-text" id="name" >Name</span>
                      <input type="text" class="form-control" id="inputName" placeholder="Name" aria-label="Username" aria-describedby="addon-wrapping" name="name">
                    </div>
                    
                    <div class="input-group flex-nowrap">
                      <span class="input-group-text" id="surname"  >Surname</span>
                      <input type="text" class="form-control" id="inputSurname" placeholder="Surname" aria-label="" aria-describedby="addon-wrapping" name="surname">
                    </div>
                    
                    <div class="input-group flex-nowrap">
                      <span class="input-group-text" id="age" >Age</span>
                      <input type="text" class="form-control" id="inputAge" placeholder="Age" aria-label="Username" aria-describedby="addon-wrapping" name="age">
                    </div>
                    
                    <div class="input-group flex-nowrap">
                      <span class="input-group-text" id="gender" >Gender</span>
                      <select name='gender' class="form-select">
                        <option disabled="disabled" selected value="null" id="NullGender">Select your gender</option>
                        <?php 
                          $conn = new mysqli($host, $user, $password, $dbname);
                          
                          if ($conn->errno){
                            die("Problemi di connessione" . $conn->error);
                          }
                            
                          mysqli_set_charset($conn, "utf8");
                          
                          $sql="SELECT COLUMN_TYPE AS ct FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'psychoacoustics_db' AND TABLE_NAME = 'guest' AND COLUMN_NAME = 'gender';";
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
                            if($elem!="")
                              echo "<option value='".strtoupper($elem)."'>".strtoupper($elem)."</option>";
                          }
                        ?>
                      </select>
                    </div>
                    
                    <div class="input-group flex-nowrap" id="notesDiv">
                      <span class="input-group-text" id="notes">Notes</span>
                      <input type="text" class="form-control" id="inputNotes" placeholder="Notes" aria-label="Username" aria-describedby="addon-wrapping" name="notes">
                    </div>

                    <!-- Checkbox -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name= "checkSave" checked>
                        <label class="form-check-label" for="flexCheckDefault">
                          Save results
                        </label>
                    </div>
                    
                    
                   
                    <button type="button" class="btn btn-primary btn-lg m-3" onclick = "location.href='index.html'">BACK</button>
                    <button type="submit" class="btn btn-primary btn-lg m-3" >NEXT</button>

                  </form>   
                  
                  
               
                 
                 

                </div>

                
            </div>
           
        </div>

        

       

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>
