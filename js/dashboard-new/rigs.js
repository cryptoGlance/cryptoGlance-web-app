var Rigs = function() {
  this._rigs = [];
}

Rigs.prototype.add = function (rigId) {
  this._rigs[rigId] = [];
}

Rigs.prototype.generateOverview = function() {
  $.ajax({
      type: 'post',
      data : {
          type: 'miners',
          action: 'overview'
      }
      url: 'ajax.php',
      dataType: 'json'
  });

  var overview = $('#overview');
  var overviewTableData = '';
  for (index = 0; index < a.length; ++index) {

  }

  $('#overview .panel-body-overview div table tbody').append();
}