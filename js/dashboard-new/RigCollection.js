/**

  TODO:
  - continue breaking apart old rigs.js (stopped at line 190)
  - setup data synchronization of RigCollection overview

**/

!function (root, $) {

  /*==========  RigCollection object/class/constructor  ==========*/

  var RigCollection = function () {
    this.collection = []
  }

  /*==========  Public methods  ==========*/

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

  /*==========  Private methods  ==========*/


  /*==========  Export RigCollection  ==========*/

  root.RigCollection = RigCollection

}(window, window.jQuery)
