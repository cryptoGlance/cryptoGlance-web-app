!function (root, $) {

  /*=================================================================
  =            DeviceCollection Class/Object/Constructor            =
  =================================================================*/

  var DeviceCollection = function (rigID) {
    this.collection = []
    this.rigID      = rigID
    this.length      = 0
  }

  /*-----  End of DeviceCollection Class/Object/Constructor  ------*/


  /*=======================================================
  =            DeviceCollection Public Methods            =
  =======================================================*/

  DeviceCollection.prototype.add = function(deviceID) {
    this.length++
    this.collection.push(new this.SubClass(deviceID, this.rigID))
  }

  DeviceCollection.prototype.update = function (deviceList) {
    var deviceUpdate
    var deviceSummary = []
    var deviceNav     = []
    var deviceStatus  = []

    this.collection.forEach(function (device, index) {
      deviceUpdate = device.update(deviceList[index] || {})
      deviceSummary.push(deviceUpdate.summary)
      deviceNav.push(deviceUpdate.nav)
      deviceStatus.push(deviceUpdate.status)
    })

    return {
      nav: deviceNav.join(''),
      summary: deviceSummary.join(''),
      status: deviceStatus.join('')
    }
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
