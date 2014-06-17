/**

  TODO:
  - Finish general structure of Device class

**/

!function (root, $) {

  'use strict';

  /*==========================================================
  =            Device Class/Object/Constructor            =
  ==========================================================*/

  var Device = function (deviceID, rigID) {
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
    this.id           = deviceID
    this.rigID        = rigID
    this.name         = 'Device'
    this.status       = { icon: 'cpu-processor', colour: 'green' }
    this.health       = 'Alive'
    this.icon         = 'check'
    this.enabled      = 'N'
    this.hashrate_avg = '0 KH/s'
    this.hashrate_5s  = '0 KH/s'
    this.temperature  = 'n/a'
    this.accepted     = '0 (0%)'
    this.rejected     = '0 (0%)'
    this.hw_errors    = '0 (0%)'
    this.utility      = '0m'
    this.frequency    = 0
    this.panel        = ''
  }

  /*-----  End of Device Class/Object/Constructor  ------*/


  /*================================================
  =            Device Public Methods            =
  ================================================*/

  Device.prototype.update = function (deviceObj) {
    var _self = this
    var deviceStatus = []

    _self.id           = deviceObj.id
    _self.name         = deviceObj.name || 'Device'
    _self.status       = deviceObj.status || { icon: 'cpu-processor', colour: 'green' }
    _self.health       = deviceObj.health || 'Alive'
    _self.icon         = deviceObj.status.icon || 'check'
    _self.enabled      = deviceObj.enabled || 'N'
    _self.hashrate_avg = deviceObj.hashrate_avg || '0 KH/s'
    _self.hashrate_5s  = deviceObj.hashrate_5s || '0 KH/s'
    _self.temperature  = deviceObj.temperature || 'n/a'
    _self.accepted     = deviceObj.accepted || '0 (0%)'
    _self.rejected     = deviceObj.rejected || '0 (0%)'
    _self.hw_errors    = deviceObj.hw_errors || '0 (0%)'
    _self.utility      = deviceObj.utility || '0m'
    _self.frequency    = deviceObj.frequency || 0

    // _self._setStatus(_self.health)

    for (var key in deviceObj) {
      if ('object' !== typeof deviceObj[key] && 'id' !== key && 'enabled' !== key) {
        deviceStatus.push(_self._buildStatusHtml(key, deviceObj[key]))
      }
    }

    return {
      summary: '<tr>' +
             '<td><i class="icon icon-'+ _self.status.icon + ' ' + _self.status.colour + '"></i></td>' +
             '<td class="' + _self.status.colour + '">' + _self.name + ' ' + _self.id + '</td>' +
             '<td>' + _self.temperature + '</td>' +
             '<td>' + _self.hashrate_5s + '</td>' +
             '<td>' + _self.accepted + '</td>' +
             '<td>' + _self.rejected + '</td>' +
             '<td>' + _self.utility + '</td>' +
             '<td>' + _self.hw_errors + '</td>' +
             '</tr>',
      status: '<div class="tab-pane fade" id="rig-' + _self.rigID  + '-' + _self.name + '-' +_self.id + '">' +
              '<div class="panel-body panel-body-stats">' +
              '<div class="panel-body-summary">' +
              deviceStatus.join('') +
              '</div>' +
              '</div>' +
              '</div>',
      nav: '<li>' +
           '<a class="rig-' + _self.rigID  + '-' + _self.name + '-' +_self.id + ' ' + _self.status.colour + '" href="#rig-' + _self.rigID  + '-' + _self.name + '-' +_self.id +'" data-toggle="tab">' + _self.name + ' ' + _self.id + ' <i class="icon icon-' + _self.status.icon + '"></i></a>' +
           '</li>'
    }
  }

  /*-----  End of Device Public Methods  ------*/


  /*=================================================
  =            Device Private Methods            =
  =================================================*/

  Device.prototype._buildStatusHtml = function (name, value) {
    return '<div class="stat-pair">' +
           '<div class="stat-value">' + value + '</div>' +
           '<div class="stat-label">' + name.replace(/_|-|\./g, ' ') + '</div>' +
           '</div>'
  }

  // Device.prototype._setStatus = function (status) {
  //   status = status.toLowerCase()

  //   if (this.HW_ENABLED && this.hw_errors >= this.HW_DANGER) {
  //     status = 'dead'
  //   }

  //   if (this.HW_ENABLED && this.hw_errors >= this.HW_WARNING) {
  //     status = 'sick'
  //   }

  //   if (this.HEAT_DANGER <= this.temperature) {
  //     status = 'hot'
  //   }

  //   if (this.HEAT_WARNING <= this.temperature) {
  //     status = 'warm'
  //   }

  //   switch (status) {
  //     case 'disabled':
  //       this.status.colour = 'grey'
  //       this.status.icon   = 'ban-circle'
  //       this.panel         = 'offline'
  //       break
  //     case 'dead':

  //       this.status.colour = 'red'
  //       this.status.icon   = 'danger'
  //       this.panel         = 'danger'
  //       break
  //     case 'sick':
  //       this.status.colour = 'orange'
  //       this.status.icon   = 'warning-sign'
  //       this.panel         = 'warning'
  //       break
  //     case 'hot':
  //       this.status.colour = 'red'
  //       this.status.icon   = 'hot'
  //       this.panel         = 'danger'
  //       break
  //     case 'warm':
  //       this.status.colour = 'orange'
  //       this.status.icon   = 'fire'
  //       this.panel         = 'warning'
  //       break
  //     default:
  //       this.status.colour = 'green'
  //       this.status.icon   = 'cpu-processor'
  //       this.panel         = ''
  //   }
  // }


  /*-----  End of Device Private Methods  ------*/


  /*========================================
  =            Device export               =
  ========================================*/

  // root.Device = Device
  root.DeviceCollection.prototype.SubClass = Device

  /*-----  End of Device export  ------*/

} (window, window.jQuery)
