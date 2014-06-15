/**

  TODO:
  - Finish general structure of Device class

**/

!function (root, $) {

  'use strict';

  /*==========================================================
  =            Device Class/Object/Constructor            =
  ==========================================================*/

  var Device = function (deviceID) {
    /* Device constants */
    this.HEAT_WARNING     = root.devHeatWarning;
    this.HEAT_DANGER      = root.devHeatDanger;
    this.HW_ENABLED       = root.devHWEnabled;
    this.HW_WARNING       = root.devHWWarning;
    this.HW_DANGER        = root.devHWDanger;
    this.UPDATE_INTERVAL  = root.rigUpdateTime;
    this.TAB_HEADER       = '<tr>' +
                            '<th></th>' +
                            '<th>Device name</th>' +
                            '<th>Temperature</th>' +
                            '<th>Hashrate 5s</th>' +
                            '<th>Accepted</th>' +
                            '<th>Rejected</th>' +
                            '<th>Utility</th>' +
                            '<th>HW Errors</th>' +
                            '</tr>'

    /* Device properties*/
    this.id     = deviceID
    this.name     = 'Device'
    this.status = { icon: 'cpu-processor', colour: 'green' }
    this.health = 'Alive'
    this.icon   = 'check'
    this.enabled = 'N'
    this.hashrate_avg = '0 KH/s'
    this.hashrate_5s = '0 KH/s'
    this.temperature = 'n/a'
    this.accepted = '0 (0%)'
    this.rejected = '0 (0%)'
    this.hw_errors = '0 (0%)'
    this.utility = '0m'
    this.frequency = 0
    this.panel  = ''
  }

  /*-----  End of Device Class/Object/Constructor  ------*/


  /*================================================
  =            Device Public Methods            =
  ================================================*/

  Device.prototype.update = function (deviceObj) {
    this.name = deviceObj.name || 'Device'
    this.status = deviceObj.status || { icon: 'cpu-processor', colour: 'green' }
    this.health = deviceObj.health || 'Alive'
    this.icon   = deviceObj.status.icon || 'check'
    this.enabled = deviceObj.enabled || 'N'
    this.hashrate_avg = deviceObj.hashrate_avg || '0 KH/s'
    this.hashrate_5s = deviceObj.hashrate_5s || '0 KH/s'
    this.temperature = deviceObj.temperature || 'n/a'
    this.accepted = deviceObj.accepted || '0 (0%)'
    this.rejected = deviceObj.rejected || '0 (0%)'
    this.hw_errors = deviceObj.hw_errors || '0 (0%)'
    this.utility = deviceObj.utility || '0m'
    this.frequency = deviceObj.frequency || 0
    // var $summaryContentTabTable = this.$rigTabContentEl.find('#rig-' + rigId + '-summary').find('.table-summary')
    // var $summaryContentTabTableHead = this.$rigTabContentEl.find('thead')
    // var $summaryContentTabTableBody = this.$rigTabContentEl.find('tbody')
    // var removeTable = false
    // $summaryContentTabTable.find('tr').remove()

    // if ((typeof devices.GPU != 'undefined' && devices.GPU.length > 0) ||
    //      typeof devices.ASC != 'undefined' && devices.ASC.length > 0) {
    //     $summaryContentTabTableHead.append(this.TAB_HEADER);
    // } else {
    //   removeTable = true
    //   $summaryContentTabTable.remove()
    // }

    // Update Devices
    // var deviceList = ''
    // var deviceTabToRemove = []
    // var deviceTabs = ''
    // var deviceTabsContent = ''
    // this.icon = 'cpu-processor'
    // this.panel = ''
    // for (var deviceType in devices) {
    //   for (var deviceIndex in devices[deviceType]) {
        // Status colours
        // this.health = deviceIndex.health
        // if (this.enabled === 'N') {
        //   this._setStatus('disabled')
        // }
        // else if (this.health === 'Dead' || (this.HW_ENABLED && this.hw_errors >= this.HW_DANGER)) {
        //   this._setStatus('dead')
        // }
        // else if (this.health === 'Sick' || (this.HW_ENABLED && this.hw_errors >= this.HW_WARNING)) {
        //   this._setStatus('sick')
        // }
        // else if (this.HEAT_DANGER <= this.temperature) {
        //   this._setStatus('hot')
        // }
        // else if (this.HEAT_WARNING <= this.temperature) {
        //   this._setStatus('warm')
        // }

        // deviceList += '<li>' +
        //               '<a class="rig-' + this.rigId + '-' + deviceType + '-' + deviceIndex + ' ' + this.status + '" href="#rig-' + this.rigId  + '-' + deviceType + '-' + deviceIndex + '" data-toggle="tab">' + deviceType + deviceIndex + ' ' +
        //               '<i class="icon icon-'+ this.icon +'"></i>' +
        //               '</a>' +
        //               '</li>'
        // deviceTabToRemove.push('#rig-'+ this.rigId +'-'+ deviceType +'-'+ deviceIndex)
        // deviceTabsContent += '<div class="tab-pane fade in" id="rig-'+ this.rigId +'-'+ deviceType +'-'+ deviceIndex +'">' +
        //               '<div class="panel-body panel-body-stats"></div>' +
        //               '</div>'
    //   }
    // }

    // if (this.panel !== '') {
    //   this.$rigEl.addClass('panel-' + this.panel)
    // }

    // add dev to Nav
    // this.$rigNavEl.append(deviceList)
    // this.$rigTabContentEl.find(deviceTabToRemove).remove()
    // this.$rigTabContentEl.append(deviceTabsContent)

    // Updating DEV Content Tab
    // var $devContentTab = this.$rigTabContentEl.find('#rig-' + this.rigId +'-' + this.id).find('.panel-body-stats')
    // $devContentTab.find('div').remove()
    // for (var key in devices) {
    //   switch (key) {
    //     case 'hashrate_5s':
    //     case 'hashrate_avg':
    //       deviceTabs += this._buildStat(key, Util.getSpeed(devices[key]), null, null)
    //       break
    //     default:
    //       deviceTabs += this._buildStat(key, devices[key], null, null)
    //   }
    // }

    // $devContentTab.append(deviceTabs)

    // Update Summary Page of DEVs
    // if (!removeTable) {
    //   dev.hashrate_5s = Util.getSpeed(dev.hashrate_5s)

    return '<tr>' +
           '<td><i class="icon icon-'+ this.status.icon + ' ' + this.status.colour + '"></i></td>' +
           '<td class="' + this.status.colour + '">' + this.name + ' ' + this.id + '</td>' +
           '<td>' + this.temperature + '</td>' +
           '<td>' + this.hashrate_5s + '</td>' +
           '<td>' + this.accepted + '</td>' +
           '<td>' + this.rejected + '</td>' +
           '<td>' + this.utility + '</td>' +
           '<td>' + this.hw_errors + '</td>' +
           '</tr>'
    // }
  }

  /*-----  End of Device Public Methods  ------*/


  /*=================================================
  =            Device Private Methods            =
  =================================================*/

  Device.prototype._buildStat = function (name, value, progress, share) {
    return '<div class="stat-pair">' +
           '<div class="stat-value">' + value + '</div>' +
           '<div class="stat-label">' + name.replace(/_|-|\./g, ' ') + '</div>' +
           '</div>'
  }

  // Device.prototype._registerDevice = function (device) {
  //   this.deviceCollection.push(new RigDevice(device))
  // }

  Device.prototype._setStatus = function (status) {
    switch (status) {
      case 'disabled':
        this.status.colour = 'grey'
        this.status.icon = 'ban-circle'
        this.panel = 'offline'
        break
      case 'dead':
        this.status.colour = 'red'
        this.status.icon = 'danger'
        this.panel = 'danger'
        break
      case 'sick':
        this.status.colour = 'orange';
        this.status.icon = 'warning-sign';
        this.panel = 'warning';
        break
      case 'hot':
        this.status.colour = 'red';
        this.status.icon = 'hot';
        this.panel = 'danger';
        break
      case 'warm':
        this.status.colour = 'orange';
        this.status.icon = 'fire';
        this.panel = 'warning';
        break
      default:
        this.status.colour = 'green'
        this.status.icon = 'cpu-processor'
        this.panel = ''
    }
  }


  /*-----  End of Device Private Methods  ------*/


  /*========================================
  =            Device export               =
  ========================================*/

  root.Device = Device

  /*-----  End of Device export  ------*/

} (window, window.jQuery)
