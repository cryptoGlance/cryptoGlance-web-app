!function (root, $) {

  /*=======================================================
  =            Wallet Class/Object/Constructor            =
  =======================================================*/

  var Wallet = function (walletId) {
    this.id              = walletId
    this.currency        = 'CDN'
    this.balance         = 0
    this.currency_code   = 0
    this.total_addresses = 0
    this.label           = 'money'
  }

  /*-----  End of Wallet Class/Object/Constructor  ------*/


  /*=============================================
  =            Wallet Public Methods            =
  =============================================*/

  Wallet.prototype.update = function (walletObj) {
    this.currency        = walletObj.currency
    this.balance         = walletObj.balance
    this.currency_code   = walletObj.currency_code
    this.total_addresses = walletObj.total_addresses
    this.label           = walletObj.label

    return this._buildStatusHtml()
  }

  /*-----  End of Wallet Public Methods  ------*/


  /*==============================================
  =            Wallet Private Methods            =
  ==============================================*/

  Wallet.prototype._buildStatusHtml = function () {
    return '<div class="stat-pair" id="wallet-address-' + this.id + '">' +
           '<div class="stat-value">' +
           '<img src="images/icon-' + this.currency + '.png" alt="' + this.currency + '" />' +
           '<span class="green">' + this.balance + ' ' + this.currency_code + '</span>' +
           '<span class="address-label">in ' + '<b>' + this.total_addresses + '</b> address(es)</span>' +
           '</div>' +
           '<div class="stat-label">' +
           '<a href="wallet.php?id=' + this.id + '" class="stat-pair-icon">' + this.label + ' <i class="icon icon-walletalt"></i></a>' +
           '</div>' +
           '</div>'
  }

  /*-----  End of Wallet Private Methods  ------*/


  /*=====================================
  =            Export Wallet            =
  =====================================*/

  // root.Wallet = Wallet
  root.WalletCollection.prototype.SubClass = Wallet

  /*-----  End of Export Wallet  ------*/

}(window, window.jQuery)
