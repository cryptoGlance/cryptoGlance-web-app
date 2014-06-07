/**

  TODO:
  - finish updateDevice's method
  - continue breaking apart old rigs.js (stopped at line 190)
  - finish creating rest of public methods
  - finish creating rest of private methods

**/

!function (root, $) {

  /*===================================================
  =            Rig Class/Object/Constructor            =
  ===================================================*/

  var Rig = function (rigId) {

    /* Rig properties */
    this.rigId            = rigId
    this.$rigEl           = $('#rig-' + rigId)
    this.$rigNavEl        = this.$rigEl.find('.nav')
    this.$rigTabContentEl = this.$rigEl.find('.tab-content')
    this.$rigTitle        = this.$rigEl.find('h1')
    this.$rigOverviewRow  = $('tr[data-rig="'+ rigId +'"]', overviewTable)
    this.health           = 'Happy'
    this.status           = 'green'
    this.icon             = 'check'
    this.panel            = ''

    /* Rig constants */
    this.HEAT_WARNING     = root.devHeatWarning;
    this.HEAT_DANGER      = root.devHeatDanger;
    this.HW_ENABLED       = root.devHWEnabled;
    this.HW_WARNING       = root.devHWWarning;
    this.HW_DANGER        = root.devHWDanger;
    this.UPDATE_INTERVAL  = root.rigUpdateTime;
  }

  /*-----  End of Rig Class/Object/Constructor  ------*/


  /*==========================================
  =            Rig Public Methods            =
  ==========================================*/

  Rig.prototype.start = function () {

    if (rig == null || typeof rig.summary == 'undefined' || typeof rig.devs == 'undefined') {
      this.$rigEl.find('.toggle-panel-body, .panel-footer').hide();
      this.$rigNavEl.hide()
      this.$rigTabContentEl.hide()

      // if (this.$rigOverviewRow.length == 0) {
      //   $(overviewTable).append('<tr data-rig="'+ rigId +'"></tr>');
      //   rigOverviewRow = $('tr[data-rig="'+ rigId +'"]', overviewTable)
      // }
      // $(rigOverviewRow).html('<td><i class="icon icon-ban-circle grey"></i></td>' +
      //                        '<td><a href="#rig-'+ rigId +'" class="anchor-offset rig-'+ rigId +' grey">'+ $('h1', rigElm).html().replace(' - OFFLINE', '') +'</a></td>' +
      //                        '<td>--</td>' +
      //                        '<td>--</td>' +
      //                        '<td>--</td>')

      this.$rigEl.removeClass('panel-warning panel-danger').addClass('panel-offline')
      this.$rigEl.find('.btn-manage-rig').hide()
      return true
    }
    else {
      this.$rigEl.find('.toggle-panel-body, .panel-footer').show();
      this.$rigNavEl.show()
      this.$rigTabContentEl.show()
      this.$rigEl.removeClass('panel-offline');
      this.$rigEl.find('.btn-manage-rig').show();
    }
  }

  Rig.prototype.clearNav = function () {
    var selectedNav = this.$rigNavEl.find('.active').index()
    if (selectedNav === -1) {
      selectedNav = 0
    }
    this.rigNavEl.find('li').remove()
  }

  Rig.prototype.updateSummary = function (data) {
    data = data[0]
    var summary = data.summary
    var devices = data.devs // data.devices
    var sharePercent = 0;
    var stats = ''
    var totalShares = summary.accepted + summary.rejected + summary.stale

    var $summaryContentTab = this.$rigTabContentEl.find('#rig-' + this.rigId + '-summary').find('.panel-body-summary')
    $summaryContentTab.find('div, img').remove()

    this.$rigNavEl.append('<li>' +
                         '<a class="blue" href="#rig-'+ rigId +'-summary" data-toggle="tab">' +
                         'Summary ' +
                         '<i class="icon icon-dotlist"></i>' +
                         '</a>' +
                         '</li>')

    summary.hashrate_5s = summary.hashrate_5s !== 0 ? summary.hashrate_5s : summary.hashrate_avg

    for (var key in summary) {
      switch (key) {
        case 'accepted':
          stats += this._buildStat(key, summary[key], 'success', ((summary[key]/totalShares) * 100).toFixed(0))
          break
        case 'rejected':
        case 'stale':
          stats += this._buildStat(key, summary[key], 'danger', ((summary[key]/totalShares) * 100).toFixed(0))
          break
        case 'hashrate_5s':
          hashrateCollection[this.rigId] = summary[key]
        case 'hashrate_avg':
          stats += this._buildStat(key, this._getSpeed(summary[key]), null, null)
          break
        default:
          stats += this._buildStat(key, summary[key], null, null)
      }
    }

    $summaryContentTab.append(stats)
    this._updateDevices(devices)
  }

  /*-----  End of Rig Public Methods  ------*/


  /*===========================================
  =            Rig Private Methods            =
  ===========================================*/

  Rig.prototype._getSpeed = function (value) {
    if (value < 1) {
      return(value * 1000) + ' KH/S';
    }
    else if (value > 1000) {
      return parseFloat(value/1000).toFixed(2) + ' GH/S';
    } else {
      return parseFloat(value).toFixed(2) + ' MH/S';
    }
  }

  Rig.prototype._buildStat = function (name, value, progress, share) {
    return '<div class="stat-pair">' +
            '<div class="stat-value">' + value + '</div>' +
            '<div class="stat-label">' + name.replace(/_|-|\./g, ' ') + '</div>' +
            '<div class="progress progress-striped">' +
            '<div class="progress-bar progress-bar-' + progress + '" style="width: ' + share +'%">' +
            '</div>' +
            '</div>' +
            '</div>'
  }

  Rig.prototype._updateDevices = function (devices) {
    var $summaryContentTabTable = this.$rigTabContentEl.find('#rig-' + rigId + '-summary').find('.table-summary')
    var $summaryContentTabTableHead = this.$rigTabContentEl.find('thead')
    var $summaryContentTabTableBody = this.$rigTabContentEl.find('tbody')
    var removeTable = false
    $summaryContentTabTable.find('tr').remove()

    if ((typeof devices.GPU != 'undefined' && devices.GPU.length > 0) ||
         typeof devices.ASC != 'undefined' && devices.ASC.length > 0) {
        $summaryContentTabTableHead.append('<tr>' +
                                           '<th></th>' +
                                           '<th>DEV #</th>' +
                                           '<th>Temperature</th>' +
                                           '<th>Hashrate 5s</th>' +
                                           '<th>Accepted</th>' +
                                           '<th>Rejected</th>' +
                                           '<th>Utility</th>' +
                                           '<th>HW Errors</th>' +
                                           '</tr>');
    } else {
      removeTable = true
      $summaryContentTabTable.remove()
    }

    // Update Devices
    this._checkDeviceStatus(devices)
  }

  Rig.prototype._registerDevice = function(device) {
    // body...
  };

  Rig.prototype._setDeviceStatus = function(status) {
    switch (status) {
      case 'disabled':
        this.status = 'grey'
        this.icon = 'ban-circle'
        this.panel = 'offline'
        break
      case 'dead':
        this.status = 'red'
        this.icon = 'danger'
        this.panel = 'danger'
        break
      case 'sick':
        this.status = 'orange';
        this.icon = 'warning-sign';
        this.panel = 'warning';
        break
      case 'hot':
        this.status = 'red';
        this.icon = 'hot';
        this.panel = 'danger';
        break
      case 'warm':
        this.status = 'orange';
        this.icon = 'fire';
        this.panel = 'warning';
        break
      default:
        this.status = 'green'
        this.icon = 'cpu-processor'
        this.panel = ''
    }
  }

  Rig.prototype._checkDeviceStatus = function(devices) {
    var deviceList = ''
    var deviceTabToRemove = []
    var deviceTabs = ''
    var deviceTabsContent = ''
    this.icon = 'cpu-processor'
    this.panel = ''
    for (var deviceType in devices) {
      for (var deviceIndex in devices[deviceType]) {
        // Status colours
        this.health = deviceIndex.health
        if (deviceIndex.enabled === 'N') {
          this._setDeviceStatus('disabled')
        }
        else if (this.health === 'Dead' || (this.HW_ENABLED && dev.hw_errors >= this.HW_DANGER)) {
          this._setDeviceStatus('dead')
        }
        else if (this.health === 'Sick' || (this.HW_ENABLED && dev.hw_errors >= this.HW_WARNING)) {
          this._setDeviceStatus('sick')
        }
        else if (this.HEAT_DANGER <= deviceIndex.temperature) {
          this._setDeviceStatus('hot')
        }
        else if (this.HEAT_WARNING <= deviceIndex.temperature) {
          this._setDeviceStatus('warm')
        }

        deviceList += '<li>' +
                      '<a class="rig-' + this.rigId + '-' + deviceType + '-' + deviceIndex + ' ' + this.status + '" href="#rig-' + this.rigId  + '-' + deviceType + '-' + deviceIndex + '" data-toggle="tab">' + deviceType + deviceIndex + ' ' +
                      '<i class="icon icon-'+ this.icon +'"></i>' +
                      '</a>' +
                      '</li>'
        deviceTabToRemove.push('#rig-'+ this.rigId +'-'+ deviceType +'-'+ deviceIndex)
        deviceTabsContent += '<div class="tab-pane fade in" id="rig-'+ this.rigId +'-'+ deviceType +'-'+ deviceIndex +'">' +
                      '<div class="panel-body panel-body-stats"></div>' +
                      '</div>'
      }
    }

    if (this.panel !== '') {
      this.$rigEl.addClass('panel-' + this.panel);
    }

    // add dev to Nav
    this.$rigNavEl.append(deviceList)
    this.$rigTabContentEl.find(deviceTabToRemove).remove()
    this.$rigTabContentEl.append(deviceTabsContent)

    // Updating DEV Content Tab
    var $devContentTab = this.$rigTabContentEl.find('#rig-' + this.rigId + '-'+ deviceType +'-' + device.id).find('.panel-body-stats')
    $devContentTab.find('div').remove()
    for (var key in devices) {
      switch (key) {
        case 'temperature':
          deviceTabs += this._buildStat(devices[key] + '&deg;C', key, null, null)
          break
        case 'hashrate_5s':
        case 'hashrate_avg':
          deviceTabs += this._buildStat(key, this._getSpeed(devices[key]), null, null)
          break
        default:
          deviceTabs += this._buildStat(key, devices[key], null, null)
      }
    }

    $devContentTab.append(deviceTabs)

    // Update Summary Page of DEVs
    if (!removeTable) {
      dev.hashrate_5s = this._getSpeed(dev.hashrate_5s)

    $summaryContentTabTableBody.append('<tr>' +
                                         '<td><i class="icon icon-'+ icon +' '+status+'"></i></td>' +
                                         '<td class="'+status+'">'+ devType + dev.id+'</td>' +
                                         '<td>'+dev.temperature+'&deg;C</td>' +
                                         '<td>'+dev.hashrate_5s+'</td>' +
                                         '<td>'+dev.accepted+'</td>' +
                                         '<td>'+dev.rejected+'</td>' +
                                         '<td>'+dev.utility+'</td>' +
                                         '<td>'+dev.hw_errors+'</td>' +
                                         '</tr>')
    }
  }

  /*-----  End of Rig Private Methods  ------*/


  /*==================================
  =            Rig Export            =
  ==================================*/

  root.Rig = Rig

  /*-----  End of Rig Export  ------*/

}(window, window.jQuery)
