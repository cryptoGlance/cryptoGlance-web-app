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
  }

  /*-----  End of WalletCollection Class/Object/Constructor  ------*/

  /*=======================================================
  =            WalletCollection Public Methods            =
  =======================================================*/

  WalletCollection.prototype.start = function () {
    $.ajax({
      url: 'ajax.php?type=wallets&action=update',
      dataType: 'json',
      statusCode: {
        401: function() {
          window.location.assign('login.php');
        }
      }
    })
    .done(function (data) {
      console.log(data)
    })
  }

  /*-----  End of WalletCollection Public Methods  ------*/


  /*========================================================
  =            WalletCollection Private Methods            =
  ========================================================*/

  WalletCollection.prototype._add = function (walletId) {
    this.collection.push(new Wallet(walletId))
  }

  WalletCollection.prototype._update = function() {
    // body...
  }

  /*-----  End of WalletCollection Private Methods  ------*/


  /*===============================================
  =            Export WalletCollection            =
  ===============================================*/

  root.WalletCollection = WalletCollection

  /*-----  End of Export WalletCollection  ------*/

}(window, window.jQuery)
