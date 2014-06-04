var Rigs = function() {
    
    var _rigs = [];
    
    var add = function(rigId) {
        this._rigs[rigId] = [];
    }
    
    var generateOverview = function() {
        $.ajax({
            type: 'post',
            url: 'ajax.php?type=miners&action=overview',
            dataType: 'json'
        });
    
        var overview = $('#overview');
        var overviewTableData = '';
        for (index = 0; index < a.length; ++index) {
            
        }
        
        $('#overview .panel-body-overview div table tbody').append();
    }
    
}