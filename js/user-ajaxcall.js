jQuery(document).ready(function($) {
    console.log('user ajax call working');
    $( '.row-val' ).on('click', '.show-data', function(event) {
        var data = {
            'action': 'my_action',
            'id': 'ajax request success'      
        };
        
        // $.post(ajax_object.ajaxurl, data, function(response) {
        //     alert('Got this from the server: ' + response);
        // });
    });
});