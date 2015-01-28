$(document).ready(function() {
    // rig specific script
    
    $('.enableDev', '#rigDeviceDetails').on('switchChange.bootstrapSwitch', function (event, state) {
        var minerId =  $('#rig-wrap').attr('data-rigId');
        var devTr = $(this).parentsUntil('tr').parent();
        var devType = $(devTr).attr('data-devType');
        var devId = $(devTr).attr('data-devId');
        
        if (typeof minerId != 'undefined' && typeof devId != 'undefined') {
            $.ajax({
                type: 'post',
                url: 'ajax.php?type=miners&action=dev-state&miner=' + minerId + '&devType='+ devType +'&dev=' + (parseInt(devId)+1) + '&state=' + state,
                dataType: 'json'
            }).always(function(data) {
                var devTds = $('td', devTr);
                $(devTds).eq(0).find('i').removeClass();
                $(devTds).eq(1).removeClass();
                if (state) {
                    $(devTds).eq(0).find('i').addClass('icon');
                    $(devTds).eq(0).find('i').addClass('icon-' + $(devTr).attr('data-icon'));
                    $(devTds).eq(0).find('i').addClass($(devTr).attr('data-status'));
                    $(devTds).eq(1).addClass($(devTr).attr('data-status'));
                } else {
                    $(devTds).removeClass();
                    $(devTds).eq(0).find('i').addClass('icon');
                    $(devTds).eq(0).find('i').addClass('icon-ban-circle');
                    $(devTds).eq(0).find('i').addClass('grey');
                    $(devTds).eq(1).addClass('grey');
                }
            });
        }
    });
    
    // activate pool
    $('input[name="enabledPool"]:radio', '#rigPoolDetails').on('switchChange.bootstrapSwitch', function (event, state) {
        var minerId =  $('#rig-wrap').attr('data-rigId');
        var poolId = $(this).parentsUntil('tr').parent().attr('data-poolId');

        if (typeof minerId != 'undefined' && typeof poolId != 'undefined') {
            $.ajax({
                type: 'post',
                url: 'ajax.php?type=miners&action=switch-pool&miner=' + minerId + '&pool=' + (parseInt(poolId)+1),
                dataType: 'json'
            }).done(function(data) {
                alert('pool updated?');
            });
        }
    });
    
    // Sortable Pools
    $('tbody', '#rigPoolDetails').sortable({
        placeholder: "ui-state-highlight",
        stop: function(event, ui) {
            var tbody = $(this);
            var minerId =  $('#rig-wrap').attr('data-rigId');
            var poolId = $(ui.item).attr('data-poolId');
            var priority = $(ui.item).index();
            
            if (typeof minerId != 'undefined' && typeof poolId != 'undefined' && typeof priority != 'undefined') {
                $.ajax({
                    type: 'post',
                    url: 'ajax.php?type=miners&action=prioritize-pools&miner=' + minerId + '&pool=' + (parseInt(poolId)+1) + '&priority=' + priority,
                    dataType: 'json'
                }).always(function(data) {
                    $.each($('tr', tbody), function() {
                        $('.priority', this).text($(this).index());
                    });
                    $('input[name="enabledPool"]:radio', '#rigPoolDetails').bootstrapSwitch('state', false, true);
                    $('input[name="enabledPool"]:radio:first', '#rigPoolDetails').bootstrapSwitch('state', true, true);
                });
            }
        }
    });
    
    // Add Pool
    $('#btnSavePool').click(function() {
        var minerId =  $('#rig-wrap').attr('data-rigId');
        var addPool = $('#addNewPool');
        var poolLabel = $('input.poolLabel', addPool).val();
        var poolUrl = $('input.poolUrl', addPool).val();
        var poolUser = $('input.poolUser', addPool).val();
        var poolPassword = $('input.poolPassword', addPool).val();
        var poolPriority = $('input.poolPriority', addPool).val();
        
        if (poolUrl != '' && poolUser != '') {
            $.ajax({
                type: 'post',
                url: 'ajax.php?type=miners&action=add-pool&miner=' + minerId,
                data: { label: poolLabel, url: poolUrl, user: poolUser, password: poolPassword, priority: poolPriority },
                dataType: 'json',
                statusCode: {
                    202: function() {
                        location.reload(true);
                    },
                    406: function() {
                        // not accepted - cgminer did not add pool correctly
                    },
                    409: function() {
                        // conflict - missing required params
                    }
                }
            });
        }
        
        
    });
});