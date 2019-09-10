<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0001" && $_SESSION["employee"]["etype"]!=="J0002")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
include('../lib/connection.php'); // attach db connection
include('../lib/function.php');
$meta_title = "Purchases Return Details";
$c_page = 'purchases';
//--------------------------------------------------------
$page_action = '';
$page_title='View purchases Return Details';
$frm_err_msg='';

if(isset($_GET['action'])){
	$page_action=$_GET['action'];
	if($page_action=='edit'){
		$page_title='Edit Purchase Return Status';	
		if(isset($_GET['id'])){
			$prid=$_GET['id'];
			$sql_all="SELECT R.pur_retrn_id,P.prd_name,R.pur_retrn_qnty,S.sup_fname,S.sup_lname,R.pur_retrn_stat FROM tbl_purchase_return R,tbl_supplier S,tbl_products P,tbl_batch B WHERE R.prd_id=P.prd_id AND P.prd_id=B.prd_id AND B.sup_id=S.sup_id AND pur_retrn_id='$prid';";
			$result=mysqli_query($conn,$sql_all) or die("MYSQL Error:".mysqli_error());
			$row=mysqli_fetch_assoc($result);
			$pname=$row['prd_name'];
			$qnty=$row['pur_retrn_qnty'];
			$supfname=$row['sup_fname'];
			$suplname=$row['sup_lname'];
			$stat=$row['pur_retrn_stat'];
			if(isset($_POST['btnsubmit']) && ($_POST['btnsubmit'] == "Submit")){
				$stat=$_POST['optstat'];
				$sql_update="UPDATE tbl_purchase_return SET pur_retrn_stat='$stat' WHERE pur_retrn_id='$prid';";
					mysqli_query($conn,$sql_update) or die("Mysql error".mysqli_error());
					header('Location:'.$base_url.'purchases/pur_return.php?id='.$prid.'&s=1');	
			}
		}//isset id
	}//edit action
	
}
?>
<?php include('../inc-head.php');?> <!-- attach inc-head.php -->
</head>

<body onLoad="startTime();">
<?php include('../inc-header.php');?> <!-- attach inc-header.php -->
<div class="page-body container-fluid">
    	<div class="container inner">
        	<div class="page-title clearfix">
                <h1 class="pull-left"><?php echo $page_title ?></h1>
                 <?php if($page_action == 'edit'): ?>
                <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>purchases/pur_return.php">View Purchase Return Details</a></div>
                <?php endif;?>
    		</div><!-- end page-title -->
            <?php if($page_action == ''): ?>
             <div class="form_msg">
						<?php if($frm_err_msg != ''){
                            echo '<p class="bg-danger">'.$frm_err_msg.'</p>';
                        }
                        if(isset($_GET['s']) && $_GET['s'] == "1"){
                            echo '<p class="bg-success">Record has been succesfully saved</p>';
                        }
						elseif(isset($_GET['ds']) && $_GET['ds'] == '1'){
                            echo '<p class="bg-warning">Record has been succesfully deleted</p>';
                        }
                        ?>
                    </div>
                    <div class="frmdiv">
                    <table class="frm-tbl table table-responsive">
                        <thead>
                        	<th>Purchase Return ID</th>
                            <th>Product Name</th>
                            <th>Returning Quantity</th>
                            <th>Date Added</th>
                            <th>Supplier Name</th>
                            <th>Return status</th>
                            <th></th>
                        </thead>
                        <tbody>
                        <?php $sql_select="SELECT R.pur_retrn_id,P.prd_name,R.pur_retrn_qnty,S.sup_fname,S.sup_lname,R.date_added,R.pur_retrn_stat FROM tbl_purchase_return R,tbl_supplier S,tbl_products P,tbl_batch B WHERE R.prd_id=P.prd_id AND P.prd_id=B.prd_id AND B.sup_id=S.sup_id ;";
							  $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error());
							  while($row=mysqli_fetch_assoc($result)){
								  
						?>	<tr>
                        	<td><?php echo $prid=$row['pur_retrn_id'];?></td>
                        	<td><?php echo $pname=$row['prd_name'];?></td>
                            <td><?php echo $qnty=$row['pur_retrn_qnty'];?></td>
                            <td><?php echo $date=$row['date_added'];?></td>
                            <td><?php echo $supfname=$row['sup_fname'];?> <?php echo $suplname=$row['sup_lname'];?></td>
                            <td><?php $stat=$row['pur_retrn_stat'];?>
                            <?php if($stat=='1')
									$stat='Returned';
								  elseif($stat=='0')
								  $stat='Not Returned';
								  echo $stat;
							?>
                            
							</td>
                            <td>
                        <a class="glyphicon glyphicon-download-alt" href="<?php echo $base_url ?>purchases/pur_return.php?action=edit&id=<?php echo $prid ?>" id="<?php echo $prid?>" title="Update">UpdateStatus</a>
                        	</td>
                            <td>
                        	</td>
                            </tr>
                            <?php }// close while loop ?>
                        </tbody>
                    </table>    
                    </div><!-- end frmdiv -->
                	<?php elseif($page_action=='edit'):?>
                 	<form class="frm form-horizontal" action="<?php echo $base_url.'purchases/pur_return.php?action=edit&id='.$_GET['id']?>" name="frmexp" method="post">
                    <div class="form_msg">
						<?php if($frm_err_msg != ''){
                            echo '<p class="bg-danger">'.$frm_err_msg.'</p>';
                        }
                        if(isset($_GET['s']) && $_GET['s'] == '1'){
                            echo '<p class="bg-success">Record has been succesfuly saved</p>';
                        }
						
                        ?>
                    </div>
                    	<div class="frmdiv">
                		<table class="frm-tbl table table-responsive">
                         <tr>
                            	<td><label for="txtprid">Purchase Return ID</label></td>
                                <td><input class="form-control" id="txtprid" name="txtprid" type="text" value="<?php echo $prid?>" readonly/></td>
                            </tr>
                            <tr>
                            	<td><label for="txtprname">Product Name</label></td>
                                <td><input class="form-control" id="txtprname" name="txtprname" type="text" value="<?php echo $pname?>" readonly/></td>   
                            </tr>
                            <tr>
                            	<td><label for="txtprqnty">Returning Quantity</label></td>
                                <td><input class="form-control" id="txtprqnty" name="txtprqnty" type="text" value="<?php echo $qnty?>" readonly/></td>   
                            </tr>
                            <tr>
                            	<td><label for="txtsup">Supplier Name</label></td>
                                <td><input class="form-control" id="txtsup" name="txtsup" type="text" value="<?php echo $supfname.' '.$suplname?>" readonly/></td>   
                            </tr>
							<tr>
                                <td><label for="optstat">Status<em style="color:#F00">*</em>&nbsp;&nbsp;<span style="color:#00f;font-size:x-small;">Please set the status if returned</span></label></td>
                                <td><input class="radio-inline" id="optstat" name="optstat" type="radio" value="1" <?php if($stat=='1'):?>checked='checked'<?php endif ?>checked/>Returned
                                <input class="radio-inline" id="optstat" name="optstat" type="radio" value="0" <?php if($stat=='0'):?>checked='checked'<?php endif ?>/>Not Returned
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
        </div><!-- end container inner -->
</div><!-- end page body container fluid -->            
<?php include('../inc-footer.php'); ?>
</body>
</html>