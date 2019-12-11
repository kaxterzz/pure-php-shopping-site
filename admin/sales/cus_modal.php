<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0002") && ($_SESSION["employee"]["etype"]!=="J0003")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
// include('../lib/connection.php'); // attach db connection
include('../lib/function.php');
$meta_title = "Customer Details"; // title on the browser tab
$c_page = 'sales';// highligting the navbar tab based on the current page


//--------------------------------------------------------
$page_action = '';
$page_title='';
$cusid=getCusId();
$frm_err_msg='';
?>
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-title clearfix">
        	<h1 class="pull-left">Add Customer</h1><!-- Title of the page loaded according to the action on URL-->
        </div><!--end modal-title -->
      </div><!-- modal-header -->
      <div class="modal-body">
                	<form class="frm form-horizontal" action="" name="frmcus" method="post">
                    <div id="form_msg">
						
                    </div>
              
             <div class="frmdiv clearfix">
                		<table class="frm-tbl table table-responsive">
                            <thead>
                            <tr>
                               <td colspan="4"><b>Select One of the Options</b></td>
                            </tr>
                        	<tr>
                               <th colspan="4"><a id="show_exist_cus_option" title="Find Existing Customer">Existing Customer</a></th>
                            </tr>
                        	</thead>
                            <tbody>
                            	<tr style="display:none" id="searchopt">
                                <td><label for="searchbycusname">Search By Name</label></td>
                                <td><input type="text" id="searchbycusname" name="searchbycusname"></td>
                                <td><input type="button" id="findcus" name="findcus" class="btn btn-primary" value="Search"></td>
                                </tr>
                            </tbody>
                            <tfoot>
                            	<table class="frm-tbl table table-responsive" id="tblexistcushead" style="display:none">
                                	<thead>
                                    <th>Cus ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Gender</th>
									<th>Address</th>
                                    <th></th>
                                    </thead>
                                    <tbody id="tblexistcus">
                                    
                                    </tbody>
                                </table>    
                            </tfoot>
                         </table>
                        <table class="frm-tbl table table-responsive">  
                        	<thead>
                                <tr>
                                	<th colspan="4"><a id="show_add_cus_form" title="Add New Customer">Add New Customer</a></th>
                                </tr> 
                            </thead>
                            <tbody id="tblnewcus" style="display:none">     
                            <tr>
                            	<td><label for="txtcusid">Customer ID</label></td>
                                <td><input class="form-control" id="txtcusid" name="txtcusid" type="text" value="<?php echo $cusid?>" readonly/></td>
                            </tr>
                            <tr>
                            	<td><label for="txtfname">First Name<em style="color:#F00">*</em></label></td>
                                <td><input class="form-control" id="txtfname" name="txtfname" type="text" value=""/></td>
                            </tr>
                            <tr>
                            	<td><label for="txtlname">Last Name<em style="color:#F00">*</em></label></td>
                                <td><input class="form-control" id="txtlname" name="txtlname" type="text" value=""/></td>
                            </tr>
							<tr>
                                <td><label for="optgen">Gender<em style="color:#F00">*</em></label></td>
                                <td>
                                <input class="radio-inline" type="radio" id="opt1" name="optgen" value="1" checked>Male
                                <input class="radio-inline" type="radio" id="opt2" name="optgen" value="0">Female
                                </td>
                               </tr>
                                <tr>
                            	<td><label for="txtadd">Address<em style="color:#F00">*</em></label></td>
                                <td><input class="form-control" id="txtadd" name="txtadd" type="text" value=""/></td>
                            </tr>    
                         <table class="btns tbl-horizontal col-md-3" style="display:none" id="formbtn">
							<tr>
                            	<td><input class="form-control btn btn-primary" type="button" name="btncussubmit" id="btncussubmit" value="Submit"/></td>
                                <td><input class="form-control btn btn-warning" type="reset"  name="btnreset" id="btnreset" value="Reset"/></td>
                            </tr>
                        </table> 
                      </tbody>
                    </table>   	
                    </form>   
                     
                    
      </div><!-- end modal body -->
      <div class="modal-footer"></div>
    </div><!-- modal-content -->

  </div><!-- modal-dialog -->
  
<script type="text/javascript">
$(document).ready(function(e) {
	$('#show_exist_cus_option').click(function(){
		$("#searchopt").css("display","block");
		$("#tblexistcushead").css("display","block");
	});
	
	$('#show_add_cus_form').click(function(){
		$("#tblnewcus").css("display","block");
		$("#formbtn").css("display","block");
	});

$('#findcus').click(function(){ //get cus records when search by name
	var cusname=$('#searchbycusname').val();
	$.get('../lib/sales_func.php?type=getCusDetailsByName',{cusname:cusname},function(data,status){
		if(status=='success'){
			$("#tblexistcus").html(data);	
		}
	});
});

$('#btncussubmit').click(function(){
	var cusid=$('#txtcusid').val();
	var fname=$('#txtfname').val();
	var lname=$('#txtlname').val();
	if ($("#opt1").is(":checked")) {
         var gen=$('#opt1').val();
    }
    else if($("#opt2").is(":checked")){
         var gen=$('#opt2').val();
     }
	var add=$('#txtadd').val(); 
	$.post('../lib/sales_func.php?type=addcusdetails',{cusid:cusid,fname:fname,lname:lname,gen:gen,add:add},function(data,status){
		if(status=='success'){
			var dataArr = data.split("|");
					if(dataArr[0]==1){
						$("#form_msg").css("display","block");
						$("#form_msg").html('<p class="alert alert-success">'+dataArr[1]+'</p>');
						var inputbox = document.getElementById("txtcus");// get the id of input box
						inputbox.value = cusid;// add the cusid on attribute 'value' of inputbox
						setTimeout(function(){ $(".close").click() },3000);	// close the popup after 3000 miliseconds
					}
					else if(dataArr[0]==2){
						$("#form_msg").css("display","block");
						$("#form_msg").html('<p class="alert alert-danger">'+dataArr[1]+'</p>');
						$('#txtfname').val("");
						$('#txtfname').focus();
					}
					else if(dataArr[0]==3){
						$("#form_msg").css("display","block");
						$("#form_msg").html('<p class="alert alert-danger">'+dataArr[1]+'</p>');
						$('#txtlname').val("");
						$('#txtlname').focus();
					}
					else if(dataArr[0]==4){
						$("#form_msg").css("display","block");
						$("#form_msg").html('<p class="alert alert-danger">'+dataArr[1]+'</p>');
						$('#txtadd').focus(); 
					}
					else if(dataArr[0]==5){
						$("#form_msg").css("display","block");
						$("#form_msg").html('<p class="alert alert-danger">'+dataArr[1]+'</p>'); 
					}

					
			}
		});
	});
});

</script>