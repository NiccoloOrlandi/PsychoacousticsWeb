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
		<div class="container" style="margin-top:1%">
			<div class="row gx-4">
				<div class="col">
					<div class=" p-3 border bg-light" style="height:98%">
		
						<h1>Set the characteristics of the standard pure tone</h1>
						<form action="soundSettingsValidation.php" onsubmit="redirect()" name="Settings" method="post">
							<!-- Primo slot di setting -->
							<div class="container p-4" >
								<div class="row gx-4">
									<div class="col">
										<div class="p-3 border bg-light little">
											<!-- <form name="soundsForm">  non veniva mai chiuso, al momento non serve, andrà inserito quando imprementeremo la parte in php -->
											
											<!-- Contenuto dello slot, qui vanno inseriti tutti i bottoni e i check box del secondo slot -->
											<div class="input-group flex-nowrap">
												<span class="input-group-text" id="addon-wrapping">Amplitude</span>
												<input type="text" class="form-control"  name="amplitude" id = "amplitude" placeholder="Standard" aria-label="Username" aria-describedby="addon-wrapping" value = "20">
											</div>

											<div class="input-group flex-nowrap">
												<span class="input-group-text" id="addon-wrapping">Frequency</span>
												<input type="text" class="form-control" name="frequency" id = "frequency" placeholder="Standard" aria-label="Username" aria-describedby="addon-wrapping" value="1000">
											</div>

											<div class="input-group flex-nowrap">
												<span class="input-group-text" id="addon-wrapping">Duration</span>
												<input type="text" class="form-control" name="duration" id = "duration" placeholder="Standard" aria-label="Username" aria-describedby="addon-wrapping" value = "1000">
											</div>

											<div class="input-group flex-nowrap">
												<span class="input-group-text" id="addon-wrapping">Starting phase</span>
												<input type="text" class="form-control" name="phase" id = "phase" placeholder="Standard" aria-label="Username" aria-describedby="addon-wrapping" value = "0">
											</div>
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
													<input class="form-check-input" type="radio" name="algorithm" id="SimpleUpDown" checked>
													<label class="form-check-label" for="flexRadioDefault1">
														SimpleUpDown
													</label>
												</div>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="algorithm" id="TwoDownOneUp">
													<label class="form-check-label" for="flexRadioDefault1">
														TwoDownOneUp
													</label>
												</div>
												<div class="form-check" >
													<input class="form-check-input" type="radio" name="algorithm" id="ThreeDownOneUp">
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
