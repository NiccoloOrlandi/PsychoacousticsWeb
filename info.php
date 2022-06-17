<!doctype html>
<html lang="en">
	<head>
		<?php 
			session_start(); 
			include "config.php";
			if(!isset($_GET["test"]) && !isset($_SESSION['test']))
				header("Location: index.php");
		?>
		
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/x-icon" href="logo.png">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		
		<link rel="stylesheet" href="staircaseStyle.css<?php if (isset($_SESSION['version'])) echo "?{$_SESSION['version']}"; ?>">
		
		<title>Psychoacoustics-web - Test settings</title>
		
		<?php
			try{
				$conn = new mysqli($host, $user, $password, $dbname);
				if ($conn->connect_errno)
					throw new Exception('DB connection failed');
				mysqli_set_charset($conn, "utf8");
				
				$sql = "SELECT Type, Amplitude as amp, Frequency as freq, Duration as dur, blocks, Delta, nAFC, 
						Factor as fact, Reversal as rev, SecFactor as secfact, SecReversal as secrev, 
						Threshold as thr, Algorithm as alg
						
						FROM test
						
						WHERE Guest_ID='{$_SESSION['test']['guest']}' AND Test_count='{$_SESSION['test']['count']}'";
				$result = $conn->query($sql);
				$row=$result->fetch_assoc();
				
				if($row['Type']=='PURE_TONE_INTENSITY')
					$type="amplitude";
				else if($row['Type']=='PURE_TONE_FREQUENCY')
					$type="frequency";
				else if($row['Type']=='PURE_TONE_DURATION')
					$type="duration";
			}catch(Exception $e){
				header("Location: index.php?err=db");
			}
		?>
	</head>
	<body>
		<div class="container">
			<h2 class="info title">Hi <?php echo $_SESSION['name']; ?></h2>
			<p class="info text">
				You will now do an acoustic test that will measure your sensibility to the <?php echo $type; ?> of a sound.
				<br><br>
				During the test you will be asked a series of questions. In each question you will hear <?php echo $row['nAFC']; ?> sounds
				and will have to choose which of them was the 
				<?php
					if($type=='amplitude')
						echo "loudest";
					else if($type=='frequency')
						echo "highest pitch";
					else if($type=='duration')
						echo "longest";
				?>.
				<br><br>
				<?php 
					if($row['nAFC']>2)
						echo "Only o";
					else 
						echo "O";
				?>ne of the sounds will be 
				<?php
					if($type=='amplitude')
						echo "louder";
					else if($type=='frequency')
						echo "higher pitch";
					else if($type=='duration')
						echo "longer";
				?>
				than the other<?php 
					if($row['nAFC']>2)
						echo "s";
				?>. 
				It will have a<?php
					if($type=='amplitude')
						echo "n intensity of ".(floatval($row['amp'])+floatval($row['Delta']))." dB";
					else if($type=='frequency')
						echo " frequency of ".(floatval($row['freq'])+floatval($row['Delta']))." Hz";
					else if($type=='duration')
						echo " duration of ".(floatval($row['dur'])+floatval($row['Delta']))." ms";
				?>,
				while the other<?php 
					if($row['nAFC']>2)
						echo "s";
				?>
				will have a<?php
					if($type=='amplitude')
						echo "n intensity of ".floatval($row['amp'])." dB (the maximum amplitude is 0dB, which corresponds to 
							'1' in decimal, while a negative number in decibel corresponds to a number near '0' in decimal 
							(the higher is the absolute value, the nearest is to 0))";
					else if($type=='frequency')
						echo " frequency of ".floatval($row['freq'])." Hz";
					else if($type=='duration')
						echo " duration of ".floatval($row['dur'])." ms";
				?>.
				<br><br>
				The number of questions that will be asked depends on the number of reversals that was set. 
				Every time you give a correct answer and then a wrong answer or vice versa, there will be a reversal (the correctness direction changes).
				In this case there will be <?php echo $row['rev']; ?> reversal<?php if($row['rev']>1) echo "s"; ?> using a factor of 
				<?php echo $row['fact']; ?> and then <?php echo $row['secrev']; ?> reversal<?php if($row['secrev']>1) echo "s"; ?> using a factor of 
				<?php echo $row['secfact']; ?>.
				<br>
				But what are these factors?
				<br>
				Every time you give
				<?php
					if($row['alg']=='SimpleUpDown')
						echo "1";
					else if($row['alg']=='TwoDownOneUp')
						echo "2";
					else if($row['alg']=='ThreeDownOneUp')
						echo "3";
				?>
				right answer<?php
					if($row['alg']!='SimpleUpDown')
						echo "s";
				?>
				or a wrong answer, the difficulty changes. The right answers make the test harder, reducing the difference between the
				correct sound and the wrong one, the wrong answers make it easier, increasing the difference.
				<br><br>
				The test will be repeated <?php echo $row['blocks']; ?> time<?php if($row['blocks']>1) echo "s"; ?>. Each time you will see your threshold,
				a number that summarizes your level of sensibility. It is calculated only using the last <?php echo $row['thr']; ?> 
				reversal<?php if($row['rev']>1) echo "s"; ?>.
				<br>
				At the end you can download a csv file that summarizes all the tests done (and also a file with the details of each test, 
				if you are logged in with an account).
				<br><br>
				Check the 'Feedback' checkbox if you want to know when you give a correct or a wrong answer.
			</p>
			<form action="soundSettingsValidation.php" name="Settings" method="post">
				
				<div class="info Checkbox">
					<input class="form-check-input" type="checkbox" id="cb" name="checkFb" checked>
					<label class="form-check-label" for="cb">Feedback</label>
				</div>
				
				<button type="button" class="btn btn-primary btn-lg m-3 soundSettingsButton" onclick="location.href='demographicData.php'">BACK</button>
				<button type="submit" class="btn btn-primary btn-lg m-3 soundSettingsButton" >START</button>
			</form>
		</div>
	</body>
</html>
