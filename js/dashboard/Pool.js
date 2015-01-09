!function (root, $) {

  /*=====================================================
  =            Pool Class/Object/Constructor            =
  =====================================================*/

  var Pool = function (poolId) {
    this.poolId         = poolId
    this.$poolEl        = $('#pool-' + poolId)
    this.$poolContentEl = $('#pool-' + poolId +' .panel-body-stats')
  }

  /*-----  End of Pool Class/Object/Constructor  ------*/


  /*===========================================
  =            Pool Public Methods            =
  ===========================================*/

  Pool.prototype.update = function (poolObj) {
    var summary = ''

    for (var key in poolObj) {
      if (null === poolObj[key]) {
        summary += this._buildStatusHtml('', key, 'n/a')
        continue
      }

      switch (key) {
        case 'type':
          break
        case 'last_block':
          if (poolObj.type === 'mpos' &&  'undefined' !== typeof poolObj.url) {
            summary += this._buildStatusHtml('', key, '<a href="' + poolObj.url + '/index.php?page=statistics&action=round&height=' + poolObj[key] + '" target="_blank" rel="external">' + poolObj[key] + '</a>')
          }
          break
        case 'url':
          if ('undefined' !== typeof poolObj[key]) {
            summary += this._buildStatusHtml('', key, '<a href="' + poolObj[key] + '" target="_blank" rel="external" style="color: #c8c8c8;">' + poolObj[key] + '</a>')
          }
          break
        default:
            if (key.match(/unconfirmed/i) || key.match(/unpaid/i)) {
                summary += this._buildStatusHtml('red', key, poolObj[key])
            } else if (key.match(/balance/i) || key.match(/payout/i)) {
                summary += this._buildStatusHtml('green', key, poolObj[key])
            } else {
                summary += this._buildStatusHtml('', key, poolObj[key])
            }
      }
    }
    if (summary) {
      this.$poolContentEl.html(summary)
    }
  }

  /*-----  End of Pool Public Methods  ------*/


  /*============================================
  =            Pool Private Methods            =
  ============================================*/

  Pool.prototype._buildStatusHtml = function (_class, name, value) {
    return '<div class="stat-pair">' +
           '<div class="stat-value">' +
           '<span class="' + _class + '">' + value + '</span>' +
           '</div>' +
           '<div class="stat-label">' + name.replace(/_|-|\./g, ' ') + '</div>' +
           '</div>'
  }

  /*-----  End of Pool Private Methods  ------*/


  /*===================================
  =            Export Pool            =
  ===================================*/

  // root.Pool = Pool
  root.PoolCollection.prototype.SubClass = Pool

  /*-----  End of Export Pool  ------*/

}(window, window.jQuery)
