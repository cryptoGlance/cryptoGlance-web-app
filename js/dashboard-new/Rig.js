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

  root.Rig = Rig

}(window, window.jQuery)
