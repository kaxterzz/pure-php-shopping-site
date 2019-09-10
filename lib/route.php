<?php 
session_start();
if(!isset($_SESSION['customer'])){
	header("Location:../login.php");	
}
elseif(isset($_SESSION['customer'])){
	$cusid=$_SESSION['customer']['cid'];
	$ctype=$_SESSION['customer']['ctype'];
	switch($ctype){
		case "1":
		header("Location:../fill_cus_details.php?action=add");	
		break;	
		case "2":
		header("Location:../myaccount.php?");
		break;
	}
}

?>