!function (root, $) {

  /*=================================================================
  =            PoolPicker Class/Object/Constructor            =
  =================================================================*/

  var PoolPicker = function () {
    this.apiData                 = { type: 'pool-picker', action: 'update' }
    this.ready                   = true

    this.$poolPickerOverview = $('#pool-picker .panel-poolPicker')
  }

  /*-----  End of PoolPicker Class/Object/Constructor  ------*/

  /*=======================================================
  =            PoolPicker Public Methods            =
  =======================================================*/

    PoolPicker.prototype.start = function () {
        if ($('#pool-picker').length == 0) {
            return false;
        }

        var _self = this // caching self ref for passing down in scope

        /*==========  Initial data call  ==========*/
        this._getData(function (data) {

            /*==========  Initial wallet update in DOM  ==========*/
            _self._update(data);

            /*==========  Setup polling  ==========*/
            setInterval(function () {
                if (_self.ready) {
                    _self.ready = false
                    _self._getData(function (data) {
                        _self._update(data)
                    })
                }
            }, 3600000);
        })
    }

    PoolPicker.prototype.update = function (cached) {
        var _self = this

        cached = typeof cached !== 'undefined' ? cached : 1;
        if (cached == 0)  {
            _self.apiData.cached = 0;
        }

        _self._getData(function (data) {
            _self._update(data)
        })

        delete _self.apiData.cached;

        return true;
    }


  /*-----  End of PoolPicker Public Methods  ------*/

  /*========================================================
  =            PoolPicker Private Methods            =
  ========================================================*/

  PoolPicker.prototype._update = function (data) {
    var _self = this // caching self ref for passing down in scope

    var poolPickerOverviewHtml = '';

    for (var algorithm in data) {
        poolPickerOverviewHtml += '<div class="stat-pair">' +
            '<div class="stat-value">';

        data[algorithm].forEach(function (pool, index) {
            poolPickerOverviewHtml += '<span>' +
                '<i class="icon icon-square'+ (index+1) +'"></i>&nbsp;&nbsp;' +
                '<span>'+ pool.name +'</span> - <span>'+ pool.btc +' BTC/'+ pool.metric +'</span>' +
            '</span><br />';

        });

        poolPickerOverviewHtml += '</div>' +
            '<div class="stat-label">'+ algorithm +'</div>' +
        '</div>';
    }

    this.$poolPickerOverview.html(poolPickerOverviewHtml);
    this.ready = true;
  }

  PoolPicker.prototype._getData = function (callback) {
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

  /*-----  End of PoolPicker Private Methods  ------*/

  /*===============================================
  =            Export PoolPicker            =
  ===============================================*/

  root.PoolPicker = PoolPicker

  /*-----  End of Export PoolPicker  ------*/

}(window, window.jQuery)

!function ($){

  /*===================================
  =          The Pool Picker          =
  ===================================*/

    var poolPicker = new PoolPicker()
    poolPicker.start()


    // Edit PoolPicker
    $document.on('click', '.btn-edit-poolPicker', function (evt) {
        var $editPoolPicker = $('#poolPicker')
        $('.title-add', $editPoolPicker).hide();
        $('.title-edit', $editPoolPicker).show();

        // Get Pool Config:
        $.ajax({
            type: 'get',
            data: {
                type: 'pool-picker',
                action: 'config'
            },
            url: 'ajax.php',
            dataType: 'json'
        })
        .done(function (data) {
            $.each(data, function(k, v) {
                $editPoolPicker.find('input[value="'+ v +'"]').bootstrapSwitch('toggleState');
            });
        });

        prettifyInputs()
    });

  /*-----  End of The Pool Picker  ------*/

}(window.jQuery);
