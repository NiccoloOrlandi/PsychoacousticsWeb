<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/x-icon" href="logo.png">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<link rel="stylesheet" href="staircaseStyle.css">
		
		<?php 
			session_start(); 
			include "config.php";
			if(!isset($_GET["test"]))
				header("Location: index.php");
		?>
		<title>Psychoacoustics-web - Test settings</title>
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
					echo "<div class='alert alert-danger'>The amplitude value can't be a positive value (maximum is 0db)</div>";
				else if($_GET['err']=="freq1")
					echo "<div class='alert alert-danger'>The frequency field is required</div>";
				else if($_GET['err']=="freq2")
					echo "<div class='alert alert-danger'>The frequency value must be a positive number</div>";
				else if($_GET['err']=="dur1")
					echo "<div class='alert alert-danger'>The duration field is required</div>";
				else if($_GET['err']=="dur2")
					echo "<div class='alert alert-danger'>The duration value must be a positive number</div>";
				else if($_GET['err']=="numblock1")
					echo "<div class='alert alert-danger'>The n. of blocks field is required</div>";
				else if($_GET['err']=="numblock2")
					echo "<div class='alert alert-danger'>The n. of blocks value must be a positive number</div>";
				else if($_GET['err']=="delta1")
					echo "<div class='alert alert-danger'>The delta field is required</div>";
				else if($_GET['err']=="delta2")
					echo "<div class='alert alert-danger'>The delta value must be a positive number</div>";
				else if($_GET['err']=="delta3")
					echo "<div class='alert alert-danger'>The delta value is too high</div>";
				else if($_GET['err']=="ISI1")
					echo "<div class='alert alert-danger'>The ISI field is required</div>";
				else if($_GET['err']=="ISI2")
					echo "<div class='alert alert-danger'>The ISI value must be a positive number</div>";
				else if($_GET['err']=="nAFC1")
					echo "<div class='alert alert-danger'>The nAFC field is required</div>";
				else if($_GET['err']=="nAFC2")
					echo "<div class='alert alert-danger'>The nAFC value must be a number greater than or equal to 2</div>";
				else if($_GET['err']=="nAFC3")
					echo "<div class='alert alert-danger'>The nAFC value can't be greater than 9</div>";
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
					echo "<div class='alert alert-danger'>The reversals value must be a positive number</div>";
				else if($_GET['err']=="secRev1")
					echo "<div class='alert alert-danger'>The second reversals field is required</div>";
				else if($_GET['err']=="secRev2")
					echo "<div class='alert alert-danger'>The second reversals value must be a positive number</div>";
			}
			
			if(isset($_SESSION['usr'])){
				try{
					$conn=new mysqli($host, $user, $password, $dbname);
					if ($conn->connect_errno)
						throw new Exception('DB connection failed');
					mysqli_set_charset($conn, "utf8");
					
					$sql="SELECT test.Amplitude as amp, test.Frequency as freq, test.Duration as dur, test.blocks as blocks, 
						test.nAFC as nafc, test.ISI as isi, test.Factor as fact, test.Delta as delta, test.Reversal as rev, 
						test.SecFactor as secfact, test.SecReversal as secrev, test.Threshold as thr, test.Algorithm as alg
										
						FROM test
						INNER JOIN account ON account.fk_GuestTest=test.Guest_ID AND account.fk_TestCount=test.Test_count
						
						WHERE account.Username='{$_SESSION['usr']}'";
					$result=$conn->query($sql);
					$row=$result->fetch_assoc();
				}catch(Exception $e){
					header("Location: index.php?err=db");
				}
			}else
				$row=false;
			
		?>
		<div class="container" style="margin-top:1%">
			<div class="row gx-4">
				<div class="col">
					<div class=" p-3 border bg-light" style="height:98%">
						<h1>Set the characteristics of the experiment</h1>
						<form action="soundSettingsValidation.php<?php echo "?test=".$_GET["test"]; ?>" name="Settings" method="post">
							<!-- Primo slot di setting -->
							<div class="container p-4" >
								<div class="row gx-4">
									<div class="col">
										<div class="p-3 border bg-light little1">
											<!-- Contenuto dello slot, qui vanno inseriti tutti i bottoni e i check box del secondo slot -->
											<div class="input-group flex-nowrap">
												<span class="input-group-text">Amplitude</span>
												<input type="text" class="form-control" name="amplitude" id="amplitude"
													value="<?php 
														if($row) 
															echo $row['amp']; 
														else 
															echo "-20"; 
													?>">
												<span class="input-group-text">dB</span>
											</div>

											<div class="input-group flex-nowrap">
												<span class="input-group-text">Frequency</span>
												<input type="text" class="form-control" name="frequency" id="frequency"
													value="<?php 
														if($row) 
															echo $row['freq']; 
														else 
															echo "1000"; 
													?>">
												<span class="input-group-text">Hz</span>
											</div>

											<div class="input-group flex-nowrap">
												<span class="input-group-text">Duration</span>
												<input type="text" class="form-control" name="duration" id="duration" 
													value="<?php 
														if($row) 
															echo $row['dur']; 
														else 
															echo "500"; 
													?>">
												<span class="input-group-text">ms</span>
											</div>

											<!-- <div class="input-group flex-nowrap">
												<span class="input-group-text">Starting phase</span>
												<input type="text" class="form-control" name="phase" id="phase" placeholder="Standard" aria-label="Username" aria-describedby="addon-wrapping" value="0">
												<span class="input-group-text">°</span>
											</div> -->
										</div>
									</div>
								</div>
							</div>


							<!-- Secondo slot di setting -->
							<div class="container p-4" >
								<div class="row gx-4">
									<div class="col">
									<div class="p-3 border bg-light little2">
							
											<!-- Contenuto dello slot, qui vanno inseriti tutti i bottoni e i check box del secondo slot -->
											
											<div class="input-group flex-nowrap" title="how many times the test will be repeated">
											<span class="input-group-text">
												n. of blocks
											</span>
											<input type="text" class="form-control" name="blocks" id="blocks"
												value="<?php
													if($row) 
														echo $row['blocks']; 
													else 
														echo "3"; 
												?>">
											</div>
											
											<div class="input-group flex-nowrap" title="how many sounds will be played">
												<span class="input-group-text">nAFC</span>
												<input type="text" class="form-control" name="nAFC" id="nAFC"
													value="<?php 
														if($row) 
															echo $row['nafc']; 
														else 
															echo "2"; 
													?>" >
											</div>   
											
											<div class="input-group flex-nowrap" title="the time between two sounds (ms)">
												<span class="input-group-text">ISI</span>
												<input type="text" class="form-control" name="ISI" id="ISI"
													value="<?php 
														if($row) 
															echo $row['isi']; 
														else 
															echo "500"; 
													?>" >
												<span class="input-group-text">ms</span>
											</div>   
											
											<div class="input-group flex-nowrap" title="the starting difference between the sounds">
												<span class="input-group-text">Delta</span>
												<input type="text" class="form-control" name="delta" id="level"
													value="<?php 
														if($_GET["test"]=="amp")
															echo "12"; 
														else if($_GET["test"]=="freq")
															echo "200";
														else if($_GET["test"]=="dur")
															echo "300";
													?>">
												<span class="input-group-text">
													<?php
														if($_GET['test']=="amp")
															echo "dB";
														else if($_GET['test']=="freq")
															echo "Hz";
														else if($_GET['test']=="dur")
															echo "ms";
													?>
												</span>
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
														<span class="input-group-text">Factor</span>
														<input type="text" class="form-control" name="factor" id="factor" 
															value="<?php 
																if($row) 
																	echo $row['fact']; 
																else 
																	echo "2"; 
															?>">
													</div>
													<div class="input-group flex-nowrap">
														<span class="input-group-text">Reversals</span>
														<input type="text" class="form-control" name="reversals" id="reversals"
															value="<?php 
																if($row) 
																	echo $row['rev']; 
																else 
																	echo "4"; 
															?>">
													</div>
												</div>
												<div class="right-div">
													<div class="input-group flex-nowrap">
														<span class="input-group-text">Second factor</span>
														<input type="text" class="form-control" name="secFactor" id="secondFactor"
															value="<?php 
																if($row) 
																	echo $row['secfact']; 
																else 
																	echo "1.414"; 
															?>">
													</div>
													<div class="input-group flex-nowrap">
														<span class="input-group-text">Second reversals</span>
														<input type="text" class="form-control" name="secReversals" id="reversals"
															value="<?php 
																if($row) 
																	echo $row['secrev']; 
																else 
																	echo "8"; 
															?>">
													</div>
												</div>
												
												<div class="form-check checkboxes">
													<div class="form-check">
														<input class="form-check-input" type="checkbox" id="cb" name="checkFb" checked>
														<label class="form-check-label" for="cb">
														Feedback
														</label>
													</div>
												</div>
											</div>

											<!-- Radios, sono raggruppati in un div che sta sulla sinistra-->
											<div class="left-div">
												<div class="form-check">
													<input class="form-check-input" type="radio" name="algorithm" value="SimpleUpDown" 
														<?php 
															if($row && $row['alg']=="SimpleUpDown")
																echo "checked";
														?>>
													<label class="form-check-label" for="flexRadioDefault1">
														SimpleUpDown
													</label>
												</div>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="algorithm" value="TwoDownOneUp" 
														<?php 
															if(($row && $row['alg']=="TwoDownOneUp") || !$row) 
																echo "checked"; 
														?>>
													<label class="form-check-label" for="flexRadioDefault1">
														TwoDownOneUp
													</label>
												</div>
												<div class="form-check" >
													<input class="form-check-input" type="radio" name="algorithm" value="ThreeDownOneUp" 
														<?php 
															if($row && $row['alg']=="ThreeDownOneUp") 
																echo "checked"; 
														?>>
													<label class="form-check-label" for="flexRadioDefault1">
														ThreeDownOneUp
													</label>
												</div>
												
											
												<!-- Checkbox -->
												<div class="form-check checkboxes">
													<?php
														if(isset($_SESSION['usr']))
															echo '<div class="form-check">
																	<input class="form-check-input" type="checkbox" id="saveSettings" name="saveSettings">
																	<label class="form-check-label" for="saveSettings">
																		Save settings
																	</label>
																  </div>';
													?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<!-- i bottoni sono fuori dal terzo slot -->
							<button type="button" class="btn btn-primary btn-lg m-3 soundSettingsButton" onclick="location.href='demographicData.php'">BACK</button>
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
