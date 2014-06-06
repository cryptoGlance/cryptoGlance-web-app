!function (root, $) {

  var Rig = function (rigId) {
    this.rigId = rigId
    this.$rigEl = $('#rig-' + rigId)
    this.$rigNavEl = this.$rigEl.find('.nav')
    this.$rigTabContentEl = this.$rigEl.find('.tab-content')
    this.$rigTitle = this.$rigEl.find('h1')
    this.$rigOverviewRow = $('tr[data-rig="'+ rigId +'"]', overviewTable)
  }

  Rig.prototype.start = function () {
    this.$rigEl.removeClass('panel-warning panel-danger')
  }

  Rig.prototype.update = function () {}

  Rig.prototype.generateOverview = function() {
    $.ajax({
        type: 'post',
        data : {
          type: 'miners',
          action: 'overview'
        },
        url: 'ajax.php',
        dataType: 'json'
    });

    var overview = $('#overview')
    var overviewTableData = ''

    $('#overview .panel-body-overview div table tbody').append()
  }

  $(document).on('update.rigs', update)

  root.Rig = Rig

}(window, window.jQuery)
