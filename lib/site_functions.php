<?php
require('../admin/lib/function.php');
require_once('../admin/lib/connection.php');
$conn = $conn;
if(isset($_GET['type'])){
	$type=$_GET['type'];
	
	switch($type){
		case 'cartadd':
			addToCart();
		break;
		case 'newacc':
			newAcc();
		break;
		case 'loginacc':
			loginAcc();
		break;
		case 'remvcartitem_sess':
			removeCartItemSess();
		break;	
		case 'updqnty_sess':
			updateCartItemQntySess();
		break;
		case 'remvcartitem_cus':
			removeCartItemCus();
		break;	
		case 'updqnty_cus':
			updateCartItemQntyCus();
		break;
		case 'calSubtotNettot_cus':
			calcSubAndNetTotCus();
		break;
		case 'caltotonremv':
			calTotsOnRemv();
		break;
		case 'wishadd':
			$pid=$_GET['pid'];
			addToWishlist($pid);
		break;
		case 'remvwishlistitem':
			removeWishlistItem();
		break;
		case 'billshipinsrt_sess':
			billShipInsrtSess();
		break;
		case 'billshipinsrtupdt_cus':
			billShipInsrtUpdtCus();
		break;	
		case 'addinv_cus':
			addinv_cus();
		break;
		case 'addinv_sess':
			addinv_sess();	
		break;			
	}
}

function addToCart(){
session_start();	
 $session_id=session_id();
$pid='';
$qnty='';
if(!isset($_SESSION['customer'])|| !isset($_SESSION['customer']['cid']) ){ // if user is not logon to its account
	if(isset($_GET['action']) && $_GET['action']='cadd'){
		if(isset($_GET['pid'])){
			$pid=$_GET['pid'];
			$qnty=$_GET['qnty'];
			$sql1="SELECT * FROM tbl_cart WHERE prd_id='$pid' AND session_id='$session_id'";
			$res=mysqli_query($GLOBALS['conn'],$sql1) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
			if(mysqli_num_rows($res)>0){ // if the prd exist in the cart then update the record
				$sql2="UPDATE tbl_cart SET date_time=Now(),cart_qnty=cart_qnty+'$qnty' WHERE prd_id='$pid' AND session_id='$session_id';";
				$res2=mysqli_query($GLOBALS['conn'],$sql2) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
				if($res2>0)
					echo('2|Successfuly Product updated on Cart');
				else
					echo('3|Something wrong');	
			}
			else{ // if the prd not exist in the cart then insert a record
				$sql3="INSERT INTO tbl_cart(prd_id,session_id,date_time,cart_qnty) VALUES('$pid','$session_id',Now(),'$qnty');";
				$res3=mysqli_query($GLOBALS['conn'],$sql3) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
				if($res3>0)
					echo('1|Successfuly Product added to Cart');
				else
					echo('3|Something wrong');
				}	
		}	
	}
}
elseif(isset($_SESSION['customer']) || isset($_SESSION['customer']['cid'])){ //if user is logon to its account
	if(isset($_GET['action']) && $_GET['action']='cadd'){
		if(isset($_GET['pid'])){
			$pid=$_GET['pid'];
			$qnty=$_GET['qnty'];
			$cid=$_SESSION['customer']['cid'];
			$sql1="SELECT * FROM tbl_cart WHERE prd_id='$pid' AND cus_id='$cid'";
			$res=mysqli_query($GLOBALS['conn'],$sql1) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
			if(mysqli_num_rows($res)>0){ // if the prd exist in the cart then update the record
				$sql2="UPDATE tbl_cart SET date_time=Now(),cart_qnty=cart_qnty+'$qnty' WHERE prd_id='$pid' AND cus_id='$cid';";
				$res2=mysqli_query($GLOBALS['conn'],$sql2) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
				if($res2>0)
					echo('2|Successfuly Product updated on Cart');
				else
					echo('3|Something wrong');	
			}
			else{ // if the prd not exist in the cart then insert a record
				$sql3="INSERT INTO tbl_cart(prd_id,cus_id,session_id,date_time,cart_qnty) VALUES('$pid','$cid','$sessionid',Now(),'$qnty');";
				$res3=mysqli_query($GLOBALS['conn'],$sql3) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
				if($res3>0)
					echo('1|Successfuly Product added to Cart');
				else
					echo('3|Something wrong');
				}	
		}	
	}

}
}

function removeCartItemSess(){ // remove cart item of session cart
	session_start();	
 	$session_id=session_id();
	$pid=$_GET['pid'];
	$sql="DELETE FROM tbl_cart WHERE prd_id='$pid' AND session_id='$session_id';";
	$res=mysqli_query($GLOBALS['conn'],$sql) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
	if($res>0)
		echo "1";	
	
	else
		echo "0";	
}

function updateCartItemQntySess(){
	session_start();	
 	$session_id=session_id();
	$pid=$_GET['pid'];
	$qnty=$_GET['qnty'];
	$price=$_GET['price'];
	$totprice=number_format((double)((int)$qnty*(double)$price),2,'.','');
	$sql="UPDATE tbl_cart SET cart_qnty='$qnty'WHERE prd_id='$pid' AND session_id='$session_id';";
	$res=mysqli_query($GLOBALS['conn'],$sql) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
	if($res>0)
		echo "1|".$totprice;	
	
	else
		echo "0";
}

function removeCartItemCus(){ // remove cart item of session cart
	session_start();	
 	if(isset($_SESSION['customer']) || isset($_SESSION['customer']['cid'])){
		$cid=$_SESSION['customer']['cid'];
		$pid=$_GET['pid'];
		$sql="DELETE FROM tbl_cart WHERE prd_id='$pid' AND cus_id='$cid';";
		$res=mysqli_query($GLOBALS['conn'],$sql) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
		if($res>0)
			echo "1";	
		
		else
			echo "0";	
	}
}

function updateCartItemQntyCus(){
	session_start();	
 	if(isset($_SESSION['customer']) || isset($_SESSION['customer']['cid'])){
		$cid=$_SESSION['customer']['cid'];
		$pid=$_GET['pid'];
		$qnty=$_GET['qnty'];
		$price=$_GET['price'];
		$totprice=number_format((double)((int)$qnty*(double)$price),2,'.','');
		$sql="UPDATE tbl_cart SET cart_qnty='$qnty' WHERE prd_id='$pid' AND cus_id='$cid';";
		$res=mysqli_query($GLOBALS['conn'],$sql) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
		if($res>0)
			echo '1|'.$totprice;	
		
		else
			echo "0";
	}
}

function calcSubAndNetTotCus(){ //calculate subtot and nettot in the cart panel
	$ship=$_GET['ship'];
	$darr=$_GET['darr'];
	$subtot='';
	$nettot='';
	foreach($darr as $arr1){
			$tot = number_format((double)$arr1[0],2,'.','');
			$subtot=number_format((double)((double)$subtot+(double)$tot),2,'.','');
			$nettot=number_format((double)((double)$subtot+(double)$ship),2,'.','');
	}
	echo('1|'.$subtot.'|'.$nettot);
}

function calTotsOnRemv(){ // calculate subtot and nettot when cart item deleted
	$tot=number_format((double)$_GET['tot'],2,'.','');
	$subtot= number_format((double)$_GET['subtot'],2,'.','');
	$ship=$_GET['ship'];
	$nettot='';
	$subtot=number_format((double)((double)$subtot-(double)$tot),2,'.','');
	$nettot=number_format((double)((double)$subtot+(double)$ship),2,'.','');
	echo('1|'.$subtot.'|'.$nettot);
}

function addToWishlist($pid){
	session_start();	
	if(isset($_SESSION['customer'])|| isset($_SESSION['customer']['cid']) ){ // if user is  logon to its account
			$pid;
			$cid=$_SESSION['customer']['cid'];
			$sql1="SELECT * FROM tbl_wishlist WHERE prd_id='$pid' AND cus_id='$cid'";
			$res=mysqli_query($GLOBALS['conn'],$sql1) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
			if(mysqli_num_rows($res)>0){ // if the prd exist in the wishlist then notify user
					echo'2|The Product already in the Wishlist';	
			}
			else{ // if the prd not exist in the wishlist then insert a record
				$sql3="INSERT INTO tbl_wishlist(prd_id,cus_id,date_time) VALUES('$pid','$cid',Now());";
				$res3=mysqli_query($GLOBALS['conn'],$sql3) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
				if($res3>0)
					echo'1|Successfuly Product added to Wishlist';
				else
					echo('3|Something wrong');
				}
			
	
	}
	else echo('4|Please Login to your Account');
}

function removeWishlistItem(){
	session_start();	
 	if(isset($_SESSION['customer']) || isset($_SESSION['customer']['cid'])){
		$cid=$_SESSION['customer']['cid'];
		$pid=$_GET['pid'];
		$sql="DELETE FROM tbl_wishlist WHERE prd_id='$pid' AND cus_id='$cid';";
		$res=mysqli_query($GLOBALS['conn'],$sql) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
		if($res>0)
			echo "1";	
		
		else
			echo "0";	
	}
}

function newAcc(){
	$email=$_POST['email'];	
	$upass=$_POST['upass'];
	$reupass=$_POST['reupass'];
	$cusid=getCusId();
	$email_pat="/^[a-zA-Z0-9\.\_]+\@[a-zA-Z0-9\.\_]+\.[a-zA-Z]{2,4}$/";
	$eupass=md5($upass);
	$ereupass=md5($reupass);
	if(!preg_match($email_pat, $email)){
		echo("2|Please enter a valid email");
	}
	elseif($eupass!=$ereupass){
			echo("3|Please retype the valid password");
			}
	else{		
	$sql="INSERT INTO tbl_customer(cus_id,cus_email,cus_pass,cus_online,cus_stat) VALUES('$cusid','$email','$eupass',1,1);";
	$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
	if($res>0){
		session_start();
		$_SESSION["customer"]["cid"] =$cusid;
		$_SESSION["customer"]["ctype"]="1"; //ctype = new customer a/c = 1
		echo("1|Successfully Account Created");
	}
	else
		echo("4|something wrong");
	}
}

function loginAcc(){
	$email=$_POST['email'];	
	$upass=$_POST['upass'];
	$sql="SELECT * FROM tbl_customer WHERE cus_email='$email';";
	$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
	$nor=mysqli_num_rows($res);
	if($nor>0){
		$rec=mysqli_fetch_assoc($res);
		if($rec['cus_pass']==md5($upass)){
			if($rec['cus_stat']=='1'){
				session_start();
				$_SESSION["customer"]["cid"] =$rec['cus_id'];
				$_SESSION["customer"]["ctype"]="2"; //ctype= logged in customer = 2
				echo("1|Successfully Logged in");
			}
			else
				echo("3|Your account has been disabled");
		}	
		else
			echo("2|Invalid Email or Password");
	}
	else
		echo("2|Invalid Email or Password");		
}

function billShipInsrtSess(){ //insert billing and shipping details at checkout_bill_ship_info.php as a not loggedin user
$Bfname=$_POST['Bfname'];	
$Blname=$_POST['Blname'];
$Bcomp=$_POST['Bcomp'];
$Badd=$_POST['Badd'];
$Badd2=$_POST['Badd2'];
$Bcity=$_POST['Bcity'];
$Bprov=$_POST['Bprov'];
$Btel=$_POST['Btel'];
$Bemail=$_POST['Bemail'];

$fname=$_POST['fname'];	
$lname=$_POST['lname'];
$comp=$_POST['comp'];
$add=$_POST['add'];
$add2=$_POST['add2'];
$city=$_POST['city'];
$prov=$_POST['prov'];
$tel=$_POST['tel'];
$email=$_POST['email'];	
session_start();
$session_id=session_id();
$Bfname_pat='/[a-zA-Z]+/';
$Blname_pat="/[a-zA-Z]+/";
$Btel_pat="/^[0-9]{10}$/";
$Bemail_pat="/^[a-zA-Z0-9\.\_]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,4}$/";
$fname_pat='/[a-zA-Z]+/';
$lname_pat="/[a-zA-Z]+/";
$tel_pat="/^[0-9]{10}$/";
$email_pat="/^[a-zA-Z0-9\.\_]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,4}$/";
			if($Bfname==''|| !preg_match($Bfname_pat,$Bfname)){
				echo'2|Please enter a valid first name';
				}
			elseif($Blname==''|| !preg_match( $Blname_pat,$Blname)){
				echo'3|Please enter a valid last name';
				}	
			elseif($Badd=='' || $Badd2=='' || $Bcity==''){
				echo'4|Please enter your address';
				}
			/*elseif($Btel!='' || !preg_match( $Btel_pat,$Btel) ){
				echo'5|Please enter a valid telephone number';	
			}*/
			/*elseif($Bemail!='' || !preg_match( $Bemail_pat,$Bemail) ){
				echo'6|Please enter a valid email';	
			}*/	
			elseif($fname==''|| !preg_match($fname_pat,$fname)){
				echo'7|Please enter a valid first name';
				}
			elseif($lname==''|| !preg_match( $lname_pat,$lname)){
				echo'8|Please enter a valid last name';
				}	
			elseif($add=='' || $add2=='' || $city==''){
				echo'9|Please enter your address';
				}
			elseif($prov=='' ){
				echo'10|Please select the province';	
			}	
			/*elseif($tel!='' || !preg_match( $tel_pat,$tel) ){
				echo'11|Please enter a valid telephone number';
			}*/	
			/*elseif($email!='' || !preg_match( $email_pat,$email) ){
				echo'12|Please enter a valid email';	
			}*/
			else{
				$sql_all="SELECT * FROM tbl_billing_info WHERE session_id='$session_id';";
				$result=mysqli_query($GLOBALS['conn'],$sql_all) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
				$nor=mysqli_num_rows($result);
				if($nor>0){ //if billing details available(editing) 
					$sql1="UPDATE tbl_billing_info SET bill_fname='$Bfname',bill_lname='$Blname',bill_comp='$Bcomp',bill_add1='$Badd',bill_add2='$Badd2',bill_city='$Bcity',bill_prov='$Bprov',bill_tel='$Btel',bill_email='$Bemail' WHERE session_id='$session_id';";
					$res1=mysqli_query($GLOBALS['conn'],$sql1) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
					$sql2="UPDATE tbl_ship_info SET ship_fname='$fname',ship_lname='$lname',ship_comp='$comp',ship_add1='$add',ship_add2='$add2',ship_city='$city',ship_prov='$prov',ship_tel='$tel',ship_email='$email' WHERE session_id='$session_id';";
					$res2=mysqli_query($GLOBALS['conn'],$sql2) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
					echo '1|Successfully Information Saved';
				}
				else{ // if billing details not available(newely inserting) 
					$sql1="INSERT INTO tbl_billing_info(session_id,bill_fname,bill_lname,bill_comp,bill_add1,bill_add2,bill_city,bill_prov,bill_tel,bill_email) VALUES('$session_id','$Bfname','$Blname','$Bcomp','$Badd','$Badd2','$Bcity','$Bprov','$Btel','$Bemail');";
					$res1=mysqli_query($GLOBALS['conn'],$sql1) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
					$sql2="INSERT INTO tbl_ship_info(session_id,ship_fname,ship_lname,ship_comp,ship_add1,ship_add2,ship_city,ship_prov,ship_tel,ship_email) VALUES('$session_id','$fname','$lname','$comp','$add','$add2','$city','$prov','$tel','$email');";	
					$res2=mysqli_query($GLOBALS['conn'],$sql2) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
					echo '1|Successfully Information Saved';
				}
			}

}

function billShipInsrtUpdtCus(){ //insert/update billing and shipping details at checkout_bill_ship_info.php as a loggedin user
	// if select * from bill table statement true -> update bill details insert ship details
	//if select * from bill table statement false ->insert bill and ship details
	$Bfname=$_POST['Bfname'];	
	$Blname=$_POST['Blname'];
	$Bcomp=$_POST['Bcomp'];
	$Badd=$_POST['Badd'];
	$Badd2=$_POST['Badd2'];
	$Bcity=$_POST['Bcity'];
	$Bprov=$_POST['Bprov'];
	$Btel=$_POST['Btel'];
	$Bemail=$_POST['Bemail'];
	
	$fname=$_POST['fname'];	
	$lname=$_POST['lname'];
	$comp=$_POST['comp'];
	$add=$_POST['add'];
	$add2=$_POST['add2'];
	$city=$_POST['city'];
	$prov=$_POST['prov'];
	$tel=$_POST['tel'];
	$email=$_POST['email'];	
	
	session_start();
	$session_id=session_id();
	$cid=$_SESSION['customer']['cid'];
	$Bfname_pat='/[a-zA-Z]+/';
$Blname_pat="/[a-zA-Z]+/";
$Btel_pat="/^[0-9]{10}$/";
$Bemail_pat="/^[a-zA-Z0-9\.\_]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,4}$/";
$fname_pat='/[a-zA-Z]+/';
$lname_pat="/[a-zA-Z]+/";
$tel_pat="/^[0-9]{10}$/";
$email_pat="/^[a-zA-Z0-9\.\_]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,4}$/";
			if($Bfname==''|| !preg_match($Bfname_pat,$Bfname)){
				echo'2|Please enter a valid first name';
				}
			elseif($Blname==''|| !preg_match( $Blname_pat,$Blname)){
				echo'3|Please enter a valid last name';
				}	
			elseif($Badd=='' || $Badd2=='' || $Bcity==''){
				echo'4|Please enter your address';
				}
			/*elseif($Btel!='' || !preg_match( $Btel_pat,$Btel) ){
				echo'5|Please enter a valid telephone number';	
			}*/
			/*elseif($Bemail!='' || !preg_match( $Bemail_pat,$Bemail) ){
				echo'6|Please enter a valid email';	
			}*/	
			elseif($fname==''|| !preg_match($fname_pat,$fname)){
				echo'7|Please enter a valid first name';
				}
			elseif($lname==''|| !preg_match( $lname_pat,$lname)){
				echo'8|Please enter a valid last name';
				}	
			elseif($add=='' || $add2=='' || $city==''){
				echo'9|Please enter your address';
				}
			elseif($prov=='' ){
				echo'10|Please select the province';	
			}	
			/*elseif($tel!='' || !preg_match( $tel_pat,$tel) ){
				echo'11|Please enter a valid telephone number';
			}*/	
			/*elseif($email!='' || !preg_match( $email_pat,$email) ){
				echo'12|Please enter a valid email';	
			}*/
			else{
				$sql_all="SELECT * FROM tbl_billing_info WHERE cus_id='$cid';";
				$result=mysqli_query($GLOBALS['conn'],$sql_all) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
				$nor=mysqli_num_rows($result);
				if($nor>0){ //if billing details available(previously added or editing) 
					$sql1="UPDATE tbl_billing_info SET bill_fname='$Bfname',bill_lname='$Blname',bill_comp='$Bcomp',bill_add1='$Badd',bill_add2='$Badd2',bill_city='$Bcity',bill_prov='$Bprov',bill_tel='$Btel',bill_email='$Bemail' WHERE cus_id='$cid';";
					$res1=mysqli_query($GLOBALS['conn'],$sql1) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
					
					//check whether ship info available or not
					$sql_all2="SELECT * FROM tbl_ship_info WHERE cus_id='$cid';";
					$result2=mysqli_query($GLOBALS['conn'],$sql_all2) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
					$nor2=mysqli_num_rows($result2);
					if($nor2>0){ //if ship details available=>update (editing)
						$sql="UPDATE tbl_ship_info SET ship_fname='$fname',ship_lname='$lname',ship_comp='$comp',ship_add1='$add',ship_add2='$add2',ship_city='$city',ship_prov='$prov',ship_tel='$tel',ship_email='$email' WHERE cus_id='$cid';";
						$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
						echo '1|Successfully Information Saved';
					}
					else{ //if ship details not available=>insert
						$sql2="INSERT INTO tbl_ship_info(cus_id,ship_fname,ship_lname,ship_comp,ship_add1,ship_add2,ship_city,ship_prov,ship_tel,ship_email) VALUES('$cid','$fname','$lname','$comp','$add','$add2','$city','$prov','$tel','$email');";	
						$res2=mysqli_query($GLOBALS['conn'],$sql2) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
						echo '1|Successfully Information Saved';
					}
				}
				else{ //if billing details not available=>insert billing and shipping details (not inserted previously)
					$sql1="INSERT INTO tbl_billing_info(cus_id,bill_fname,bill_lname,bill_comp,bill_add1,bill_add2,bill_city,bill_prov,bill_tel,bill_email) VALUES('$cid','$Bfname','$Blname','$Bcomp','$Badd','$Badd2','$Bcity','$Bprov','$Btel','$Bemail');";
					$res1=mysqli_query($GLOBALS['conn'],$sql1) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
					$sql2="INSERT INTO tbl_ship_info(cus_id,ship_fname,ship_lname,ship_comp,ship_add1,ship_add2,ship_city,ship_prov,ship_tel,ship_email) VALUES('$cid','$fname','$lname','$comp','$add','$add2','$city','$prov','$tel','$email');";	
					$res2=mysqli_query($GLOBALS['conn'],$sql2) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
					if($res1>0 && $res2>0)
						echo '1|Successfully Information Saved';
				}//end else 'if billing details not available=>insert billing and shipping details'
			}//main else
	
}

function addinv_cus(){//add invoice by registered customer
	session_start();
	$invid=getOrderId(); 
	$denum=false;
	$verified=false;
	if(isset($_SESSION['customer'])|| isset($_SESSION['customer']['cid']) ){ // if user is  logon to its account
		
		$cid=$_SESSION['customer']['cid'];

		$sql_all="SELECT * FROM tbl_customer WHERE cus_id='$cid';";
		$result=mysqli_query($GLOBALS['conn'],$sql_all) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
		$row=mysqli_fetch_assoc($result);
		$cus_email=$row['cus_email'];



		$gtot=$_POST['gtot'];
		$ship=$_POST['ship'];
		$ntot=$_POST['ntot'];
		$parr=$_POST['parr'];
		$cardholder=$_POST['cardholder'];
		$cardno=$_POST['cardno'];
		$cardtype=$_POST['cardtype'];
		$ccExpM=$_POST['ccExpM'];
		$ccExpY=$_POST['ccExpY'];
		$cvc=$_POST['cvc'];
		$month=date('m');// extract month
		$year=date('Y'); //extract year
		function validateCC($cc_num, $type) {
			$denum=false;
			$verified=false;
	
			if($type == "master") {
			$denum = "Master Card";
			} elseif($type == "visa") {
			$denum = "Visa";
			}
			
			if($type == "master") {
			$pattern = "/^([51|52|53|54|55]{2})([0-9]{14})$/";//Mastercard
			if (preg_match($pattern,$cc_num)) {
			$verified = true;
			} else {
			$verified = false;
			}
		
		
			} elseif($type == "visa") {
			$pattern = "/^([4]{1})([0-9]{12,15})$/";//Visa
			if (preg_match($pattern,$cc_num)) {
			$verified = true;
			} else {
			$verified = false;
			}
		
			}
		//print_r($verified);print_r($denum);
		
			if($verified == false) {
				//Do something here in case the validation fails
				//echo "Credit card invalid. Please make sure that you entered a valid <em>" . $denum . "</em> credit card ";
				return array('result'=>false,'card'=>$denum);
		
			} else { //if it will pass...do something
				//echo "Your <em>" . $denum . "</em> credit card is valid";
				return array('result'=>true,'card'=>$denum);
			}
		
		
		}//end function validate
		$arrVC = validateCC($cardno, $cardtype);
		if($cardholder=='')
			echo '3|Please enter the Card holder Name';
		elseif($cardno=='')
			echo '4|Please enter the Card Number';
		elseif($cardtype=='')
			echo '5|Please Select the Card Type';
		elseif($ccExpM=='')
			echo '6|Please enter the Month of Expiry Date of the Card';
		elseif($ccExpY=='')
			echo '7|Please enter the Year of Expiry Date of the Card';	
		elseif($ccExpY<$year)
			echo '8|Your Card has been Expired';
		elseif($ccExpY==$year && $ccExpM<=$month)
			echo '8|Your Card has been Expired';	
		elseif($cvc=='')
			echo '9|Please enter the CVC';	
		elseif(strlen($cvc)!=3)
			echo '10|Please enter valid CVC';
		elseif($arrVC['result'] == false)	
			echo '11|Credit card invalid. Please make sure that you entered a valid <em>'.$arrVC['card'].'</em> credit card ';
		else{			
		$sql="INSERT INTO tbl_invoice(inv_id,inv_date,inv_cus_id,inv_gtot,ship_cost,inv_ntot,inv_online,is_new) VALUES('$invid',Now(),'$cid','$gtot','$ship','$ntot',1,1);";
		$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
		$res1='';
		if($res>0){
			foreach($parr as $val){
				$pid=$val[0];
				$uprice=$val[1];
				$qnty=$val[2];
				$prdtot=$val[3];
				$sql1="INSERT INTO tbl_inv_info(inv_id,inv_date,prd_id,prd_u_price,inv_prd_qnty,inv_prd_tot) VALUES('$invid',Now(),'$pid','$uprice','$qnty','$prdtot');";
				$res1=mysqli_query($GLOBALS['conn'],$sql1) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
				if($res1>0){
					$sql2="DELETE FROM tbl_cart WHERE cus_id='$cid';";
					$res2=mysqli_query($GLOBALS['conn'],$sql2) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
					if($res2>0){
						$sql3="UPDATE tbl_products SET prd_tot_qnty=prd_tot_qnty-'$qnty' WHERE prd_id='$pid';";
						$res3=mysqli_query($GLOBALS['conn'],$sql3) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
						if($res3>0){
							  $from ="amayafashion72@gmail.com";
							  $header = "From : ".$from;
							  $header .= "MIME-Version: 1.0\n";
							  $header .= "Content-type: text/html; charset=iso-8859-1\n";
							  $to =$cus_email;
							  $subject ='Order Receipt '.$invid;
							  $message ='Dear Customer,<br/>&nbsp;&nbsp;Thank you for your Order.<br/><br/><b style="color:#3399ff">Order Summary</b><br/><b>Invoice No:</b>'.$invid.'<br/><b>Total Amount:</b>Rs.'.$ntot.'<br/><br/>Please pay the above amount within 2 days of order placement.<br/><br/>Thank you';
							  
							  // message lines should not exceed 70 characters (PHP rule), so wrap it
							  $message = wordwrap($message, 70);
							  
							  // send mail
							  if(mail($to,$subject,$message,$header)){
								echo('1|Your Order has been Successfully Processed|'.$invid);
							  }
						}
						else
							echo '2|error';
					}
					else 
						echo '2|error';
				}
				else 
					echo '2|error';
			}
		}
		else 
			echo '2|error';
		}//else
	}
}

function addinv_sess(){
session_start();
	$invid=getOrderId(); 
	$denum=false;
	$verified=false;
	if(!isset($_SESSION['customer'])|| !isset($_SESSION['customer']['cid']) ){ // if user is  logon to its account
		$session_id=session_id();
		$cid=$_SESSION['customer']['cid'];

		$sql_all="SELECT * FROM tbl_customer WHERE cus_id='$cid';";
		$result=mysqli_query($GLOBALS['conn'],$sql_all) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
		$row=mysqli_fetch_assoc($result);
		$cus_email=$row['cus_email'];

		
		$gtot=$_POST['gtot'];
		$ship=$_POST['ship'];
		$ntot=$_POST['ntot'];
		$parr=$_POST['parr'];
		$cardholder=$_POST['cardholder'];
		$cardno=$_POST['cardno'];
		$cardtype=$_POST['cardtype'];
		$ccExpM=$_POST['ccExpM'];
		$ccExpY=$_POST['ccExpY'];
		$cvc=$_POST['cvc'];
		$month=date('m');// extract month
		$year=date('Y'); //extract year
		function validateCC($cc_num, $type) {
			$denum=false;
			$verified=false;
	
			if($type == "master") {
			$denum = "Master Card";
			} elseif($type == "visa") {
			$denum = "Visa";
			}
			
			if($type == "master") {
			$pattern = "/^([51|52|53|54|55]{2})([0-9]{14})$/";//Mastercard
			if (preg_match($pattern,$cc_num)) {
			$verified = true;
			} else {
			$verified = false;
			}
		
		
			} elseif($type == "visa") {
			$pattern = "/^([4]{1})([0-9]{12,15})$/";//Visa
			if (preg_match($pattern,$cc_num)) {
			$verified = true;
			} else {
			$verified = false;
			}
		
			}
		//print_r($verified);print_r($denum);
		
			if($verified == false) {
				//Do something here in case the validation fails
				//echo "Credit card invalid. Please make sure that you entered a valid <em>" . $denum . "</em> credit card ";
				return array('result'=>false,'card'=>$denum);
		
			} else { //if it will pass...do something
				//echo "Your <em>" . $denum . "</em> credit card is valid";
				return array('result'=>true,'card'=>$denum);
			}
		
		
		}//end function validate
		$arrVC = validateCC($cardno, $cardtype);
		if($cardholder=='')
			echo '3|Please enter the Card holder Name';
		elseif($cardno=='')
			echo '4|Please enter the Card Number';
		elseif($cardtype=='')
			echo '5|Please Select the Card Type';
		elseif($ccExpM=='')
			echo '6|Please enter the Month of Expiry Date of the Card';
		elseif($ccExpY=='')
			echo '7|Please enter the Year of Expiry Date of the Card';	
		elseif($ccExpY<$year)
			echo '8|Your Card has been Expired';
		elseif($ccExpY==$year && $ccExpM<=$month)
			echo '8|Your Card has been Expired';	
		elseif($cvc=='')
			echo '9|Please enter the CVC';	
		elseif(strlen($cvc)!=3)
			echo '10|Please enter valid CVC';
		elseif($arrVC['result'] == false)	
			echo '11|Credit card invalid. Please make sure that you entered a valid <em>'.$arrVC['card'].'</em> credit card ';
		else{			
		$sql="INSERT INTO tbl_invoice(inv_id,inv_date,inv_session_id,inv_gtot,ship_cost,inv_ntot,inv_online,is_new) VALUES('$invid',Now(),'$session_id','$gtot','$ship','$ntot',1,1);";
		$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
		$res1='';
		if($res>0){
			foreach($parr as $val){
				$pid=$val[0];
				$uprice=$val[1];
				$qnty=$val[2];
				$prdtot=$val[3];
				$sql1="INSERT INTO tbl_inv_info(inv_id,inv_date,prd_id,prd_u_price,inv_prd_qnty,inv_prd_tot) VALUES('$invid',Now(),'$pid','$uprice','$qnty','$prdtot');";
				$res1=mysqli_query($GLOBALS['conn'],$sql1) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
				if($res1>0){
					$sql2="DELETE FROM tbl_cart WHERE session_id='$session_id';";
					$res2=mysqli_query($GLOBALS['conn'],$sql2) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
					if($res2>0){
						$sql3="UPDATE tbl_products SET prd_tot_qnty=prd_tot_qnty-'$qnty' WHERE prd_id='$pid';";
						$res3=mysqli_query($GLOBALS['conn'],$sql3) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
						if($res3>0){
							  $from ="amayafashion72@gmail.com";
							  $header = "From : ".$from;
							  $header .= "MIME-Version: 1.0\n";
							  $header .= "Content-type: text/html; charset=iso-8859-1\n";
							  $to =$cus_email;
							  $subject ='Order Receipt '.$invid;
							  $message ='Dear Customer,<br/>&nbsp;&nbsp;Thank you for your Order.<br/><br/><b style="color:#3399ff">Order Summary</b><br/><b>Invoice No:</b>'.$invid.'<br/><b>Total Amount:</b>Rs.'.$ntot.'<br/><br/>Please pay the above amount within 2 days of order placement.<br/><br/>Thank you';
							  
							  // message lines should not exceed 70 characters (PHP rule), so wrap it
							  $message = wordwrap($message, 70);
							  
							  // send mail
							  if(mail($to,$subject,$message,$header)){
								echo('1|Your Order has been Successfully Processed|'.$invid);
							  }
						}
						else
							echo '2|error';
					}
					else 
						echo '2|error';
				}
				else 
					echo '2|error';
			}
		}
		else 
			echo '2|error';
		}//else
	}	
}
?>