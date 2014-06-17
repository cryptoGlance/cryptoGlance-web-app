/**

  TODO:
  - scaffold Device Collection class

**/

!function (root, $) {

  /*=================================================================
  =            DeviceCollection Class/Object/Constructor            =
  =================================================================*/

  var DeviceCollection = function (rigID) {
    this.collection        = []
    this.rigID             = rigID
    this.$summaryTable     = $('#rig-' + rigID + '-summary table')
    this.$summaryTableBody = $('#rig-' + rigID + '-summary table tbody')
    this.$deviceNav        = $('#rig-' + rigID + '-summary .nav')
    this.$deviceStatus     = $('#rig-' + rigID + '-summary .nav')
    this.count             = 0
  }

  /*-----  End of DeviceCollection Class/Object/Constructor  ------*/


  /*=======================================================
  =            DeviceCollection Public Methods            =
  =======================================================*/

  DeviceCollection.prototype.add = function(deviceID) {
    this.count++
    this.collection.push(new this.SubClass(deviceID))
  }

  DeviceCollection.prototype.update = function (deviceList) {
    var deviceUpdate
    var deviceSummary = []
    var deviceNav = []
    var deviceStatus = []
    this.collection.forEach(function (device, index) {
      deviceUpdate = device.update(deviceList[index] || {})
      deviceSummary.push(deviceUpdate.summary)
      deviceNav.push(deviceUpdate.nav)
      deviceStatus.push(deviceUpdate.status)
    })
    deviceNav.unshift('<li>' +
                      '<a class="blue" href="#rig-3-summary" data-toggle="tab">Summary <i class="icon icon-dotlist"></i></a>' +
                      '</li>')
    this.$deviceNav.html(deviceNav.join(''))
    this.$summaryTable.show()
    this.$summaryTableBody.html(deviceSummary.join(''))
  }

  /*-----  End of DeviceCollection Public Methods  ------*/


  /*========================================================
  =            DeviceCollection Private Methods            =
  ========================================================*/



  /*-----  End of DeviceCollection Private Methods  ------*/


  /*===============================================
  =            DeviceCollection Export            =
  ===============================================*/

  root.DeviceCollection = DeviceCollection

  /*-----  End of DeviceCollection Export  ------*/

}(window, window.jQuery)
