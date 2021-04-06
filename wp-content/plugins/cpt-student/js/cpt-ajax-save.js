jQuery(document).ready( function($) {    
    $('input:checkbox').change(function(){
	    var data = {
	 	    'action': 'st_save',
	 	    'checked': $(this).prop("checked"),
			'post_id': $(this).prop("name"),
	    };
        jQuery.post(ajax_object.ajax_url, data);
    });
});