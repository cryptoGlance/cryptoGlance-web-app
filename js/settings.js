// BTN Updates
$('button').click(function(e) {
    if ($(this).attr('name') == 'clearCookies') {
        e.preventDefault();
        
        for (var cookie in $.cookie()) {
            $.removeCookie(cookie);
        }

        window.location.assign('logout.php');
    }
});