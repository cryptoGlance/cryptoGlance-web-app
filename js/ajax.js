var ajaxCall = ['all', 'rig', 'pool', 'wallet'];

ajaxUpdateCall('all');

// BTN Updates
$('.btn-updater').click(function() {
    if ($(this).attr('data-type') == 'all') {
        ajaxUpdateCall('all');
    } else {
        ajaxUpdateCall($(this).attr('data-type'), $(this).attr('data-attr'));
    }
});

// Update json data
function ajaxUpdateCall(action, actionAttr) {
    var queryUrl = action;
    if (typeof actionAttr != 'undefined') {
        queryUrl = action + '&attr=' + actionAttr;
    }
    
    if (typeof ajaxCall[action] == 'object') {
        ajaxCall[action].abort();
    }
    
    ajaxCall[action] = $.ajax({
        type: 'post',
        url: 'ajax.php?type=update&action=' + queryUrl,
        dataType: 'json',
        statusCode: {
            401: function() {
                window.location.assign('login.php');
            }
        }
    }).done(function(data) {
        if (typeof data.rigs != 'undefined') {
            updateRigs(data.rigs);
        }
        if (typeof data.pools != 'undefined') {
            updatePools(data.pools);
        }
        if (typeof data.wallets != 'undefined') {
            updateWallets(data.wallets);
        }
    });
}