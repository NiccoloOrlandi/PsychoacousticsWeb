<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<link rel="stylesheet" href="staircaseStyle.css">
		
		<script type="text/javascript" src="soundSettingsValidation.js" defer></script>
		
		<title>Hello, world!</title>
	</head>
	<body>
		<?php
			//controllo errori
			if(isset($_GET['err'])){
				if($_GET['err']=="amp1")
					echo "<div class='alert alert-danger'>The amplitude field is required</div>";
				else if($_GET['err']=="amp2")
					echo "<div class='alert alert-danger'>The amplitude value must be a number</div>";
				else if($_GET['err']=="amp3")
					echo "<div class='alert alert-danger'>The amplitude value can't be a positive value (maximum is 0)</div>";
				else if($_GET['err']=="freq1")
					echo "<div class='alert alert-danger'>The frequency field is required</div>";
				else if($_GET['err']=="freq2")
					echo "<div class='alert alert-danger'>The frequency value can't be a negative number</div>";
				else if($_GET['err']=="dur1")
					echo "<div class='alert alert-danger'>The duration field is required</div>";
				else if($_GET['err']=="dur2")
					echo "<div class='alert alert-danger'>The duration value can't be a negative number</div>";
				else if($_GET['err']=="numblock1")
					echo "<div class='alert alert-danger'>The n. of blocks field is required</div>";
				else if($_GET['err']=="numblock2")
					echo "<div class='alert alert-danger'>The n. of blocks value can't be a negative number</div>";
				else if($_GET['err']=="delta1")
					echo "<div class='alert alert-danger'>The delta field is required</div>";
				else if($_GET['err']=="delta2")
					echo "<div class='alert alert-danger'>The delta value can't be a negative number</div>";
				else if($_GET['err']=="nAFC1")
					echo "<div class='alert alert-danger'>The nAFC field is required</div>";
				else if($_GET['err']=="nAFC2")
					echo "<div class='alert alert-danger'>The nAFC value can't be a negative number</div>";
				else if($_GET['err']=="factor1")
					echo "<div class='alert alert-danger'>The factor field is required</div>";
				else if($_GET['err']=="factor2")
					echo "<div class='alert alert-danger'>The factor value must be a number grater than the second factor</div>";
				else if($_GET['err']=="secFactor1")
					echo "<div class='alert alert-danger'>The second factor field is required</div>";
				else if($_GET['err']=="secFactor2")
					echo "<div class='alert alert-danger'>The second factor value must be a number lower than the factor</div>";
				else if($_GET['err']=="rev1")
					echo "<div class='alert alert-danger'>The reversals field is required</div>";
				else if($_GET['err']=="rev2")
					echo "<div class='alert alert-danger'>The reversals value can't be a negative number</div>";
				else if($_GET['err']=="secRev1")
					echo "<div class='alert alert-danger'>The second reversals field is required</div>";
				else if($_GET['err']=="secRev2")
					echo "<div class='alert alert-danger'>The second reversals value can't be a negative number</div>";
				else if($_GET['err']=="threshold1")
					echo "<div class='alert alert-danger'>The reversal threshold field is required</div>";
				else if($_GET['err']=="threshold2")
					echo "<div class='alert alert-danger'>The reversal threshold value can't be a negative number</div>";
			}
		?>
		<div class="container" style="margin-top:1%">
			<div class="row gx-4">
				<div class="col">
					<div class=" p-3 border bg-light" style="height:98%">
		
						<h1>Set the characteristics of the standard pure tone</h1>
						<form action="soundSettingsValidation.php<?php echo "?type=".$_GET["test"]; ?>" name="Settings" method="post">
							<!-- Primo slot di setting -->
							<div class="container p-4" >
								<div class="row gx-4">
									<div class="col">
										<div class="p-3 border bg-light little">
											<!-- <form name="soundsForm">  non veniva mai chiuso, al momento non serve, andrà inserito quando imprementeremo la parte in php -->
											
											<!-- Contenuto dello slot, qui vanno inseriti tutti i bottoni e i check box del secondo slot -->
											<div class="input-group flex-nowrap">
												<span class="input-group-text" id="addon-wrapping">Amplitude</span>
												<input type="text" class="form-control"  name="amplitude" id = "amplitude" placeholder="Standard" aria-label="Username" aria-describedby="addon-wrapping" value = "-20">
												<span class="input-group-text" id="addon-wrapping">dB</span>
											</div>

											<div class="input-group flex-nowrap">
												<span class="input-group-text" id="addon-wrapping">Frequency</span>
												<input type="text" class="form-control" name="frequency" id = "frequency" placeholder="Standard" aria-label="Username" aria-describedby="addon-wrapping" value="1000">
												<span class="input-group-text" id="addon-wrapping">Hz</span>
											</div>

											<div class="input-group flex-nowrap">
												<span class="input-group-text" id="addon-wrapping">Duration</span>
												<input type="text" class="form-control" name="duration" id = "duration" placeholder="Standard" aria-label="Username" aria-describedby="addon-wrapping" value = "1000">
												<span class="input-group-text" id="addon-wrapping">ms</span>
											</div>

											<!-- <div class="input-group flex-nowrap">
												<span class="input-group-text" id="addon-wrapping">Starting phase</span>
												<input type="text" class="form-control" name="phase" id = "phase" placeholder="Standard" aria-label="Username" aria-describedby="addon-wrapping" value = "0">
												<span class="input-group-text" id="addon-wrapping">°</span>
											</div> -->
										</div>
									</div>
								</div>
							</div>


							<!-- Secondo slot di setting -->
							<div class="container p-4" >
								<div class="row gx-4">
									<div class="col">
									<div class="p-3 border bg-light little">
							
											<!-- Contenuto dello slot, qui vanno inseriti tutti i bottoni e i check box del secondo slot -->
											
											<div class="input-group flex-nowrap">
											<span class="input-group-text" id="addon-wrapping" style="width:7rem">n. of blocks</span>
											<input type="text" class="form-control" name = "blocks" id = "blocks" placeholder="Blocks" aria-label="Username" aria-describedby="addon-wrapping">
											</div>
											
											<div class="input-group flex-nowrap">
												<span class="input-group-text" id="addon-wrapping">Delta</span>
												<input type="text" class="form-control" name = "delta" id = "level" placeholder="Starting " aria-label="Username" aria-describedby="addon-wrapping">
											</div>
											
											<div class="input-group flex-nowrap">
												<span class="input-group-text" id="addon-wrapping">nAFC</span>
												<input type="text" class="form-control" name = "nAFC" id = "nAFC" placeholder="nAFC" aria-label="Username" aria-describedby="addon-wrapping" value = "2" >
											</div>   
											
											<!-- Checkbox -->
											<div class="form-check">
												<input class="form-check-input" type="checkbox" id="cb" name="checkFb" >
												<label class="form-check-label" for="cb">
												Feedback
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>


							<!-- Terzo slot di setting -->
							<div class="container p-4" >
								<div class="row gx-4">
									<div class="col">
										<div class="p-3 border bg-light">
										
											<!-- Contenuto dello slot, qui vanno inseriti tutti i componenti del terzo slot -->
											
											<!-- input boxes, sono raggruppati in un div che sta sulla destra-->
											<div class="right-div">
												<div class="left-div">
													<div class="input-group flex-nowrap">
														<span class="input-group-text" id="addon-wrapping">Factor</span>
														<input type="text" class="form-control" name="factor" id="factor" placeholder="Factor" aria-label="Username" aria-describedby="addon-wrapping" value = "2">
													</div>
													<div class="input-group flex-nowrap">
														<span class="input-group-text" id="addon-wrapping">Reversals</span>
														<input type="text" class="form-control" name="reversals" id = "reversals" placeholder="Reversals" aria-label="Username" aria-describedby="addon-wrapping" value = "2">
													</div>
												</div>
												<div class="right-div">
													<div class="input-group flex-nowrap">
														<span class="input-group-text" id="addon-wrapping">Second factor</span>
														<input type="text" class="form-control" name="secFactor" id="secondFactor" placeholder="secondFactor" aria-label="Username" aria-describedby="addon-wrapping" value = "1.414">
													</div>
													<div class="input-group flex-nowrap">
														<span class="input-group-text" id="addon-wrapping">Second reversals</span>
														<input type="text" class="form-control" name="secReversals" id = "reversals" placeholder="Reversals" aria-label="Username" aria-describedby="addon-wrapping" value = "2">
													</div>
												</div>
												<div class="input-group flex-nowrap">
													<span class="input-group-text" id="addon-wrapping">Reversal threshold</span>
													<input type="text" class="form-control" name="threshold" id = "reversalsTh" placeholder="Threshold" aria-label="Username" aria-describedby="addon-wrapping">
												</div>
											</div>

											<!-- Radios, sono raggruppati in un div che sta sulla sinistra-->
											<div class="left-div">
												<div class="form-check">
													<input class="form-check-input" type="radio" name="algorithm" value="SimpleUpDown" checked>
													<label class="form-check-label" for="flexRadioDefault1">
														SimpleUpDown
													</label>
												</div>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="algorithm" value="TwoDownOneUp">
													<label class="form-check-label" for="flexRadioDefault1">
														TwoDownOneUp
													</label>
												</div>
												<div class="form-check" >
													<input class="form-check-input" type="radio" name="algorithm" value="ThreeDownOneUp">
													<label class="form-check-label" for="flexRadioDefault1">
														ThreeDownOneUp
													</label>
												</div>
												
												<!-- Algoritmi non implementati
												<div class="form-check">
													<input class="form-check-input" type="radio" name="algorithm" id="Geometric" disabled>
													<label class="form-check-label" for="flexRadioDefault1">
														Geometric
													</label>
												</div>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="algorithm" id="Median" disabled>
													<label class="form-check-label" for="flexRadioDefault1">
														Median
													</label>
												</div>
												<div class="form-check" >
													<input class="form-check-input" type="radio" name="algorithm" id="Limits" disabled>
													<label class="form-check-label" for="flexRadioDefault1">
														Method of Limits
													</label>
												</div>
												<div class="form-check" >
													<input class="form-check-input" type="radio" name="algorithm" id="Arithmetic" disabled>
													<label class="form-check-label" for="flexRadioDefault1">
														Arithmetic
													</label>
												</div>
												-->
											</div>
											
										</div>
									</div>
								</div>
							</div>
							
							<!-- i bottoni sono fuori dal terzo slot -->
							<button type="button" class="btn btn-primary btn-lg m-3 soundSettingsButton" onclick = "location.href='demographicData.html'">BACK</button>
							<button type="submit" class="btn btn-primary btn-lg m-3 soundSettingsButton" >START</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	   
		<!-- Bootstrap Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

	</body>
</html>
