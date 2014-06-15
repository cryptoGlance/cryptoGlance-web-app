/**

  TODO:
  - scaffold WalletCollection class

**/

!function (root, $) {

  /*=================================================================
  =            WalletCollection Class/Object/Constructor            =
  =================================================================*/

  var WalletCollection = function () {
    this.collection = []

    this.apiData = {
      type: 'wallets',
      action: 'update'
    }
    this.walletOverviewHtml = ''

    this.$walletOverviewBody = $('#wallet .panel-body')
  }

  /*-----  End of WalletCollection Class/Object/Constructor  ------*/

  /*=======================================================
  =            WalletCollection Public Methods            =
  =======================================================*/

  WalletCollection.prototype.start = function () {
    var _self = this

    _self._getData(function (wallets) {
      wallets.forEach(function (wallet, index) {
        _self._add(index)
      })
      console.log(_self.collection)
      setInterval(function () {
        _self._update()
      }, window.interval)
    })
  }

  /*-----  End of WalletCollection Public Methods  ------*/


  /*========================================================
  =            WalletCollection Private Methods            =
  ========================================================*/

  WalletCollection.prototype._add = function (walletId) {
    this.collection.push(new Wallet(walletId))
  }

  WalletCollection.prototype._update = function () {
    var _self = this
    _self.walletOverviewHtml = ''
    _self._getData(function (wallets) {
      _self.collection.forEach(function (wallet, index) {
        _self.walletOverviewHtml += wallet.update(wallets[index])
      })
    })
    _self.$walletOverviewBody.html(_self.walletOverviewHtml)
  }

  WalletCollection.prototype._getData = function (callback) {
    var _self = this
    $.ajax({
      url: 'ajax.php',
      data: _self.apiData,
      dataType: 'json',
      statusCode: {
        401: function() {
          window.location.assign('login.php');
        }
      }
    })
    .fail(function (xhr, status, message) {
      console.error(xhr, status, message)
    })
    .done(callback)
  }

  /*-----  End of WalletCollection Private Methods  ------*/


  /*===============================================
  =            Export WalletCollection            =
  ===============================================*/

  root.WalletCollection = WalletCollection

  /*-----  End of Export WalletCollection  ------*/

}(window, window.jQuery)
