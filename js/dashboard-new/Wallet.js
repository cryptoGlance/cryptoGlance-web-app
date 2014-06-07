/**

  TODO:
  - scaffold Wallet class

**/

!function (root, $) {

  /*=======================================================
  =            Wallet Class/Object/Constructor            =
  =======================================================*/

  var Wallet = function (walletId) {
    this.walletId = walletId
    this.$walletPanel = $('#wallet')
    this.$addressesPanel = this.$walletPanel.find('.panel-body-addresses')
  }

  /*-----  End of Wallet Class/Object/Constructor  ------*/


  /*=============================================
  =            Wallet Public Methods            =
  =============================================*/

  Wallet.prototype.start = function() {
    this.$addressesPanel.html('')

     $.each(data, function( walletIndex, wallet) {
        this.$addressesPanel.append('<div class="stat-pair" id="wallet-address-'+ walletId +'">' +
                                 '<div class="stat-value">' +
                                 '<img src="images/icon-'+ wallet.currency +'.png" alt="'+ wallet.currency +'" />' +
                                 '<span class="green">'+ wallet.balance +' '+ wallet.currency_code +'</span>' +
                                 '<span class="address-label">in '+'<b>'+ wallet.total_addresses +'</b> address(es)</span>' +
                                 '</div>' +
                                 '<div class="stat-label">' +
                                 '<a href="wallet.php?id='+walletId+'" class="stat-pair-icon">'+ wallet.label +' <i class="icon icon-walletalt"></i></a>' +
                                 '</div>' +
                                 '</div>')
    });
  }

  /*-----  End of Wallet Public Methods  ------*/


  /*==============================================
  =            Wallet Private Methods            =
  ==============================================*/



  /*-----  End of Wallet Private Methods  ------*/


  /*=====================================
  =            Export Wallet            =
  =====================================*/

  root.Wallet = Wallet

  /*-----  End of Export Wallet  ------*/

}(window, window.jQuery)
