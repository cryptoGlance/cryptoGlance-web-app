/**

  TODO:
  - finish general structure of Rig class

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
    this.$overview        = $('#overview')
    this.$overviewTable   = this.$overview.find('.panel-body-overview div table tbody');
    this.$rigOverviewRow  = this.$overviewTable.find('tr[data-rig="'+ rigId +'"]')
    this.deviceCollection = []
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

      if (this.$rigOverviewRow.length == 0) {
        $this.overviewTable.append('<tr data-rig="'+ this.rigId +'"></tr>')
      }
      this.$rigOverviewRow.html('<td><i class="icon icon-ban-circle grey"></i></td>' +
                                '<td><a href="#rig-'+ this.rigId +'" class="anchor-offset rig-'+ this.rigId +' grey">'+ this.$rigTitle.html().replace(' - OFFLINE', '') +'</a></td>' +
                                '<td>--</td>' +
                                '<td>--</td>' +
                                '<td>--</td>')

      this.$rigEl.removeClass('panel-warning panel-danger').addClass('panel-offline')
      this.$rigEl.find('.btn-manage-rig').hide()
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
          stats += Util.buildStat(key, summary[key], 'success', ((summary[key]/totalShares) * 100).toFixed(0))
          break
        case 'rejected':
        case 'stale':
          stats += Util.buildStat(key, summary[key], 'danger', ((summary[key]/totalShares) * 100).toFixed(0))
          break
        case 'hashrate_5s':
          hashrateCollection[this.rigId] = summary[key]
        case 'hashrate_avg':
          stats += Util.buildStat(key, Util.getSpeed(summary[key]), null, null)
          break
        default:
          stats += Util.buildStat(key, summary[key], null, null)
      }
    }

    this.clearNav()
    $summaryContentTab.append(stats)
    this._updateDevices(devices)

    this.$rigNavEl.find('li:eq('+ selectedNav +')').addClass('active');
    this.$rigTabContentEl.find('.tab-pane:eq('+ selectedNav +')').addClass('active');
  }

  /*-----  End of Rig Public Methods  ------*/


  /*===========================================
  =            Rig Private Methods            =
  ===========================================*/



  /*-----  End of Rig Private Methods  ------*/


  /*==================================
  =            Rig Export            =
  ==================================*/

  root.Rig = Rig

  /*-----  End of Rig Export  ------*/

}(window, window.jQuery)
