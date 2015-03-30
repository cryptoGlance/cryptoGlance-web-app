!function (root, $) {

  /*=================================================================
  =            WalletCollection Class/Object/Constructor            =
  =================================================================*/

  var WalletCollection = function () {
    this.collection          = []

    this.apiData             = { type: 'wallets', action: 'update' }
    this.walletOverviewHtml  = ''
    this._ready               = true

    this.$walletOverviewBody = $('#wallet .panel-body-addresses')
  }

  /*-----  End of WalletCollection Class/Object/Constructor  ------*/

  /*=======================================================
  =            WalletCollection Public Methods            =
  =======================================================*/

  WalletCollection.prototype.start = function () {
    var _self = this // caching self ref for passing down in scope

    /*==========  Initial data call  ==========*/
    this._getData(function (wallets) {

      /*==========  Generate collection  ==========*/
      wallets.forEach(function (wallet, index) {
        _self._add(index+1)
      })

      /*==========  Initial wallet update in DOM  ==========*/
      _self._update(wallets)

      /*==========  Setup polling  ==========*/
      setInterval(function () {
        if (_self._ready) {
          _self._ready = false
          _self._getData(function (wallets) {
            _self._update(wallets)
          })
        }
      }, root.walletUpdateTime)
    })
  }

  WalletCollection.prototype.update = function () {
    var _self = this

    _self.apiData.cached = 0;

    _self._getData(function (wallets) {
        _self._update(wallets)
    })

    delete _self.apiData.cached;
  }


  /*-----  End of WalletCollection Public Methods  ------*/


  /*========================================================
  =            WalletCollection Private Methods            =
  ========================================================*/

  WalletCollection.prototype._add = function (walletId) {
    this.collection.push(new this.SubClass(walletId))
  }

  WalletCollection.prototype._update = function (wallets) {
    var _self = this // caching self ref for passing down in scope

    this.walletOverviewHtml = ''
    this.collection.forEach(function (wallet, index) {
      _self.walletOverviewHtml += wallet.update(wallets[index])
    })
    this.$walletOverviewBody.html(this.walletOverviewHtml)
    this._ready = true
  }

  WalletCollection.prototype._getData = function (callback) {
    var _self = this // caching self ref for passing down in scope

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
      //console.error(xhr, status, message)
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
