<!doctype html>
<html lang="en">
    
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel ="stylesheet" href="test.css">
    
    <title>Frequency test</title>
	
	<script>
		// pass info from php session to js
		<?php session_start(); ?>
		var amp = <?php echo $_SESSION["amplitude"]; ?>;
		var freq = <?php echo $_SESSION["frequency"]; ?>;
		var dur = <?php echo $_SESSION["duration"]; ?>;
		//var phase = <//?php echo $_SESSION["phase"]; ?>;
		var blocks = <?php echo $_SESSION["blocks"]; ?>;
		var delta = <?php echo $_SESSION["delta"]; ?>;
		var nAFC = <?php echo $_SESSION["nAFC"]; ?>;
		var feedback = <?php echo $_SESSION["checkFb"]; ?>;
		var factor = <?php echo $_SESSION["factor"]; ?>;
		var secondFactor = <?php echo $_SESSION["secFactor"]; ?>;
		var reversals = <?php echo $_SESSION["reversals"]; ?>;
		var secondReversals = <?php echo $_SESSION["secReversals"]; ?>;
		var reversalThreshold = <?php echo $_SESSION["threshold"]; ?>;
		var algorithm = <?php echo "'{$_SESSION["algorithm"]}'"; ?>;

	</script>
	<script type="text/javascript" src="soundsFrequency.js" defer></script>
	
  </head>
  <body>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	
	<div class="window" id="StartingWindow">
		<h2>Pronto?</h2>
		
		<button type="button" class="btn btn-success" id="start" onclick="start()">Cominciamo!</button>
	</div>
	
	<form action="" id="PlayForm">

		<H1>Quale suono è più acuto?</H1>   

		<p id="output"></p>

		<script></script>
		
		<!--button type="button" class="btn btn-primary" id='start' onclick="random()" >Play</button-->
		<button type="button" class="btn btn-success" id="first" onclick = "select(1)" disabled>First</button>
		<button type="button" class="btn btn-danger" id="second" onclick = "select(2)" disabled>Second</button>

	</form>

  </body>
</html>
