<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0002" && $_SESSION["employee"]["etype"]!=="J0003" && $_SESSION["employee"]["etype"]!=="J0001")){
header("Location:../index.php");
		}
include('../lib/config.php'); // attach config.php
include('../lib/connection.php'); // attach db connection
include('../lib/function.php');
$meta_title = "Sales Return Details";
$c_page = 'Sales';
//--------------------------------------------------------
$page_action = '';
$page_title='View Sales Return Details';
$srid='';
$rdate='';
$invid='';
$cat='';
$prdid='';
$prd='';
$qnty='';
$price='';
$qlitystat='';
$frm_err_msg='';
if(isset($_GET['action'])){
	$page_action = $_GET['action'];
	if($page_action=='add'){
		$srid=getSalesReturnId();
		$rdate=date('Y-m-d');
		$page_title='Add Sales Return';
		if(isset($_POST['btnsubmit']) && ($_POST['btnsubmit'] == "Submit")){
			$srid=$_POST['txtsalretrnid'];
			$rdate=$_POST['dtpsalretrndate'];
			$invid=$_POST['txtinvid'];
			$cat=$_POST['txtcat'];
			$prd=$_POST['txtprd'];
			$sql_prdid="SELECT prd_id FROM tbl_products WHERE prd_name='$prd';";
			$res_prdid=mysqli_query($conn,$sql_prdid) or die("MYSQL Error:".mysqli_error());
			$row_prdid=mysqli_fetch_assoc($res_prdid);
			$prdid=$row_prdid['prd_id'];
			$qnty=$_POST['txtqnty'];
			$price=$_POST['txtprice'];
			$qlitystat=$_POST['optqlitystat'];
			$invid_pat='/^\I\N\V[0-9]{6}[1-9]{1}$/';
			if($invid==''|| !preg_match($invid_pat,$invid)){
				$frm_err_msg='Please enter the  valid Invoice Number';
				$invid=='';
			}
			elseif($cat=='' || $prd=='' || $price==''){
				$frm_err_msg='Please click on Get Invoice Info';
			}
			elseif($qnty==''){
				$frm_err_msg='Please enter the quantity returned';
				}
			elseif($rdate==''){
				$frm_err_msg='Please enter the date of sales return';
				}						
			else{
				if($qlitystat=='1'){ //if quality=waste record as a sales return + insert into waste table+sms+email
					$sql1="INSERT INTO tbl_sales_return(sal_retrn_id,sal_retrn_date,inv_id,prd_id,sal_retrn_qnty,sal_retrn_prd_price,sal_retrn_qlity_stat) VALUES('$srid','$rdate','$invid','$prdid','$qnty','$price','$qlitystat');";
					$res1=mysqli_query($conn,$sql1) or die("Mysql error".mysqli_error());
					if($res1>0){//insert to waste table
						$sql2="UPDATE tbl_products SET prd_waste_qnty=prd_waste_qnty+'$qnty' WHERE prd_id='$prdid';";
						$res2=mysqli_query($conn,$sql2) or die("Mysql error".mysqli_error());
						sendNotify($invid,$prdid,$qnty,$rdate);
						header('Location:'.$base_url.'sales/sales_return.php?action=add&id='.$srid.'&s=1');
						mysqli_close($con);
					}
					
				}
				elseif($qlitystat=='2'){// quality=re-sell record as a sales return + insert into products table+sms+email
					$sql1="INSERT INTO tbl_sales_return(sal_retrn_id,sal_retrn_date,inv_id,prd_id,sal_retrn_qnty,sal_retrn_prd_price,sal_retrn_qlity_stat) VALUES('$srid','$rdate','$invid','$prdid','$qnty','$price','$qlitystat');";
					$res1=mysqli_query($conn,$sql1) or die("Mysql error".mysqli_error());
					if($res1>0){//insert to waste table
						$sql2="UPDATE tbl_products SET prd_tot_qnty=prd_tot_qnty+'$qnty' WHERE prd_id='$prdid';";
						$res2=mysqli_query($conn,$sql2) or die("Mysql error".mysqli_error());
						sendNotify($invid,$prdid,$qnty,$rdate);
						header('Location:'.$base_url.'sales/sales_return.php?action=add&id='.$srid.'&s=1');
						mysqli_close($con);
					}
				}
				elseif($qlitystat=='3'){ //quality=damaged record as a sales return + insert into purchase return table+sms+email
					$sql1="INSERT INTO tbl_sales_return(sal_retrn_id,sal_retrn_date,inv_id,prd_id,sal_retrn_qnty,sal_retrn_prd_price,sal_retrn_qlity_stat) VALUES('$srid','$rdate','$invid','$prdid','$qnty','$price','$qlitystat');";
					$res1=mysqli_query($conn,$sql1) or die("Mysql error".mysqli_error());
					if($res1>0){//insert to waste table
						$sql="SELECT sup_id FROM tbl_batch WHERE prd_id='$prdid';";
						$res=mysqli_query($conn,$sql) or die("Mysql error".mysqli_error());
						$row=mysqli_fetch_assoc($res);
						$sup=$row['sup_id'];
						$sql2="INSERT INTO tbl_purchase_return(pur_retrn_id,prd_id,pur_retrn_qnty,sup_id,date_added,pur_retrn_stat) VALUES('$srid','$prdid','$qnty','$sup','$rdate',0);";
						$res2=mysqli_query($conn,$sql2) or die("Mysql error".mysqli_error());
						sendNotify($invid,$prdid,$qnty,$rdate);
						header('Location:'.$base_url.'sales/sales_return.php?action=add&id='.$srid.'&s=1');
						mysqli_close($con);
					}
				}
			}//else close
			
			}//post close
		}//add close
	elseif($page_action=='edit'){
		$page_title='Edit Sales Return Details';
		if(isset($_GET['id'])){
			$srid=$_GET['id'];
			$sql_all="SELECT * FROM tbl_sales_return S,tbl_products P,tbl_category C WHERE sal_retrn_id='$srid' AND S.prd_id=P.prd_id AND P.cat_id=C.cat_id;";
			$result=mysqli_query($conn,$sql_all) or die("MYSQL Error:".mysqli_error());
			$row=mysqli_fetch_assoc($result);
			$rdate=date($row['sal_retrn_date']);
			$invid=$row['inv_id'];
			$cat=$row['cat_name'];
			$prd=$row['prd_name'];
			$qnty=$row['sal_retrn_qnty'];
			$price=$row['sal_retrn_prd_price'];
			$qlitystat=$row['sal_retrn_qlity_stat'];
			if(isset($_POST['btnsubmit']) && ($_POST['btnsubmit'] == "Submit")){
				$asrid=$_POST['txtsalretrnid'];
				$ardate=$_POST['dtpsalretrndate'];
				$ainvid=$_POST['txtinvid'];
				$acat=$_POST['txtcat'];
				$aprd=$_POST['txtprd'];
				$sql_prdid="SELECT prd_id FROM tbl_products WHERE prd_name='$prd';";
				$res_prdid=mysqli_query($conn,$sql_prdid) or die("MYSQL Error:".mysqli_error());
				$row_prdid=mysqli_fetch_assoc($res_prdid);
				$aprdid=$row_prdid['prd_id'];
				$aqnty=$_POST['txtqnty'];
				$aprice=$_POST['txtprice'];
				$aqlitystat=$_POST['optqlitystat'];
				$ainvid_pat='/^\I\N\V[0-9]{6}[1-9]{1}$/';
				if($invid==''|| !preg_match($invid_pat,$invid)){
					$frm_err_msg='Please enter the  valid Invoice Number';
					$invid=='';
				}
				elseif($cat=='' || $prd=='' || $price==''){
					$frm_err_msg='Please click on Get Invoice Info';
				}
				elseif($qnty==''){
					$frm_err_msg='Please enter the quantity returned';
					}
				elseif($rdate==''){
					$frm_err_msg='Please enter the date of sales return';
					}	
					else{
						if($aqlitystat=='1'){ //if after quality=waste record as a sales return
							if($qlitystat=='1'){ //if before quality=waste update sales return and update prd_waste_qnty
								$sql_update="UPDATE tbl_sales_return SET sal_retrn_date='$ardate',inv_id='$ainvid',prd_id='$aprdid',sal_retrn_qnty='$aqnty',sal_retrn_prd_price='$aprice',sal_retrn_qlity_stat='$aqlitystat' WHERE sal_retrn_id='$asrid';";
								$res=mysqli_query($conn,$sql_update) or die("Mysql error".mysqli_error());
								if($res>0){
									$sql2="UPDATE tbl_products SET prd_waste_qnty=prd_waste_qnty-'$qnty'+'$aqnty' WHERE prd_id='$prdid';";
									$res2=mysqli_query($conn,$sql2) or die("Mysql error".mysqli_error());
									header('Location:'.$base_url.'sales/sales_return.php?id='.$srid.'&s=1');
									mysqli_close($con);
								}
							}
							elseif($qlitystat=='2'){//if before quality=resell update sales return and update prd_waste_qnty and prd_tot_qnty
								$sql_update="UPDATE tbl_sales_return SET sal_retrn_date='$ardate',inv_id='$ainvid',prd_id='$aprdid',sal_retrn_qnty='$aqnty',sal_retrn_prd_price='$aprice',sal_retrn_qlity_stat='$aqlitystat' WHERE sal_retrn_id='$asrid';";
								$res=mysqli_query($conn,$sql_update) or die("Mysql error".mysqli_error());
									if($res>0){
										$sql2="UPDATE tbl_products SET prd_waste_qnty=prd_waste_qnty-'$qnty' WHERE prd_id='$prdid';";
										$res2=mysqli_query($conn,$sql2) or die("Mysql error".mysqli_error());
										if($res2>0){
											$sql3="UPDATE tbl_products SET prd_tot_qnty=prd_tot_qnty+'$aqnty' WHERE prd_id='$prdid';";	
											mysqli_query($conn,$sql3) or die("Mysql error".mysqli_error());
											header('Location:'.$base_url.'sales/sales_return.php?&id='.$srid.'&s=1');
										}
									}
							}
							elseif($qlitystat=='3'){//if before quality=pur_retrn update sales return and update prd_waste_qnty and insert pur_return record
							$sql_update="UPDATE tbl_sales_return SET sal_retrn_date='$ardate',inv_id='$ainvid',prd_id='$aprdid',sal_retrn_qnty='$aqnty',sal_retrn_prd_price='$aprice',sal_retrn_qlity_stat='$aqlitystat' WHERE sal_retrn_id='$asrid';";
								$res=mysqli_query($conn,$sql_update) or die("Mysql error".mysqli_error());
									if($res>0){
										$sql2="UPDATE tbl_products SET prd_waste_qnty=prd_waste_qnty-'$qnty' WHERE prd_id='$prdid';";
										$res2=mysqli_query($conn,$sql2) or die("Mysql error".mysqli_error());
										if($res2>0){
											$sql3="INSERT INTO tbl_purchase_return(pur_retrn_id,prd_id,pur_retrn_qnty,date_added,pur_retrn_stat) VALUES('$asrid','$aprdid','$aqnty','$ardate',0);";
											mysqli_query($conn,$sql3) or die("Mysql error".mysqli_error());
											header('Location:'.$base_url.'sales/sales_return.php?&id='.$srid.'&s=1');	
										}
									}
							}
						}
						elseif($aqlitystat=='2'){// quality=re-sell record as a sales return
							if($qlitystat=='1'){//before quality=waste update prd_waste_qnty and prd_tot_qnty 
								$sql_update="UPDATE tbl_sales_return SET sal_retrn_date='$ardate',inv_id='$ainvid',prd_id='$aprdid',sal_retrn_qnty='$aqnty',sal_retrn_prd_price='$aprice',sal_retrn_qlity_stat='$aqlitystat' WHERE sal_retrn_id='$asrid';";
								$res=mysqli_query($conn,$sql_update) or die("Mysql error".mysqli_error());
									if($res>0){
										$sql2="UPDATE tbl_products SET prd_waste_qnty=prd_waste_qnty-'$qnty' WHERE prd_id='$prdid';";
										$res2=mysqli_query($conn,$sql2) or die("Mysql error".mysqli_error());
										if($res2>0){
											$sql3="UPDATE tbl_products SET prd_tot_qnty=prd_tot_qnty+'$aqnty' WHERE prd_id='$prdid';";	
											mysqli_query($conn,$sql3) or die("Mysql error".mysqli_error());
											header('Location:'.$base_url.'sales/sales_return.php?&id='.$srid.'&s=1');
										}
									}
							}
							elseif($qlitystat=='2'){//before quality=resell update prd_tot_qnty
								$sql_update="UPDATE tbl_sales_return SET sal_retrn_date='$ardate',inv_id='$ainvid',prd_id='$aprdid',sal_retrn_qnty='$aqnty',sal_retrn_prd_price='$aprice',sal_retrn_qlity_stat='$aqlitystat' WHERE sal_retrn_id='$asrid';";
								$res=mysqli_query($conn,$sql_update) or die("Mysql error".mysqli_error());
									if($res>0){
										$sql2="UPDATE tbl_products SET prd_tot_qnty=prd_tot_qnty-'$qnty'+'$aqnty' WHERE prd_id='$prdid';";	
										mysqli_query($conn,$sql2) or die("Mysql error".mysqli_error());
										header('Location:'.$base_url.'sales/sales_return.php?&id='.$srid.'&s=1');
									}
							}
							elseif($qlitystat=='3'){//before quality=damaged update prd_tot_qnty and delete purchretrn
								$sql_update="UPDATE tbl_sales_return SET sal_retrn_date='$ardate',inv_id='$ainvid',prd_id='$aprdid',sal_retrn_qnty='$aqnty',sal_retrn_prd_price='a$price',sal_retrn_qlity_stat='$aqlitystat' WHERE sal_retrn_id='$asrid';";
								$res=mysqli_query($conn,$sql_update) or die("Mysql error".mysqli_error());
									if($res>0){
										$sql2="UPDATE tbl_products SET prd_tot_qnty=prd_tot_qnty-'$qnty'+'$aqnty' WHERE prd_id='$prdid';";	
										$res2=mysqli_query($conn,$sql2) or die("Mysql error".mysqli_error());
										if($res2>0){
											$sql3="DELETE FROM tbl_purchase_return WHERE pur_retrn_id='$asrid';";
											mysqli_query($conn,$sql3) or die("Mysql error".mysqli_error());
											header('Location:'.$base_url.'sales/sales_return.php?&id='.$srid.'&s=1');	
										}
									}
							}
					}
					elseif($aqlitystat=='3'){ //quality=damaged record as a sales return 
						if($qlitystat=='1'){// before quality=waste update prd_waste_qnty and insert pur_retrn 
							$sql_update="UPDATE tbl_sales_return SET sal_retrn_date='$ardate',inv_id='$ainvid',prd_id='$aprdid',sal_retrn_qnty='$aqnty',sal_retrn_prd_price='$aprice',sal_retrn_qlity_stat='$aqlitystat' WHERE sal_retrn_id='$asrid';";
								$res=mysqli_query($conn,$sql_update) or die("Mysql error".mysqli_error());
									if($res>0){
										$sql2="UPDATE tbl_products SET prd_waste_qnty=prd_waste_qnty-'$qnty' WHERE prd_id='$prdid';";	
										$res2=mysqli_query($conn,$sql2) or die("Mysql error".mysqli_error());
										if($res2>0){
											$sql3="INSERT INTO tbl_purchase_return(pur_retrn_id,prd_id,pur_retrn_qnty,date_added,pur_retrn_stat) VALUES('$asrid','$aprdid','$aqnty','$ardate',0);";
											mysqli_query($conn,$sql3) or die("Mysql error".mysqli_error());
											header('Location:'.$base_url.'sales/sales_return.php?&id='.$srid.'&s=1');	
										}
									}
						}
						elseif($qlitystat=='2'){// before quality=resell update prd_tot_qnty and insert pur_retrn
							$sql_update="UPDATE tbl_sales_return SET sal_retrn_date='$ardate',inv_id='$ainvid',prd_id='$aprdid',sal_retrn_qnty='$aqnty',sal_retrn_prd_price='$aprice',sal_retrn_qlity_stat='$aqlitystat' WHERE sal_retrn_id='$asrid';";
								$res=mysqli_query($conn,$sql_update) or die("Mysql error".mysqli_error());
									if($res>0){
										$sql2="UPDATE tbl_products SET prd_tot_qnty=prd_tot_qnty-'$qnty' WHERE prd_id='$prdid';";	
										$res2=mysqli_query($conn,$sql2) or die("Mysql error".mysqli_error());
										if($res2>0){
											$sql3="INSERT INTO tbl_purchase_return(pur_retrn_id,prd_id,pur_retrn_qnty,date_added,pur_retrn_stat) VALUES('$asrid','$aprdid','$aqnty','$ardate',0);";
											mysqli_query($conn,$sql3) or die("Mysql error".mysqli_error());
											header('Location:'.$base_url.'sales/sales_return.php?&id='.$srid.'&s=1');	
										}
									}
						}
						elseif($qlitystat=='3'){//before quality=damaged update pur_retrn
							$sql_update="UPDATE tbl_sales_return SET sal_retrn_date='$ardate',inv_id='$ainvid',prd_id='$aprdid',sal_retrn_qnty='$aqnty',sal_retrn_prd_price='$aprice',sal_retrn_qlity_stat='$aqlitystat' WHERE sal_retrn_id='$asrid';";
								$res=mysqli_query($conn,$sql_update) or die("Mysql error".mysqli_error());
									if($res>0){
										$sql2="UPDATE tbl_purchase_return SET prd_id='$aprdid',pur_retrn_qnty='$aqnty',date_added='$ardate',pur_retrn_stat=0 WHERE pur_retrn_id='$asrid';";
										mysqli_query($conn,$sql2) or die("Mysql error".mysqli_error());
										header('Location:'.$base_url.'sales/sales_return.php?&id='.$srid.'&s=1');
									}
						}
					}
						}	// else close
		
			}//post close
		}	//get id close
}// edit close
elseif($page_action == ' '){
		$page_title='View Sales Return Details';
}
elseif($page_action == 'delete' && isset($_GET['id'])){
		$srid=$_GET['id'];
		$sql_delete="DELETE FROM tbl_sales_return WHERE sal_retrn_id='$srid';";
		mysqli_query($conn,$sql_delete) or die("SQL Error:".mysqli_error());
		header('Location:'.$base_url.'sales/sales_return.php?id='.$srid.'&ds=1');
		}

}// end action
?>


<?php include('../inc-head.php');?> <!-- attach inc-head.php -->
</head>

<body onLoad="startTime();">
<?php include('../inc-header.php');?> <!-- attach inc-header.php -->
	<div class="page-body container-fluid">
    	<div class="container inner">
        	<div class="page-title clearfix">
                <h1 class="pull-left"><?php echo $page_title ?></h1>
                <?php if($page_action == 'add' || $page_action == 'edit'): ?>
                <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>sales/sales_return.php">View Sales Return Details</a></div>
                <?php elseif($page_action == '' && $_SESSION["employee"]["etype"]=="J0001"): ?>
                <div class="page-top-action pull-right" style="display:none"><a class="btn btn-primary" href="<?php echo $base_url?>sales/sales_return.php?action=add">Add Sales Return</a></div>
                <?php elseif($page_action == '' && ($_SESSION["employee"]["etype"]=="J0002" || $_SESSION["employee"]["etype"]=="J0003" )): ?>
                <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>sales/sales_return.php?action=add">Add Sales Return</a></div>
                <?php endif;?>
    		</div><!-- end page-title -->
					 <?php if($page_action==''):?>
                     <div class="form_msg">
						<?php if($frm_err_msg != ''){
                            echo '<p class="alert alert-danger">'.$frm_err_msg.'</p>';
                        }
                     		if(isset($_GET['ds']) && $_GET['ds'] == '1'){
                            echo '<p class="alert alert-warning">Record has been succesfully deleted</p>';
                        }
						  	elseif(isset($_GET['s']) && $_GET['s'] == '1'){
                            echo '<p class="alert alert-success">Record has been succesfuly saved</p>';
                        }
						
                        ?>
                     </div>
						
                    	<div class="frmdiv">
                            <table class="frm-tbl table table-striped table-responsive">
                                <thead>
                                	<th>Sales Return ID</th>
                                    <th>Date Returned</th>
                                    <th>Invoice ID</th>
                                    <th>Product Name</th>
                                    <th>Quantity Returned</th>
                                    <th>Product price</th>
                                    <th>Product Quality Status</th>
                                </thead>
                                <tbody>
                                <?php $sql_select="SELECT S.sal_retrn_id,S.sal_retrn_date,S.inv_id,P.prd_name,S.sal_retrn_qnty,S.sal_retrn_prd_price,S.sal_retrn_qlity_stat FROM tbl_sales_return S,tbl_products P WHERE S.prd_id=P.prd_id;";
                                      $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error());
                                      while($row=mysqli_fetch_assoc($result)){
                                          
                                ?>	<tr>
                                	<td><?php echo $srid=$row['sal_retrn_id'];?></td>
                                    <td><?php echo $rdate=$row['sal_retrn_date'];?></td>
                                    <td><?php echo $invid=$row['inv_id'];?></td>
                                    <td><?php echo $prd=$row['prd_name'];?></td>
                                    <td><?php echo $qnty=$row['sal_retrn_qnty'];?></td>
                                    <td><?php echo $price=$row['sal_retrn_prd_price'];?></td>
                                    <td><?php $qlitystat=$row['sal_retrn_qlity_stat'];
                                        if($qlitystat=='1'){
                                            echo "Waste";
                                            }
                                        elseif($qlitystat=='2'){
                                            echo "Re-sell";
                                            }
										elseif($qlitystat=='3'){
                                            echo "Damaged";
                                            }	
                                    ?></td>
                                    <td>
                                <a class="glyphicon glyphicon-pencil link-edit" 
                                href="<?php echo $base_url ?>sales/sales_return.php?action=edit&amp;id=<?php echo $srid ?>" 
                                title="Edit"> Edit</a>
                                    </td>
                                    <td>
                                <a class="glyphicon glyphicon-remove link-delete" 
                                onclick="confirmDelete('<?php echo $base_url.'sales/sales_return.php?action=delete&amp;id='.$srid ?>');"
                                href="javascript:void(0);" title="Delete"> Delete</a>
                                    </td>
                                    </tr>
                                    <?php }// close while loop ?>
                                </tbody>
                            </table>    
                    </div><!-- end frmdiv -->
                    <?php elseif($page_action == 'add' || $page_action=='edit'):?>
           			<?php if($page_action == 'add'):?>	
                	<form class="frm form-horizontal" action="<?php echo $base_url.'sales/sales_return.php?action=add'?>" name="frmsalretrn" method="post">
                	<?php elseif($page_action=='edit'):?>
                 	<form class="frm form-horizontal" action="<?php echo $base_url.'sales/sales_return.php?action=edit&id='.$_GET['id']?>" name="frmsalretrn" method="post">
         			<?php endif?>
                    <div class="form_msg">
						<?php if($frm_err_msg != ''){
                            echo '<p class="alert alert-danger">'.$frm_err_msg.'</p>';
                        }
                        if(isset($_GET['s']) && $_GET['s'] == '1'){
                            echo '<p class="alert alert-success">Record has been succesfuly saved</p>';
                        }
						
                        ?>
                    </div>
                    	<div class="frmdiv">
                		<table class="frm-tbl table table-responsive">
                        <tr>
                        
                        <td><span style="color:#00f;font-size:smaller;">Please Enter the Invoice Number to get the Invoice details</span></td>
                      
                        <td><label for="txtinvid">Invoice ID<em style="color:#F00">*</em></label></td>
                        <td><input class="form-control" id="txtinvid" name="txtinvid" type="text" value="<?php echo $invid?>"/></td>
                        <td><input type="button" class="btn btn-primary" id="getinvinfo" name="getinvinfo" value="Get Invoice Info"/></td>
                        </tr>
                         <tr>
                            	<td><label for="txtsalretrnid">Sales Return ID</label></td>
                                <td><input class="form-control" id="txtsalretrnid" name="txtsalretrnid" type="text" value="<?php echo $srid?>" readonly/></td>
                         </tr>  
                             <tr>
                                <script type="text/javascript">
									$("#getinvinfo").click(function(){
									var invid = $("#txtinvid").val();
									//alert(invid);
										if(invid!=""){
											var url = "../lib/sales_func.php?type=getinvinfo";
											$.get(url,{invid:invid},function(data,status){
												if(status=="success"){
													var arr = data.split("|");
													var cat=arr[0];
													var prd=arr[1];
													var uprice=arr[2];
													$("#txtcat").val(cat);
													$("#txtprd").val(prd);
													$("#txtprice").val(uprice);
												}
											});
										}
									});
            					</script>
                                <td><label for="txtcat">Category</label></td>
                                <td><input class="form-control" id="txtcat" name="txtcat" type="text" value="<?php echo $cat?>" readonly/></td>   
                                <td><label for="txtprd">Product</label></td>
                                <td>  
                                	<input class="form-control" id="txtprd" name="txtprd" type="text" value="<?php echo $prd?>" readonly/>
                                </td>
                              </tr>
                              <tr>
                            	<td><label for="txtprice">Product Price <span style="color:#00f;font-size:x-small;">(Rs)</span></label></td>
                                <td><input class="form-control" id="txtprice" name="txtprice" type="text" value="<?php echo $price?>" readonly/></td>
                            </tr>
                               <tr>
                            	<td><label for="txtqnty">Quantity Returned<em style="color:#F00">*</em></label></td>
                                <td><input class="form-control" id="txtqnty" name="txtqnty" type="text" value="<?php echo $qnty?>"/></td>
                            </tr>
                             
                             <tr>
                            	<td><label for="dtpsalretrndate">Date of Return<em style="color:#F00">*</em></label></td>
                                <td><input type="text" class="form-control datepicker" id="dtpsalretrndate" name="dtpsalretrndate"  value="<?php echo $rdate ?>"/></td>
                            </tr>
							<tr>
                                <td><label for="optstat">Product Quality Status<em style="color:#F00">*</em></label></td>
                                <td>
                                <input class="radio-inline" id="optqlitystat" name="optqlitystat" type="radio" value="1"<?php if($qlitystat=='1'):?>checked='checked' <?php endif?> checked/>Waste
                                <input class="radio-inline" id="optqlitystat" name="optqlitystat" type="radio" value="2"<?php if($qlitystat=='2'):?>checked='checked'<?php endif?>/>Re-sell
                                <input class="radio-inline" id="optqlitystat" name="optqlitystat" type="radio" value="3"<?php if($qlitystat=='3'):?>checked='checked'<?php endif?>/>Damaged
                                </td>
                            </tr>
                        </table>
                        </div><!-- end frmdiv -->
                        <table class=" btns tbl-horizontal col-md-3">
							<tr>
                            	<td><input class="form-control btn btn-primary" type="submit" name="btnsubmit" id="btnsubmit" value="Submit"/></td>
                                <td><input class="form-control btn btn-warning" type="reset"  name="btnreset" id="btnreset" value="Reset"/></td>
                            </tr>
                            
                        </table> 	
                    </form>
                    <?php endif?><!-- if($page_action ==): -->
        </div><!-- end inner -->
    </div><!-- end page-body -->
<?php include('../inc-footer.php'); ?>
</body>
</html>
<script type="text/javascript">
$( ".datepicker" ).datepicker({
		//showOn: "button",
        //buttonImage: "../images/calendarIcon.gif",
       // buttonImageOnly: true,
		dateFormat: 'yy-mm-dd',
		maxDate: new Date() 
		});
</script>