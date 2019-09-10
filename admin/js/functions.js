// JavaScript Document
function confirmUpdate(update_url) //submit button click data upadation confirmation
{
	var usereq=confirm("Are you sure you want to update the details?");
	if(usereq=='true'){
		window.location=update_url+'&s=1';
	}
	/*$.jAlert({
	type:'confirm',
	title:'Confirmation',
	theme:'yellow',
	confirmQuestion: 'Are you sure you want to Update the Details?',
	onConfirm:function(){
			window.location= update_url;
		}
	});*/
}

function confirmDelete(delete_url) //delete link click data deletion confirmation
{
	$.jAlert({
		type:'confirm',
		title:'Confirmation',
		theme:'yellow',
		confirmationQuestion:'Are you sure you want to Delete the selected record?',
		onConfirm:function(){
			window.location= delete_url;
		}
	});
}

$(function() {
	$(document).on("click", ".btnLoadBrand, .btntoggle", function(e) {	//click on button btnLoadBrand in product.php
		e.preventDefault();
		var elem = $(this).attr('data-type');
		$.post('brand.php?action=' + elem, {}, function(data, status) {
			if (status == 'success') {
				$(".loadExt").html(data);
			}
			else {
				// connection failed action
			}
		});
	});

	$(document).on("click", ".btnLoadCat, .btntoggle", function(e) { //click on button btnLoadCat in product.php
		e.preventDefault();
		var elem = $(this).attr('data-type');//data-type set on the button as add 
		$.post('category.php?action=' + elem, {}, function(data, status) {
			if (status == 'success') {
				$(".loadExt2").html(data);
			}
			
		});
	});
	
	$(document).on("click", ".btnLoadOrderPrdData, .btntoggle", function(e) {
		e.preventDefault();
		var elem = $(this).attr('data-type');
		var invid=$(this).attr('data-id');
		$.post('detail_order.php?action=' + elem, {invid:invid}, function(data,status) {
			if (status == 'success') {
				$(".loadExt3").html(data);
			}
			else {
				// connection failed action
			}
		});
	});
	
	$(document).on("click", ".btnAddCusDetails, .btntoggle", function(e) {
		e.preventDefault();
		var elem = $(this).attr('data-type');
		$.post('cus_modal.php?action=' + elem, function(data,status) {
			if (status == 'success') {
				$(".loadExt4").html(data);
			}
			else {
				// connection failed action
			}
		});
	});
});//document.ready()




/*$(document).on("click", ".btnedit", function(e) {// click on edit link btnedit in the view category table in category.php?action=view
		e.preventDefault();
		var elem = $(this).attr('data-type');
		var c_id = $(this).attr('data-id');
		$.post('category.php?action=' + elem + '&id=' + c_id, {}, function(data, status) { 
			if (status == 'success') {
				$(".loadExt2").html(data);
			}
			else {
				// connection failed action
			}
		});
	});*/
