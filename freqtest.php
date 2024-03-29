<!doctype html>
<html lang="en">
	<head>
		<?php session_start(); ?>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/x-icon" href="files/logo.png">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link rel ="stylesheet" href="css/test.css<?php if (isset($_SESSION['version'])) echo "?{$_SESSION['version']}"; ?>">

		<title>Psychoacoustics-web - Frequency test</title>

		<script>
			// pass info from php session to js
			var amp = parseFloat(<?php echo $_SESSION["amplitude"]; ?>);
			var freq = parseFloat(<?php echo $_SESSION["frequency"]; ?>);
			var dur = parseFloat(<?php echo $_SESSION["duration"]; ?>);
            var mod = parseFloat(<?php echo $_SESSION["modulation"]; ?>);
            //var phase = <//?php echo $_SESSION["phase"]; ?>;
			var blocks = parseInt(<?php echo $_SESSION["blocks"]; ?>);
			var delta = parseFloat(<?php echo $_SESSION["delta"]; ?>);
			var nAFC = parseInt(<?php echo $_SESSION["nAFC"]; ?>);
			var ITI = parseInt(<?php echo $_SESSION["ITI"]; ?>);
			var ISI = parseInt(<?php echo $_SESSION["ISI"]; ?>);
			var feedback = <?php echo $_SESSION["checkFb"]; ?>;
			//var noise = <//?php echo $_SESSION["checkNoise"]; ?>;
			var saveSettings = <?php echo $_SESSION["saveSettings"]; ?>;
			var factor = parseFloat(<?php echo $_SESSION["factor"]; ?>);
			var secondFactor = parseFloat(<?php echo $_SESSION["secFactor"]; ?>);
			var reversals = parseInt(<?php echo $_SESSION["reversals"]; ?>);
			var secondReversals = parseInt(<?php echo $_SESSION["secReversals"]; ?>);
			var reversalThreshold = parseInt(<?php echo $_SESSION["threshold"]; ?>);
			var algorithm = <?php echo "'{$_SESSION["algorithm"]}'"; ?>;
			var currentBlock = parseInt(<?php if(isset($_SESSION["currentBlock"])) echo $_SESSION["currentBlock"]+1; else echo "1"?>);

		</script>
		<script type="text/javascript" src="js/soundsFrequency.js<?php if (isset($_SESSION['version'])) echo "?{$_SESSION['version']}"; ?>" defer></script>
	</head>
	
	<body>
		<!-- Option 1: Bootstrap Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

		<div class="window" id="StartingWindow">
			<h2>Ready?</h2>
			<button type="button" class="btn btn-success" id="start" onclick="start()">Let's start!</button>
		</div>

		<form action="" id="PlayForm">
			<H1>Which is the highest pitch tone?</H1>
			<button type="button" class="btn btn-success" id="button1" onclick = "select(1)" disabled>1° sound</button>
			<button type="button" class="btn btn-danger" id="button2" onclick = "select(2)" disabled>2° sound</button>
			<?php
				$colors = ["#198754", "#dc3545", "#0d6efd", "#e0b000", "#a000a0", "#ff8010", "#50a0f0", "#703000", "#606090"];
				for($i = 3; $i<=intval($_SESSION['nAFC']); $i++){
					echo "<button type='button' class='btn btn-success' style='background-color:".$colors[($i-1)%count($colors)].";' id='button{$i}' onclick = 'select({$i})' disabled>{$i}° sound</button>";
				}
			?>
		</form>
		<div class='alert alert-danger' id="wrong">Wrong!</div>
		<div class='alert alert-success' id="correct">Correct!</div>
	</body>
</html>
