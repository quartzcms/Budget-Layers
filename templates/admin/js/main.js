$('#select_all').click(function() {
    var checkboxes = $(this).closest('form').find(':checkbox');
    if($(this).is(':checked')) {
        checkboxes.prop("checked", true);
    } else {
        checkboxes.prop("checked", false);
    }
	
	
});

$(document).ready(function () {
	if($('#date').length > 0){
		$('#date').datetimepicker({
			format: 'Y-m-d',
			timepicker:false
		});
		
		$('#time').datetimepicker({
			 format: 'H:i:s',
			 datepicker:false
		});
	}
});