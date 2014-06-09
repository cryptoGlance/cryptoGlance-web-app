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
    if (value < 1) {
      return(value * 1000) + ' KH/S';
    }
    else if (value > 1000) {
      return parseFloat(value/1000).toFixed(2) + ' GH/S';
    } else {
      return parseFloat(value).toFixed(2) + ' MH/S';
    }
  }

  Util.extractHashrate = function (hashrate) {
    if ('number' === typeof hashrate) {
      return hashrate
    }

    var regex = /^(\d{1,})\s?(KH\/s|MH\/s|GH\/s)$/gi
    var value
    var unit

    if (regex.test(hashrate)) {
      var matches = hashrate.replace(regex, function (arr, v, u) {
          value = parseFloat(v)
          unit = u.toLowerCase()
          return arr
      })

      switch (unit) {
        case 'gh/s':
          value = value * 1e6
          break
        case 'mh/s':
          value = value * 1e3
          break
        case 'kh/s':
        default:
          value = value
      }

      return value
    }
    else {
      throw 'Error:: invalid value for parameter {hashrate}'
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
