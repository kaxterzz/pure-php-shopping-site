<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0002" && $_SESSION["employee"]["etype"]!=="J0003")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
include('../lib/connection.php'); // attach db connection
include('../lib/function.php');
include('../lib/sales_func.php');
$meta_title = "Order Details";
$c_page = 'sales';

//-------------------------------------
$page_title='';
$cus='';
$empid='';
$cat='';
$uprice='';
$qnty='';
$tblprdid='';
$tblprd='';
$tbluprice='';
$tblqnty='';
$tblprdtot='';
$tblgtot='';
$tbldisc='';
$tblntot='';
if(isset($_GET['id'])){
	$invid=$_GET['id'];
	$page_title='Edit Customer Order '.$invid;
	$sql_all="SELECT C.cus_fname,I.inv_emp_id,I.inv_gtot,I.inv_disc,I.inv_ntot FROM tbl_invoice I,tbl_customer C WHERE I.inv_id='$invid' AND I.inv_cus_id=C.cus_id;";
	$result=mysqli_query($GLOBALS['conn'],$sql_all) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
	$row=mysqli_fetch_assoc($result);
	$cus=$row['cus_fname'];
	$empid=$row['inv_emp_id'];
	$tblgtot=$row['inv_gtot'];
	$tbldisc=$row['inv_disc'];
	$tblntot=$row['inv_ntot'];
}
?>
<?php include('../inc-head.php');?>
<!-- attach inc-head.php -->
</head>

<body onLoad="startTime();">
<?php include('../inc-header.php');?>
<!-- attach inc-header.php -->
<div class="page-body container-fluid">
  <div class="container inner">
    <div class="page-title clearfix">
      <h1 class="pull-left"><?php echo $page_title ?></h1>
      <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>sales/view_order.php">View Sales Orders</a></div>
    </div>
    <!-- end page-title -->
    <form class="frm form-horizontal" action="<?php echo $base_url.'sales/edit-order.php'?>" name="frmeditorder" method="post">
      <div id="form_msg">
      </div>
      <div class="frmdiv">
        <table class="frm-tbl table table-responsive">
          <tr>
          <td><label for="txtcus">Customer Name</label></td>
          <td><input class="form-control" id="txtcus" name="txtcus" type="text" value="<?php echo $cus ?>"/></td>
          </tr>
          
           <tr>
          <td><label for="txtempid">Employee ID</label></td>
          <td><input class="form-control" id="txtempid" name="txtempid" type="text" value="<?php echo $empid ?>" /></td>
          </tr>
          <tr>
          <tr>
            <td><label for="txtinvid">Invoice ID</label></td>
            <td><input class="form-control" id="txtinvid" name="txtinvid" type="text" value="<?php echo $invid?>" readonly/></td>
          </tr>
         
          <tr>
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
          <tr>  
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
                            <tbody id="inv-update-tbl">
                            	<?php $sql_all2="SELECT I.prd_id,P.prd_name,I.prd_u_price,I.inv_prd_qnty,I.inv_prd_tot FROM tbl_inv_info I,tbl_products P WHERE inv_id='$invid' AND I.prd_id=P.prd_id;";
								  $result2=mysqli_query($GLOBALS['conn'],$sql_all2) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
								  while($row2=mysqli_fetch_assoc($result2)){?>
									<tr id="<?php echo $tblprdid=$row2['prd_id']; ?>">
                                    <td><?php echo $tblprdid ?></td>
                                    <td><?php echo $tblprd=$row2['prd_name']; ?></td>
                                    <td><?php echo $tbluprice=$row2['prd_u_price']; ?></td>
                                    <td><input type='text' id='qnty_<?php echo $tblprdid; ?>' name='qnty_<?php echo $tblprdid; ?>' value='<?php echo $tblqnty=$row2['inv_prd_qnty']; ?>' onChange='updatetot(this)' /></td>
                                    <td><?php echo $tblprdtot=$row2['inv_prd_tot']; ?></td>
                                    <td><span class='glyphicon glyphicon-remove' id='<?php echo $tblprdid?>|<?php echo $invid?>' onclick='deleteprd(this);'></span></td>
                                    </tr>
								<?php  }?>
                            </tbody>
                            <tbody id="inv-tbl"></tbody>
                            <tfoot id="inv-cal-tbl">
                            <tr>
                            <th colspan="4" style="text-align:right">Gross Total <span style="color:#00f;font-size:x-small;">(Rs)</span></th>
                            <td><input class="form-control" type="text" name="txtgtot" id="txtgtot" value="<?php echo $tblgtot ?>" readonly/>
                            
                            </td>
                            <tr>
                            <tr>
                            <th colspan="4" style="text-align:right">Discount</th>
                            <td><input class="form-control" type="text" name="txtdisc" id="txtdisc" value="<?php echo $tbldisc ?>" onChange="updatentot()"/></td>
                            <tr>
                            <tr>
                            <th colspan="4" style="text-align:right">Net Total <span style="color:#00f;font-size:x-small;">(Rs)</span></th>
                            <td><input class="form-control" type="text" name="txtntot" id="txtntot" value="<?php echo $tblntot ?>" readonly/></td>
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
  </div>
  <!-- end inner --> 
</div>
<!-- end page-body -->
<?php include('../inc-footer.php'); ?>
</body>
</html>

<script type="text/javascript">
function removerow(obj){ //remove newly added products
			var index = obj.parentNode.parentNode.rowIndex;
			//alert(index);
			var mytable = document.getElementById("inv-tbl");
			var gtot = parseFloat(document.getElementById("txtgtot").value);
			var tot = parseFloat(obj.parentNode.previousSibling.innerHTML);
			var disc=parseFloat(document.getElementById("txtdisc").value);
			document.getElementById("txtgtot").value = (gtot-tot).toFixed(2);
			document.getElementById("txtntot").value =( (gtot-tot)-((gtot-tot)*disc/100)).toFixed(2);
			mytable.deleteRow(index-3);
}

function deleteprd(obj){ // removing existing item from the invoice
		var id = obj.id;
		var dataArr = id.split("|");
		var pid=dataArr[0];
		var invid=dataArr[1];
		$.jAlert({'type':'confirm',
		'title':'Confirmation',
		'theme':'yellow',
		'confirmQuestion': 'Are you sure you want to Delete Product '+dataArr[0]+'?',
		'onConfirm':function(){
			delItem(pid,invid);
		}
	});
}

function delItem(pid,invid){//check
	$.get("../lib/sales_func.php?type=delprdorder",{pid:pid,invid:invid},function(data,status){
		if(status=='success'){
				//alert(data);
				var dataArr = data.split("|");
					if(dataArr[0]=="1"){
						$("#form_msg").css("display","block");
						$("#form_msg").html('<p class="alert alert-warning">'+dataArr[1]+'</p>');	
					}
					else if(dataArr[0]=="2" ){
						$("#form_msg").css("display","block");
						$("#form_msg").html('<p class="alert alert-danger">'+dataArr[1]+'</p>');
					}//edit
		}
	});
}

var j=1;
	$("#btnadd").click(function(){
		if($('#cmbprd').val() !='' && $('#txtuprice').val() !=''){
			$("#form_msg").css("display","none");
			if($('#txtqnty').val() !=''){
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
			else{ //'#txtval'!=''
				$("#form_msg").css("display","block");
				//$("#info_msg").css("background-color","#ff0000");
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
	var tbody = document.getElementById("inv-tbl"); //check this
	var row_count = tbody.rows.length;
	i = 0;
	var gtot = 0;
	var ntot=0;
	var disc=parseFloat(document.getElementById("txtdisc").value);
	while(i<row_count){
		gtot += parseFloat(tbody.rows[i].childNodes[4].innerHTML);
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
	
	
$("#btnprint").click(function(){
		var arr=new Array(); // updating prds array
		var new_arr = new Array(); //new prds array
		var invtable=document.getElementById("inv-update-tbl");//updating table
		var newinvtable = document.getElementById("inv-tbl"); //new table
		var invcaltable=document.getElementById("inv-cal-tbl"); //calculating table
		var row_count = invtable.rows.length; //updating table rows count
		var new_row_count = newinvtable.rows.length; //new table rows count
		var inv_id = $("#txtinvid").val(); 
		//var cust_id = "C0001";get customer id and empid
		var gtot = document.getElementById("txtgtot").value; 
		var disc = document.getElementById("txtdisc").value;
		var ntot = document.getElementById("txtntot").value;
		j=0;
		while(j<row_count){//update prd table records extraction
			var pro_id = invtable.rows[j].childNodes[0].innerHTML; 
			var uprice = invtable.rows[j].childNodes[2].innerHTML;
			var qnty = invtable.rows[j].childNodes[3].childNodes[0].value; 
			var tot = invtable.rows[j].childNodes[4].innerHTML;
			arr[j] = Array(pro_id,uprice,qnty,tot)
			j++;
		}
		i = 0;
		while(i<new_row_count){ //new [rd table record extraction
			var new_pro_id = newinvtable.rows[i].childNodes[0].innerHTML; 
			var new_uprice = newinvtable.rows[i].childNodes[2].innerHTML;
			var new_qnty = newinvtable.rows[i].childNodes[3].childNodes[0].value; 
			var new_tot = newinvtable.rows[i].childNodes[4].innerHTML;
			new_arr[i] = Array(new_pro_id,new_uprice,new_qnty,new_tot)
			i++;
		}	
		$.post("../lib/sales_func.php?type=addnewinvprd",{invid:inv_id,n_darr:new_arr},function(data,status){
			if(status=="success"){
				if(data=='1'){
					$.post("../lib/sales_func.php?type=updateinvprd",{invid:inv_id,darr:arr},function(data,status){
						if(status=="success"){
							if(data=='1'){
								$.post("../lib/sales_func.php?type=updateinv",{invid:inv_id,gtot:gtot,disc:disc,ntot:ntot},function(data,status){
									if(status=='success'){
										var dataArr = data.split("|");
										if(dataArr[0]=="1"){
											$("#form_msg").css("display","block");
											$("#form_msg").html("<p class='alert alert-success'>"+dataArr[1]+"</p>");
			//window.open("reports/bill.php?invid="+inv_id,"billwnd_"+inv_id,"width=600,height=500,menubar=no,location=no");
											window.location.href="view_order.php";	
										}
										else if(dataArr[0]=="2"){
											$("#form_msg").css("display","block");
											$("#form_msg").html("<p class='alert alert-danger'>"+dataArr[1]+"</p>");
										}	
									}	
								});
								
							}	
						}
					});
				}
			}
		});
});	
</script>