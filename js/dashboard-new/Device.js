/**

  TODO:
  - Finish general structure of Device class

**/

!function (root, $) {

  /*==========================================================
  =            Device Class/Object/Constructor            =
  ==========================================================*/

  var Device = function () {
    /* Device constants */
    this.HEAT_WARNING     = root.devHeatWarning;
    this.HEAT_DANGER      = root.devHeatDanger;
    this.HW_ENABLED       = root.devHWEnabled;
    this.HW_WARNING       = root.devHWWarning;
    this.HW_DANGER        = root.devHWDanger;
    this.UPDATE_INTERVAL  = root.rigUpdateTime;

    /* Device properties*/
    this.health = 'Happy'
    this.status = 'green'
    this.icon   = 'check'
    this.panel  = ''
  }

  /*-----  End of Device Class/Object/Constructor  ------*/


  /*================================================
  =            Device Public Methods            =
  ================================================*/



  /*-----  End of Device Public Methods  ------*/


  /*=================================================
  =            Device Private Methods            =
  =================================================*/


  Device.prototype._updateDevices = function (devices) {
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

  Device.prototype._checkDeviceStatus = function (devices) {
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

  Device.prototype._registerDevice = function (device) {
    this.deviceCollection.push(new RigDevice(device))
  }

  Device.prototype._setDeviceStatus = function (status) {
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


  /*-----  End of Device Private Methods  ------*/


  /*========================================
  =            Device export            =
  ========================================*/

  root.Device = Device

  /*-----  End of Device export  ------*/

} (window, window.jQuery)
