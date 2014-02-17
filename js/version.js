$( document ).ready(function() {
    var cookie = $.cookie('rigwatch_version');
    
    if (typeof cookie == 'undefined') {    
        $.ajax({
            type: 'get',
            url: 'https://api.github.com/repos/scar45/rigWatch/releases',
            dataType: 'json',
            crossDomain: 'true'
        }).done(function(data) {
            console.log('--- VERSION ---------------------');
            console.log('Current: ' + CURRENT_VERSION);
            console.log('Latest: ' + data[0].tag_name);
            console.log('-----------------------------------------');
            if (data.tag_name != CURRENT_VERSION) {
                $.cookie('rigwatch_version', true, { expires: 3, path: '/' });
                alert('Out of date! George needs to make a popup for this!');
            } else {
                $.removeCookie('rigwatch_version', { path: '/' });
            }
        });
    }
});
