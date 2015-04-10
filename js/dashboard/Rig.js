!function (root, $) {

  'use strict';

  /*===================================================
  =            Rig Class/Object/Constructor            =
  ===================================================*/

  var Rig = function (rigID) {
    /* Rig properties */
    this.rigID                   = rigID
    this.$rigEl                  = $('#rig-' + rigID)
    this.rigPanel                = this.$rigEl.find('.panel-content')
    this.$rigNavEl               = this.$rigEl.find('.nav')
    this.$rigTabContentEl        = this.$rigEl.find('.tab-content')
    this.$rigTitle               = this.$rigEl.find('h1')
    this.$rigSummary             = $('#rig-' + rigID + '-summary')
    this.$rigSummaryTableSummary = this.$rigSummary.find('.table-summary')
    this.$rigSummaryTable        = this.$rigSummary.find('table')
    this.$rigSummaryTableBody    = this.$rigSummaryTable.find('tbody')
    this.$loader                 = this.$rigSummary.find('img[alt="loading"]')
    this.$rigSummaryBody         = this.$rigSummary.find('.panel-body-summary')
    this.deviceCollection        = []//new DeviceCollection(rigID)
    this.init                    = true
    this.ready                   = true
    this.summaryBtn              = '<li>' +
                                   '<a class="blue" href="#rig-'+ rigID +'-summary" data-toggle="tab">' +
                                   'Summary ' +
                                   '<i class="icon icon-dotlist"></i>' +
                                   '</a>' +
                                   '</li>'
    this.panelStatus             = ''
  }

  /*-----  End of Rig Class/Object/Constructor  ------*/


  /*==========================================
  =            Rig Public Methods            =
  ==========================================*/

  Rig.prototype.update = function (data) {
    if ('undefined' === typeof data.overview || data.overview.status == 'offline') {
      this._off()
      this.ready = false
      return
    }
    else if (!this.ready) {
      this.ready = true
      this._on()
    }

    if (this.init) {
      this._on()

      this.$loader.remove()

      this.$rigSummaryTable.show()
    }

    var stats          = ''
    var overview       = data.overview || {}
    var summary        = data.summary || {}
    var devices        = data.devs || []
    var sharePercent   = 0
    var scrollPosition = this.$rigEl.find('.table-responsive:visible').scrollLeft()

    // everything below is so incredibly dirty...
    var $activeNav     = this.$rigNavEl.find('.active')
    var activeNavIndex = $activeNav.index()
    var activeTab      = $activeNav.length ? $activeNav.find('a')[0].getAttribute('href') : ''

    // ensure newly added/removed devices are accounted for
    if (this.deviceCollection.length !== devices.length) {
      this.deviceCollection = new DeviceCollection(this.rigID)
      for (var i = 0; i < devices.length; i++) {
        this.deviceCollection.add(devices[i].id)
      }
    }

    if (this.panelStatus !== overview.status.panel) {
      this.panelStatus = overview.status.panel
      this.$rigEl[0].className = 'panel panel-primary panel-rig ' + this.panelStatus
    }

    this.$rigSummaryBody.html(this._buildStatus(summary))

    if (this.deviceCollection.length > 0) {
        var deviceHtml = this.deviceCollection.update(devices)
        this.$rigNavEl.html(this.summaryBtn + deviceHtml.nav)
        this.$rigSummaryTableBody.html(deviceHtml.summary)
        this.$rigTabContentEl.html(this.$rigSummary[0].outerHTML + deviceHtml.status)
        this.$rigSummaryTableSummary.show();
    } else {
        this.$rigSummaryTableSummary.hide();
    }

    if (this.init) {
      this.$rigNavEl.find('li:first-child').addClass('active')
    }
    if ($activeNav.length) {
      this.$rigTabContentEl.find('.active.in').removeClass('in active')
      this.$rigNavEl.find('li:eq(' + activeNavIndex + ')').addClass('active')
      $(activeTab).addClass('in active')
    }

    this.init = false

    this.$rigEl.find('.table-responsive:visible').scrollLeft(scrollPosition)
  }

  /*-----  End of Rig Public Methods  ------*/


  /*===========================================
  =            Rig Private Methods            =
  ===========================================*/

  Rig.prototype._buildStatus = function (statusObj) {
    var statusHtml = ''
    // var totalShares = statusObj.accepted + statusObj.rejected + statusObj.stale
    for (var key in statusObj) {
      switch (key) {
        case 'temperature':
          statusHtml += this._getStatusHtml(key,
                                            statusObj[key].celsius + '&deg;C / ' +
                                            statusObj[key].fahrenheit + '&deg;F',
                                            null,
                                            null)
          break
        case 'accepted':
          statusHtml += this._getStatusHtml(key,
                                            statusObj[key].raw + ' <span>(' + statusObj[key].percent + '%)</span>',
                                            'success',
                                            statusObj[key].percent)
          break
        case 'rejected':
        case 'stale':
          statusHtml += this._getStatusHtml(key,
                                            statusObj[key].raw + ' <span>(' + statusObj[key].percent + '%)</span>',
                                            'danger',
                                            statusObj[key].percent)
          break
        case 'hw_errors':
          statusHtml += this._getStatusHtml(key,
                                            statusObj[key].raw + ' <span>(' + statusObj[key].percent + '%)</span>',
                                            null,
                                            statusObj[key].percent)
          break
        case 'hashrate_5s':
        case 'hashrate_avg':
          statusHtml += this._getStatusHtml(key,
                                            Util.getSpeed(statusObj[key]),
                                            null,
                                            null)
          break
        case 'active_pool':
          statusHtml += this._getStatusHtml(key,
                                            statusObj[key].url,
                                            null,
                                            null)
          break
        default:
          statusHtml += this._getStatusHtml(key,
                                            statusObj[key],
                                            null,
                                            null)
      }
    }

    return statusHtml
  }
  Rig.prototype._getStatusHtml = function (name, value, progress, share) {
    return '<div class="stat-pair">' +
            '<div class="stat-value">' + value + '</div>' +
            '<div class="stat-label">' + name.replace(/_|-|\./g, ' ') + '</div>' +
            '<div class="progress progress-striped">' +
             '<div class="progress-bar progress-bar-' + progress + '" style="width: ' + share + '%"></div>' +
            '</div>' +
           '</div>'
  }

  Rig.prototype._off = function () {
    this.$rigEl.removeClass('panel-warning panel-danger').addClass('panel-offline')
    this.$rigEl.find('.btn-manage-rig').hide()
    this.$rigEl.find('.btn-edit-rig').show()
    this.$rigEl.find('.rig-label').text('Rig Offline');
    this.rigPanel.hide()
    this.$rigNavEl.html('')
    this.$rigSummaryTableBody.html('')
  }

  Rig.prototype._on = function() {
    this.$rigEl.removeClass('panel-offline')
    this.$rigEl.find('.rig-label').text('Rig Stats');
    this.$rigEl.find('.btn-manage-rig').show()
    this.$rigEl.find('.btn-edit-rig').hide()
    this.$rigSummary.find('table').show()
    this.rigPanel.show()
  }

  /*-----  End of Rig Private Methods  ------*/


  /*==================================
  =            Rig Export            =
  ==================================*/

  root.RigCollection.prototype.SubClass = Rig

  /*-----  End of Rig Export  ------*/

}(window, window.jQuery)
