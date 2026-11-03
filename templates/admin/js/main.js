$('#select_all').click(function() {
    var checkboxes = $(this).closest('form').find(':checkbox');
    if($(this).is(':checked')) {
        checkboxes.prop("checked", true);
    } else {
        checkboxes.prop("checked", false);
    }
	
	
});
