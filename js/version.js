$( window ).ready(function() {
setTimeout(function() {
    var cookie = $.cookie('cryptoglance_version');
    
    if (typeof cookie == 'undefined') {    
        $.ajax({
            type: 'get',
            url: 'https://api.github.com/repos/cryptoGlance/cryptoGlance-web-app/releases',
            dataType: 'json',
            crossDomain: 'true'
        }).done(function(data) {
            if (data[0].tag_name != CURRENT_VERSION) {
                $('.current', '#alert-update').html(CURRENT_VERSION);
                $('.latest', '#alert-update').html(data[0].tag_name);
                $('#alert-update').slideDown('fast');
            } else {
                $.removeCookie('cryptoglance_version', { path: '/' });
            }
        });
    }
}, 2500);
});
