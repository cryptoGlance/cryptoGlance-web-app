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
  }

  /*-----  End of PoolCollection Class/Object/Constructor  ------*/


  /*=====================================================
  =            PoolCollection Public Methods            =
  =====================================================*/

  PoolCollection.prototype.start = function () {
    $.ajax({
      url: 'ajax.php?type=pools&action=update',
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

  /*-----  End of PoolCollection Public Methods  ------*/


  /*======================================================
  =            PoolCollection Private Methods            =
  ======================================================*/

  PoolCollection.prototype._add = function(poolId) {
    this.collection.push(new Pool(poolId))
  }

  PoolCollection.prototype._update = function (poolList) {
    this.collection.forEach(function (pool, index) {
      pool.update(poolList[index])
    })
  }

  /*-----  End of PoolCollection Private Methods  ------*/


  /*=============================================
  =            Export PoolCollection            =
  =============================================*/

  root.PoolCollection = PoolCollection

  /*-----  End of Export PoolCollection  ------*/

}(window, window.jQuery)
