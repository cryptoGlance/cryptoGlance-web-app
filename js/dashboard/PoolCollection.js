!function (root, $) {

  /*===============================================================
  =            PoolCollection Class/Object/Constructor            =
  ===============================================================*/

  var PoolCollection = function () {
    this.collection = []
    this.apiData    = { type: 'pools', action: 'update' }
    this.ready      = true
  }

  /*-----  End of PoolCollection Class/Object/Constructor  ------*/


  /*=====================================================
  =            PoolCollection Public Methods            =
  =====================================================*/

  PoolCollection.prototype.start = function () {
    var _self = this // caching self ref for passing down in scope

    /*==========  Generate collection  ==========*/
    $('.panel-pool').each(function () {
      _self._add(this.getAttribute('data-id'))
    })

    /*==========  Initial data call  ==========*/
    this._getData(function (pools) {

      /*==========  Initial pools update in DOM  ==========*/
      _self._update(pools)

      /*==========  Setup polling  ==========*/
      setInterval(function () {
        if (_self.ready) {
          _self.ready = false
          _self._getData(function (pools) {
            _self._update(pools)
          })
        }
      }, root.poolUpdateTime)
    })
  }

  /*-----  End of PoolCollection Public Methods  ------*/


  /*======================================================
  =            PoolCollection Private Methods            =
  ======================================================*/

  PoolCollection.prototype._add = function (poolId) {
    this.collection.push(new this.SubClass(poolId))
  }

  PoolCollection.prototype._update = function (pools) {
    var _self = this // caching self ref for passing down in scope

    this.collection.forEach(function (pool, index) {
      pool.update(pools[index])
    })
    this.ready = true
  }

  PoolCollection.prototype._getData = function (callback) {
    var _self = this // caching self ref for passing down in scope

    $.ajax({
      url: 'ajax.php',
      data: _self.apiData,
      dataType: 'json'
    })
    .fail(function (xhr, status, message) {
      //console.error(message)
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
