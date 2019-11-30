<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0001" && $_SESSION["employee"]["etype"]!=="J0002" && $_SESSION["employee"]["etype"]!=="J0003")){
	header("Location:../index.php");
}
include('lib/config.php'); // attach config.php
include('lib/function.php');
$meta_title = "Expense Details";
$c_page = 'expense';


//--------------------------------------------------------
$page_action = '';
$page_title='View Expense Details';
$expid='';
$expense='';
$date='';
$amnt='';
$stat='';
$frm_err_msg='';
if(isset($_GET['action'])){
	$page_action = $_GET['action'];
	if($page_action=='add'){
		$expid=getExpId();
		$page_title='Add New Expense';
		if(isset($_POST['btnsubmit']) && ($_POST['btnsubmit'] == "Submit")){
			$expid=$_POST['txtexpid'];
			$expense=$_POST['cmbexptype'];
			$date=$_POST['dtpdate'];
			$amnt=$_POST['txtamnt'];
			$stat=$_POST['optstat'];
			$amnt_pat='/^[0-9]{1,6}\.[0-9]{2}$/';
			if($exp==''){
				$frm_err_msg='Select a type of Expense';
				}
			elseif($date==''){
				$frm_err_msg='Select date of payment';
				}	
			if($amnt=='' || !preg_match($amnt_pat, $amnt) ){
				$frm_err_msg='Enter valid amount of payment';
				}	
			else{
				$sql_insert="INSERT INTO tbl_expense(exp_id,exp_type,exp_pdate,exp_amount,exp_stat) VALUES('$expid','$expense','$date','$amnt','$stat');";
				mysqli_query($GLOBALS['conn'],$sql_insert) or die("Mysql error".mysqli_error($GLOBALS['conn']));
				header('Location:'.$base_url.'expense.php?action=add&id='.$expid.'&s=1');
				mysqli_close($con);
				}	//else close
			
			}//post close
		}//add close
	elseif($page_action=='edit'){
		$page_title='Edit Expense Details';
		if(isset($_GET['id'])){
			$expid=$_GET['id'];
			$sql_all="SELECT * FROM tbl_expense WHERE exp_id='$expid';";
			$result=mysqli_query($GLOBALS['conn'],$sql_all) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
			$row=mysqli_fetch_assoc($result);
			$expense=$row['exp_type'];
			$date=$row['exp_pdate'];
			$amnt=$row['exp_amount'];
			$stat=$row['exp_stat'];
			if(isset($_POST['btnsubmit']) && ($_POST['btnsubmit'] == "Submit")){
				$expense=$_POST['cmbexptype'];
				$date=$_POST['dtpdate'];
				$amnt=$_POST['txtamnt'];
				$stat=$_POST['optstat'];
				$amnt_pat='/^[0-9]{1,6}\.[0-9]{2}$/';
				if($exp==''){
					$frm_err_msg='Select a type of Expense';
					}
				elseif($date==''){
					$frm_err_msg='Select date of payment';
					}	
				if($amnt=='' || !preg_match($amnt_pat, $amnt) ){
					$frm_err_msg='Enter valid amount of payment';
					}	
				else{
					$sql_update="UPDATE tbl_expense SET exp_type='$expense',exp_pdate='$date',exp_amount='$amnt',exp_stat='$stat' WHERE exp_id='$expid';";
					mysqli_query($GLOBALS['conn'],$sql_update) or die("Mysql error".mysqli_error($GLOBALS['conn']));
					header('Location:'.$base_url.'expense.php?&id='.$expid.'&s=1');
					}	// else close
		
			}//post close
		}	//get id close
}// edit close
elseif($page_action == ''){
		$page_title='View Expense Details';
}
elseif($page_action == 'delete' && isset($_GET['id'])){
		$jid=$_GET['id'];
		$sql_delete="DELETE FROM tbl_expense WHERE exp_id='$expid'";
		mysqli_query($GLOBALS['conn'],$sql_delete) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
		header('Location:'.$base_url.'expense.php?id='.$expid.'&ds=1');
		}

}// end action
?>


<?php include('inc-head.php');?> <!-- attach inc-head.php -->
</head>

<body onLoad="startTime();">
<?php include('inc-header.php');?> <!-- attach inc-header.php -->
	<div class="page-body container-fluid">
    	<div class="container inner">
        	<div class="page-title clearfix">
                <h1 class="pull-left"><?php echo $page_title ?></h1>
                <?php if($page_action == 'add' || $page_action == 'edit'): ?>
                <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>expense.php">View Expense Details</a></div>
                <?php elseif($page_action == ''): ?>
                <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>expense.php?action=add">Add New Expense</a></div>
                <?php endif;?>
    		</div><!-- end page-title -->
					 <?php if($page_action==''):?>
                     <div class="form_msg">
						<?php if($frm_err_msg != ''){
                            echo '<p class="bg-danger">'.$frm_err_msg.'</p>';
                        }
                     		if(isset($_GET['ds']) && $_GET['ds'] == '1'){
                            echo '<p class="bg-warning">Record has been succesfully deleted</p>';
                        }
						  	elseif(isset($_GET['s']) && $_GET['s'] == '1'){
                            echo '<p class="bg-success">Record has been succesfuly saved</p>';
                        }
						
                        ?>
                     </div>
						
                    	<div class="frmdiv col-md-6">
                            <table class="frm-tbl table table-striped table-responsive">
                                <thead>
                                	<th>Expense ID</th>
                                    <th>Expense Type</th>
                                    <th>Payment date</th>
                                    <th>Payment Amount</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                <?php $sql_select="SELECT E.exp_id,ET.exp_type,E.exp_pdate,E.exp_amount,E.exp_stat FROM tbl_expense E,tbl_expense_type ET WHERE E.exp_type=ET.exp_type_id;";
                                      $result=mysqli_query($GLOBALS['conn'],$sql_select) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
                                      while($row=mysqli_fetch_assoc($result)){
                                          
                                ?>	<tr>
                                	<td><?php echo $expid=$row['exp_id'];?></td>
                                    <td><?php echo $expense=$row['exp_type'];?></td>
                                    <td><?php echo $date=$row['exp_pdate'];?></td>
                                    <td><?php echo $amnt=$row['exp_amount'];?></td>
                                    <td><?php $stat=$row['exp_stat'];
                                        if($stat=='1'){
                                            echo "Active";
                                            }
                                        elseif($stat=='0'){
                                            echo "Inactive";
                                            }
                                    ?></td>
                                    <td>
                                <a class="glyphicon glyphicon-pencil link-edit" 
                                href="<?php echo $base_url ?>expense.php?action=edit&amp;id=<?php echo $expid ?>" 
                                title="Edit"> Edit</a>
                                    </td>
                                    <td>
                                <a class="glyphicon glyphicon-remove link-delete" 
                                onclick="confirmDelete('<?php echo $base_url.'expense.php?action=delete&amp;id='.$expid ?>');"
                                href="javascript:void(0);" title="Delete"> Delete</a>
                                    </td>
                                    </tr>
                                    <?php }// close while loop ?>
                                </tbody>
                            </table>    
                    </div><!-- end frmdiv -->
                    <?php elseif($page_action == 'add' || $page_action=='edit'):?>
           			<?php if($page_action == 'add'):?>	
                	<form class="frm form-horizontal" action="<?php echo $base_url.'expense.php?action=add'?>" name="frmexp" method="post">
                	<?php elseif($page_action=='edit'):?>
                 	<form class="frm form-horizontal" action="<?php echo $base_url.'expense.php?action=edit&id='.$_GET['id']?>" name="frmexp" method="post">
         			<?php endif?>
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
                            	<td><label for="txtexpid">Expense ID</label></td>
                                <td><input class="form-control" id="txtexpid" name="txtexpid" type="text" value="<?php echo $expid?>" readonly/></td>
                            </tr>
                            <tr>
                            	<td><label for="cmbexptype">Expense Type<em style="color:#F00">*</em></label></td>
                                <td>
                                <select class="form-control" id="cmbexptype" name="cmbexptype">
                                      <option value="">--Select--</option>
										 <?php $sql_opt="SELECT * FROM tbl_expense_type;";
                                           $result=mysqli_query($GLOBALS['conn'],$sql_opt) or die("SQL error:".mysqli_error($GLOBALS['conn']));
										   while($row=mysqli_fetch_assoc($result)){
											   $exptypeid=$row['exp_type_id'];
											   $exptype=$row['exp_type'];
											   $select='';
											   if($expense==$exptypeid){
												   $select='selected="selected"';
											   }
                                         ?>
                                      <option value="<?php echo $exptypeid?>" <?php echo $select?>><?php echo $exptype ?></option>  
                                      <?php }//end while?>
                                    </select></td>   
                            </tr>
                            <tr>
                            	<td><label for="dtpdate">Date of Payment<em style="color:#F00">*</em></label></td>
                                <td><input class="form-control datepicker" id="dtpdate" name="dtpdate"value="<?php echo $date?>"/></td>
                            </tr>
                            <tr>
                            	<td><label for="txtamnt">Amount Payed<em style="color:#F00">*</em></label></td>
                                <td><input class="form-control" id="txtamnt" name="txtamnt" type="text" value="<?php echo $amnt?>"/></td>
                            </tr>
							<tr>
                                <td><label for="optstat">Status<em style="color:#F00">*</em></label></td>
                                <td><input class="radio-inline" id="optstat" name="optstat" type="radio" value="1" <?php if($stat=='1'):?>checked='checked'<?php endif ?>checked/>Active
                                <input class="radio-inline" id="optstat" name="optstat" type="radio" value="0" <?php if($stat=='0'):?>checked='checked'<?php endif ?>/>Inactive
                                </td>
                            </tr>
                        </table>
                        </div><!-- end frmdiv -->
                        <table class=" btns tbl-horizontal col-md-3">
							<tr>
                            	<td><input class="form-control btn btn-primary" type="submit" name="btnsubmit" id="btnsubmit" value="Submit" <?php if($page_action=='edit'):?> onClick="confirmUpdate('<?php echo $base_url.'expense.php?action=edit&amp;id='.$expid ?>');" href="javascript:void(0);"<?php endif;?>/></td>
                                <td><input class="form-control btn btn-warning" type="reset"  name="btnreset" id="btnreset" value="Reset"/></td>
                            </tr>
                            
                        </table> 	
                    </form>
                    <?php endif?><!-- if($page_action ==): -->
        </div><!-- end inner -->
    </div><!-- end page-body -->
<?php include('inc-footer.php'); ?>
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