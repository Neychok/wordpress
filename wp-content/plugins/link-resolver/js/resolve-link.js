jQuery(document).ready( function($) {    
    $('#lr-search').click(function () {
        const data = {
            'action': 'lr_search',
            'url': $('#link-field').val(),
            'expiry': $('#expiry-field').val(),
        }
        // Makes a POST request and puts the response in the inner html of #url-content 
        jQuery.post(ajax_object.ajax_url, data, function(response) {
            $("#url-content").html(response)
        });
    })
});