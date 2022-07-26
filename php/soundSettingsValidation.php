<?php

	session_start();
	include "config.php";
	if(isset($_SESSION['test'])){
		try{
			$conn = new mysqli($host, $user, $password, $dbname);
			if ($conn->connect_errno)
				throw new Exception('DB connection failed');
			mysqli_set_charset($conn, "utf8");
			
			$sql = "SELECT Type, Amplitude as amp, Frequency as freq, Duration as dur, Modulation as modu, blocks, Delta, nAFC, 
					ISI, ITI, Factor as fact, Reversal as rev, SecFactor as secfact, SecReversal as secrev, 
					Threshold as thr, Algorithm as alg
					
					FROM test
					
					WHERE Guest_ID='{$_SESSION['test']['guest']}' AND Test_count='{$_SESSION['test']['count']}'";
			$result = $conn->query($sql);
			$row=$result->fetch_assoc();
			
			if($row['Type']=='PURE_TONE_INTENSITY')
				$type="amp";
			else if($row['Type']=='PURE_TONE_FREQUENCY')
				$type="freq";
			else if($row['Type']=='PURE_TONE_DURATION')
				$type="dur";
            else if($row['Type']=='WHITE_NOISE_GAP')
                $type="gap";
            else if($row['Type']=='WHITE_NOISE_DURATION')
                $type="ndur";
			
			$checkFb = 0;
			if(isset($_POST["checkFb"]))
				$checkFb = 1;
			
			$_SESSION["amplitude"] = $row["amp"];
			$_SESSION["frequency"] = $row["freq"];
			$_SESSION["duration"] = $row["dur"];
			$_SESSION["modulation"] = $row["modu"];
			$_SESSION["blocks"] = $row["blocks"];
			$_SESSION["nAFC"] = $row["nAFC"];
			$_SESSION["ITI"] = $row["ITI"];
			$_SESSION["ISI"] = $row["ISI"];
			$_SESSION["delta"] = $row["Delta"];
			$_SESSION["checkFb"] = $checkFb;
			$_SESSION["saveSettings"] = 0;
			$_SESSION["factor"] = $row["fact"];
			$_SESSION["secFactor"] = $row["secfact"];
			$_SESSION["reversals"] = $row["rev"];
			$_SESSION["secReversals"] = $row["secrev"];
			$_SESSION["threshold"] = $row["thr"];
			$_SESSION["algorithm"] = $row["alg"];
			unset($_SESSION['score']);
			unset($_SESSION['currentBlock']);
			unset($_SESSION['results']);
			
			header("Location: {$type}test.php");
		}catch(Exception $e){
			header("Location: ../index.php?err=db");
		}
	}else{

		$sound_irreg_exp = "/^([a-zA-Z])+$/";
		//controlli su amplitude
		if (($_POST["amplitude"]== "") || ($_POST["amplitude"]== "undefined"))
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=amp1");

		else if(!is_numeric($_POST["amplitude"]))
		   header("Location: ../soundSettings.php?test={$_GET['test']}&err=amp2");

		else if(intval($_POST["amplitude"])>0)
		header("Location: ../soundSettings.php?test={$_GET['test']}&err=amp3");

		//controlli su frequency
		else if (($_POST["frequency"]== "") || ($_POST["frequency"]== "undefined")) 
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=freq1");

		else if (!is_numeric($_POST["frequency"]) || intval($_POST["frequency"])<0)
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=freq2");

		//Controlli su duration
		else if (($_POST["duration"]== "") || ($_POST["duration"]== "undefined")) 
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=dur1");

		else if (!is_numeric($_POST["duration"]) || $_POST["duration"]<0) 
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=dur2");

        else if (($_POST["modulation"]== "") || ($_POST["modulation"]== "undefined"))
            header("Location: ../soundSettings.php?test={$_GET['test']}&err=mod1");

        else if (!is_numeric($_POST["modulation"]) || $_POST["modulation"]<0)
            header("Location: ../soundSettings.php?test={$_GET['test']}&err=mod2");

		/*controlli su phase
		else if (($_POST["phase"]== "") || ($_POST["phase"]== "undefined")) 
			header("Location: soundSettings.php?test={$_GET['test']}&err=phase1");

		else if ($_POST["phase"]<0)
			header("Location: soundSettings.php?test={$_GET['test']}&err=phase2");
		*/
		//controlli su number of blocks
		else if (($_POST["blocks"]== "") || ($_POST["blocks"]== "undefined")) 
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=numblock1");

		else if (!is_numeric($_POST["blocks"]) || $_POST["blocks"]<0)
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=numblock2");

		//controlli su delta
		else if (($_POST["delta"]== "") || ($_POST["delta"]== "undefined")) 
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=delta1");

		else if (!is_numeric($_POST["delta"]) || $_POST["delta"]<0)
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=delta2");

		else if ($_GET['test']=="amp" && $_POST["amplitude"]+$_POST["delta"]>0)
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=delta3");

		//controlli su ITI
		else if (($_POST["ITI"]== "") || ($_POST["ITI"]== "undefined")) 
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=ITI1");

		else if (!is_numeric($_POST["ITI"]) || $_POST["ITI"]<1000)
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=ITI2");

		//controlli su ISI
		else if (($_POST["ISI"]== "") || ($_POST["ISI"]== "undefined")) 
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=ISI1");

		else if (!is_numeric($_POST["ISI"]) || $_POST["ISI"]<0)
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=ISI2");

		//controlli su nAFC
		else if (($_POST["nAFC"]== "") || ($_POST["nAFC"]== "undefined")) 
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=nAFC1");

		else if (!is_numeric($_POST["nAFC"]) || $_POST["nAFC"]<2)
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=nAFC2");

		else if ($_POST["nAFC"]>9)
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=nAFC3");

		//controlli sul factor
		else if (($_POST["factor"]== "") || ($_POST["factor"]== "undefined")) 
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=factor1");


		else if (!is_numeric($_POST["factor"]) || $_POST["factor"]< $_POST["secFactor"])
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=factor2");

		//controlli sul factor
		else if (($_POST["secFactor"]== "") || ($_POST["secFactor"]== "undefined")) 
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=secFactor1");


		else if (!is_numeric($_POST["secFactor"]) || $_POST["secFactor"]< 1)
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=secFactor2");

		//controlli su starting rev
		else if (($_POST["reversals"]== "") || ($_POST["reversals"]== "undefined")) 
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=rev1");

		else if (!is_numeric($_POST["reversals"]) || $_POST["reversals"]<0)
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=rev2");

		// controlli su secreversal
		else if (($_POST["secReversals"]== "") || ($_POST["secReversals"]== "undefined")) 
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=secRev1");

		else if (!is_numeric($_POST["secReversals"]) || $_POST["secReversals"]<0)
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=secRev2");

		//controlli su revTh
		else if (($_POST["threshold"]== "") || ($_POST["threshold"]== "undefined")) 
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=threshold1");

		else if (!is_numeric($_POST["threshold"]) || $_POST["threshold"]<0)
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=threshold2");

		else if ($_POST["threshold"]>$_POST["reversals"]+$_POST["secReversals"])
			header("Location: ../soundSettings.php?test={$_GET['test']}&err=threshold3");

		else{
			$checkFb = 0;
			if(isset($_POST["checkFb"]))
				$checkFb = 1;
			
			$checkSave = 0;
			if(isset($_POST["saveSettings"]))
				$checkSave = 1;
			
			$_SESSION["amplitude"] = $_POST["amplitude"];
			$_SESSION["frequency"] = $_POST["frequency"];
			$_SESSION["duration"] = $_POST["duration"];
            $_SESSION["modulation"] = $_POST["modulation"];
			//$_SESSION["phase"] = $_POST["phase"];
			$_SESSION["blocks"] = $_POST["blocks"];
			$_SESSION["nAFC"] = $_POST["nAFC"];
			$_SESSION["ITI"] = $_POST["ITI"];
			$_SESSION["ISI"] = $_POST["ISI"];
			$_SESSION["delta"] = $_POST["delta"];
			$_SESSION["checkFb"] = $checkFb;
			$_SESSION["saveSettings"] = $checkSave;
			$_SESSION["factor"] = $_POST["factor"];
			$_SESSION["secFactor"] = $_POST["secFactor"];
			$_SESSION["reversals"] = $_POST["reversals"];
			$_SESSION["secReversals"] = $_POST["secReversals"];
			$_SESSION["threshold"] = $_POST["threshold"];
			$_SESSION["algorithm"] = $_POST["algorithm"];
			unset($_SESSION['score']);
			unset($_SESSION['currentBlock']);
			unset($_SESSION['results']);
			
			header("Location: ../{$_GET['test']}test.php");
		}
	}

?>
