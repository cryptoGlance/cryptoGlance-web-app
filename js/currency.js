function Currency() {
    this.getLtcUsd();
};

Currency.prototype.getLtcUsd = function() {
    
    $.ajax({
        type: 'post',
        url: '/rigwatch/includes/ltc_usd.php',
        dataType: 'json',
        success: function(data) {
            $('.ltc-usd').find('div.stat-value').html('$' + data.ticker.low);
        }
    });
};

//Currency.prototype.getBtcUsd = function() {
//    
//    $.ajax({
//        type: 'post',
//        url: 'https://btc-e.com/api/2/btc_usd/ticker',
//        dataType: 'jsonp',
//        success: success,
//        crossDomain: true
//    });
//};
//
Currency.prototype.getLctBtc = function() {
    
    $.ajax({
        type: 'post',
        url: '/rigwatch/includes/ltc_btc.php',
        dataType: 'json',
        success: function(data) {
            $('.ltc-btc').find('div.stat-value').html(data.ticker.low);
        }
    });
};

var c = new Currency();
setInterval(function(){c.getLtcUsd();}, 5000);

var ltcBtc = new Currency();
setInterval(function(){ltcBtc.getLctBtc();}, 5000);

//c.getBtcUsd();
//c.getLctBtc();

