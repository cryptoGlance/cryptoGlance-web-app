!function (root, $) {

  /*===============================================================
  =              MobileMiner Class/Object/Constructor             =
  ===============================================================*/

  var MobileMiner = function () {
    this.apiData    = { type: 'mobile-miner', action: 'update' }
  }

  /*-----  End of MobileMiner Class/Object/Constructor  ------*/


  /*=====================================================
  =              MobileMiner Public Methods             =
  =====================================================*/

  MobileMiner.prototype.start = function () {
    var _self = this;

    /*==========  Initial Poll  ==========*/
    _self._getData();

    /*==========  Setup polling  ==========*/
    setInterval(function () {
        _self._getData();
    }, 40000); // every 40 seconds
  }

  /*-----  End of MobileMiner Public Methods  ------*/


  /*======================================================
  =              MobileMiner Private Methods             =
  ======================================================*/

  MobileMiner.prototype._getData = function () {
    var _self = this;

    $.ajax({
        url: 'ajax.php',
        data: _self.apiData,
        dataType: 'json'
    })
    .fail(function (xhr, status, message) {
        //console.error(message)
    })
  }

  /*-----  End of MobileMiner Private Methods  ------*/


  /*=============================================
  =            Export MobileMiner            =
  =============================================*/

  root.MobileMiner = MobileMiner

  /*-----  End of Export MobileMiner  ------*/

}(window, window.jQuery)
