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
    // body...
  }

  WalletCollection.prototype.add = function (walletId) {
    this.collection.push(new Wallet(walletId))
  }

  /*-----  End of WalletCollection Public Methods  ------*/


  /*========================================================
  =            WalletCollection Private Methods            =
  ========================================================*/



  /*-----  End of WalletCollection Private Methods  ------*/


  /*===============================================
  =            Export WalletCollection            =
  ===============================================*/

  root.WalletCollection = WalletCollection

  /*-----  End of Export WalletCollection  ------*/

}(window, window.jQuery)
