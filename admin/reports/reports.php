<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0001" && $_SESSION["employee"]["etype"]!=="J0002")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
include('../lib/connection.php'); // attach db connection
$meta_title = "Generate Reports";
$c_page = 'reports';
$page_title='Generate Reports';
$page_action='';

?>
<?php include('../inc-head.php');?> <!-- attach inc-head.php -->
<style>
	.monthpicker > .ui-datepicker-calendar {
    display: none;
    }
</style>
</head>

<body onLoad="startTime();">
<?php include('../inc-header.php');?> <!-- attach inc-header.php -->
	<div class="page-body container-fluid">
    	<div class="container inner">
        	<div class="page-title clearfix">
                <h1 class="pull-left"><?php  echo $page_title ?></h1>
                <div class="page-top-action pull-right">
                </div><!--end page-top-action--> 
    		</div><!-- end page-title --> 
           
            <div class="frmdiv">
           		<table class="frm-tbl table table-responsive">
                	<tr>
                    	<td class="col-md-3">
                        	<select class="form-control" id="cmbreporttype" name="cmbreporttype">
                                      <option value="">--Select Report Type--</option>
                                      <option value="dailySales">Daily Sales</option>
                                      <option value="dailyOnlineSales">Daily Online Sales</option>
                                      <option value="monthlySales">Mothly Sales</option>
                                      <option value="yearlySales">Yearly Sales</option>
                                      <option value="dailyStock">Daily Stock</option>
                                      <option value="dailyStockReorderLvl">Daily Stock Reoreder Level</option>
                             </select>         
                        </td>
                       
                        <td id="calandar" class="col-md-6">
							<form class="frm form-inline" action="" name="myForm" id="myForm" method="post" target="_blank">
							<div class="form-group">
								<label for="exampleInputName2">From</label>
								<input id="fromDate" name="fromDate" class="datepicker" value="">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail2">To</label>
								<input id="toDate" name="toDate" class="datepicker" value="">
							</div>
						</td>
                        <td id="genbtn" class="col-md-4"><button type="submit" class="btn btn-warning" id="myButton">Generate</button></form></td>
                    </tr>
                </table>   	
            </div><!--end frmdiv-->
        </div><!--end inner-->
     </div><!--end page-body-->  
     <?php include('../inc-footer.php'); ?>     
</body>
</html>
<script type="text/javascript">
$(document).ready(function(e) {
	$('#cmbreporttype').change(function(){
		var reptype=$('#cmbreporttype').val();
		if(reptype=='dailySales'){
			$('#myForm').attr('action','dailysales.php');
			$('#fromDate').attr('class','datepicker');
			$('#fromDate').attr('name','dailysales_from');
			$('#toDate').attr('class','datepicker');
			$('#toDate').attr('name','dailysales_to');
			$( ".datepicker" ).datepicker({
				//showOn: "button",
				//buttonImage: "../images/calendarIcon.gif",
				//buttonImageOnly: true,
				dateFormat: 'yy-mm-dd',
				maxDate: new Date() 
			});
		}
		else if(reptype=='dailyOnlineSales'){
			$('#myForm').attr('action','dailyonlinesales.php');
			$('#fromDate').attr('class','datepicker');
			$('#fromDate').attr('name','dailyonlinesales_from');
			$('#toDate').attr('class','datepicker');
			$('#toDate').attr('name','dailyonlinesales_to');
			$( ".datepicker" ).datepicker({
				//showOn: "button",
				//buttonImage: "../images/calendarIcon.gif",
				//buttonImageOnly: true,
				dateFormat: 'yy-mm-dd',
				maxDate: new Date() 
			});
		}
		else if(reptype=='monthlySales'){
			$('#myForm').attr('action','monthlysales.php');
			$('#fromDate').attr('class','monthpicker');
			$('#fromDate').attr('name','monthlylysales_from');
			$('#toDate').attr('class','monthpicker');
			$('#toDate').attr('name','monthlylysales_to');
			$('.monthpicker').datepicker( {
				//showOn: "button",
				//buttonImage: "../images/calendarIcon.gif",
				//buttonImageOnly: true,	
				changeMonth: true,
				changeYear: true,
				//showButtonPanel: true,
				dateFormat: 'yy-mm',
				maxDate: new Date(), 
				
				onClose: function(dateText, inst) { 
					var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
					var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
					$(this).datepicker('setDate', new Date(year, month, 1));
				}
			 });
		}
		else if(reptype=='yearlySales'){
			$('#myForm').attr('action','yearlysales.php');
			$('#fromDate').attr('class','yearpicker');
			$('#fromDate').attr('name','yearlylysales_from');
			$('#toDate').attr('class','yearpicker');
			$('#toDate').attr('name','yearlylysales_to');
			$('.yearpicker').datepicker( {
				//showOn: "button",
				//buttonImage: "../images/calendarIcon.gif",
				//buttonImageOnly: true,	
				changeYear: true,
				//showButtonPanel: true,
				dateFormat: 'yy',
				maxDate: new Date(), 
				
				onClose: function(dateText, inst) { 
					var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
					$(this).datepicker('setDate', new Date(year, 1));
				}
			 });
		}
		else if(reptype=='dailyStock'){
			$('#myForm').attr('action','dailystock.php');
			$('#fromDate').attr('class','datepicker');
			$('#fromDate').attr('name','dailystock_from');
			$('#toDate').attr('class','datepicker');
			$('#toDate').attr('name','dailystock_to');
			$( ".datepicker" ).datepicker({
				//showOn: "button",
				//buttonImage: "../images/calendarIcon.gif",
				//buttonImageOnly: true,
				dateFormat: 'yy-mm-dd',
				maxDate: new Date() 
			});
		}
		else if(reptype=='dailyStockReorderLvl'){
			$('#myForm').attr('action','daily_stock_reorder.php');
			$('#fromDate').attr('class','datepicker');
			$('#fromDate').attr('name','dailyrestock_from');
			$('#toDate').attr('class','datepicker');
			$('#toDate').attr('name','dailyrestock_to');
			$( ".datepicker" ).datepicker({
				//showOn: "button",
				//buttonImage: "../images/calendarIcon.gif",
				//buttonImageOnly: true,
				dateFormat: 'yy-mm-dd',
				maxDate: new Date() 
			});
		}
	});
	
	$( ".datepicker" ).datepicker({
		showOn: "button",
        buttonImage: "../images/calendarIcon.gif",
        buttonImageOnly: true,
		dateFormat: 'yy-mm-dd',
		maxDate: new Date() 
	});
});//end doc ready	 
  </script>