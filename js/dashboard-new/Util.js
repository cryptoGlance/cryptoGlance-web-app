/**

  TODO:
  - continue to add to Util class

**/

!function (root, $) {

  /*=====================================================
  =            Util Class/Object/Constructor            =
  =====================================================*/
  var Util = function () {
    throws 'Error:: Util is an abstract class, and should not be instantiated!'
  }

  /*-----  End of Util Class/Object/Constructor  ------*/


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

  Util.buildStat = function (name, value, progress, share) {
    return '<div class="stat-pair">' +
            '<div class="stat-value">' + value + '</div>' +
            '<div class="stat-label">' + name.replace(/_|-|\./g, ' ') + '</div>' +
            '<div class="progress progress-striped">' +
            '<div class="progress-bar progress-bar-' + progress + '" style="width: ' + share +'%">' +
            '</div>' +
            '</div>' +
            '</div>'
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
