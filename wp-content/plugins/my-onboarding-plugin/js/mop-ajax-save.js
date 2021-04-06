jQuery(document).ready( function($) {    
    $('#mop-checkbox').change(function(){
	    var data = {
	 	    'action': 'mop_save',
	 	    'checked': $(this).prop("checked"),
	    };
        jQuery.post(ajax_object.ajax_url, data);
    });
});