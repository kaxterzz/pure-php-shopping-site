<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0002")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
include('../lib/connection.php'); // attach db connection
include('../lib/function.php');	// need to edit
include('../lib/inv_func.php');
$meta_title = "Product Details";
$c_page="inventory";

//--------------------------------------------------------
$page_action='';
$page_title='Add New Product';
$frm_err_msg='';
$pid=getprdId();
$pname='';
$cat='';
$img='';
$brand='';
$reordrlvl='';
$stat='';
$feature='';
$featureval='';
$fname='';
$ftype='';
$fsize='';
$ftname='';
$root='';
$ext='';
$path='';



?>
<?php include('../inc-head.php');?> <!-- attach inc-head.php -->
</head>

<body onLoad="startTime();">

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
       
           			
                	<form class="frm form-horizontal" action="<?php echo $base_url.'inventory/product.php'?>" name="frmprd" id="frmprd" method="post" enctype="multipart/form-data">
                  
                    <div id="msg">
                    	 <?php  if($frm_err_msg != ''){
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
                                <?php if($page_action='edit' && $img!=''):?>
                                	<td><img class="img-responsive" src="<?php echo $base_url.'images/products/'.$cid.'/'.$pid.'/'.$img?>"/></td>
                                <?php endif;?>
								<td><label for="prdimage"> Product Image </label></td>
                                <td><input type="hidden" name="MAX_FILE_SIZE" value="10000000" /></td>
								<td><input type="file" name="prdimage" id="prdimage" /></td>

                            
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
                            	<td colspan="4"><input class="form-control" type="hidden" name="txtfeature" id="txtfeature" value=""/></td>
                            </tr>
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
														$("#cmbfeature").empty();
			  											$("#cmbfeature").append(data);
													}
												});
											}
										});
										</script>
                                    </select>
                                </td>								
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
                                <th>cancel</th>
                            </tr>
                            </thead>
                            <tbody id="feature-tbl">
                            
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
			//alert(index);
			var mytable = document.getElementById("feature-tbl");
			mytable.deleteRow(index-1);
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
		if($('#cmbfeature').val() !=''){
			$("#info_msg").css("display","none");
			if($('#txtval').val() !=''){
				$("#info_msg").css("display","none");
				var mytable = document.getElementById("feature-tbl");
				var row_count = mytable.rows.length;
				var new_row = mytable.insertRow(row_count);
		
				new_row.insertCell(0).innerHTML = $("#cmbfeature").val();
				new_row.insertCell(1).innerHTML ="<input type='text' id='featu_text_"+j+"' name='featu_text_"+j+"' value="+$("#txtfeature").val()+" readonly />";
				new_row.insertCell(2).innerHTML = "<input type='text' id='featu_value_"+j+"' name='featu_value_"+j+"' value="+$("#txtval").val()+"  />";
				new_row.insertCell(3).innerHTML = "<span class='glyphicon glyphicon-remove' id='remove' onclick='removerow(this);'></span>";
				j++;
				$("#txtfeature").val("");
				$("#txtval").val("");
				$("#cmbfeature").val("");
		
			}
			else{ //'#txtval'!=''
				$("#info_msg").css("display","block");
				//$("#info_msg").css("background-color","#ff0000");
				$("#info_msg").html("<p class='alert alert-danger'>Please Enter a Feature value for the Product</p>");
				}
				
		}
		else{	//if('#cmbfeature'!='' && '#txtfeature'!='')
			$("#info_msg").css("display","block");
			//$("#info_msg").css("background-color","#ff0000");
			$("#info_msg").html("<p class='alert alert-danger'>Please Select a Feature for the Product from the Dropdown</p>");
		}
		
		
	});
	$('#frmprd').submit(function(e){
		e.preventDefault();
		$.ajax({
			url: "../lib/inv_func.php?type=addprds",
			type:"POST",
			data:new FormData(this),
			contentType:false,
			cache:false,
			processData:false,
			success: function(data){
				//alert(data);	
				var arr = data.split("|");
				//alert(arr[0]);
				if(arr[0]=="2"){
				//alert(arr[1]);
				$("#msg").css("display","block");
				$("#msg").html('<p class="alert alert-danger">'+arr[1]+'</p>');
				}
				else if(arr[0]=="3" ){
					$("#msg").css("display","block");
					$("#msg").html('<p class="alert alert-danger">'+arr[1]+'</p>');
					}
				else if(arr[0]=="4" ){
					$("#msg").css("display","block");
					$("#msg").html('<p class="alert alert-danger">'+arr[1]+'</p>');
					}
				else if(arr[0]=="5" ){
					$("#msg").css("display","block");
					$("#msg").html('<p class="alert alert-danger">'+arr[1]+'</p>');
					}		
				else if(arr[0]=="6" ){
					$("#msg").css("display","block");
					$("#msg").html('<p class="alert alert-danger">'+arr[1]+'</p>');
					}	
				else if(arr[0]=="7" ){
					$("#msg").css("display","block");
					$("#msg").html('<p class="alert alert-danger">'+arr[1]+'</p>');
					}
				else if(arr[0]=="8" ){
					$("#msg").css("display","block");
					$("#msg").html('<p class="alert alert-danger">'+arr[1]+'</p>');
					}
				else if(arr[0]=="9" ){
					$("#msg").css("display","block");
					$("#msg").html('<p class="alert alert-danger">'+arr[1]+'</p>');
					}			
				else if(arr[0]=="1" ){
					//alert(arr[1]);
					var pid=document.getElementById('txtprdid').value;
					var mytable = document.getElementById("feature-tbl");
					var row_count = mytable.rows.length;
					var arr=new Array();
					i=0;
					while(i<row_count){
						var featr_type=mytable.rows[i].cells[1].childNodes[0].value;
						var featr_data=mytable.rows[i].cells[2].childNodes[0].value;
						arr[i] =Array(featr_type,featr_data);
						i++;
					}
						$.post("../lib/inv_func.php?type=addfeatures",{pid:pid,farr:arr},function(data,status){
							if(status=="success"){	
								var arr = data.split("|");
							    if(arr[0]=="1"){
									$("#msg").css("display","block");
									$("#msg").html('<p class="alert alert-success">'+arr[1]+'</p>');
									setTimeout(function(){window.location.reload()},3000);
								}
								else if(arr[0]=="2"){
							//alert(arr[1]);
									$("#msg").css("display","block");
									$("#msg").html('<p class="alert alert-danger">'+arr[1]+'</p>');
							
								}
								else{
									alert(arr[0]);	
								}
							}
						});
					
				}
			}
		});
			
	});
		
</script>
