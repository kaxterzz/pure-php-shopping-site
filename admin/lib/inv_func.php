<?php
require_once('connection.php');
if(isset($_GET['type'])){
	$type=$_GET['type'];
	
	switch($type){
		case 'addcat':
			addCategory();
		break;	
		
		case 'getcat':
			getCategory();	
		break;
		case 'addbrand':
			addBrand();	
		break;
		case 'getbrand':
			getBrand();
		break;
		case 'featrbycat':
			FeatrByCate();
		break;
		case 'getfeatr':
			GetFeature();
		break;		
		case 'cmbprobycat':
			proByCate($prd);
		break;	
			
		case 'addprds':
			addPrds(); 
		break;
		case 'addfeatures':
			addfeatures();
		break;	
		case 'remvfeatr':
			remvfeatr();
		break;		
		case 'updprds':
			updateprds();
		break;	
		case 'updfeatures':
			updatefeatures();
		break;	
		case 'remvcatfeatr':
			deleteCatFeatr();
		break;
		case 'updatecatfeatr':	
			updateCatAndPfeatr();
		break;	
		case 'updatenewtfeatr':
			updateNewFeatr();
		break;		
		}
	}
	
function addCategory(){			//category.php modal adding new category to db
	 $catid=$_POST['cid'];
	 $cat=$_POST['cname'];
	 $cstat=$_POST['cstat'];
	 $supcat=$_POST['scat'];
	 $cfarr=$_POST['farr'];
	 $res1='';
	 $res2='';
	$cat_pat='/[a-zA-Z]+/';
	if($cat==''|| !preg_match($cat_pat,$cat)){
		echo('1|Please enter a valid Category Name');
	}
	else{
		$sql1="INSERT INTO tbl_category(cat_id,cat_name,cat_stat,cat_super_cat) VALUES('$catid','$cat','$cstat','$supcat');";
		$res1=mysqli_query($GLOBALS['conn'],$sql1) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
		foreach($cfarr as $val){
		 $feature=$val;
		 $sql2="INSERT INTO tbl_cat_feature(cat_id,cat_feature,feature_stat) VALUES('$catid','$feature','1');";
		 $res2=mysqli_query($GLOBALS['conn'],$sql2) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
		}
		if($res1>0 && $res2>0){
				echo('3|Successfuly data saved');	
			}
			else{
				echo('2|Something wrong with data entry');	
			}
	}
}

function getCategory($cat){ // get dropdown items of Category product.php?action=add
	$sql_opt="SELECT * FROM tbl_category WHERE cat_stat=1;";
    $result=mysqli_query($GLOBALS['conn'],$sql_opt) or die("SQL error:".mysqli_error($GLOBALS['conn']));
	
	if(mysqli_num_rows($result)>0){
		 while($row=mysqli_fetch_assoc($result)){
			$catid=$row['cat_id'];
			$catname=$row['cat_name'];
			$select='';
			if($cat==$catid){
				$select='selected="selected"';
			}
			
            echo '<option value="'.$catid.'"'.$select.' >'.$catname.'</option>';  
             }//end while
			 
			 }
	}
	
function getBrand($brand){ // get dropdown items of Brand product.php?action=add
	$sql_opt="SELECT * FROM tbl_brand WHERE brand_stat=1;";
    $result=mysqli_query($GLOBALS['conn'],$sql_opt) or die("SQL error:".mysqli_error($GLOBALS['conn']));
	
	if(mysqli_num_rows($result)>0){
		
		
		 while($row=mysqli_fetch_assoc($result)){
			$brandid=$row['brand_id'];
			$brandname=$row['brand_name'];
			$select='';
			if($brand==$brandid){
				$select='selected="selected"';
			}
			
            echo '<option value="'.$brandid.'"'.$select.'>'.$brandname.'</option>';  
             }//end while
			 
	}
}

function addBrand(){			//brand.php modal adding new brand to db
	 $bid=$_POST['bid'];
	 $brand=$_POST['bname'];
	 $bstat=$_POST['bstat'];
	
	$brand_pat='/[a-zA-Z]+/';
	if($brand==''|| !preg_match($brand_pat,$brand)){
		echo('1_Please enter a valid Brand Name');
	}
	else{
		$sql="INSERT INTO tbl_brand(brand_id,brand_name,brand_stat) VALUES('$bid','$brand','$bstat');";
		$res=mysqli_query($GLOBALS['conn'],$sql) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
			 if($res>0){
				echo('3_Successfuly data saved');	
			}
			else{
				echo('2_Something wrong with data entry');	
			}
		}	
}

function FeatrByCate(){	// feature items on dropdown product.php
	$catid=$_GET['cid'];
	print_r($catid);
	$sql="SELECT cat_feature_id,cat_feature FROM tbl_cat_feature WHERE cat_id='$catid' AND feature_stat=1;";
	$res=mysqli_query($GLOBALS['conn'],$sql) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
	if(mysqli_num_rows($res)>0){
		echo '<option value="">--Select Feature--</option>';
		 while($row=mysqli_fetch_assoc($res)){
			$featureid=$row['cat_feature_id'];
			$featurename=$row['cat_feature'];
            echo '<option value="'.$featureid.'">'.$featurename.'</option>';  
          }//end while	 
	}
}

function GetFeature(){ // get the feature to the input box by selecting from the dropdown list
	$fid=$_GET['featrid'];
	$sql="SELECT cat_feature FROM tbl_cat_feature WHERE cat_feature_id=$fid AND feature_stat=1;";
	$result = mysqli_query($GLOBALS['conn'],$sql) or die("SQL Error : ".mysqli_error($GLOBALS['conn']));
	if($row=mysqli_num_rows($result)>0){
		 $rec = mysqli_fetch_array($result);
		  echo($rec[0]);
	}	
}


function addPrds(){ //send products details in product.php?action=add by submit button click to db
	 $pid=$_POST['txtprdid'];
	 $pname=trim($_POST['txtprdname']);
	 $cat=$_POST['cmbcat'];
	 $brand=$_POST['cmbbrand'];
	 $reorderlvl=$_POST['txtreorderlvl'];  
	 $stat=$_POST['optstat']; 
	 $fname = $_FILES["prdimage"]["name"];
	 $ftname = $_FILES["prdimage"]["tmp_name"];
	 $ftype=$_FILES["prdimage"]["type"];
	 $fsize=$_FILES["prdimage"]["size"];
	 $ext = substr($fname,strrpos($fname,"."));
	 $img = $pid."_".time().$ext;
	 $path = "../images/products/".$img;
	 $pname_pat='/^[a-zA-Z\s0-9]+$/';
	 $reorderlvl_pat='/^[0-9]+$/';
	 if($pname==''|| !preg_match($pname_pat,$pname)){
		echo '2|Please enter a valid Product Name';
	 }
	 elseif($cat==''){
		echo '3|Please select a Product Category';
	 }
	 elseif($brand==''){
		echo '4|Please select a Product Brand';
	 }
	 elseif($ftname == ''){
		echo "5|Please add the Product Image";
		
	 }
	 elseif ($fsize > 10000000) {
		echo "6|Sorry, your image is too large";	
	 }
	 elseif($ftype != "image/jpeg"){
		echo "7|Sorry, only JPG, JPEG images are allowed";
	 }
	 elseif (file_exists($path)) {
		echo "8|Sorry, image already exists";	
	 }
	 elseif($reorderlvl==''|| !preg_match($reorderlvl_pat,$reorderlvl)){
		echo '9|Please enter a valid Number';
	 }
	 else{
	    move_uploaded_file($ftname,$path);	
	    $sql1="INSERT INTO tbl_products(prd_id,prd_name,cat_id,brand_id,prd_img_path,prd_reorder_lvl,prd_stat) VALUES('$pid','$pname','$cat','$brand','$img','$reorderlvl','$stat');";	
	  $res1 = mysqli_query($GLOBALS['conn'],$sql1) or die("SQL Error : ".mysqli_error($GLOBALS['conn']));
	  echo "1|success";
	 }
} 

function addfeatures(){ //send feature details in product.php?action=add by submit button click to db
	$pid=$_POST['pid'];
	$farr=$_POST['farr'];
		foreach($farr as $arr1){
			$ptype = $arr1[0];
			$pdata = $arr1[1];
			$sql2="INSERT INTO tbl_prd_info(prd_id,pi_type,pi_data,pi_stat) VALUES('$pid','$ptype','$pdata','1');";
			$res2 = mysqli_query($GLOBALS['conn'],$sql2) or die("SQL Error : ".mysqli_error($GLOBALS['conn']));
				
		}
		if( $res2>0){
				$resp ='+94775059818';
				$msg ='Dear Customer,Experience Our new Product '.$pid.'If you are intrested,please contact us.';
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
				if($smsg=='success'){
				echo "1|Record has been Successfully Saved";
				}
		}
		else
			echo "2|Submission Error";	
}

function remvfeatr(){	//delete the product feature from tbl_prd_info when remove icon is clicked in the edit_product.php
	$pi_id=$_GET['pi_id'];
	$sql="DELETE FROM tbl_prd_info WHERE pi_id='$pi_id';";
	$res=mysqli_query($GLOBALS['conn'],$sql) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
	if($res>0)
		echo "1";	
	
	else
		echo "0";
}

function updateprds(){ //update the products into db of edit_product.php
	$pid=$_POST['txtprdid'];
	 $pname=$_POST['txtprdname'];
	 $cat=$_POST['cmbcat'];
	 $brand=$_POST['cmbbrand']; 
	 $reorderlvl=$_POST['reordrlvl']; 
	 $stat=$_POST['optstat']; 
	 $fname = $_FILES["prdimage"]["name"];
	 $ftname = $_FILES["prdimage"]["tmp_name"];
	 $ftype=$_FILES["prdimage"]["type"];
	 $fsize=$_FILES["prdimage"]["size"];
	 
	 
	 $ext = substr($fname,strrpos($fname,"."));
	 $img = $pid."_".time().$ext;
	 $path = "../images/products/".$img;
	 
	 $pname_pat='/^[a-zA-Z ]+$/';
	 $reorderlvl_pat='/^[1-9]+$/';
	 if($pname==''|| !preg_match($pname_pat,$pname)){
		echo '2_Please enter a valid Product Name';
	 }
	 elseif($cat==''){
		echo '3_Please select a Product Category';
	 }
	 elseif($brand==''){
		echo '4_Please select a Product Brand';
	 }
	 elseif($ftname != ''){ 
		if ($fsize > 10000000) {
			echo "6_Sorry, your file is too large.";	
	 	}
	 	elseif($ftype != "image/jpeg"){
			echo "7_Sorry, only JPG, JPEG files are allowed.";
	 	}
	 	elseif (file_exists($path)) {
			echo "8_Sorry, file already exists.";	
	 	}
		elseif($reorderlvl==''|| !preg_match($reorderlvl_pat,$reorderlvl)){
			echo '9|Please enter a valid Number';
	 	}
		else{
	   		move_uploaded_file($ftname,$path);	
	    	$sql1="UPDATE tbl_products SET prd_name='$pname',cat_id='$cat',brand_id='$brand',prd_img_path='$img',prd_stat='$stat' WHERE prd_id='$pid';";	
	  		$res1 = mysqli_query($GLOBALS['conn'],$sql1) or die("SQL Error : ".mysqli_error($GLOBALS['conn']));
	  		echo "1_success";
		 }
	 }//end elseif($ftname != '')
	 
	 else{	
	    $sql1="UPDATE tbl_products SET prd_name='$pname',cat_id='$cat',brand_id='$brand',prd_stat='$stat' WHERE prd_id='$pid';";	
	  $res1 = mysqli_query($GLOBALS['conn'],$sql1) or die("SQL Error : ".mysqli_error($GLOBALS['conn']));
	  echo "1_success";
	 }

}

function updatefeatures(){ // update the values of features in edit_product.php
	$pid=$_POST['pid'];
    $farr=$_POST['farr'];
	
		foreach($farr as $arr1){
			$fid=$arr1[0];
			$ftype = $arr1[1];
			$fdata = $arr1[2];
			$fstat=$arr1[3];
			$sql2="UPDATE tbl_prd_info SET pi_type='$ftype',pi_data='$fdata',pi_stat='$fstat' WHERE prd_id='$pid' AND pi_id=$fid;";
			$res2 = mysqli_query($GLOBALS['conn'],$sql2) or die("SQL Error : ".mysqli_error($GLOBALS['conn']));	
		}
		if( $res2>0)
			echo "1_Record has been Successfully Updated";
		else
			echo "2_Submission Error";	
}

function proByCate(){ //get products in to dropdown based on category
	//$pid=$_GET['prdid'];
	$catid=$_GET['catid'];
	$sql = "SELECT prd_id,prd_name FROM tbl_products WHERE cat_id='$catid' AND prd_stat=1;";
	$result = mysqli_query($GLOBALS['conn'],$sql) or die("SQL Error : ".mysqli_error($GLOBALS['conn']));
	$nor = mysqli_num_rows($result);
	if($result>0){
		echo ("<option value=''>--Select Product--</option>");
	  while($rec = mysqli_fetch_assoc($result)){
		  $select='';
			if($prd==$rec['prd_id']){
				$select='selected="selected"';
			}
		  					   
		  echo('<option value="'.$rec['prd_id'].'" '.$select.'>'.$rec["prd_name"].'</option>');
	  }
	}
	else{
		echo ("<option value='0'>No products found.</option>");	
	}
}	

function proCate($cat,$prd){ // to get the previously selected prd which belong to the particular cat in add_batch.php
	$sql_opt="SELECT prd_id,prd_name FROM tbl_products WHERE cat_id='$cat' AND prd_stat=1;";
    $result=mysqli_query($GLOBALS['conn'],$sql_opt) or die("SQL error:".mysqli_error($GLOBALS['conn']));
	
	if(mysqli_num_rows($result)>0){
		
		 //echo '<option value="">--Select--</option>';
		 while($row=mysqli_fetch_assoc($result)){
			$prdid=$row['prd_id'];
			$prdname=$row['prd_name'];
			$select='';
			if($prd==$prdid){
				$select='selected="selected"';
			}
			
            echo '<option value="'.$prdid.'"'.$select.' >'.$prdname.'</option>';  
             }//end while
			 
			 }
	}
function deleteCatFeatr()	{ // remove previously added features in the categoryWindow.php
	$fid=$_GET['fid'];
	$sql="DELETE FROM tbl_cat_feature WHERE cat_feature_id='$fid';";
	$res=mysqli_query($GLOBALS['conn'],$sql) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
	if($res>0)
		echo "1";	
	
	else
		echo "0";
} 

function updateCatAndPfeatr(){
$cid=$_POST['cid'];
$cname=$_POST['cname'];
$stat=$_POST['stat'];
$pfarr=$_POST['pfarr'];	
$sql1="UPDATE tbl_category SET cat_name='$cname', cat_stat='$stat' WHERE cat_id='$cid'";
$res1=mysqli_query($GLOBALS['conn'],$sql1) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
if($res1>0){
	foreach($pfarr as $arr1){
			$fid=$arr1[0];
			$fname=$arr1[1];
			$sql2="UPDATE tbl_cat_feature SET cat_feature='$fname' WHERE cat_feature_id='$fid';";
			$res2 = mysqli_query($GLOBALS['conn'],$sql2) or die("SQL Error : ".mysqli_error($GLOBALS['conn']));	
			if($res2>0)
				echo('1|Success');
			else
				echo('2|Some Error Occured');	
		}
}
else
	echo('2|Some Error Occured');
}	

function updateNewFeatr(){
$cid=$_POST['cid'];
$nfarr=$_POST['nfarr'];	
foreach($nfarr as $arr1){
			$fname=$arr1[0];
			$sql2="INSERT INTO tbl_cat_feature(cat_id,cat_feature,feature_stat) VALUES('$cid','$fname',1);";
			$res2 = mysqli_query($GLOBALS['conn'],$sql2) or die("SQL Error : ".mysqli_error($GLOBALS['conn']));	
			if($res2>0)
				echo('1|Successfully Record Updated');
			else
				echo('2|Some Error Occured');	
}
}
?>