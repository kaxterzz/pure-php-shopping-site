// JavaScript Document
function confirmUpdate(update_url)
{
	$.jAlert({
	type:'confirm',
	title:'Confirmation',
	theme:'yellow',
	confirmQuestion: 'Are you sure you want to Update the Details?',
	onConfirm:function(){
			window.location= update_url;
		}
	});
	/*var userreq=confirm('Are you sure you want to Update the Details?');
	if (userreq==true)
	{
		window.location= update_url;
	}*/
}

function confirmDelete(delete_url)
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
	$(document).on("click", ".btnLoadPrdData, .btntoggle", function(e) {
		e.preventDefault();
		var elem = $(this).attr('data-type');
		var catid;
		var prdid=$(this).attr('data-id');
		$.post('prd_details.php?action=' + elem, {prdid:prdid}, function(data, status) {
			if (status == 'success') {
				$(".loadExt").html(data);
			}
			else {
				// connection failed action
			}
		});
	});
});