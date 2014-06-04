// Update call by seconds
setInterval(function() {
    ajaxUpdateCall('pool');
}, poolUpdateTime);


function updatePools (data) {
    $.each(data, function(poolIndex, pool) {
        var poolId = (poolIndex+1);
        var poolElm = $('#pool-'+poolId);
        var poolContentElm = $('.panel-body-stats', poolElm);
        
        if (pool == null || typeof pool == 'undefined') {
            return true;
        }
        
        $(poolContentElm).html('');
        $.each(pool, function (k,v) {
            var pairClass = '';
            if (k == 'type') {
                return true;
            } else if (k == 'balance' || k == 'paid_BTC' || k == 'paid_NMC') {
                pairClass = 'green';
            } else if (k == 'unconfirmed_balance' || k == 'unpaid_BTC' || k == 'unpaid_NMC') {
                pairClass = 'red';
            } else if (k == 'last_block' && pool.type == 'mpos' && typeof pool.url != 'undefined') {
                v = '<a href="'+ pool.url +'/index.php?page=statistics&action=round&height='+v+'" target="_blank" rel="external">'+v+'</a>';
            }
            
            $(poolContentElm).append('<div class="stat-pair"><div class="stat-value"><span class="'+pairClass+'">'+v+'</span></div><div class="stat-label">'+k.replace(/_|-|\./g, ' ')+'</div></div>');
        });
    });
}