/**

  TODO:
  - finish general structure of RigCollection class
  - setup data synchronization of RigCollection overview

**/

!function (root, $) {

  'use strict';

  /*==============================================================
  =            RigCollection Class/Object/Constructor            =
  ==============================================================*/

  var RigCollection = function () {
    this.collection = []
    this.overallHashrate = 0

    this.$overview = $('#overview')
    this.$overviewTable = $('#overview-table')
    this.overviewTableData = ''
    // $summaryContentTabTable.show()
  }

  /*-----  End of RigCollection Class/Object/Constructor  ------*/


  /*====================================================
  =            RigCollection Public Methods            =
  ====================================================*/

  RigCollection.prototype.add = function (rigId) {
    this.collection.push(new Rig(rigId))
  }

  RigCollection.prototype.start = function() {
    this.collection.forEach(function (rig) {
      rig.start()
    })
  }

  RigCollection.prototype.update = function () {
    var _self = this
    $.ajax({
      type: 'post',
      data : {
        type: 'miners',
        action: 'overview'
      },
      url: 'ajax.php',
      dataType: 'json'
    })
    .done(function (data) {
      data.forEach(function (overview, index) {
      _self.overviewTableData += _self._buildOverviewRow(overview, index)
      _self.overallHashrate = Util.extractHashRate(overview.hashrate_5s)
      })

      _self.overallHashrate = Util.getSpeed(_self.overallHashrate)

      _self.$overviewTable.find('tbody').html(_self.overviewTableData)

      $('.total-hashrate').html(_self.overallHashrate)

      _self._updateDocumentTitle(_self.overallHashrate)

    })
  }

  /*-----  End of RigCollection Public Methods  ------*/


  /*=====================================================
  =            RigCollection Private Methods            =
  =====================================================*/

  RigCollection.prototype._updateDocumentTitle = function (str) {
    document.title = str + ' | Dashboard :: cryptoGlance'
  }

  RigCollection.prototype._buildOverviewRow = function (overview, index) {
    return '<tr data-rig="'+ index +'">' +
           '<td><i class="icon icon-'+ overview.status_icon +' '+ overview.status_colour +'"></i></td>' +
           '<td><a href="#rig-'+ index +'" class="anchor-offset rig-'+ index +' '+ overview.status_colour +'">'+ $('#rig-'+ index + ' h1').html() +'</a></td>' +
           '<td>'+ overview.hashrate_5s +'</td>' +
           '<td>'+ overview.active_pool.url +'</td>' +
           '<td>'+ overview.uptime +'</td>' +
           '</tr>'
  }

  /*-----  End of RigCollection Private Methods  ------*/


  /*============================================
  =            RigCollection Export            =
  ============================================*/

  root.RigCollection = RigCollection

  /*-----  End of RigCollection Export  ------*/

}(window, window.jQuery)
