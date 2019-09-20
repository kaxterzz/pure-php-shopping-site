<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0001" && $_SESSION["employee"]["etype"]!=="J0002" && $_SESSION["employee"]["etype"]!=="J0003")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
include('../lib/connection.php'); // attach db connection
include('../lib/function.php');
$meta_title = "Product Brand Details"; // title on the browser tab
$c_page = 'inventory';// highligting the navbar tab based on the current page


//--------------------------------------------------------
$page_action = '';
$page_title='View Product Brand Details';
$bid=getBrandId();
$brand='';
$stat='';
$frm_err_msg='';
if(isset($_GET['action'])){
	$page_action = $_GET['action'];
	
	if($page_action=='edit'){
		$page_title='Edit Product Brand Details';
		if(isset($_GET['id'])){
			$bid=$_GET['id'];
			$sql_all="SELECT * FROM tbl_brand WHERE brand_id='$bid';";
			$result=mysqli_query($GLOBALS['conn'],$sql_all) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
			$row=mysqli_fetch_assoc($result);
			$brand=$row['brand_name'];
			$stat=$row['brand_stat'];
			if(isset($_POST['btnsubmit']) && ($_POST['btnsubmit'] == "Submit")){
				$brand=$_POST['txtbrand'];
				$stat=$_POST['optstat'];
				$brand_pat='/[a-zA-Z]+/';
				
				if($brand==''|| !preg_match($brand_pat,$brand)){
					$frm_err_msg='Please enter a valid Brand Name';
					}
				else{
					$sql_update="UPDATE tbl_brand SET brand_name='$brand',brand_stat='$stat' WHERE brand_id='$bid';";
					mysqli_query($GLOBALS['conn'],$sql_update) or die("Mysql error".mysqli_error($GLOBALS['conn']));
					header('Location:'.$base_url.'inventory/brandWindow.php?&id='.$bid.'&s=1');
					}	// else close
		
			}//post close
		}	//get id close
}// edit close
elseif($page_action == 'view'){
		$page_title='View Product Brand Details';
}
elseif($page_action == 'delete' && isset($_GET['id'])){
		$bid=$_GET['id'];
		$sql_delete="DELETE FROM tbl_brand WHERE brand_id='$bid'";
		mysqli_query($GLOBALS['conn'],$sql_delete) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
		header('Location:'.$base_url.'inventory/brandWindow.php?&ds=1');
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
        	
            <?php if( $page_action == 'edit'): /*check whether action of the url is add or edit and if so, dispaly a button says " view Brand Details" in the add or edit page*/?>
            	<h1 class="pull-left"><?php echo $page_title ?></h1><!-- Title of the page loaded according to the action on URL-->
                <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>inventory/brandWindow.php?">View Brand Details</a></div>
            <?php endif;?>
 	</div><!--end page-title -->
      
      		<?php if($page_action=='edit'):?>
               <form class="frm form-horizontal" action="<?php echo $base_url.'inventory/brandWindow.php?action=edit&id='.$_GET['id']?>" name="frmbrand" method="post">
				<div class="form_msg">
						<?php if($frm_err_msg != ''){
                            echo '<p class="bg-danger">'.$frm_err_msg.'</p>';
                        }
                        if(isset($_GET['s']) && $_GET['s'] == '1'){
                            echo '<p class="bg-success">Record has been succesfuly saved</p>';
                        }
						
                        ?>
                    </div>
              
             <div class="frmdiv clearfix">
                		<table class="frm-tbl table table-responsive">
                            <tr>
                            	<td><label for="txtbid">Brand Id</label></td>
                                <td><input class="form-control" id="txtbid" name="txtbid" type="text" value="<?php echo $bid?>" readonly/></td>
                            </tr>
                            <tr>
                            	<td><label for="txtbrand">Brand Name<em style="color:#F00">*</em></label></td>
                                <td><input class="form-control" id="txtbrand" name="txtbrand" type="text" value="<?php echo $brand?>"/></td>
                            </tr>
							<tr>
                                <td><label for="optstat">Status<em style="color:#F00">*</em></label></td>
                                <td><input class="radio-inline" id="optstat" name="optstat" type="radio" value="1" <?php if($stat=='1'):?>checked='checked'<?php endif ?>checked/>Available
                                <input class="radio-inline" id="optstat" name="optstat" type="radio" value="0" <?php if($stat=='0'):?>checked='checked'<?php endif ?>/>Unavailable
                                </td>
                            </tr>
                        </table>
                        </div><!-- end frmdiv -->  
                        
                         <table class=" btns tbl-horizontal col-md-3">
							<tr>
                            	<td><input class="form-control btn btn-primary" type="submit" name="btnsubmit" id="btnsubmit" value="Submit" <?php if($page_action=='edit'):?> onClick="confirmUpdate('<?php echo $base_url.'inventory/brandWindow.php?action=edit&amp;id='.$bid ?>');" href="javascript:void(0);"<?php endif;?>/></td>
                                <td><input class="form-control btn btn-warning" type="reset"  name="btnreset" id="btnreset" value="Reset"/></td>
                            </tr>
                            
                        </table> 	
                    </form>   
	<?php elseif( $page_action == ''): /*check whether action of the url is add or edit and if so, dispaly a button says " view Brand Details" in the add or edit page*/?>
            <div class="page-title clearfix">
            	<h1 class="pull-left">View Product Brand Details</h1><!-- Title of the page loaded according to the action on URL-->
 			</div><!--end page-title -->

      		
                     <div class="form_msg">
						<?php if($frm_err_msg != ''){						//if there is a error message assigned to the 	
                            echo '<p class="bg-danger">'.$frm_err_msg.'</p>';//variable 'frm_err_msg' then dispaly the message in 
                        }
                     		if(isset($_GET['ds']) && $_GET['ds'] == '1'){
                            echo '<p class="bg-warning">Record has been succesfully deleted</p>';
                        }
						  	elseif(isset($_GET['s']) && $_GET['s'] == '1'){
                            echo '<p class="bg-success">Record has been succesfuly saved</p>';
                        }
						
                        ?>
                     </div>
                     <div class="frmdiv">
                     <table class="frm-tbl table table-striped table-responsive">
                                <thead>
                                    <th>Brand Id</th>
                                    <th>Brand Name</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                <?php $sql_select="SELECT * FROM tbl_brand;";
                                      $result=mysqli_query($GLOBALS['conn'],$sql_select) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
                                      while($row=mysqli_fetch_assoc($result)){
                                ?>	<tr>
                                	<td><?php echo $bid=$row['brand_id'];?></td>
                                    <td><?php echo $brand=$row['brand_name'];?></td>
                                    <td><?php $stat=$row['brand_stat'];
                                        if($stat=='1'){
                                            echo "Available";
                                            }
                                        elseif($stat=='0'){
                                            echo "Unavailable";
                                            }
                                    ?></td>
                                    <td>
                                <a class="glyphicon glyphicon-pencil link-edit btnedit"data-type="" data-id="" href="<?php echo $base_url ?>inventory/brandWindow.php?action=edit&id=<?php echo $bid?>" title="Edit"></a>
                                    </td>
                                    <td>
                                <a class="glyphicon glyphicon-remove link-delete" 
                                onclick="confirmDelete('<?php echo $base_url.'inventory/brandWindow.php?action=delete&amp;id='.$bid ?>');"
                                href="javascript:void(0);" title="Delete"></a>
                                    </td>
                                    </tr>
                                    <?php }// close while loop ?>
                                </tbody>
                            </table>    
                    </div><!-- end frmdiv -->	
                    <?php endif;?>
		  </div><!-- end inner -->
    </div><!-- end page-body -->
        <?php include('../inc-footer.php'); ?>
   </body>
</html>
