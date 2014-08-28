!function (root, $) {

  /*=======================================================
  =            Wallet Class/Object/Constructor            =
  =======================================================*/

  var Wallet = function (walletId) {
    this.id              = walletId
    this.currency        = 'CDN'
    this.balance         = 0
    this.btc             = 0
    this.btc_code        = 'BTC'
    this.fiat            = 0
    this.fiat_code       = 0
    this.currency_code   = 0
    this.total_addresses = 0
    this.label           = 'money'
  }

  /*-----  End of Wallet Class/Object/Constructor  ------*/


  /*=============================================
  =            Wallet Public Methods            =
  =============================================*/

  Wallet.prototype.update = function (walletObj) {
    this.label              = walletObj.label
    this.currency           = walletObj.currency
    this.currency_balance   = walletObj.currency_balance
    this.currency_code      = walletObj.currency_code
    this.coin_balance       = walletObj.coin_balance
    this.coin_code          = walletObj.coin_code
    this.coin_price          = walletObj.coin_price
    this.fiat_balance       = walletObj.fiat_balance
    this.fiat_code          = walletObj.fiat_code
    this.total_addresses    = walletObj.total_addresses

    return this._buildStatusHtml()
  }

  /*-----  End of Wallet Public Methods  ------*/


  /*==============================================
  =            Wallet Private Methods            =
  ==============================================*/

  Wallet.prototype._buildStatusHtml = function () {
    var  output = '<div class="stat-pair" id="wallet-address-' + this.id + '">' +
        '<img src="images/coin/' + this.currency + '.png" alt="' + this.currency + '" />' +
        '<div class="stat-value">' +
        '<span class="green">' + this.currency_balance + ' ' + this.currency_code + '</span>';

    if (this.currency_code != this.coin_code) {
        output += '<span class="blue">' + this.coin_balance + ' ' + this.coin_code +'</span>' +
            '<span class="blue">' + this.fiat_balance + ' ' + this.fiat_code + '</span>' +
            '<span class="address-label">in ' + '<b>' + this.total_addresses + '</b> address(es)</span>' +
            '<span class="address-label">(' + this.coin_price + ' ' + this.coin_code +')</span>';
    } else {
        output += '<span class="blue">' + this.fiat_balance + ' ' + this.fiat_code + '</span>' +
            '<span class="address-label">in ' + '<b>' + this.total_addresses + '</b> address(es)</span>';
    }

    output += '</div>' +
        '<div class="stat-label">' +
        '<a href="wallet.php?id=' + this.id + '" class="stat-pair-icon">' + this.label + ' <i class="icon icon-walletalt"></i></a>' +
        '</div>' +
        '</div>';

    return output;
  }

  /*-----  End of Wallet Private Methods  ------*/


  /*=====================================
  =            Export Wallet            =
  =====================================*/

  // root.Wallet = Wallet
  root.WalletCollection.prototype.SubClass = Wallet

  /*-----  End of Export Wallet  ------*/

}(window, window.jQuery)
