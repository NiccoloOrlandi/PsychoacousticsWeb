<!DOCTYPE html>
<html>
    <head>
        <title>Psychoacoustics - Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="formStyle.css"> 
    </head>
    <body>
		<?php
			//se si sceglie un username già esistente verrà messo "?err=1" nell'url
			if(isset($_GET['err']) && $_GET['err']==1)
				echo "<div class='alert alert-danger'>Username o password errati</div>";
		?>
        <form method="post" action="log.php">
            <h1>Login</h1>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Username</span>
                <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required name="usr">
            </div>            
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Password</span>
                <input type="password" class="form-control" placeholder="Password" aria-label="Username" aria-describedby="basic-addon1" required name="psw">
            </div>  
              
              <!--input type="password" id="password" placeholder="Password" name="password"-->
            <button type="submit" class="btn btn-primary btn-lg m-1">Accedi</button>
        </form>
    </body>
</html>