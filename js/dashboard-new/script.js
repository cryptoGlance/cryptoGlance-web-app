$(document).ready(function() {
    var rigs = new Rigs();
    
    $('.panel-rig').each(function() {
        var rigId = $(this).attr('data-id');
        rigs.add(rigId);
    });
    
    rigs.generateOverview();
});
