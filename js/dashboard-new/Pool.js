/**

  TODO:
  - scaffold Pool class

**/

!function (root, $) {

  /*=====================================================
  =            Pool Class/Object/Constructor            =
  =====================================================*/

  var Pool = function (poolId) {
    this.poolId = poolId
    this.$poolEl = $('#pool-' + poolId)
    this.$poolContentElm = this.$poolEl.find('.panel-body-stats')
  }

  /*-----  End of Pool Class/Object/Constructor  ------*/


  /*===========================================
  =            Pool Public Methods            =
  ===========================================*/

  Pool.prototype.start = function() {
    this.$poolContentEl.html('')

    $.each(pool, function (k,v) {
      var pairClass = '';
      if (k == 'type') {
          return true;
      } else if (k == 'balance' || k == 'paid_BTC' || k == 'paid_NMC') {
          pairClass = 'green';
      } else if (k == 'unconfirmed_balance' || k == 'unpaid_BTC' || k == 'unpaid_NMC') {
          pairClass = 'red';
      } else if (k == 'last_block' && pool.type == 'mpos' && typeof pool.url != 'undefined') {
          v = '<a href="' + pool.url + '/index.php?page=statistics&action=round&height=' + v + '" target="_blank" rel="external">' + v + '</a>';
      }

      $(poolContentElm).append('<div class="stat-pair"><div class="stat-value"><span class="'+pairClass+'">'+v+'</span></div><div class="stat-label">'+k.replace(/_|-|\./g, ' ')+'</div></div>');
    })
  }

  /*-----  End of Pool Public Methods  ------*/


  /*============================================
  =            Pool Private Methods            =
  ============================================*/



  /*-----  End of Pool Private Methods  ------*/


  /*===================================
  =            Export Pool            =
  ===================================*/

  root.Pool = Pool

  /*-----  End of Export Pool  ------*/

}(window, window.jQuery)
