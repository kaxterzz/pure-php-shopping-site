<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0001" && $_SESSION["employee"]["etype"]!=="J0002" && $_SESSION["employee"]["etype"]!=="J0003")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
include('../lib/function.php');
$meta_title = "Product Category Details"; // title on the browser tab
$c_page = 'inventory';// highligting the navbar tab based on the current page


//--------------------------------------------------------
$page_action = '';
$page_title='';
$cid='';
$cat='';
$stat='';
$frm_err_msg='';
	if(isset($_GET['action'])){
	$page_action = $_GET['action'];
	
	if($page_action=='edit'){
		$page_title='Edit Product Category Details';
		if(isset($_GET['id'])){
			$cid=$_GET['id'];
			$sql_all="SELECT * FROM tbl_category WHERE cat_id='$cid';";
			$result=mysqli_query($GLOBALS['conn'],$sql_all) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
			$row=mysqli_fetch_assoc($result);
			$cat=$row['cat_name'];
			$stat=$row['cat_stat'];
			
		}	//get id close
}// edit close
	elseif($page_action == ''){
		$page_title='View Product Category Details';
}
	elseif($page_action == 'delete' && isset($_GET['id'])){
		$cid=$_GET['id'];
		$sql_delete="DELETE FROM tbl_category WHERE cat_id='$cid'";
		mysqli_query($GLOBALS['conn'],$sql_delete) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
		header('Location:'.$base_url.'inventory/categoryWindow.php?&ds=1');
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
                <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>inventory/categoryWindow.php?">View Category Details</a></div>
            <?php endif;?>
 	</div><!--end page-title -->
      
      		<?php if($page_action=='edit'):?>
               <div class="frm form-horizontal">
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
                            	<td><label for="txtcid">Category Id</label></td>
                                <td><input class="form-control" id="txtcid" name="txtcid" type="text" value="<?php echo $cid?>" readonly/></td>
                            </tr>
                            <tr>
                            	<td><label for="txtcat">Category Name<em style="color:#F00">*</em></label></td>
                                <td><input class="form-control" id="txtcat" name="txtcat" type="text" value="<?php echo $cat?>"/></td>
                            </tr>
							<tr>
                                <td><label for="optstat">Status<em style="color:#F00">*</em></label></td>
                                <td><input class="radio-inline" id="opt1" name="optstat" type="radio" value="1" <?php if($stat=='1'):?>checked='checked'<?php endif ?>checked/>Available
                                <input class="radio-inline" id="opt2" name="optstat" type="radio" value="0" <?php if($stat=='0'):?>checked='checked'<?php endif ?>/>Unavailable
                                </td>
                            </tr>
                        </table>
                        <table class="frm-tbl-addInfo table table-responsive">
                        	<thead>
                        	<tr>
                            	<th colspan="2">Add additional Information about category by filling the table below</th>
                            </tr>
                            <tr>
                            <th><div id="msg"></div></th>
                            </tr>
                            <tr>
                            	<th>Product Feature</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="info-body">
                            <?php $sql_all2="SELECT * FROM tbl_cat_feature WHERE cat_id='$cid';";
								  $result2=mysqli_query($GLOBALS['conn'],$sql_all2) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
								  while($row2=mysqli_fetch_assoc($result2)){?>
									<tr>
                                    
                                    <td><input type='text' id='<?php echo $row2['cat_feature_id']; ?>' name='feature_name<?php echo $row2['cat_feature_id']; ?>' value="<?php echo $row2['cat_feature']; ?>" /></td>
                                    <td> <a href="#" onclick='removerow(<?php echo $row2["cat_feature_id"] ?>)';><span class='glyphicon glyphicon-remove' id='<?php echo $row2['cat_feature_id']; ?>'></span></a></td>
                                    </tr>
								<?php  }?>
                            </tbody>
                            <tbody id="info-body-2">
                            
                            </tbody>
                        </table>
                        <a href="#" title="" class="add_feature">Add another Feature</a>
                        </div><!-- end frmdiv -->  
                        
                         <table class=" btns tbl-horizontal col-md-3">
							<tr>
                            	<td>
								<a href="#" class="form-control btn btn-primary" role="button" name="btnsubmit" id="btnsubmit" href="#" <?php if($page_action=='edit'):?> onclick="addNewType(<?php $cid ?>)" <?php endif;?>>Submit</a></td>
                                <td><input class="form-control btn btn-warning" type="reset"  name="btnreset" id="btnreset" value="Reset"/></td>
                            </tr>
                            
                        </table> 	
                    </div>   
			
            <?php elseif( $page_action == ''): /*check whether action of the url is add or edit and if so, dispaly a button says " view Brand Details" in the add or edit page*/?>
            <div class="page-title clearfix">
            	<h1 class="pull-left">View Product Category Details</h1><!-- Title of the page loaded according to the action on URL-->
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
                                    <th>Category Id</th>
                                    <th>Category Name</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                <?php $sql_select="SELECT * FROM tbl_category;";
                                      $result=mysqli_query($GLOBALS['conn'],$sql_select) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
                                      while($row=mysqli_fetch_assoc($result)){
                                ?>	<tr>

                                	<td><?php echo $cid=$row['cat_id'];?></td>
                                    <td><?php echo $cat=$row['cat_name'];?></td>
                                    <td><?php $stat=$row['cat_stat'];
                                        if($stat=='1'){
                                            echo "Available";
                                            }
                                        elseif($stat=='0'){
                                            echo "Unavailable";
                                            }
                                    ?></td>
                                    <td>
                                		<a class="glyphicon glyphicon-pencil link-edit" data-type="" data-id="" href="<?php echo $base_url ?>inventory/categoryWindow.php?action=edit&amp;id=<?php echo $cid ?>" title="Edit"></a>
                                    </td>
                                    <td>
                                <a class="glyphicon glyphicon-remove link-delete" onClick="confirmDelete('<?php echo $base_url.'inventory/categoryWindow.php?action=delete&amp;id='.$cid ?>');" href="javascript:void(0);" title="Delete"></a>
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


<script type="text/javascript">
var count=1;
	$(".add_feature").click(function(){
			            
    	$("#info-body-2").append('<tr><td><input type="text" name="feature'+count+ '" id="feature'+count+'"/></td><td><span class="glyphicon glyphicon-remove" id="remove" onclick="removerow2(this);"></span></td></tr>');
		count++;
	});
	
function removerow(obj){ // removing previously added features
			console.log(obj);
			// alert(obj);
			var fid=obj;
			//alert(index);
	
			$.confirm({
				title: 'Confirmation Dialog',
				content: 'Are you sure ?',
				type: 'blue',
				typeAnimated: true,
				buttons: {
					yes: {
						isHidden: false, // hide the button
						keys: ['y'],
						action: function () {
							$.get("../lib/inv_func.php?type=remvcatfeatr",{fid:fid},function(data,status){
								console.log(data);
								console.log(status);
								if(status=='success'){
									if(data==1){
										$.alert({
											title: 'Success',
											content: 'Done !',
											type: 'green',
											typeAnimated: true,
										});
										var mytable = document.getElementById("info-body");
										mytable.deleteRow(index-3);
										$("#msg").css("display","block");
										$("#msg").html('<div class="alert alert-warning alert-dismissible">Successfully Feature deleted</p>');
									}
								}
							});
						}
					},
					no: {
						keys: ['N'],
						action: function () {
							$.alert('You clicked No.');
						}
					},
				}
			});

	
			
}
	
function removerow2(obj){ // removing newly added features
			//alert(obj);
			var index = obj.parentNode.parentNode.rowIndex;
			//alert(index);
			var mytable = document.getElementById("info-body-2");
			mytable.deleteRow(index-4);
	}

function addNewType(cid){
	console.log('in func')
	console.log(cid);
	var cid = document.getElementById('txtcid').value;
	var cname=document.getElementById('txtcat').value;
	console.log(cid);
	
	console.log(cname);
	
	if ($("#opt1").is(":checked")) {
         var catstat=$('#opt1').val();
    }
    else if($("#opt2").is(":checked")){
         var catstat=$('#opt2').val();
     }
	 var arr=new Array();
	var table=document.getElementById('info-body');
	var row_count=table.rows.length;
	
	var table2=document.getElementById('info-body-2');
	var row_count2=table2.rows.length;
	
	i=0;
	while (i<row_count){
		var fid=table.rows[i].cells[0].childNodes[0].id;
		//alert(fid);
		var feature=table.rows[i].cells[0].childNodes[0].value;
		arr[i] =Array(fid,feature);
		i++;
	}//alert(arr[0]);

	console.log(arr[0]);
	$.ajax({
		type: "POST",
		url: "../lib/inv_func.php?type=updatecatfeatr",
		data: {"cid":cid,"cname":cname,"stat":catstat,"pfarr":arr}, // fix: need to append your data to the call
		success: function (data,status) {
			console.log(data);
			console.log('status');
			console.log(status);
			
			if(status=="success"){	
			//alert(data);
			
			var arr = data.split("|");
			console.log('data');
			console.log(arr);
			
			if(arr[0]==2){
				//alert(arr[1]);
				$("#msg").css("display","block");
				$("#msg").html('<p class="bg-danger">'+arr[1]+'</p>');
							
			}
			else if(arr[0]==1){	
				console.log('inside 1');
				
				$("#msg").css("display","block");
				$("#msg").html('<p class="bg-success">Success !</p>');
				console.log(row_count2);
				
				if(row_count2!=0){
					var narr=new Array();
					i=0;
					while (i<row_count2){
						var feature=table2.rows[i].cells[0].childNodes[0].value;
						narr[i] =feature;
						i++;
					}
					$.post('../lib/inv_func.php?type=updatenewtfeatr',{cid:cid,nfarr:narr},function(data,success){
					if(status=="success"){	
					console.log(data);
					console.log(success);
					console.log('second elif');
					
					//alert(data);
						var arr = data.split("|");
						if(arr[0]==2){
							//alert(arr[1]);
							$("#msg").css("display","block");
							$("#msg").html('<p class="bg-danger">'+arr[1]+'</p>');
										
						}
						else if(arr[0]==1){
							var cur_loc=window.location;
							cur_loc=cur_loc+"&s=1";
							window.location=cur_loc;
							window.location='<?php echo $base_url?>inventory/categoryWindow.php';
							$.alert({
								title: 'Success',
								content: 'Done !',
								type: 'green',
								typeAnimated: true,
							});
						}
					}
					});
					
				}//if(row_count2!=0)
				var cur_loc=window.location;
			  	cur_loc=cur_loc+"&s=1";
				window.location=cur_loc;
				window.location='<?php echo $base_url?>inventory/categoryWindow.php';
			}
		}
		
		}
	});
					

}

</script>