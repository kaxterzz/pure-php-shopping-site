<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0002")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
// include('../lib/connection.php'); // attach db connection
include('../lib/function.php');
$meta_title = "Product Brand Details"; // title on the browser tab
$c_page = 'inventory';// highligting the navbar tab based on the current page


//--------------------------------------------------------
$page_action = '';
$page_title='View Product Brand Details';
$bid='';
$bid=getBrandId();
$brand='';
$stat='';
$frm_err_msg='';
?>
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-title clearfix">
        	<h1 class="pull-left">Add New Product Brand</h1><!-- Title of the page loaded according to the action on URL-->    
        </div><!--end modal-title -->
      </div><!-- modal-header -->
      <div class="modal-body">
                     <div id="form_msg">
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
                                <td><input class="radio-inline" id="opt1" name="optstat" type="radio" value="1" <?php if($stat=='1'):?>checked='checked'<?php endif ?>checked/>Available
                                <input class="radio-inline" id="opt2" name="optstat" type="radio" value="0" <?php if($stat=='0'):?>checked='checked'<?php endif ?>/>Unavailable
                                </td>
                            </tr>
                        </table>
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
$('#btnsubmit').click(function(){
	var url="../lib/inv_func.php?type=addbrand";
	var brandid=$('#txtbid').val();
	var brandname=$('#txtbrand').val();
	if ($("#opt1").is(":checked")) {
         var bstat=$('#opt1').val();
    }
    else if($("#opt2").is(":checked")){
         var bstat=$('#opt2').val();
     }
	
	$.post(url,{bid:brandid,bname:brandname,bstat:bstat},function(data,status){
		if(status=='success'){
			var dataArr = data.split("_");
					if(dataArr[0]=="3"){
						$("#form_msg").css("display","block");
						//$("#form_msg").css("background-color","#00ff00");
						$("#form_msg").html('<p class="bg-success">'+dataArr[1]+'</p>');
						var selection_list = document.getElementById("cmbbrand");
						var new_option   = document.createElement("option");
						new_option.value = brandid;
						new_option.text  = brandname;
						selection_list.add(new_option);
						setTimeout(function(){ $(".close").click() },3000);	
					}
					else if(dataArr[0]=="2" || dataArr[0]=="1"){
						$("#form_msg").css("display","block");
						//$("#form_msg").css("background-color","#ff0000");
						$("#form_msg").html('<p class="bg-danger">'+dataArr[1]+'</p>');
					}
					
			}
		});
	});


</script>