/**

  TODO:
  - continue breaking apart old rigs.js (stopped at line 172)
  - finish creating rest of public methods
  - finish creating rest of private methods

**/

!function (root, $) {

  /*==========  Rig object/class/constructor  ==========*/

  var Rig = function (rigId) {
    this.rigId = rigId
    this.$rigEl = $('#rig-' + rigId)
    this.$rigNavEl = this.$rigEl.find('.nav')
    this.$rigTabContentEl = this.$rigEl.find('.tab-content')
    this.$rigTitle = this.$rigEl.find('h1')
    this.$rigOverviewRow = $('tr[data-rig="'+ rigId +'"]', overviewTable)
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
        case 'hashrate_avg':
          stats += this._buildStat(key, this._getSpeed(summary[key]), null, null)
          break
        default:
          stats += this._buildStat(key, summary[key], null, null)
      }

    }
    // if (k == 'hashrate_5s' || k == 'hashrate_avg') {
    //     if (k == 'hashrate_5s') {
    //         hashrateCollection[rigId] = v;
    //     }
    // }

    $summaryContentTab.append(stats)
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
  };


  /*==========  Export Rig constructor  ==========*/

  root.Rig = Rig

}(window, window.jQuery)
