jQuery(document).ready( function($) {    
    $('input:checkbox').change(function(){

		console.log('button clicked')
	    var data = {
	 	    'action': 'st_save',
	 	    'checked': $(this).prop("checked"),
			'post_id': $(this).prop("value"),
	    };
        jQuery.post(ajax_object.ajax_url, data, function(response) {
	 	    console.log('Got this from the server: ' + response);
	    });
    });
});