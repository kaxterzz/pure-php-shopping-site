<?php require_once('connection.php');
if(isset($_GET['type'])){
	$type=$_GET['type'];
	
	switch($type){
		case 'getproprice':
			getProPrice();
		break;
		case 'addinv':
			addInvoice();
		break;	
		case 'delprdorder':
			delPrdOrder();
		break;
		case 'addnewinvprd':
			addNewInvPrd();
		break;	
		case 'updateinvprd':
			updateInvPrd();
		break;	
		case 'updateinv':
			updateInv();
		break;
		case 'getinvinfo':
			getinvinfo();
		break;
		case 'getstoklvl':
			getstoklvl();
		break;
		case 'getCusDetailsByName':
			getCusDetailsByName();
		break;	
		case 'addcusdetails':
			addcusdetails();
		break;					
	}
}

function getProPrice(){ //get corresponding prod price when prd selected in dropdown in add-order.php and edit-order.php
	$pid=$_GET['pid'];
	$sql="SELECT prd_price FROM tbl_products WHERE prd_id='$pid';";
	$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
	$row=mysqli_fetch_assoc($res);
	echo($row['prd_price']);	
}

function addInvoice(){
	$invid=$_POST['invid'];
	$cusid=$_POST['cusid'];
	$eid=$_POST['eid'];
	$gtot=$_POST['gtot'];
	$disc=$_POST['disc'];
	$ntot=$_POST['ntot'];
	$darr=$_POST['darr'];	
	$sql="INSERT INTO tbl_invoice(inv_id,inv_date,inv_cus_id,inv_emp_id,inv_gtot,inv_disc,inv_ntot) VALUES('$invid',Now(),'$cusid','$eid','$gtot','$disc','$ntot');";
	$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
	$res2='';
		foreach($darr as $val){
		 $pid=$val[0];
		 $uprice=$val[1];
		 $qnty=$val[2];
		 $tot=$val[3];
		 $sql2="INSERT INTO tbl_inv_info(inv_id,inv_date,prd_id,prd_u_price,inv_prd_qnty,inv_prd_tot) VALUES('$invid',Now(),'$pid','$uprice','$qnty','$tot');";
		 $res2=mysqli_query($GLOBALS['conn'],$sql2) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
		 if($res2>0){
			$sql3="UPDATE tbl_products SET prd_tot_qnty=prd_tot_qnty-'$qnty' WHERE prd_id='$pid';";
			$res3=mysqli_query($GLOBALS['conn'],$sql3) or die("MYSQL Error:".mysqli_error($GLOBALS['conn'])); //test this
		 }
		echo "1";	
	}
}

function delPrdOrder(){ // delete existing prd in tbl_inv_info in edit-order.php and detail_order.php
	$pid=$_GET['pid'];
	$invid=$_GET['invid'];
	$sql="SELECT inv_prd_tot FROM tbl_inv_info WHERE prd_id='$pid' AND inv_id='$invid';";
	$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
 	$row=mysqli_fetch_assoc($res);
	$delprdtot=$row['inv_prd_tot'];
	$sql1="DELETE FROM tbl_inv_info WHERE prd_id='$pid' AND inv_id='$invid';";	
	$res1=mysqli_query($GLOBALS['conn'],$sql1) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
	if($res1>0){
		$sql2="UPDATE tbl_invoice SET inv_gtot=inv_gtot-'$delprdtot',inv_ntot=inv_gtot-(inv_disc*inv_gtot) WHERE inv_id='$invid';";
		$res2=mysqli_query($GLOBALS['conn'],$sql2) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
		if($res2>0){
			echo '1|Successfully Record deleted';
		}
		else{
			echo '2|Something wrong';
		}
	}
	else{
		echo '2|Something wrong';
	}
}

function addNewInvPrd(){ // inserting new prds to tbl_inv_info in edit-order.php
	$invid=$_POST['invid'];	
	$darr=$_POST['darr'];
	foreach($darr as $val){
			 $pid=$val[0];
			 $uprice=$val[1];
			 $qnty=$val[2];
			 $tot=$val[3];
			 $sql="INSERT INTO tbl_inv_info(inv_id,prd_id,prd_u_price,inv_prd_qnty,inv_prd_tot) VALUES('$invid','$pid','$uprice','$qnty','$tot');";
			 $res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
	}
	if($res>0)
		echo '1';	 
	 else
		echo '0';
}

function updateInvPrd(){ //updating existing prds to tbl_inv_info in edit-order.php
	$invid=$_POST['invid'];	
	$darr=$_POST['darr'];
	foreach($darr as $val){
			 $pid=$val[0];
			 $uprice=$val[1];
			 $qnty=$val[2];
			 $tot=$val[3];
			 $sql="UPDATE tbl_inv_info SET prd_id='$pid',prd_u_price='$uprice',inv_prd_qnty='$qnty',inv_prd_tot='$tot' WHERE inv_id='$invid';";
			 $res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
	}
	if($res>0)
		echo '1';	 
	else
		echo '0';
}
function updateInv(){ //update the tbl_invoice in edit-order.php
	$invid=$_POST['invid'];	
	$gtot=$_POST['gtot'];
	$disc=$_POST['disc'];
	$ntot=$_POST['ntot'];
	$sql="UPDATE tbl_invoice SET inv_gtot='$gtot',inv_disc='$disc',inv_ntot='$ntot' WHERE inv_id='$invid';";
	$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
	if($res>0)
		echo '1|Successfully Record Updated';	 
	else
		echo '2|Something Wrong';	
}

function getinvinfo(){ // get cat,prd,price when inv entered in sales_return.php
	$invid=$_GET['invid'];
	$sql="SELECT C.cat_name,P.prd_name,I.prd_u_price FROM tbl_inv_info I,tbl_products P,tbl_category C WHERE inv_id='$invid' AND I.prd_id=P.prd_id AND P.cat_id=C.cat_id;";	
	$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
	$row=mysqli_fetch_assoc($res);
	//$arr=array($row['cat_name'],$row['prd_name'],$row['prd_u_price']);
	echo ($row['cat_name'].'|'.$row['prd_name'].'|'.$row['prd_u_price']);
	/*$arr=new Array();
	echo($row['prd_price']);*/
}
function getstoklvl(){ // get stock lvl when qnty of particular prd entered in add-order.php
	$pid=$_GET['pid'];
	$sql="SELECT prd_tot_qnty FROM tbl_products WHERE prd_id='$pid';";
	$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
	$row=mysqli_fetch_assoc($res);
	echo($row['prd_tot_qnty']);
}

function getCusDetailsByName(){ //get cus details to table when search by name in cus_modal.php
	$cusname=$_GET['cusname'];
	$sql="SELECT cus_id,cus_fname,cus_lname,cus_gen,cus_add FROM tbl_customer WHERE cus_fname LIKE '%$cusname%' OR cus_lname LIKE '%$cusname%';";
	$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
	if(mysqli_num_rows($res)<0){
		echo '<tr><td colspan="6">No Records Found. Please Add a New Customer</td></tr>';	
	}
	else{
		while($row=mysqli_fetch_assoc($res)){
			echo'<tr>';
				echo '<td>'.$row['cus_id'].'</td>';
				echo '<td>'.$row['cus_fname'].'</td>';
				echo '<td>'.$row['cus_lname'].'</td>';
				$gen=$row['cus_gen'];
				if($gen==1)
					$gen='Male';
				elseif($gen==0)	
					$gen='Female';
				echo '<td>'.$gen.'</td>';
				echo '<td>'.$row['cus_add'].'</td>';
				echo'<td><a class="glyphicon glyphicon-download-alt" id="addcustofrm" title="Add Customer" onclick="addcustoform(this);">Add</a></td>';
			echo'</tr>';
		}
	}	
}

function addcusdetails(){
	$cusid=$_POST['cusid'];
	$fname=trim($_POST['fname']);
	$lname=trim($_POST['lname']);	
	$gen=$_POST['gen'];
	$add=$_POST['add'];
	$fname_pat='/^[a-zA-Z]+$/';
	$lname_pat="/^[a-zA-Z]+$/";
	if($fname==''|| !preg_match($fname_pat,$fname)){
		echo'2|Please enter a valid first name';
	}
	elseif($lname==''|| !preg_match( $lname_pat,$lname)){
		echo'3|Please enter a valid last name';
	}		
	elseif($add==''){
		echo'4|Please enter your address';
	}
	else{
	$sql="INSERT INTO tbl_customer(cus_id,cus_fname,cus_lname,cus_gen,cus_add) VALUES('$cusid','$fname','$lname','$gen','$add');";
	$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
	if($res>0)
		echo '1|Successfully Record Saved';
	
	else
		echo '5|Something wrong';
	}
}
?>		