<?php

session_start();

$sound_irreg_exp = "/^([a-zA-Z])+$/";
//controlli su amplitude
if (($_POST["amplitude"]== "") || ($_POST["amplitude"]== "undefined"))    
    header("Location: soundSettings.php?test={$_GET['type']}&err=amp1");

else if(!is_numeric($_POST["amplitude"]))
   header("Location: soundSettings.php?test={$_GET['type']}&err=amp2");

else if(intval($_POST["amplitude"])>0)
header("Location: soundSettings.php?test={$_GET['type']}&err=amp3");

//controlli su frequency
else if (($_POST["frequency"]== "") || ($_POST["frequency"]== "undefined")) 
    header("Location: soundSettings.php?test={$_GET['type']}&err=freq1");

else if ($_POST["frequency"]<0)
    header("Location: soundSettings.php?test={$_GET['type']}&err=freq2");

//Controlli su duration
else if (($_POST["duration"]== "") || ($_POST["duration"]== "undefined")) 
    header("Location: soundSettings.php?test={$_GET['type']}&err=dur1");

else if ($_POST["duration"]<0) 
    header("Location: soundSettings.php?test={$_GET['type']}&err=dur2");

/*controlli su phase
else if (($_POST["phase"]== "") || ($_POST["phase"]== "undefined")) 
    header("Location: soundSettings.php?test={$_GET['type']}&err=phase1");

else if ($_POST["phase"]<0)
    header("Location: soundSettings.php?test={$_GET['type']}&err=phase2");
*/
//controlli su number of blocks
else if (($_POST["blocks"]== "") || ($_POST["blocks"]== "undefined")) 
    header("Location: soundSettings.php?test={$_GET['type']}&err=numblock1");

else if ($_POST["blocks"]<0)
    header("Location: soundSettings.php?test={$_GET['type']}&err=numblock2");

//controlli su starting level
else if (($_POST["delta"]== "") || ($_POST["delta"]== "undefined")) 
    header("Location: soundSettings.php?test={$_GET['type']}&err=delta1");

else if ($_POST["delta"]<0)
    header("Location: soundSettings.php?test={$_GET['type']}&err=delta2");

//controlli su nAFC
else if (($_POST["nAFC"]== "") || ($_POST["nAFC"]== "undefined")) 
    header("Location: soundSettings.php?test={$_GET['type']}&err=nAFC1");

else if ($_POST["nAFC"]<0)
    header("Location: soundSettings.php?test={$_GET['type']}&err=nAFC2");

//controlli sul factor
else if (($_POST["factor"]== "") || ($_POST["factor"]== "undefined")) 
    header("Location: soundSettings.php?test={$_GET['type']}&err=factor1");


else if (($_POST["factor"]< $_POST["secFactor"] ) || !is_numeric($_POST["factor"]))
    header("Location: soundSettings.php?test={$_GET['type']}&err=factor2");

//controlli sul factor
else if (($_POST["secFactor"]== "") || ($_POST["secFactor"]== "undefined")) 
    header("Location: soundSettings.php?test={$_GET['type']}&err=secFactor1");


else if (($_POST["secFactor"]< 1) || !is_numeric($_POST["secFactor"]))
    header("Location: soundSettings.php?test={$_GET['type']}&err=secFactor2");

//controlli su starting rev
else if (($_POST["reversals"]== "") || ($_POST["reversals"]== "undefined")) 
    header("Location: soundSettings.php?test={$_GET['type']}&err=rev1");

else if ($_POST["reversals"]<0)
    header("Location: soundSettings.php?test={$_GET['type']}&err=rev2");

// controlli su secreversal
else if (($_POST["secReversals"]== "") || ($_POST["secReversals"]== "undefined")) 
    header("Location: soundSettings.php?test={$_GET['type']}&err=secRev1");

else if ($_POST["secReversals"]<0)
    header("Location: soundSettings.php?test={$_GET['type']}&err=secRev2");

//controlli su revTh
else if (($_POST["threshold"]== "") || ($_POST["threshold"]== "undefined")) 
    header("Location: soundSettings.php?test={$_GET['type']}&err=threshold1");

else if ($_POST["threshold"]<0)
    header("Location: soundSettings.php?test={$_GET['type']}&err=threshold2");

else{
	$checkFb = 0;
	if(isset($_POST["checkFb"]))
		$checkFb = 1;
	
	$_SESSION["amplitude"] = $_POST["amplitude"];
	$_SESSION["frequency"] = $_POST["frequency"];
	$_SESSION["duration"] = $_POST["duration"];
	//$_SESSION["phase"] = $_POST["phase"];
	$_SESSION["blocks"] = $_POST["blocks"];
	$_SESSION["delta"] = $_POST["delta"];
	$_SESSION["nAFC"] = $_POST["nAFC"];
	$_SESSION["checkFb"] = $checkFb;
	$_SESSION["factor"] = $_POST["factor"];
	$_SESSION["secFactor"] = $_POST["secFactor"];
	$_SESSION["reversals"] = $_POST["reversals"];
	$_SESSION["secReversals"] = $_POST["secReversals"];
	$_SESSION["threshold"] = $_POST["threshold"];
	$_SESSION["algorithm"] = $_POST["algorithm"];
	unset($_SESSION['score']);
	
	header("Location: {$_GET['type']}test.php");
}

?>