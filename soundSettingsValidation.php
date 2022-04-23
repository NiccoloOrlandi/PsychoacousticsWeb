<?php

session_start();

$_SESSION["amplitude"] = $_POST["amplitude"];
$_SESSION["frequency"] = $_POST["frequency"];
$_SESSION["duration"] = $_POST["duration"];
$_SESSION["phase"] = $_POST["phase"];
$_SESSION["blocks"] = $_POST["blocks"];
$_SESSION["delta"] = $_POST["delta"];
$_SESSION["nAFC"] = $_POST["nAFC"];
$_SESSION["checkFb"] = $_POST["checkFb"];
$_SESSION["factor"] = $_POST["factor"];
$_SESSION["secFactor"] = $_POST["secFactor"];
$_SESSION["reversals"] = $_POST["reversals"];
$_SESSION["secReversals"] = $_POST["secReversals"];
$_SESSION["threshold"] = $_POST["threshold"];
$_SESSION["algorithm"] = $_POST["algorithm"];

$sound_irreg_exp = "/^([a-zA-Z])+$/";
//controlli su amplitude
if (($_POST["amplitude"]== "") || ($_POST["amplitude"]== "undefined"))    
    header("Location: soundSettings.php?err=amp1")  

else if(sound_irreg_exp.test($_POST["amplitude"]))
   header("Location: soundSettings.php?err=amp2")

//controlli su frequency
if (($_POST["frequency"]== "") || ($_POST["frequency"]== "undefined")) 
    header("Location: soundSettings.php?err=freq1")

else if ($_POST["frequency"]<0)
    header("Location: soundSettings.php?err=freq2")

//Controlli su duration
if (($_POST["duration"]== "") || ($_POST["duration"]== "undefined")) 
    header("Location: soundSettings.php?err=dur1")

else if ($_POST["duration"]<0) 
    header("Location: soundSettings.php?err=dur2")

//controlli su phase
if (($_POST["phase"]== "") || ($_POST["phase"]== "undefined")) 
    header("Location: soundSettings.php?err=phase1")

else if ($_POST["phase"]<0)
    header("Location: soundSettings.php?err=phase2")

//controlli su number of blocks
if (($_POST["blocks"]== "") || ($_POST["blocks"]== "undefined")) 
    header("Location: soundSettings.php?err=numblock1")

else if ($_POST["blocks"]<0)
    header("Location: soundSettings.php?err=numblock2")

//controlli su starting level
if (($_POST["delta"]== "") || ($_POST["delta"]== "undefined")) 
    header("Location: soundSettings.php?err=delta1")

else if ($_POST["delta"]<0)
    header("Location: soundSettings.php?err=delta2")

//controlli su nAFC
if (($_POST["nAFC"]== "") || ($_POST["nAFC"]== "undefined")) 
    header("Location: soundSettings.php?err=nAFC1")

else if ($_POST["nAFC"]<0)
    header("Location: soundSettings.php?err=nAFC2")

//controlli sul factor
if (($_POST["factor"]== "") || ($_POST["factor"]== "undefined")) 
    header("Location: soundSettings.php?err=factor1")


else if (($_POST["factor"]< $_POST["secFactor"] ) || !is_numeric($_POST["factor"]))
    header("Location: soundSettings.php?err=factor2")

//controlli sul factor
if (($_POST["secFactor"]== "") || ($_POST["secFactor"]== "undefined")) 
    header("Location: soundSettings.php?err=secFactor1")


else if (($_POST["secFactor"]< 1) || !is_numeric($_POST["secFactor"]))
    header("Location: soundSettings.php?err=secFactor2")

//controlli su starting rev
if (($_POST["reversals"]== "") || ($_POST["reversals"]== "undefined")) 
    header("Location: soundSettings.php?err=rev1")

else if ($_POST["reversals"]<0)
    header("Location: soundSettings.php?err=rev2")

// controlli su secreversal
if (($_POST["secReversals"]== "") || ($_POST["secReversals"]== "undefined")) 
    header("Location: soundSettings.php?err=secRev1")

else if ($_POST["secReversals"]<0)
    header("Location: soundSettings.php?err=secRev2")

//controlli su revTh
if (($_POST["threshold"]== "") || ($_POST["threshold"]== "undefined")) 
    header("Location: soundSettings.php?err=threshold1")

else if ($_POST["threshold"]<0)
    header("Location: soundSettings.php?err=threshold2")
       
?>