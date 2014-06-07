/**

  TODO:
  - continue breaking apart old rigs.js (stopped at line 190)
  - setup data synchronization of RigCollection overview

**/

!function (root, $) {

  /*==============================================================
  =            RigCollection Class/Object/Constructor            =
  ==============================================================*/

  var RigCollection = function () {
    this.collection = []
  }

  /*-----  End of RigCollection Class/Object/Constructor  ------*/


  /*====================================================
  =            RigCollection Public Methods            =
  ====================================================*/

  RigCollection.prototype.add = function (rig) {
    this.collection.push(rig)
  }

  RigCollection.prototype.update = function () {}

  RigCollection.prototype.generateOverview = function () {

    var overview = $('#overview')
    var overviewTableData = ''

    $.ajax({
      type: 'post',
      data : {
        type: 'miners',
        action: 'overview'
      },
      url: 'ajax.php',
      dataType: 'json'
    })

    $('#overview .panel-body-overview div table tbody').append()
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
