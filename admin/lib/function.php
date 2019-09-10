<?php
include('config.php');
include('connection.php');

$conn = $conn;

if(isset($_GET['type'])){
	$type=$_GET['type'];
	
	switch($type){
		case 'getcusfname':
			getcusfname();
		break;	
		case 'loginemp':
			empLogin();
		break;	
	}
}

function empLogin(){
	$uname=$_POST['uname'];	
	$upass=$_POST['upass'];
	$sql="SELECT * FROM tbl_emp WHERE emp_uname='$uname';";
	$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
	$nor=mysqli_num_rows($res);
	if($nor>0){
		$rec=mysqli_fetch_assoc($res);
		if($rec['emp_pass']==md5($upass)){
			if($rec['emp_stat']=='1'){
				session_start();
				$_SESSION["employee"]["eid"] =$rec['emp_id'];
				$_SESSION["employee"]["etype"]=$rec['emp_job_id'];
				echo("1|Successfully Logged in");
			}
			else
				echo("3|Your account has been disabled");
		}	
		else
			echo("2|Invalid Username or Password");
	}
	else
		echo("2|Invalid Username or Password");		
	
}	

function getcusfname(){
	$f=$_GET['selectFirst'];
	//echo $f;
	$f = mysqli_real_escape_string($f);
  	$output = array();	
	$sql="SELECT cus_fname FROM tbl_customer WHERE cus_fname LIKE '%$f%' ORDER BY cus_fname";
 	$result = mysqli_query($GLOBALS['conn'],$sql) or die(mysqli_error($GLOBALS['conn']));
 	if($result){
  		while($row=mysqli_fetch_array($result)){
   			$output[] = $row['cus_fname'];
  		}
 	}
	echo json_encode($output);
}	
	
function getEmpId(){
		$sql="SELECT emp_id FROM tbl_emp ORDER BY emp_id DESC LIMIT 1;";
		$result=mysqli_query($GLOBALS['conn'],$sql) or die("SQL error:".mysqli_error($GLOBALS['conn']));
		$nor=mysqli_num_rows($result);
		if($nor>0){
			$rec=mysqli_fetch_assoc($result);
			$eid=$rec["emp_id"];
			$num=substr($eid,1);
			if($num<9){
				return "E000".($num+1);
				}
			elseif($num<99){
				return "E00".($num+1);
				}	
			elseif($num<999){
				return "E0".($num+1);
				}
			else{
				return "E".($num+1);
				}				
		}
		else{
			return "E0001";
			}
	}	
	
function getJobId(){
		$sql="SELECT job_id FROM tbl_job ORDER BY job_id DESC LIMIT 1;";
		$result=mysqli_query($GLOBALS['conn'],$sql) or die("SQL error:".mysqli_error($GLOBALS['conn']));
		$nor=mysqli_num_rows($result);
		if($nor>0){
			$rec=mysqli_fetch_assoc($result);
			$jid=$rec["job_id"];
			$num=substr($jid,1);
			if($num<9){
				return "J000".($num+1);
				}
			elseif($num<99){
				return "J00".($num+1);
				}	
			elseif($num<999){
				return "J0".($num+1);
				}
			else{
				return "J".($num+1);
				}				
		}
		else{
			return "J0001";
			}
	}		
	
	function getBrandId(){
		$sql="SELECT brand_id FROM tbl_brand ORDER BY brand_id DESC LIMIT 1;";
		$result=mysqli_query($GLOBALS['conn'],$sql) or die("SQL error:".mysqli_error($GLOBALS['conn']));
		$nor=mysqli_num_rows($result);
		if($nor>0){
			$rec=mysqli_fetch_assoc($result);
			$bid=$rec["brand_id"];
			$num=substr($bid,1);
			if($num<9){
				return "B000".($num+1);
				}
			elseif($num<99){
				return "B00".($num+1);
				}	
			elseif($num<999){
				return "B0".($num+1);
				}
			else{
				return "B".($num+1);
				}				
		}
		else{
			return "B0001";
			}
	}		
	
	function getCatId(){
		$sql="SELECT cat_id FROM tbl_category ORDER BY cat_id DESC LIMIT 1;";
		$result=mysqli_query($GLOBALS['conn'],$sql) or die("SQL error:".mysqli_error($GLOBALS['conn']));
		$nor=mysqli_num_rows($result);
		if($nor>0){
			$rec=mysqli_fetch_assoc($result);
			$catid=$rec["cat_id"];
			$num=substr($catid,1);
			if($num<9){
				return "C000".($num+1);
				}
			elseif($num<99){
				return "C00".($num+1);
				}	
			elseif($num<999){
				return "C0".($num+1);
				}
			else{
				return "C".($num+1);
				}				
		}
		else{
			return "C0001";
			}
	}		
	
	function getprdId(){
		$sql="SELECT prd_id FROM tbl_products ORDER BY prd_id DESC LIMIT 1;";
		$result=mysqli_query($GLOBALS['conn'],$sql) or die("SQL error:".mysqli_error($GLOBALS['conn']));
		$nor=mysqli_num_rows($result);
		if($nor>0){
			$rec=mysqli_fetch_assoc($result);
			$pid=$rec["prd_id"];
			$num=substr($pid,1);
			if($num<9){
				return "P000000".($num+1);
				}
			elseif($num<99){
				return "P00000".($num+1);
				}	
			elseif($num<999){
				return "P0000".($num+1);
				}
			elseif($num<9999){
				return "P000".($num+1);
				}
			elseif($num<99999){
				return "P00".($num+1);
				}
			elseif($num<999999){
				return "P0".($num+1);
				}	
			else{
				return "P".($num+1);
				}						
		}
		else{
			return "P0000001";
			}
	}	
	
	function getBatchId(){
		$sql="SELECT batch_id FROM tbl_batch ORDER BY batch_id DESC LIMIT 1;";
		$result=mysqli_query($GLOBALS['conn'],$sql) or die("SQL error:".mysqli_error($GLOBALS['conn']));
		$nor=mysqli_num_rows($result);
		if($nor>0){
			$rec=mysqli_fetch_assoc($result);
			$bid=$rec["batch_id"];
			$num=substr($bid,1);
			if($num<9){
				return "K000000".($num+1);
				}
			elseif($num<99){
				return "K00000".($num+1);
				}	
			elseif($num<999){
				return "K0000".($num+1);
				}
			elseif($num<9999){
				return "K000".($num+1);
				}
			elseif($num<99999){
				return "K00".($num+1);
				}
			elseif($num<999999){
				return "K0".($num+1);
				}	
			else{
				return "K".($num+1);
				}						
		}
		else{
			return "K0000001";
			}
		}
	
	function getCusId(){
		$sql="SELECT cus_id FROM tbl_customer ORDER BY cus_id DESC LIMIT 1;";
		$result=mysqli_query($GLOBALS['conn'],$sql) or die("SQL error:".mysqli_error($GLOBALS['conn']));
		$nor=mysqli_num_rows($result);
		if($nor>0){
			$rec=mysqli_fetch_assoc($result);
			$cusid=$rec["cus_id"];
			$num=substr($cusid,1);
			if($num<9){
				return "Z000".($num+1);
				}
			elseif($num<99){
				return "Z00".($num+1);
				}	
			elseif($num<999){
				return "Z0".($num+1);
				}
			else{
				return "Z".($num+1);
				}				
		}
		else{
			return "Z0001";
			}
	}		
	
	function getOrderId(){
		$sql="SELECT inv_id FROM tbl_invoice ORDER BY inv_id DESC LIMIT 1;";
		$result=mysqli_query($GLOBALS['conn'],$sql) or die("SQL error:".mysqli_error($GLOBALS['conn']));
		$nor=mysqli_num_rows($result);
		if($nor>0){
			$rec=mysqli_fetch_assoc($result);
			$invid=$rec["inv_id"];
			$num=substr($invid,3);
			if($num<9){
				return "INV000000".($num+1);
				}
			elseif($num<99){
				return "INV00000".($num+1);
				}	
			elseif($num<999){
				return "INV0000".($num+1);
				}
			elseif($num<9999){
				return "INV000".($num+1);
				}
			elseif($num<99999){
				return "INV00".($num+1);
				}
			elseif($num<999999){
				return "INV0".($num+1);
				}	
			else{
				return "INV".($num+1);
				}						
		}
		else{
			return "INV0000001";
			}
	}
	
	function getSupId(){
		$sql="SELECT sup_id FROM tbl_supplier ORDER BY sup_id DESC LIMIT 1;";
		$result=mysqli_query($GLOBALS['conn'],$sql) or die("SQL error:".mysqli_error($GLOBALS['conn']));
		$nor=mysqli_num_rows($result);
		if($nor>0){
			$rec=mysqli_fetch_assoc($result);
			$supid=$rec["sup_id"];
			$num=substr($supid,1);
			if($num<9){
				return "S000".($num+1);
				}
			elseif($num<99){
				return "S00".($num+1);
				}	
			elseif($num<999){
				return "S0".($num+1);
				}
			else{
				return "S".($num+1);
				}				
		}
		else{
			return "S0001";
			}
		}
		
	function getExpId(){
		$sql="SELECT exp_id FROM tbl_expense ORDER BY exp_id DESC LIMIT 1;";
		$result=mysqli_query($GLOBALS['conn'],$sql) or die("SQL error:".mysqli_error($GLOBALS['conn']));
		$nor=mysqli_num_rows($result);
		if($nor>0){
			$rec=mysqli_fetch_assoc($result);
			$expid=$rec["exp_id"];
			$num=substr($expid,1);
			if($num<9){
				return "X000".($num+1);
				}
			elseif($num<99){
				return "X00".($num+1);
				}	
			elseif($num<999){
				return "X0".($num+1);
				}
			else{
				return "X".($num+1);
				}				
		}
		else{
			return "X0001";
			}
	}	
	
function getSalesReturnId(){
		$sql="SELECT sal_retrn_id FROM tbl_sales_return ORDER BY sal_retrn_id DESC LIMIT 1;";
		$result=mysqli_query($GLOBALS['conn'],$sql) or die("SQL error:".mysqli_error($GLOBALS['conn']));
		$nor=mysqli_num_rows($result);
		if($nor>0){
			$rec=mysqli_fetch_assoc($result);
			$salretid=$rec["sal_retrn_id"];
			$num=substr($salretid,2);
			if($num<9){
				return "SR000000".($num+1);
				}
			elseif($num<99){
				return "SR00000".($num+1);
				}	
			elseif($num<999){
				return "SR0000".($num+1);
				}
			elseif($num<9999){
				return "SR000".($num+1);
				}
			elseif($num<99999){
				return "SR00".($num+1);
				}
			elseif($num<999999){
				return "SR0".($num+1);
				}			
			else{
				return "SR".($num+1);
				}				
		}
		else{
			return "SR0000001";
			}
	}
function sendNotify($invid,$prdid,$qnty,$rdate){ //sales return notification
	$from ="binnytraders@gmail.com";
	$header = "From : ".$from;
	$header .= "MIME-Version: 1.0\n";
	$header .= "Content-type: text/html; charset=iso-8859-1\n";
	$to ='newuser@localhost';
	$subject ='Sales Return Arrived';
	$message ='Dear Sir,<br/><center><b style="color:#9900ff">Return Sales Summary</b></center>
<br/><b>Invoice ID:</b> '.$invid.'<br/><b>Product ID:</b> '.$prdid.'<br/><b>Quantity Returned:</b> '.$qnty.'<br/>
<b>Returned Date:</b> '.$rdate.'<br/><br/>Thank you';
$message = wordwrap($message, 70);	  
// send mail
	if(mail($to,$subject,$message,$header))
		$esmsg="success email";


$resp ='+94775059818';
$msg ='Dear Sir,A Sales Returned :( ,Invoice ID:'.$invid.' Product ID:'.$prdid.' Quantity Returned:'.$qnty.' Returned Date:'.$rdate.'';
$gatewayURL = 'http://localhost:9333/ozeki?'; 
$request = 'login=admin'; 
$request .= '&password=abc123'; 
$request .= '&action=sendMessage'; 
$request .= '&messageType=SMS:TEXT'; 
$request .= '&recepient='.urlencode($resp); 
$request .= '&messageData='.urlencode($msg);
$url = $gatewayURL . $request; 
//Open the URL to send the message 
file($url);
$smsg="success";
	if($smsg=='success' && $esmsg="success email"){
		echo "1|Record has been Successfully Saved";
	}



}		
?>