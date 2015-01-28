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
    this.temperature_c  = 'n/a'
    this.temperature_f  = 'n/a'
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
    var deviceStatus  = []

    this.id           = deviceObj.id
    this.name         = deviceObj.name || 'Device'
    this.status       = deviceObj.status || { icon: 'cpu-processor', colour: 'green' }
    this.health       = deviceObj.health || 'Alive'
    this.icon         = deviceObj.status.icon || 'check'
    this.enabled      = deviceObj.enabled + '' || 'N'
    this.hashrate_avg = deviceObj.hashrate_avg + '' || '0 KH/s'
    this.hashrate_5s  = Util.getSpeed(deviceObj.hashrate_5s) + '' || '0 KH/s'
    this.temperature  = deviceObj.temperature || { celsius: 0, fahrenheit: 0 }
    this.accepted     = deviceObj.accepted || { raw: 'n/a', percent: '%' }
    this.rejected     = deviceObj.rejected || { raw: 'n/a', percent: '%' }
    this.hw_errors    = deviceObj.hw_errors || { raw: 'n/a', percent: '%' }
    this.utility      = deviceObj.utility + '' || '0m'
    this.frequency    = deviceObj.frequency + '' || 0

    var DOMId         = 'rig-' + this.rigID  + '-' + this.name + '-' + this.id
    var deviceName    = this.name + ' ' + this.id

    var fanTest = new RegExp('fan_([0-9]+)');
    var tempTest = new RegExp('temperature_([0-9]+)');
    for (var key in deviceObj) {
      switch (key) {
        case 'id':
        case 'enabled':
        case 'status':
          break // skip these values
        case 'temperature':
          deviceStatus.push(this._buildStatusHtml(key,
                                                  deviceObj[key].celsius + '&deg;C / ' + deviceObj[key].fahrenheit + '&deg;F',
                                                  null,
                                                  null))
          break
        case 'fan_speed':
          deviceStatus.push(this._buildStatusHtml(key,
                                                  deviceObj[key].raw + ' RPM (' + deviceObj[key].percent + '%)',
                                                  null,
                                                  null))
          break
        case (key.match(/^fan_([0-9]+)/) || {}).input:
          deviceStatus.push(this._buildStatusHtml(key,
                                                  deviceObj[key] + ' RPM',
                                                  null,
                                                  null))
          break
        case (key.match(/^temperature_([0-9]+)/) || {}).input:
          deviceStatus.push(this._buildStatusHtml(key,
                                                  deviceObj[key].celsius + '&deg;C / ' + deviceObj[key].fahrenheit + '&deg;F',
                                                  null,
                                                  null))
          break
        case 'accepted':
          deviceStatus.push(this._buildStatusHtml(key,
                                                  deviceObj[key].raw + ' <span>(' + deviceObj[key].percent + '%)</span>',
                                                  'success',
                                                  deviceObj[key].percent))
          break
        case 'rejected':
          deviceStatus.push(this._buildStatusHtml(key,
                                                  deviceObj[key].raw + ' <span>(' + deviceObj[key].percent + '%)</span>',
                                                  'danger',
                                                  deviceObj[key].percent))
          break
        case 'hw_errors':
          deviceStatus.push(this._buildStatusHtml(key,
                                                  deviceObj[key].raw + ' <span>(' + deviceObj[key].percent + '%)</span>',
                                                  null,
                                                  deviceObj[key].percent))
          break
        case 'hashrate_5s':
        case 'hashrate_avg':
          deviceStatus.push(this._buildStatusHtml(key,
                                                  Util.getSpeed(deviceObj[key]),
                                                  null,
                                                  null))
          break
        default:
          deviceStatus.push(this._buildStatusHtml(key, deviceObj[key]))
      }
    }

    return {
      summary: '<tr>' +
               '<td><i class="icon icon-'+ this.status.icon + ' ' + this.status.colour + '"></i></td>' +
               '<td class="' + this.status.colour + '">' +
               '<a href="#" data-target=".' + DOMId + '[data-toggle=\'tab\']">' + deviceName + '</a>' +
               '</td>' +
               '<td>' + this.temperature.celsius + '&deg;C / ' + this.temperature.fahrenheit + '&deg;F</td>' +
               '<td>' + this.hashrate_5s + '</td>' +
               '<td>' + this.accepted.raw + ' <span>(' + this.accepted.percent + '%)</span>' + '</td>' +
               '<td>' + this.rejected.raw + ' <span>(' + this.rejected.percent + '%)</span>' + '</td>' +
               '<td>' + this.utility + '</td>' +
               '<td>' + this.hw_errors.raw + ' <span>(' + this.hw_errors.percent + '%)</span>' + '</td>' +
               '</tr>',
      status: '<div class="tab-pane fade" id="' + DOMId + '">' +
              '<div class="panel-body panel-body-stats">' +
              '<div class="panel-body-summary">' +
              deviceStatus.join('') +
              '</div>' +
              '</div>' +
              '</div>',
      nav: '<li>' +
           '<a class="' + DOMId + ' ' + this.status.colour + '" href="#' + DOMId +'" data-toggle="tab">' + deviceName + ' <i class="icon icon-' + this.status.icon + '"></i></a>' +
           '</li>'
    }
  }

  /*-----  End of Device Public Methods  ------*/


  /*=================================================
  =            Device Private Methods            =
  =================================================*/

  Device.prototype._buildStatusHtml = function (name, value, progress, share) {
    return '<div class="stat-pair">' +
            '<div class="stat-value">' + value + '</div>' +
            '<div class="stat-label">' + name.replace(/_|-|\./g, ' ') + '</div>' +
            '<div class="progress progress-striped">' +
             '<div class="progress-bar progress-bar-' + progress + '" style="width: ' + share + '%"></div>' +
            '</div>' +
           '</div>'
  }


  /*-----  End of Device Private Methods  ------*/


  /*========================================
  =            Device export               =
  ========================================*/

  // root.Device = Device
  root.DeviceCollection.prototype.SubClass = Device

  /*-----  End of Device export  ------*/

} (window, window.jQuery)
