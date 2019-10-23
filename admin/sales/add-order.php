<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0002" && $_SESSION["employee"]["etype"]!=="J0003")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
// include('../lib/connection.php'); // attach db connection
include('../lib/function.php');
include('../lib/sales_func.php');
//include('../inventory/inv_func.php');
$meta_title = "Order Details";
$c_page = 'sales';

//-------------------------------------
$page_title='Add New Customer Order';
$invid=getOrderId();
$cus='';
$empid=$_SESSION['employee']['eid'];
$qnty='';
$uprice='';

?>
<?php include('../inc-head.php');?>
<!-- attach inc-head.php -->
</head>

<body onLoad="startTime();">
<?php include('../inc-header.php');
//send notifications if prds have reach the re-order lvl
$sql="SELECT prd_id,prd_name FROM tbl_products WHERE prd_tot_qnty<=prd_reorder_lvl;";
	$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
	$nor=mysqli_num_rows($res);
	if($nor!=0){
		$arr=array();
		while($row=mysqli_fetch_assoc($res)){
			array_push($arr,$row['prd_id'].' '.$row['prd_name']);
		}
		$i=0;
		$msg ='Dear Sir/Madam, Products ';
		for($i=0;$i<$nor;$i++){
					$msg.=' '.$arr[$i];		
		};
		$msg.=' have reached the re-order level on stock.Please Purchase the above products';
		$from ="binnytraders@gmail.com";
		$header = "From : ".$from;
		$header .= "MIME-Version: 1.0\n";
		$header .= "Content-type: text/html; charset=iso-8859-1\n";
		$to ='kasunsmbox@hotmail.com';
		$subject ='Products';
		$message = $msg; 
		// send mail
		if(mail($to,$subject,$message,$from,$header))
		$smsg="success";
		if($smsg=='success'){
			//echo "1";
		}
	}

?>
<!-- attach inc-header.php -->
<div class="modal fade" id="ModelWindow">
<div class="loadExt4"></div>
</div><!-- /.modaladdcus -->
<div class="page-body container-fluid">
  <div class="container inner">
    <div class="page-title clearfix">
      <h1 class="pull-left">Add New Sales Order</h1>
      <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>sales/view_order.php">View Sales Orders</a></div>
    </div>
    <!-- end page-title -->
    <form class="frm form-horizontal" action="<?php echo $base_url.'sales/add-order.php'?>" name="frmorder" method="post">
      <div id="form_msg">
       
      </div>
      <div class="frmdiv">
        <table class="frm-tbl table table-responsive">
          <tr>
          	<td>&nbsp;</td><td>&nbsp;</td>
            <td><label for="txtinvid">Invoice ID</label></td>
            <td><input class="form-control" id="txtinvid" name="txtinvid" type="text" value="<?php echo $invid?>" readonly/></td>
          </tr>	
          <tr>
          <td>&nbsp;</td><td>&nbsp;</td>
          <td><label for="txtcus">Customer ID</label></td>
          <td><input class="form-control" id="txtcus" name="txtcus" type="text" value="" readonly/></td>
          <td><button class="btn btn-primary btnAddCusDetails" data-type="add" type="button" data-toggle="modal" data-target="#ModelWindow">Add Customer</button></td>
          </tr>
          
          <tr>
           <td>&nbsp;</td><td>&nbsp;</td>
          <td><label for="txtempid">Employee ID</label></td>
          <td><input class="form-control" id="txtempid" name="txtempid" type="text" value="<?php echo $empid ?>" readonly/></td>
          </tr>
          
          <tr>
          <td colspan="5">
          <input type="hidden" name="txtstocklvl" id="txtstocklvl">
          </td>
          </tr>
         
          <tr id="combo1">
            <td><label for="cmbcat">Product<em style="color:#F00">*</em></label></td>
            <td><select class="form-control" id="cmbcat" name="cmbcat">
                <option value="">--Select Category--</option>
                <?php $sql_opt="SELECT * FROM tbl_category WHERE cat_stat=1;";
                                           $result=mysqli_query($GLOBALS['conn'],$sql_opt) or die("SQL error:".mysqli_error($GLOBALS['conn']));
										   while($row=mysqli_fetch_assoc($result)){
											   $cid=$row['cat_id'];
											   $catname=$row['cat_name'];
											   $select='';
											   if($cat==$cid){
												   $select='selected="selected"';
											   }
											   
                                         ?>
                <option value="<?php echo $cid?>" <?php echo $select?>><?php echo $catname ?></option>
                <?php }//end while?>
              </select></td>   
            <td>  
            	<select class="form-control" id="cmbprd" name="cmbprd">
                <option value="">--Select Product--</option>
                	<script type="text/javascript">
            	//view selected category's products
		  				$("#cmbcat").change(function(){
			  				var catid = $("#cmbcat").val();
							//alert(catid);
							if(catid!=''){
							$.get("../lib/inv_func.php?type=cmbprobycat",{catid:catid},
							function(data,status){
								if(status=="success"){
			  					$("#cmbprd").append(data);
								}
							});
							}
		  				});
        			
				</script>  
              </select>
            	
            </td>
          </tr>
           <tr>
            
          </tr>
          <tr id="addingrow">  
            <td><label for="txtsprice">Unit Price &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#00f;font-size:x-small;">(Rs)</span></label></td>
            <td><input class="form-control" id="txtuprice" name="txtuprice" type="text" value="<?php echo $uprice?>" readonly/>
            <script type="text/javascript">
            $("#cmbprd").change(function(){
			var pid = $("#cmbprd").val();
			//alert(pid);
				if(pid!=""){
					var url = "../lib/sales_func.php?type=getproprice";
					$.get(url,{pid:pid},function(data,status){
					if(status=="success")
					$("#txtuprice").val(data);
					});
				}
			});
            </script>
            </td>
            <td><label for="txtqnty">Quantity<em style="color:#F00">*</em></label></td>
            <td><input class="form-control has-feedback" id="txtqnty" name="txtqnty" type="text" value="<?php echo $qnty?>"/></td>
             <td><input class="form-control btn btn-primary" type="button"  name="btnadd" id="btnadd" value="Add"/></td> 
          </tr>
        </table>
        <table class=" table table-responsive">
                        	<thead id="">
                        	<tr>
                            	<th>Product ID</th>
                                <th>Product Name </th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="inv-tbl">
                            </tbody>
                            <tfoot id="inv-cal-tbl">
                            <tr>
                            <th colspan="4" style="text-align:right">Gross Total <span style="color:#00f;font-size:x-small;">(Rs)</span></th>
                            <td><input class="form-control" type="text" name="txtgtot" id="txtgtot" value="0.00" readonly/>
                            
                            </td>
                            <tr>
                            <tr>
                            <th colspan="4" style="text-align:right">Discount</th>
                            <td><input class="form-control" type="text" name="txtdisc" id="txtdisc" value="0.00" onChange="updatentot()"/></td>
                            <tr>
                            <tr>
                            <th colspan="4" style="text-align:right">Net Total <span style="color:#00f;font-size:x-small;">(Rs)</span></th>
                            <td><input class="form-control" type="text" name="txtntot" id="txtntot" value="0.00" readonly/></td>
                            <tr>
                            </tfoot>
                        </table>
      </div>
      <!-- end frmdiv -->
      <table class="btns tbl-horizontal  col-md-3">
        <tr>
          <td><input class="form-control btn btn-primary" type="button" name="btnprint" id="btnprint" value="Print" /></td>
          <td><input class="form-control btn btn-warning" type="reset"  name="btnreset" id="btnreset" value="Reset"/></td>
        </tr>
      </table>
    </form>

    <!-- if($page_action == 'add' || $page_action == 'edit'): --> 
  </div>
  <!-- end inner --> 
</div>
<!-- end page-body -->
<?php include('../inc-footer.php'); ?>
</body>
</html>

<script type="text/javascript">
function removerow(obj){
			//alert(obj);
			var index = obj.parentNode.parentNode.rowIndex;
			//alert(index);
			var mytable = document.getElementById("inv-tbl");
			//var ntot = parseFloat(document.getElementById("txtntot").value);
			var gtot = parseFloat(document.getElementById("txtgtot").value);
			var tot = parseFloat(obj.parentNode.previousSibling.innerHTML);
			var disc=parseFloat(document.getElementById("txtdisc").value);
			//var ntot=0;
			document.getElementById("txtgtot").value = (gtot-tot).toFixed(2);
			document.getElementById("txtntot").value =( (gtot-tot)-((gtot-tot)*disc/100)).toFixed(2);
			mytable.deleteRow(index-1);
}

$('#txtqnty').keyup(function(){//get stock lvl when qnty of prd entered
	var pid=$('#cmbprd').val();
	$.get('../lib/sales_func.php?type=getstoklvl',{pid:pid},function(data,status){
		if(status=='success'){
			//alert(data);
			document.getElementById("txtstocklvl").value=data;
		}
	});
});          
    
function addcustoform(obj){ //modal add link click
	cusid=obj.parentNode.parentNode.childNodes[0].innerHTML;
	var inputbox = document.getElementById("txtcus");// get the id of input box
	inputbox.value = cusid;// add the cusid on attribute 'value' of inputbox
	$(".close").click();	// close the popup
}	      	

var j=1;
	$("#btnadd").click(function(){
		if($('#cmbprd').val() !='' && $('#txtuprice').val() !=''){
			$("#form_msg").css("display","none");
			if($('#txtqnty').val() !=''){
				if($('#txtqnty').val()>$('#txtstocklvl').val()){
				$("#form_msg").css("display","block");
				$("#form_msg").html("<p class='alert alert-danger'>The quantity entered is above the stock level.Please enter quantity below "+$('#txtstocklvl').val()+"</p>");
				$('#txtqnty').val("");
				$('#txtqnty').focus();
				}
				else{
					$("#form_msg").css("display","none");
					var mytable = document.getElementById("inv-tbl");
					var row_count = mytable.rows.length;
					var new_row = mytable.insertRow(row_count);
			
					new_row.insertCell(0).innerHTML = $("#cmbprd").val();
					new_row.insertCell(1).innerHTML = $("#cmbprd option:selected").text();
					new_row.insertCell(2).innerHTML = $("#txtuprice").val();
					new_row.insertCell(3).innerHTML = "<input type='text' id='qnty_"+j+"' name='qnty_"+j+"' value="+$("#txtqnty").val()+" onchange='updatetot(this)' />";
					var tot=parseInt($("#txtqnty").val()) * parseFloat($("#txtuprice").val());
					new_row.insertCell(4).innerHTML = tot.toFixed(2);
					new_row.insertCell(5).innerHTML = "<span class='glyphicon glyphicon-remove' id='remove' onclick='removerow(this);'></span>";
					var gtot = parseFloat(document.getElementById("txtgtot").value);
					document.getElementById("txtgtot").value = (gtot+tot).toFixed(2);
					//var ntot = parseFloat(document.getElementById("txtntot").value);
					var disc = parseFloat(document.getElementById("txtdisc").value);
			/*edit*/document.getElementById("txtntot").value =((gtot+tot)-((gtot+tot)*disc/100)).toFixed(2); 
					j++;
					
					$("#cmbcat").val("");
					$("#cmbprd").empty();
					$("#cmbprd").append('<option value="">--Select Product--</option>');
					$("#txtuprice").val("");
					$("#txtqnty").val("");
				}
			}
			else{ //'#txtqnty'!=''
				$("#form_msg").css("display","block");
				$("#form_msg").html("<p class='alert alert-danger'>Please Enter the quantity</p>");
				}
				
		}
		else{	//if('#cmbfeature'!='' && '#txtfeature'!='')
			$("#form_msg").css("display","block");
			//$("#info_msg").css("background-color","#ff0000");
			$("#form_msg").html("<p class='alert alert-danger'>Please Select the particular Product from the dropdown list</p>");
		}
		
		
	});
	
function updatetot(obj){ // change tot,gtot,ntot when quantity changed
	var qty = parseInt(obj.value);
	var uprice = parseFloat(obj.parentNode.previousSibling.innerHTML);
	var gtot = parseFloat(document.getElementById("txtgtot").value);
	var tot = qty * uprice;
	obj.parentNode.nextSibling.innerHTML = tot.toFixed(2);
	var tbody = document.getElementById("inv-tbl");
	var row_count = tbody.rows.length;
	i = 0;
	var gtot = 0;
	var ntot=0;
	var disc=parseFloat(document.getElementById("txtdisc").value);
	while(i<row_count){
		gtot += parseFloat(tbody.rows[i].childNodes[4].innerHTML);
		//ntot+=/*parseFloat(tbody.rows[i].childNodes[4].innerHTML)*/gtot-(gtot*disc/100);
		i++;
	}
	document.getElementById("txtgtot").value = gtot.toFixed(2);
	ntot+=gtot-(gtot*disc/100);
	document.getElementById("txtntot").value=ntot.toFixed(2);
}

function updatentot(){ // change ntot when discount change
	var gtot = parseFloat(document.getElementById("txtgtot").value);
	var disc = parseFloat(document.getElementById("txtdisc").value);
	document.getElementById("txtntot").value =( gtot-(gtot*disc/100)).toFixed(2);
}
	
	
$("#btnprint").click(function(){ // edit
		var arr = new Array();
		var invtable = document.getElementById("inv-tbl"); 
		var invcaltable=document.getElementById("inv-cal-tbl"); 
		var row_count = invtable.rows.length; 
		var inv_id = $("#txtinvid").val(); 
		var cus_id =$("#txtcus").val();
		var emp_id=$("#txtempid").val();
		var gtot = document.getElementById("txtgtot").value; 
		var disc = document.getElementById("txtdisc").value;
		var ntot = document.getElementById("txtntot").value;
		i = 0;
		while(i<row_count){
			var pro_id = invtable.rows[i].childNodes[0].innerHTML; 
			var uprice = invtable.rows[i].childNodes[2].innerHTML;
			var qnty = invtable.rows[i].childNodes[3].childNodes[0].value; 
			var tot = invtable.rows[i].childNodes[4].innerHTML;
			arr[i] = Array(pro_id,uprice,qnty,tot)
			i++;
		}	
		if(cus_id==""){
			$("#form_msg").css("display","block");
			$("#form_msg").html("<p class='alert alert-danger'>Please enter a customer</p>");
			$("#txtcus").focus();
		}
		else{
		$.post("../lib/sales_func.php?type=addinv",{invid:inv_id,cusid:cus_id,eid:emp_id,gtot:gtot,disc:disc,ntot:ntot,darr:arr},function(data,status){
			if(status=="success"){
					$("#form_msg").css("display","block");
					$("#form_msg").html("<p class='alert alert-success'>Record Successfully Saved</p>");				
			  		$('.bannar').hide();
					$('.top2').hide();
					$('#form_msg').hide();
					$('.page-title').hide();
					$('.btnAddCusDetails').hide();
					$('#combo1').hide();
					$('#addingrow').hide();
					$('.btns').hide();
					$('.page-footer').hide();
			  		window.print();
			  		$('.bannar').show();
					$('.top2').show();
					$('#form_msg').show();
					$('.page-title').show();
					$('.btnAddCusDetails').show();
					$('#combo1').show();
					$('#addingrow').show();
					$('.btns').show();
					$('.page-footer').show();
					setTimeout(function(){window.location.reload()},3000);
			}
		});
		}
	});	
</script>