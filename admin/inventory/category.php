<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0002")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
// include('../lib/connection.php'); // attach db connection
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
$cid=getCatId();
?>
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-title clearfix">
        	<h1 class="pull-left">Add New Product Category</h1><!-- Title of the page loaded according to the action on URL-->
        </div><!--end modal-title -->
      </div><!-- modal-header -->
      <div class="modal-body">
                	<form class="frm form-horizontal" action="" name="frmcat" method="post">
                    <div id="form_msg">
						
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
                                <td>
                                <input class="radio-inline" type="radio" id="opt1" name="optstat" value="1" <?php if($stat=='1'):?>checked='checked'<?php endif ?>checked >Available
                                <input class="radio-inline" type="radio" id="opt2" name="optstat" value="0" <?php if($stat=='0'):?>checked='checked'<?php endif ?> >Unavailable
                                </td>
                               </tr>
                               <tr> 
                                <td><label for="cmbsupcat">Super Category</label></td>
           					 	<td><select class="form-control" id="cmbsupcat" name="cmbsupcat">
                                    <option value="">--Select Super Category--</option>
                                    <option value="Electrical">Electrical</option>
                                    <option value="Lightings">Lightings</option>
                                    <option value="Electronics">Electronics</option>
                                    <option value="Musical">Musical</option>
                                  	</select></td>
                            </tr>
                        </table>
                        <table class="frm-tbl-addInfo table table-responsive">
                        	<thead>
                        	<tr>
                            	<th colspan="2">Add additional Information about category by filling the table below</th>
                            </tr>
                            <tr>
                            	<th>Product Feature</th>
                            </tr>
                            </thead>
                            <tbody id="info-body">
                            <tr>
                            	<td><input type="text" name="feature1" id="feature1" value=""/></td>
                            </tr> 
                            </tbody>
                        </table>
                        <a href="#" title="" class="add_feature">Add another Feature</a>
                        </div><!-- end frmdiv -->  
                        
                         <table class=" btns tbl-horizontal col-md-3">
							<tr>
                            	<td><input class="form-control btn btn-primary" type="button" name="btnsubmit" id="btnsubmit" value="Submit"/></td>
                                <td><input class="form-control btn btn-warning" type="reset"  name="btnreset" id="btnreset" value="Reset"/></td>
                            </tr>
                        </table> 	
                    </form>   
                     
                    
      </div><!-- end modal body -->
      <div class="modal-footer"></div>
    </div><!-- modal-content -->

  </div><!-- modal-dialog -->
  
<script type="text/javascript">
$(document).ready(function(e) {
	var count=1;
	$(".add_feature").click(function(){
		count++;	            
    	$(".frm-tbl-addInfo").append('<tr><td><input type="text" name="feature'+count+ '" id="feature'+count+'"/></td></tr>');
	});


$('#btnsubmit').click(function(){
	var url="../lib/inv_func.php?type=addcat";
	var catid=$('#txtcid').val();
	var catname=$('#txtcat').val();
	if ($("#opt1").is(":checked")) {
         var catstat=$('#opt1').val();
    }
    else if($("#opt2").is(":checked")){
         var catstat=$('#opt2').val();
     }
	var supcat=$('#cmbsupcat').val();
	var arr=new Array();
	var table=document.getElementById('info-body');
	var row_count=table.rows.length;
	
	i=0;
	while (i<row_count){
		var feature=table.rows[i].cells[0].childNodes[0].value;
		arr[i] = feature;
		i++;
	}
	$.post(url,{cid:catid,cname:catname,cstat:catstat,scat:supcat,farr:arr},function(data,status){
		if(status=='success'){
			var dataArr = data.split("|");
					if(dataArr[0]=="3"){
						$("#form_msg").css("display","block");
						$("#form_msg").html('<p class="bg-success">'+dataArr[1]+'</p>');
						var selection_list = document.getElementById("cmbcat");// get the id of Category combobox on product.php
						var new_option   = document.createElement("option");// create an element option on the combo box
						new_option.value = catid;// add the catid on attribute 'value' of option element 
						new_option.text  = catname;//add the catname as the text of the option added
						selection_list.add(new_option);// add the new option element created on the combobox list 
						setTimeout(function(){ $(".close").click() },3000);	// close the popup after 3000 miliseconds
					}
					else if(dataArr[0]=="2" || dataArr[0]=="1"){
						$("#form_msg").css("display","block");
						$("#form_msg").html('<p class="bg-danger">'+dataArr[1]+'</p>');
					}
					
			}
		});
	});
});

</script>