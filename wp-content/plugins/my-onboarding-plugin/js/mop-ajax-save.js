jQuery(document).ready( function($) {    
    $('#checkbox').click(function(){

	    var data = {
	 	    'action': 'mop_save',
	 	    'checked': $(this).prop("checked"),
	    };
        jQuery.post(ajax_object.ajax_url, data, function(response) {
	 	    console.log('Got this from the server: ' + response);
	    });
    });
});