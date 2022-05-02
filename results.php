<!doctype html>
<html lang="en">
    
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link rel ="stylesheet" href="test.css">

		<title>Test results</title>
		<?php session_start(); ?>
	</head>
	<body>
		<div class="container p-4" style="margin-top:10%" >
			<div class="row gx-4">
				<div class="col">
					<div class=" p-3 border bg-light" style="text-align:center;">
						<h2 style="margin:5%;">Il tuo risultato è <?php echo $_SESSION["result"]; ?></h2>
						<button type="button" class="btn btn-primary btn-lg m-3" id="download" onclick = "location.href='download.php'">Download datas</button>
						<button type="button" class="btn btn-primary btn-lg m-3" id="home" onclick = "location.href='index.html'">Home</button>
						<p style="margin-bottom:5%;"></p>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
