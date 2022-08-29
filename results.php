<!doctype html>
<html lang="en">
    
	<head>
		<?php 
			session_start();
		?>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/x-icon" href="files/logo.png">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link rel ="stylesheet" href="css/staircaseStyle.css<?php if (isset($_SESSION['version'])) echo "?{$_SESSION['version']}"; ?>">

		<title>Psychoacoustics-web - Test results</title>
		
	</head>
	<body>
		<?php
			//controllo errori
			if(isset($_GET['err'])){
				if($_GET['err']=="1")
					echo "<div class='alert alert-danger' style='float:left; width:95%'>'Save result' wasn't checked but 'Save settings' was, Settings can't be saved without saving the results
							<br>Result and settings weren't saved</div>";
			}
		?>
		<div class="container p-4">
			<div class="row gx-4">
				<div class="col">
					<div class="p-3 border bg-light resultsBox">
						<h2>Your threshold is 
							<?php 
								if(isset($_SESSION['score']))
									if(strrpos($_SESSION['score'],";"))
										echo substr($_SESSION['score'],strrpos($_SESSION['score'],";")+1);
									else
										echo $_SESSION['score'];
							?>
						</h2>
						
						<?php
							if(isset($_GET['continue'])){
								if(!$_GET['continue']){
									if(isset($_SESSION['usr']))
										echo "<button type='button' class='btn btn-primary btn-lg m-3' onclick='location.href=\"php/download.php?format=complete\"'>Download data</button>";
									echo "<button type='button' class='btn btn-primary btn-lg m-3' onclick='location.href=\"php/download.php?format=reduced\"'>Download data (thresholds only)</button>";
									echo "<button type='button' class='btn btn-primary btn-lg m-3' onclick='location.href=\"index.php\"'>Home</button>";
								}else{
									$page = "test.php";
									if($_SESSION['type'] == "PURE_TONE_FREQUENCY")
										$page = "freq".$page;
									if($_SESSION['type'] == "PURE_TONE_INTENSITY")
										$page = "amp".$page;
									if($_SESSION['type'] == "PURE_TONE_DURATION")
										$page = "dur".$page;
                                    if($_SESSION['type'] == "WHITE_NOISE_GAP")
                                        $page = "gap".$page;
                                    if($_SESSION['type'] == "WHITE_NOISE_DURATION")
                                        $page = "ndur".$page;
									echo "<button type='button' class='btn btn-primary btn-lg m-3' onclick='location.href=\"{$page}\"'>Continue</button>";
								}
							}
						?>
						
						<p style="margin-bottom:5%;"></p>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
