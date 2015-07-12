/**

  TODO:
  - continue to add to Util class

**/

!function (root, $) {

  'use strict';

  /*===============================================
  =            Util Abstract Singleton            =
  ===============================================*/

  var Util = function () {
    throw 'Error:: Util is an abstract class, and should not be instantiated!'
  }

 /*-----  End of Util Abstract Singleton  ------*/


  /*===========================================
  =            Util Public Methods            =
  ===========================================*/

  Util.getSpeed = function (value) {
    if (value > 1e9) {
      return parseFloat(value/1e9).toFixed(2) + ' PH/s'
    }
    else if (value > 1e6) {
      return parseFloat(value/1e6).toFixed(2) + ' TH/s'
    }
    else if (value > 1e3) {
      return parseFloat(value/1e3).toFixed(2) + ' GH/s'
    }
    else if (value < 1) {
      return parseFloat(value * 1e3).toFixed(2) + ' KH/s'
    }

    return value.toFixed(2) + ' MH/s'
  }

  Util.extractHashrate = function (hashrate) {
    if (!hashrate) {
      return 0
    }
    if ('number' === typeof hashrate) {
      return hashrate
    }

    var regex = /^(\d{1,}|\d{1,}\.\d{1,})?\s?(KH\/s|MH\/s|GH\/s)$/gi
    var value
    var unit

    if (regex.test(hashrate)) {
      var matches = hashrate.replace(regex, function (arr, v, u) {
          value = parseFloat(v)
          unit = u.toLowerCase()
          return arr
      })

      switch (unit) {
        case 'ph/s':
          value = value * 1e9
          break
        case 'th/s':
          value = value * 1e6
          break
        case 'gh/s':
          value = value * 1e3
          break
        case 'kh/s':
          value = value / 1e3
          break
        case 'mh/s':
        default:
          value = value
      }

      return value
    }
    else {
      throw 'Error:: invalid value of  { ' + hashrate + ' } for parameter hashrate'
    }
  }

  /*-----  End of Util Public Methods  ------*/


  /*============================================
  =            Util Private Methods            =
  ============================================*/



  /*-----  End of Util Private Methods  ------*/


  /*===================================
  =            Util Export            =
  ===================================*/

  root.Util = Util

  /*-----  End of Util Export  ------*/



}(window, window.jQuery)
