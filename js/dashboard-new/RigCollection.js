/**

  TODO:
  - finish general structure of RigCollection class
  - setup data synchronization of RigCollection overview

**/

!function (root, $) {

  /*==============================================================
  =            RigCollection Class/Object/Constructor            =
  ==============================================================*/

  var RigCollection = function () {
    this.collection = []
    this.overallHashrate = 0

    this.$overview = $('#overview')
    var overviewTableData = ''
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

      $('#overview .panel-body-overview div table tbody').append()

      // Update Overview Panel
      rig.summary.hashrate_5s = Util.getSpeed(rig.summary.hashrate_5s =)


      // update overview
      if ($rigOverviewRow.length == 0) {
          $overviewTable.append('<tr data-rig="'+ rigId +'"></tr>');
          rigOverviewRow = $('tr[data-rig="'+ rigId +'"]', overviewTable)
      }
      rigOverviewRow = '<td><i class="icon icon-'+ rigIcon +' '+ rigStatus +'"></i></td>' +
                       '<td><a href="#rig-'+ rigId +'" class="anchor-offset rig-'+ rigId +' '+ rigStatus +'">'+ $('h1', rigElm).html() +'</a></td>' +
                       '<td>'+ rig.summary.hashrate_5s +'</td>' +
                       '<td>'+ rig.summary.active_mining_pool +'</td>' +
                       '<td>'+ rig.summary.uptime +'</td>'
      $rigOverviewRow.html(rigOverviewRow)

      $summaryContentTabTable.show();

       // Total amount of hash power
      for (key in hashrateCollection) {
          overallHashrate += parseFloat(hashrateCollection[key]);
      }

      overallHashrate = Util.getSpeed(overallHashrate)

      $('.total-hashrate').html(overallHashrate);
      document.title = overallHashrate + ' | Dashboard :: cryptoGlance'

    })
  }

  /*-----  End of RigCollection Public Methods  ------*/


  /*=====================================================
  =            RigCollection Private Methods            =
  =====================================================*/



  /*-----  End of RigCollection Private Methods  ------*/


  /*============================================
  =            RigCollection Export            =
  ============================================*/

  root.RigCollection = RigCollection

  /*-----  End of RigCollection Export  ------*/

}(window, window.jQuery)
