/**

  TODO:
  - finish updateDevice's method
  - continue breaking apart old rigs.js (stopped at line 190)
  - finish creating rest of public methods
  - finish creating rest of private methods

**/

!function (root, $) {

  /*==========  Rig object/class/constructor  ==========*/

  var Rig = function (rigId) {
    this.rigId            = rigId
    this.$rigEl           = $('#rig-' + rigId)
    this.$rigNavEl        = this.$rigEl.find('.nav')
    this.$rigTabContentEl = this.$rigEl.find('.tab-content')
    this.$rigTitle        = this.$rigEl.find('h1')
    this.$rigOverviewRow  = $('tr[data-rig="'+ rigId +'"]', overviewTable)
    this.status           = 'green'
    this.icon             = 'check'
    this.panel            = ''
  }

  /*==========  Public methods  ==========*/

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


  /*==========  Private methods  ==========*/

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
    $.each(rig.devs, function (devType, devTypes) {
        $.each(devTypes, function (devIndex, dev) {
            // Status colours
            var status = dev.health;
            var icon = '';
            if (dev.enabled == 'N') {
                status = 'grey';
                icon = 'ban-circle';
                rigPanel = 'offline';
            } else if (status == 'Dead' || (devHWEnabled && dev.hw_errors >= devHWDanger)) {
                status = 'red';
                icon = 'danger';
                rigStatus = 'red';
                rigIcon = 'danger';
                rigPanel = 'danger';
            } else if (status == 'Sick' || (devHWEnabled && dev.hw_errors >= devHWWarning)) {
                status = 'orange';
                icon = 'warning-sign';
                if (rigIcon != 'danger') {
                    rigStatus = 'orange';
                    rigIcon = 'warning-sign';
                    rigPanel = 'warning';
                }
            } else if (devHeatDanger <= dev.temperature) {
                status = 'red';
                icon = 'hot';
                if (rigIcon != 'danger' && rigIcon != 'warning-sign') {
                    rigStatus = 'red';
                    rigIcon = 'hot';
                    rigPanel = 'danger';
                }
            } else if (devHeatWarning <= dev.temperature) {
                status = 'orange';
                icon = 'fire';
                if (rigIcon != 'danger' && rigIcon != 'warning-sign' && rigIcon != 'hot') {
                    rigStatus = 'orange';
                    rigIcon = 'fire';
                    rigPanel = 'warning';
                }
            } else {
                status = 'green';
                icon = 'cpu-processor';
            }

            if (rigPanel != '') {
                $(rigElm).addClass('panel-' + rigPanel);
            }

            // add dev to Nav
            $(rigNavElm).append('<li><a class="rig-'+ rigId +'-'+ devType +'-'+ devIndex +' '+ status +'" href="#rig-'+ rigId +'-'+ devType +'-'+ devIndex +'" data-toggle="tab">'+ devType + devIndex +' <i class="icon icon-'+ icon +'"></i></a></li>');
            $(rigTabContentElm).find('#rig-'+ rigId +'-'+ devType +'-'+ devIndex).remove();
            $(rigTabContentElm).append('<div class="tab-pane fade in" id="rig-'+ rigId +'-'+ devType +'-'+ devIndex +'"><div class="panel-body panel-body-stats"></div></div>');

            // Updating DEV Content Tab
            var devContentTab = $(rigTabContentElm).find('#rig-' + rigId + '-'+ devType +'-' + dev.id).find('.panel-body-stats');
            $(devContentTab).find('div').remove();
            $.each(dev, function(k, v) {
                if (k != 'id' && k != 'enabled') {
                    if (k == 'temperature') {
                        v = v + '&deg;C';
                    } else if (k == 'hashrate_5s' || k == 'hashrate_avg') {
                        if (v < 1) {
                            v = (v*1000) + ' KH/S';
                        } else if (v > 1000) {
                            v = parseFloat(v/1000).toFixed(2) + ' GH/S';
                        } else {
                            v = v + ' MH/S';
                        }
                    }

                    $(devContentTab).append('<div class="stat-pair"><div class="stat-value">'+v+'</div><div class="stat-label">'+k.replace(/_|-|\./g, ' ')+'</div></div>');
                }
            });

            // Update Summary Page of DEVs
            if (!removeTable) {
                if (dev.hashrate_5s < 1) {
                    dev.hashrate_5s = (dev.hashrate_5s*1000) + ' KH/S';
                } else if (dev.hashrate_5s > 1000) {
                    dev.hashrate_5s = parseFloat(dev.hashrate_5s/1000).toFixed(2) + ' GH/S';
                } else {
                    dev.hashrate_5s += ' MH/S';
                }

                $(summaryContentTabTableBody).append('<tr><td><i class="icon icon-'+ icon +' '+status+'"></i></td><td class="'+status+'">'+ devType + dev.id+'</td><td>'+dev.temperature+'&deg;C</td><td>'+dev.hashrate_5s+'</td><td>'+dev.accepted+'</td><td>'+dev.rejected+'</td><td>'+dev.utility+'</td><td>'+dev.hw_errors+'</td></tr>');
            }

        });
    });

  }


  /*==========  Export Rig constructor  ==========*/

  root.Rig = Rig

}(window, window.jQuery)
