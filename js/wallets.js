// Update call by seconds
setInterval(function() {
    ajaxUpdateCall('wallet');
}, walletUpdateTime);


function updateWallets (data) {
    var walletPanel = $('#wallet');
    var addressesPanel = $(walletPanel).find('.panel-body-addresses');
    $(addressesPanel).html('');
    $.each(data, function( walletIndex, wallet) {
        var walletId = (walletIndex+1);
        $(addressesPanel).append('<div class="stat-pair" id="wallet-address-'+ walletId +'"><div class="stat-value"><img src="images/icon-'+ wallet.currency +'.png" alt="'+ wallet.currency +'" /><span class="green">'+ wallet.balance +' '+ wallet.currency_code +'</span><span class="address-label">in '+'<b>'+ wallet.total_addresses +'</b> address(es)</span></div><div class="stat-label"><a href="#" class="stat-pair-icon">'+ wallet.label +' <i class="icon icon-walletalt"></i></a></div></div>');
    });
}