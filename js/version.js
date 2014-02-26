$( window ).ready(function() {
setTimeout(function() {
    var cookie = $.cookie('rigwatch_version');
    
    if (typeof cookie == 'undefined') {    
        $.ajax({
            type: 'get',
            url: 'https://api.github.com/repos/scar45/rigWatch/releases',
            dataType: 'json',
            crossDomain: 'true'
        }).done(function(data) {
            if (data[0].tag_name != CURRENT_VERSION) {
//                $.cookie('rigwatch_version', true, { expires: 3, path: '/' });
                $('.current', '#alert-update').html(CURRENT_VERSION);
                $('.latest', '#alert-update').html(data[0].tag_name);
                $('#alert-update').slideDown('fast');
            } else {
                $.removeCookie('rigwatch_version', { path: '/' });
            }
        });
    }
}, 2500);
});
