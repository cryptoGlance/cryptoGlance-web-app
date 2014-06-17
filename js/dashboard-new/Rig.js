/**

  TODO:
  - finish general structure of Rig class

**/

!function (root, $) {

  'use strict';

  /*===================================================
  =            Rig Class/Object/Constructor            =
  ===================================================*/

  var Rig = function (rigID) {
    var _self = this

    /* Rig properties */
    _self.rigID            = rigID
    _self.$rigEl           = $('#rig-' + rigID)
    _self.$rigNavEl        = _self.$rigEl.find('.nav')
    _self.$rigTabContentEl = _self.$rigEl.find('.tab-content')
    _self.$rigTitle        = _self.$rigEl.find('h1')
    _self.$rigSummary      = $('#rig-' + rigID + '-summary')
    _self.$summaryTable     = _self.$rigSummary.find('table')
    _self.$loader          = _self.$rigSummary.find('img[alt="loading"]')
    _self.$rigSummaryBody      = _self.$rigSummary.find('.panel-body-summary')
    _self.deviceCollection = new DeviceCollection(rigID)
    _self.init          = true
    _self.ready         = true
    _self.manageBtn        = '<li>' +
                            '<a class="blue" href="#rig-'+ rigID +'-summary" data-toggle="tab">' +
                            'Summary ' +
                            '<i class="icon icon-dotlist"></i>' +
                            '</a>' +
                            '</li>'
  }

  /*-----  End of Rig Class/Object/Constructor  ------*/


  /*==========================================
  =            Rig Public Methods            =
  ==========================================*/

  Rig.prototype.update = function (data) {
    var _self = this
    if ('undefined' === typeof data.summary || !data.devs.length) {
      _self._off()
      _self.ready = false
      return
    }
    else if (!_self.ready) {
      _self.ready = true
      _self._on()
    }

    if (_self.init) {
      _self._on()

      _self.$loader.remove()

      _self.$summaryTable.show()
    }

    var stats = ''
    var summary = data.summary || {}
    var devices = data.devs || []
    var sharePercent = 0
    // summary.hashrate_5s = summary.hashrate_5s !== 0 ? summary.hashrate_5s : summary.hashrate_avg

    // ensure newly added devices are accounted for
    // console.log(this.deviceCollection.count, devices.length)
    if (_self.deviceCollection.count < devices.length) {
      for (var i = 0; i < devices.length; i++) {
        _self.deviceCollection.add(devices[i].id)
      }
    }

    var deviceHtml = _self.deviceCollection.update(devices)
    _self.$rigNavEl.html(_self.manageBtn + deviceHtml.nav)
    _self.$rigSummaryBody.html(_self._buildStatus(summary))
    _self.$rigSummaryTable.html(deviceHtml.summary)
    _self.$rigTabContentEl.html(_self.$rigSummary[0].outerHtml + deviceHtml.status)

    // this.$rigNavEl.find('li:eq('+ this.selectedNav +')').addClass('active')
    // this.$rigTabContentEl.find('.tab-pane:eq('+ this.selectedNav +')').addClass('active')
  }

  /*-----  End of Rig Public Methods  ------*/


  /*===========================================
  =            Rig Private Methods            =
  ===========================================*/

  // Rig.prototype._clearNav = function () {
  //   var $selectedNav = this.$rigNavEl.find('.active')
  //   this.selectedNav = $selectedNav[0] ? $selectedNav.index() : 0
  //   this.$rigNavEl.find('li').remove()
  // }

  Rig.prototype._buildStatus = function (statusObj) {
    var statusHtml = ''
    var totalShares = statusObj.accepted + statusObj.rejected + statusObj.stale
    for (var key in statusObj) {
      switch (key) {
        case 'accepted':
          statusHtml += this._getStatusHtml(key, statusObj[key], 'success', ((statusObj[key]/totalShares) * 100).toFixed(0))
          break
        case 'rejected':
        case 'stale':
          statusHtml += this._getStatusHtml(key, statusObj[key], 'danger', ((statusObj[key]/totalShares) * 100).toFixed(0))
          break
        case 'hashrate_5s':
          // hashrateCollection[this.rigID] = statusObj[key]
        case 'hashrate_avg':
          statusHtml += this._getStatusHtml(key, Util.getSpeed(Util.extractHashrate(statusObj[key])), null, null)
          break
        default:
          statusHtml += this._getStatusHtml(key, statusObj[key], null, null)
      }
    }
    return statusHtml
  }
  Rig.prototype._getStatusHtml = function (name, value, progress, share) {
    return '<div class="stat-pair">' +
            '<div class="stat-value">' + value + '</div>' +
            '<div class="stat-label">' + name.replace(/_|-|\./g, ' ') + '</div>' +
            '<div class="progress progress-striped">' +
            '<div class="progress-bar progress-bar-' + progress + '" style="width: ' + share +'%">' +
            '</div>' +
            '</div>' +
            '</div>'
  }

  Rig.prototype._off = function () {
    // this.$rigEl.find('.toggle-panel-body, .panel-footer').hide()
    this.$rigNavEl.hide()
    this.$rigTabContentEl.hide()

    // if (this.$rigOverviewRow.length == 0) {
    //   $this.overviewTable.append('<tr data-rig="'+ this.rigID +'"></tr>')
    // }
    // this.$rigOverviewRow.html('<tr data-rig="'+ this.rigID +'">' +
    //                           '<td><i class="icon icon-ban-circle grey"></i></td>' +
    //                           '<td><a href="#rig-'+ this.rigID +'" class="anchor-offset rig-'+ this.rigID +' grey">'+ this.$rigTitle.html().replace(' - OFFLINE', '') +'</a></td>' +
    //                           '<td>--</td>' +
    //                           '<td>--</td>' +
    //                           '<td>--</td>' +
    //                           '</tr>')

    this.$rigEl.removeClass('panel-warning panel-danger').addClass('panel-offline')
    this.$rigEl.find('.btn-manage-rig').hide()
  }

  Rig.prototype._on = function() {
    this.init = false
    this.$rigEl.find('.toggle-panel-body, .panel-footer').show()
    this.$rigNavEl.show()
    this.$rigTabContentEl.show()
    this.$rigEl.removeClass('panel-offline')
    this.$rigEl.find('.btn-manage-rig').show()
  }

  /*-----  End of Rig Private Methods  ------*/


  /*==================================
  =            Rig Export            =
  ==================================*/

  root.RigCollection.prototype.SubClass = Rig

  /*-----  End of Rig Export  ------*/

}(window, window.jQuery)
