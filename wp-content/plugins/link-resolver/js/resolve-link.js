jQuery(document).ready( function($) {    

    $('#lr-search').click(function () {
        console.log('button cicked')
        console.log(encodeURIComponent($('#link-field').val()))

        const data = {
            'action': 'lr_search',
            'url': "https://www.amazon.com/s?k=" + encodeURIComponent($('#link-field').val()),
        }
        jQuery.post(ajax_object.ajax_url, data, function(response) {
            console.log('Got this from the server: ' + response);
        });
    })

});