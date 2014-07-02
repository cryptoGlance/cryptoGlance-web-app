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
    this._rigCount          = 0
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

  RigCollection.prototype.start = function (data) {
    var _self = this // caching self ref for passing down in scope

    /*==========  Generate collection  ==========*/
    $('.panel-rig').each(function() {
      var rigId = this.getAttribute('data-id')
      _self._add(rigId)
    })

    /*==========  Initial data call  ==========*/
    this._getData(function (data) {
      _self._rigCount = data.length
      _self._buildOverview(data)

      _self.apiData = { type: 'rigs', action: 'update' }

      /*==========  Setup polling  ==========*/
      setInterval(function () {
        if (_self._ready) {
          _self._rigsResponded = 0
          _self._ready = false
          _self._update()
        }
      }, root.rigUpdateTime)
    })
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
    var overviewData = []

    this.collection.forEach(function (rig, index) {
      _self.apiData.id = rig.rigID
      _self._getData(function (data) {
        _self._rigsResponded++
        data = data[0]
        rig.update(data)
        overviewData[index] = data
        if (_self._rigsResponded === _self._rigCount) {
          _self._ready = true
          _self._buildOverview(overviewData)
        }
      })
    })
  }

  RigCollection.prototype._getData = function (callback) {
    var _self = this // caching self ref for passing down in scope

    $.ajax({
      url: 'ajax.php',
      data : _self.apiData,
      dataType: 'json'
    })
    .done(callback)
    .fail(function (xhr, status, message) {
      console.error(message)
    })
  }

  RigCollection.prototype._buildOverview = function (data) {
    var _self = this // caching self ref for passing down in scope

    var algorithms = {
      'scrypt': 0,
      'sha256': 0,
      'x11': 0,
      'scrypt-n': 0,
      'x13': 0
    }

    this.overviewTableData = ''
    this.overallHashrate = 0

    data = data.overview

    data.forEach(function (res, index) {
      _self.overviewTableData += _self._buildOverviewRow(res, index + 1)
      _self.overallHashrate += Util.extractHashrate(res.hashrate_5s)
      algorithms[res.algorithm] += res.raw_hashrate
    })

    this.overallHashrate = Util.getSpeed(this.overallHashrate)

    this.$overviewTableBody.html(this.overviewTableData)

    for (var key in algorithms) {
      if (algorithms[key]) {
        $('#hashrate_' + key).html('<span class="hashrate-algo">' + key + '</span>' + Util.getSpeed(algorithms[key]))
      }
      else {
        $('#total-hashrates #hashrate_' + key).remove()
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
    var hashrate_5s = colour !== 'grey' ? overview.hashrate_5s : '--'
    var active_pool_url = overview.active_pool.url || '--'
    var uptime = overview.uptime || '--'
    return '<tr data-rig="'+ index +'">' +
           '<td><i class="icon icon-'+ icon +' '+ colour +'"></i></td>' +
           '<td><a href="#rig-'+ index +'" class="anchor-offset rig-'+ index +' '+ colour +'">'+ $('#rig-'+ index + ' h1').html() +'</a></td>' +
           '<td>'+ hashrate_5s +'</td>' +
           '<td>'+ active_pool_url +'</td>' +
           '<td>'+ uptime +'</td>' +
           '</tr>'
  }

  /*-----  End of RigCollection Private Methods  ------*/


  /*============================================
  =            RigCollection Export            =
  ============================================*/

  root.RigCollection = RigCollection

  /*-----  End of RigCollection Export  ------*/

}(window, window.jQuery)
