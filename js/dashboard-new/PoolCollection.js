/**

  TODO:
  - scaffold PoolCollection class

**/

!function (root, $) {

  /*===============================================================
  =            PoolCollection Class/Object/Constructor            =
  ===============================================================*/

  var PoolCollection = function () {
    this.collection = []
    this.apiData = {
      type: 'pools',
      action: 'update'
    }
  }

  /*-----  End of PoolCollection Class/Object/Constructor  ------*/


  /*=====================================================
  =            PoolCollection Public Methods            =
  =====================================================*/

  PoolCollection.prototype.start = function () {
    var _self = this

    /*==========  Initial data call  ==========*/
    _self._getData(function (pools) {

      console.log(pools.length)

      /*==========  Generate collection  ==========*/
      pools.forEach(function (pool, index) {
        _self._add(index)
      })

      console.log(_self.collection.length)

      /*==========  Initial wallet update in DOM  ==========*/
      _self._update(pools)

      /*==========  Setup polling  ==========*/
      setInterval(function () {
        _self._getData(function (pools) {
          _self._update(pools)
        })
      }, window.interval)
    })
  }

  /*-----  End of PoolCollection Public Methods  ------*/


  /*======================================================
  =            PoolCollection Private Methods            =
  ======================================================*/

  PoolCollection.prototype._add = function (poolId) {
    this.collection.push(new Pool(poolId))
  }

  PoolCollection.prototype._update = function (pools) {
    var _self = this
    _self.collection.forEach(function (pool, index) {
      pool.update(pools[index])
    })
  }

  PoolCollection.prototype._getData = function (callback) {
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
      console.error(message)
    })
    .done(callback)
  }

  /*-----  End of PoolCollection Private Methods  ------*/


  /*=============================================
  =            Export PoolCollection            =
  =============================================*/

  root.PoolCollection = PoolCollection

  /*-----  End of Export PoolCollection  ------*/

}(window, window.jQuery)
