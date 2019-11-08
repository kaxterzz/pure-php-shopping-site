<?php
session_start();
if((!isset($_SESSION["employee"]['etype']) || ($_SESSION["employee"]["etype"]!=="J0002") || ($_SESSION["employee"]["etype"]!=="J0001"))){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
// include('../lib/connection.php'); // attach db connection
include('../lib/function.php');	// need to edit
include('../lib/inv_func.php');
$meta_title = "Product Details";
$c_page="inventory";

//--------------------------------------------------------
$page_action='';
$page_title='Edit Product Details';
$frm_err_msg='';
$pid='';
$pname='';
$cat='';
$img='';
$brand='';
$reordrlvl='';
$stat='';
$feature='';
$featureval='';
if(isset($_GET['id'])){
	$pid=$_GET['id'];
	$sql_all="SELECT * FROM tbl_products WHERE prd_id='$pid';";
	$result=mysqli_query($GLOBALS['conn'],$sql_all) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
	$row=mysqli_fetch_assoc($result);
	$pname=$row['prd_name'];
	$cat=$row['cat_id'];
	$brand=$row['brand_id'];
	$img=$row['prd_img_path'];
	$reordrlvl=$row['prd_reorder_lvl'];
	$stat=$row['prd_stat'];	
}	//get id close
?>
<?php include('../inc-head.php');?> <!-- attach inc-head.php -->
</head>

<body>

<div class="modal fade" id="ModelWindow">
<div class="loadExt"></div>
</div><!-- /.modalbrand -->

<div class="modal fade" id="ModelWindow2">
<div class="loadExt2"></div>
</div><!-- /.modalcat -->

<?php include('../inc-header.php');?> <!-- attach inc-header.php -->
	<div class="page-body container-fluid">
    	<div class="container inner">
        	<div class="page-title clearfix">
                <h1 class="pull-left"><?php echo $page_title ?></h1>
                <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>inventory/view_product.php">View Product Details</a></div>
       
    		</div><!-- end page-title -->
                	<form class="frm form-horizontal" action="<?php echo $base_url.'inventory/edit_product.php'?>" name="frmprd" id="frmprd" method="post" enctype="multipart/form-data">
                    <div id="msg">
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
                            	<td><label for="txtprdid">Product ID</label></td>
                                <td><input class="form-control" id="txtprdid" name="txtprdid" type="text" value="<?php echo $pid?>" readonly/></td>						<td></td>
                                <td><label for="txtprdname">Product Name<em style="color:#F00">*</em></label></td>
                                <td colspan="2"><input class="form-control" id="txtprdname" name="txtprdname" type="text" value="<?php echo $pname?>"/></td>				 
                            </tr>
                            <tr>
                            	<td><label for="cmbcat">Category<em style="color:#F00">*</em></label></td>
                                <td><select class="form-control" id="cmbcat" name="cmbcat">
                                		 <option value="">--Select Category--</option>
                                      	<?php getCategory($cat) ?>
                                         
                                    </select>
                                   </td> 
                                    <td><button class="btn btn-primary btnLoadCat" data-type="add" type="button" data-toggle="modal" data-target="#ModelWindow2">Add New Category</button></td>
                                
                                	
                                
								<td><label for="prdimage"> Product Image </label></td>
                                <td><img class="img-responsive" src="<?php echo $base_url.'images/products/'.$img?>" width="100px" height="100px"/></td>
								<td><input type="file" name="prdimage" id="prdimage" alt=""<?php echo $img ?> /></td>
                                <td><input type="hidden" name="MAX_FILE_SIZE" value="10000000" /></td>

                            
                            </tr>
                            <tr>
                            	<td><label for="cmbbrand">Brand Name<em style="color:#F00">*</em></label></td>
                                <td><select class="form-control" id="cmbbrand" name="cmbbrand">
                                		 <option value="">--Select Brand--</option>
                                      	 <?php getBrand($brand) ?>
                                            
                                    </select>
                                    <td><button class="btn btn-primary btnLoadBrand" data-type="add" type="button" data-toggle="modal" data-target="#ModelWindow">Add New Brand</button></td>
                                </td>                                
                            </tr>
                            <tr>
                            	<td><label for="txtreorderlvl">Reorder Level<em style="color:#F00">*</em></label></td>
                                <td colspan="2"><input class="form-control" id="txtreorderlvl" name="txtreorderlvl" type="text" value="<?php echo $reordrlvl?>"/></td>		
                            </tr>
							<tr>
                                <td><label for="optstat">Status<em style="color:#F00">*</em></label></td>
                                <td><input class="radio-inline" id="optstat1" name="optstat" type="radio" value="1" <?php if($stat=='1'):?>checked='checked'<?php endif; ?>checked/>Active
                                <input class="radio-inline" id="optstat2" name="optstat" type="radio" value="0" <?php if($stat=='0'):?>checked='checked'<?php endif; ?>/>Inactive
                                </td>
                            </tr>
                        </table>
                        <h1>Additional Information</h1>
                         	<div id="info_msg"></div>
					
                        <table class="frm-tbl table table-responsive">
                        	<tr>
                            	<td>
                                	<select class="form-control" id="cmbfeature" name="cmbfeature">
                                      <option value="">--Select Feature--</option>
                                      <script type="text/javascript">
										$("#cmbcat").change(function(){
			  							var catid = $("#cmbcat").val();
										//alert(catid);
											if(catid!=''){	
												$.get("../lib/inv_func.php?type=featrbycat",{cid:catid},function(data,status){
													if(status=="success"){
			  											$("#cmbfeature").append(data);
													}
												});
											}
										});
										</script>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                            	<td><label for="txtfeature">Feature</label></td>
                                <td><input class="form-control" type="text" name="txtfeature" id="txtfeature" value=""/></td>								
                                <td><label for="">Value</label></td>
                                <td><input class="form-control" type="text" name="txtval" id="txtval" value=""/></td>
                                <td><input class="form-control btn btn-primary" type="button"  name="btnadd" id="btnadd" value="Add"/></td> 
                            </tr>
                        </table>
                        <table class=" table table-responsive">
                        	<thead id="">
                        	<tr>
                            	<th>Feature ID</th>
                                <th>Feature </th>
                                <th>Feature Value</th>
                                <th>Status available=1 unavailable=0</th>
                                <th>cancel</th>
                            </tr>
                            </thead>
                            <tbody id="feature-tbl">
                            <?php $sql_all2="SELECT * FROM tbl_prd_info WHERE prd_id='$pid';";
								  $result2=mysqli_query($GLOBALS['conn'],$sql_all2) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
								  while($row2=mysqli_fetch_assoc($result2)){?>
									<tr>
                                    <td><?php echo $row2['pi_id']; ?></td>
                                    <td><input type='text' name='featu_text_<?php echo $row2['pi_id']; ?>' value="<?php echo $row2['pi_type']; ?>" readonly /></td>
                                    <td><input type='text' name='featu_value_<?php echo $row2['pi_id']; ?>' value="<?php echo $row2['pi_data']; ?>" /></td>
                                    <td><input type='text' name='featu_stat_<?php echo $row2['pi_id']; ?>' value="<?php echo $row2['pi_stat']; ?>" /></td>
                                    <td><span class='glyphicon glyphicon-remove' id='remove' onclick='removerow(this);'></span></td>
                                    </tr>
								<?php  }?>
                           
                            </tbody>
                        </table>
                        </div><!-- end frmdiv -->
                        <table class=" btns tbl-horizontal col-md-3">
							<tr>
                            	<td><input class="form-control btn btn-primary" type="submit" name="btnsubmit" id="btnsubmit" value="Submit"/></td>
                                <td><input class="form-control btn btn-warning" type="reset"  name="btnreset" id="btnreset" value="Reset"/></td>
                            </tr>
                            
                        </table> 	
                    </form>
                   
        </div><!-- end inner -->
    </div><!-- end page-body -->
<?php include('../inc-footer.php'); ?>
</body>
</html>
<script type="text/javascript">
	function removerow(obj){
			//alert(obj);
			var index = obj.parentNode.parentNode.rowIndex;
			var pi_id=obj.parentNode.parentNode.cells[0].innerHTML;
			$.get("../lib/inv_func.php?type=remvfeatr",{pi_id:pi_id},function(data,status){
			if(status=='success'){
				if(data=='1'){
					var mytable = document.getElementById("feature-tbl");
					mytable.deleteRow(index-1);	
				}
			}
			});
	}
	$("#cmbfeature").change(function(){
		var fid = $("#cmbfeature").val();
		if(fid!=''){
		var url = "../lib/inv_func.php?type=getfeatr";
		$.get(url,{featrid:fid},function(data,status){
			if(status=='success')
			$("#txtfeature").val(data);
		});
		}
	});
	
	var j=1;
	$("#btnadd").click(function(){
		if($('#cmbfeature').val() !='' && $('#txtfeature').val() !=''){
			$("#info_msg").css("display","none");
			if($('#txtval').val() !=''){
				$("#info_msg").css("display","none");
				var mytable = document.getElementById("feature-tbl");
				var row_count = mytable.rows.length;
				var new_row = mytable.insertRow(row_count);
		
				new_row.insertCell(0).innerHTML = $("#cmbfeature").val();
				new_row.insertCell(1).innerHTML = "<input type='text' id='featu_text_"+j+"' name='featu_text_"+j+"' value="+$("#txtfeature").val()+" readonly />";
				new_row.insertCell(2).innerHTML = "<input type='text' id='featu_value_"+j+"' name='featu_value_"+j+"' value="+$("#txtval").val()+"  />";
				new_row.insertCell(3).innerHTML = "<input type='text' id='featu_stat_"+j+"' name='featu_stat_"+j+"' value='1' />";
				new_row.insertCell(4).innerHTML = "<span class='glyphicon glyphicon-remove' id='remove' onclick='removerow(this);'></span>";
				j++;
				$("#txtfeature").val("");
				$("#txtval").val("");
				$("#cmbfeature").val("");
		
			}
			else{ //'#txtval'!=''
				$("#info_msg").css("display","block");
				//$("#info_msg").css("background-color","#ff0000");
				$("#info_msg").html("<p class='bg-danger'>Please Enter a Feature value for the Product</p>");
				}
				
		}
		else{	//if('#cmbfeature'!='' && '#txtfeature'!='')
			$("#info_msg").css("display","block");
			//$("#info_msg").css("background-color","#ff0000");
			$("#info_msg").html("<p class='bg-danger'>Please Select a Feature for the Product from the Dropdown</p>");
		}
		
		
	});
	$('#frmprd').submit(function(e){
		e.preventDefault();
		$.ajax({
			url: "../lib/inv_func.php?type=updprds",
			type:"POST",
			data:new FormData(this),
			contentType:false,
			cache:false,
			processData:false,
			success: function(data){
				//alert(data);	
				var arr = data.split("_");
				if(arr[0]=="2" || arr[0]=="3" || arr[0]=="4" || arr[0]=="5" || arr[0]=="6" || arr[0]=="7" || arr[0]=="8" || arr[0]=="9"){
				//alert(arr[1]);
				$("#msg").css("display","block");
				$("#msg").html('<p class="bg-danger">'+arr[1]+'</p>');
				}
				else if(arr[0]=="1" ){
					//alert(arr[1]);
					var pid=document.getElementById('txtprdid').value;
					var mytable = document.getElementById("feature-tbl");
					var row_count = mytable.rows.length;
					var arr=new Array();
					i=0;
					while(i<row_count){
						var featr_id=mytable.rows[i].cells[0].innerHTML;
						var featr_type=mytable.rows[i].cells[1].childNodes[0].value;
						var featr_data=mytable.rows[i].cells[2].childNodes[0].value;
						var featr_stat=mytable.rows[i].cells[3].childNodes[0].value;
						arr[i] =Array(featr_id,featr_type,featr_data,featr_stat);
						i++;
					}
					
						//alert("next");
						$.post("../lib/inv_func.php?type=updfeatures",{pid:pid,farr:arr},function(data,status){
							if(status=="success"){	
								//alert(data);
								var arr = data.split("_");
								if(arr[0]=="2"){
							//alert(arr[1]);
									$("#msg").css("display","block");
									$("#msg").html('<p class="bg-danger">'+arr[1]+'</p>');
							
								}
								else if(arr[0]=="1"){
									var cur_loc=window.location;
									cur_loc=cur_loc+"&s=1";
									//$("#form_msg").css("display","block");
									//$("#form_msg").html('<p class="bg-success">'+arr[1]+'</p>');
									//setTimeout(function(){window.location.reload},3000);
									window.location=cur_loc;
									window.location='<?php echo $base_url?>inventory/view_product.php';	
								}
							}
						});
					
				}
			}
		});
		
			
	});
		
</script>
