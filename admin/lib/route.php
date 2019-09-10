<?php 
session_start();
if(!isset($_SESSION['employee'])){//edit
	header("Location:../index.php");	
}
elseif(isset($_SESSION['employee'])){//edit
	$etype=$_SESSION['employee']['etype'];
	switch($etype){
		case "J0001":
		header("Location:../admin_dashboard.php");
		break;	
		case "J0002":
		header("Location:../admin_dashboard.php");
		break;
		case "J0003":
		header("Location:../admin_dashboard.php");
		break;
	}
}

?>