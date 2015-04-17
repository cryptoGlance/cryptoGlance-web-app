!function (root, $) {

  'use strict';

  /*==============================================================
  =            RigCollection Class/Object/Constructor            =
  ==============================================================*/

  var RigCollection = function () {
    this.collection         = []

    this.apiData            = { type: 'rigs', action: 'overview' }
    this.overallHashrate    = 0
    this._ready             = true
    this._rigsActive        = 0
    this._rigsResponded     = 0

    this.$overview          = $('#overview')
    this.$overviewTable     = $('#overview table')
    this.$overviewTableBody = $('#overview tbody')
    this.overviewTableData  = ''
  }

  /*-----  End of RigCollection Class/Object/Constructor  ------*/

  /*====================================================
  =            RigCollection Public Methods            =
  ====================================================*/

  RigCollection.prototype.start = function () {
    var _self = this; // caching self ref for passing down in scope

    /*==========  Generate collection  ==========*/
    $('.panel-rig').each(function() {
      _self._add(this.getAttribute('data-id'))
    })

    /*==========  Initial data call  ==========*/
    $.when(_self._getData()).done(function (data) {
        _self._buildOverview(data)

        _self.apiData = { type: 'rigs', action: 'update' }

        _self._update() // Populate all devices in the collection

        /*==========  Setup polling  ==========*/
        setInterval(function () {
          if (_self._ready) {
              _self._update() // Update both devices and summary stats
          }
      }, root.rigUpdateTime);
    });
  }

  /*-----  End of RigCollection Public Methods  ------*/

  /*=====================================================
  =            RigCollection Private Methods            =
  =====================================================*/

  RigCollection.prototype._add = function (rigId) {
      this.collection.push(new this.SubClass(rigId))
  }

  RigCollection.prototype._update = function () {
    var _self = this // caching self ref for passing down in scope
    var overviewData = [];

    if (_self._ready) {
        _self._ready = false;
        _self._rigsResponded = 0;

        var promises = $.map(this.collection, function (rig, index) {
            _self.apiData.id = rig.rigID;
            return _self._getData();
        });

        $.when.apply($, promises).done(function () {
            overviewData = $.map(arguments, function (arr, idx) {
                _self.collection[idx].update(arr[0])
                _self._rigsResponded++;
                return arr[0];
            })

            if (_self._rigsResponded === _self.collection.length) {
                _self._buildOverview(overviewData);
                $(document).trigger('masonry-update');
                _self._ready = true;
            }
        })
    } else {
        return false;
    }
  }

  RigCollection.prototype._getData = function () {
    var _self = this;

    var ajaxPromise = $.ajax({
        url: 'ajax.php',
        data: _self.apiData,
        dataType: 'json'
    });

    return ajaxPromise;
  }

  RigCollection.prototype._buildOverview = function (data) {
    var _self = this // caching self ref for passing down in scope

    var algorithms = { }

    function build(res, index) {
      if (res.overview) {
        res = res.overview
      }

      _self.overviewTableData += _self._buildOverviewRow(res, index + 1)
      _self.overallHashrate += parseFloat(res.hashrate_avg)

      if (typeof algorithms[res.algorithm] == 'undefined') {
        var algorithm = res.algorithm;
        algorithms[algorithm] = 0;
      }
      algorithms[res.algorithm] += parseFloat(res.hashrate_avg)
    }

    this.overviewTableData = ''
    this.overallHashrate = 0

    if (data.overview) {
      data = data.overview
    }

    data.forEach(build)

    this.overallHashrate = Util.getSpeed(this.overallHashrate)

    this.$overviewTableBody.html(this.overviewTableData)

    if (cG.showTotalHashrate == 'true') {
        var algorithmContainer = $('#total-hashrates li a');
        // get each hashrate
        var existingAlgorithms = [];
        algorithmContainer.each(function(k, v) {
            existingAlgorithms[$(v).attr('id').replace('hashrate_', '')] = k;
        });

        for (var key in algorithms) {
            if ($('#hashrate_' + key).length == 0) {
              var aTag = document.createElement('a');
              aTag.setAttribute('id',"hashrate_"+key);
              aTag.setAttribute('class',"total-hashrate hidden");
              $('#total-hashrates li').append(aTag)
            }
            $('#hashrate_' + key).removeClass('hidden').html('<span class="hashrate-algo">' + key + '</span>' + Util.getSpeed(algorithms[key]))

            if (typeof existingAlgorithms[key] != 'undefined') {
                delete existingAlgorithms[key];
            }
        }

        for (var key in existingAlgorithms) {
            $('#hashrate_' + key).remove();
            delete existingAlgorithms[key];
        }
    }

    this._updateDocumentTitle(this.overallHashrate)

  }

  RigCollection.prototype._updateDocumentTitle = function (str) {
    document.title = str + ' :: Dashboard (cryptoGlance)'
  }

  RigCollection.prototype._buildOverviewRow = function (overview, index) {
    var icon = overview.status.icon || 'ban-circle'
    var colour = overview.status.colour || 'grey'
    var hashrate_5s = colour !== 'grey' ? Util.getSpeed(overview.hashrate_5s) : '--'
    var hashrate_avg = colour !== 'grey' ? Util.getSpeed(overview.hashrate_avg) : '--'
    var active_pool_url = overview.active_pool.url || '--'
    var uptime = overview.uptime || '--'
    return '<tr data-rig="'+ index +'">' +
           '<td><i class="icon icon-'+ icon +' '+ colour +'"></i></td>' +
           '<td><a href="#rig-'+ index +'" class="anchor-offset rig-'+ index +' '+ colour +'">'+ $('#rig-'+ index + ' h1').html() +'</a></td>' +
           '<td>'+ overview.algorithm +'</td>' +
           '<td>'+ hashrate_avg +'</td>' +
           '<td>'+ hashrate_5s +'</td>' +
           '<td>'+ active_pool_url +'</td>' +
           '<td>'+ uptime +'</td>' +
           '</tr>'
  }

  /*-----  End of RigCollection Private Methods  ------*/

  /*====================================================
  =          RigCollection Actionable Methods          =
  ====================================================*/

    RigCollection.prototype.modal = new Object();

    RigCollection.prototype.manage = function (rigId) {
        var $manageRig = $('#manageRig');

        $manageRig.attr('data-attr', rigId);
        $manageRig.find('.rig-name').html($('#rig-' + rigId + ' h1').html());
        $manageRig.find('.btn-details').attr('href', 'rig.php?id=' + rigId);

        prettifyInputs();
    }

    RigCollection.prototype.modal.switchPools = function (rigId) {
        var $switchPoolModalBody = $('#switchPool .modal-body');
        $('.table tbody', $switchPoolModalBody).html('');
        $('.ajax-loader', $switchPoolModalBody).html('<img src="images/ajax-loader.gif" alt="Loading..." class="ajax-loader" />')
        $.ajax({
            url: 'ajax.php',
            data: {
                id: rigId,
                type: 'rigs',
                action: 'pools'
            },
            dataType: 'json'
        })
        .done(function (data) {
            if (typeof data != 'undefined') {
                $('#switchPool').attr('data-attr', rigId);
                $.each(data[0], function (v,k) {
                    var poolUrl = k.url.slice(k.url.indexOf("/") + 2)

                    var active = (k.active == 1) ? 'Yes' : 'No';
                    var status = (k.status == 1) ? 'Alive' : 'Dead';

                    $('.table tbody', $switchPoolModalBody).append(
                        '<tr data-pool="'+ k.id +'">' +
                        '<td>'+ k.id +'</td>' +
                        '<td>'+ '<input type="radio" name="switchPoolList" id="rig'+ rigId +'-pool'+ k.id +'" value="'+ k.id +'">' +'</td>' +
                        '<td>'+ status +'</td>' +
                        '<td>'+ poolUrl +'</td>' +
                        '<td>'+ k.priority +'</td>' +
                        '</tr>'
                    );

                    if (k.active == 1) {
                        $('input:radio[id=rig'+ rigId +'-pool'+ k.id +']', $switchPoolModalBody).prop('checked', true);
                    }
                });

                $switchPoolModalBody.find('.ajax-loader').remove()
                $('.table', $switchPoolModalBody).show();
                $('.resetStats', $switchPoolModalBody).show();
                prettifyInputs()
            }
        });
    }

    RigCollection.prototype.switchPools = function (rigId, selectedPoolId, resetStats) {
        var _self = this;

        $.ajax({
            type: 'post',
            data: {
                id: rigId,
                type: 'rigs',
                action: 'switch-pool',
                pool: parseInt(selectedPoolId, 10) + 1,
                reset: resetStats
            },
            url: 'ajax.php',
            dataType: 'json'
        })
        .done(function (data) {
            _self._update();
        });
    }

    RigCollection.prototype.restart = function (rigId) {
        var _self = this;

        $.ajax({
            type: 'post',
            data: {
                id: rigId,
                type: 'rigs',
                action: 'restart'
            },
            url: 'ajax.php',
            dataType: 'json'
        })
        .done(function (data) {
            _self._update();
        });
    }

    RigCollection.prototype.reset = function (rigId) {
        var _self = this;

        $.ajax({
            type: 'post',
            data: {
                id: rigId,
                type: 'rigs',
                action: 'reset-stats'
            },
            url: 'ajax.php',
            dataType: 'json'
        })
        .done(function (data) {
            _self._update();
        });
    }

  /*-----  End of RigCollection Actionable Methods  ------*/

  /*============================================
  =            RigCollection Export            =
  ============================================*/

  root.RigCollection = RigCollection

  /*-----  End of RigCollection Export  ------*/

}(window, window.jQuery)
