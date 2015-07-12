$( window ).ready(function() {
    if (typeof updateType != 'undefined') {
        setTimeout(function() {
            var cookie = $.cookie('cryptoglance_version');
            if (typeof cookie == 'undefined') {
                versionCheck();
            }
        }, 2500);
    }
});

function versionCheck(alwaysDisplayModal) {
    $.ajax({
        type: 'get',
        url: updateType,
        dataType: 'json',
        crossDomain: 'true'
    }).done(function(data) {
        if (data.commit.commit.message != CURRENT_VERSION) {
            showToastUpdate(CURRENT_VERSION, data.commit.commit.message);
            $('.icon-update-available').show();
        } else {
            if (typeof alwaysDisplayModal !== 'undefined' && alwaysDisplayModal == true) {
                showToastNoUpdate(CURRENT_VERSION);
            }
            $.removeCookie('cryptoglance_version');
            $('.icon-update-available').hide();
        }
    });
}
