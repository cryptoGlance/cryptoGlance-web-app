/**

  TODO:
  - scaffold Device Collection class

**/

!function (root, $) {

  /*=================================================================
  =            DeviceCollection Class/Object/Constructor            =
  =================================================================*/

  var DeviceCollection = function (rigID) {
    this.rigID             = rigID
    this.$summaryTable     = $('#rig-' + rigID + '-summary table')
    this.$summaryTableBody = $('#rig-' + rigID + '-summary table tbody')
    this.collection        = []
    this.count             = 0
  }

  /*-----  End of DeviceCollection Class/Object/Constructor  ------*/


  /*=======================================================
  =            DeviceCollection Public Methods            =
  =======================================================*/

  DeviceCollection.prototype.add = function(deviceID) {
    this.count++
    this.collection.push(new Device(deviceID))
  }

  DeviceCollection.prototype.update = function (deviceList) {
    var deviceSummary = ''
    this.collection.forEach(function (device, index) {
      deviceSummary += device.update(deviceList[index] || {})
    })
    this.$summaryTable.show()
    this.$summaryTableBody.html(deviceSummary)
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
