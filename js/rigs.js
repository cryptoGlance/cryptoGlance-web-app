// Update call by seconds
setInterval(function() {
    ajaxUpdateCall('rig');
}, rigUpdateTime);

// Update by Long Poll method... Bad idea. Those who like to explore can experiment with this. ONLY USE THIS ON YOUR RIGS!
//(function rigUpdateCall(){
//    $.ajax({
//        url: 'ajax.php?type=update&action=rig',
//        success: function(data){
//            if (typeof data.rigs != 'undefined') {
//                updateRigs(data.rigs);
//            }
//        },
//        dataType: "json",
//        complete: rigUpdateCall,
//        timeout: rigUpdateTime
//    });
//})();

// Update json data
function rigUpdateCall(action, actionAttr) {
    var queryUrl = action;
    if (typeof actionAttr != 'undefined') {
        queryUrl = action + '&attr=' + actionAttr;
    }
    
    if (typeof ajaxCall == 'object') {
        ajaxCall.abort();
    }
    
    ajaxCall = $.ajax({
        type: 'post',
        url: 'ajax.php?type=update&action=' + queryUrl,
        dataType: 'json'
    }).done(function(data) {
        if (typeof data.rigs != 'undefined') {
            updateRigs(data.rigs);
        }
        if (typeof data.pools != 'undefined') {
            updatePools(data.pools);
        }
        if (typeof data.wallets != 'undefined') {
            updateWallets(data.wallets);
        }
    });
}


// Manage Rig
$('.btn-manage-rig').click(function() {
    var minerId = $(this).attr('data-attr');
    var manageRig = $('#manageRig');
    $(manageRig).attr('data-attr', minerId);
    $('.rig-name', manageRig).html($('.panel-title .value', '#rig-'+minerId).text());
});

// Switch Pools
$('.btn-switchpool', '#manageRig').click(function() {
    var minerId = $('#manageRig').attr('data-attr');
    var switchPoolModal = $('#switchPool .checkbox');
    $(switchPoolModal).html('');
    $.ajax({
        type: 'post',
        url: 'ajax.php?type=miners&action=get-pools&miner=' + minerId,
        dataType: 'json'
    }).done(function(data) {
        if (typeof data != 'undefined') {
            $('#switchPool').attr('data-minerId', minerId);
            $.each(data, function(v,k) {
                var poolUrl = k.url;
                poolUrl = poolUrl.replace (/\:[0-9]{1,4}/, '');
                poolUrl = poolUrl.substring(poolUrl.indexOf("/") + 2);
                
                $(switchPoolModal).append('<label for="rig'+ minerId +'-pool'+ k.id +'"><input type="radio" name="switchPoolList" id="rig'+ minerId +'-pool'+ k.id +'" value="'+ k.id +'"><span>'+ poolUrl +'</span></label>');
                if (k.active == 1) {
                    $('input:radio[id=rig'+ minerId +'-pool'+ k.id +']', switchPoolModal).prop('checked', true);
                }
            });
            
        }
    });
});
$('#switchPool .btn-success').click(function() {
    var minerId =  $('#switchPool').attr('data-minerId');
    var selectedPoolId = $('input[name=switchPoolList]:checked', '#switchPool .checkbox').val();
    if (typeof selectedPoolId != 'undefined') {
        $.ajax({
            type: 'post',
            url: 'ajax.php?type=miners&action=switch-pool&miner=' + minerId + '&pool=' + (parseInt(selectedPoolId)+1),
            dataType: 'json'
        });
        
        ajaxUpdateCall('all');
    }
});

// Restart
$('.btn-restart', '#manageRig').click(function() {
    var minerId = $('#manageRig').attr('data-attr');
    $.ajax({
        type: 'post',
        url: 'ajax.php?type=miners&action=restart&miner=' + minerId,
        dataType: 'json'
    });
});

function updateRigs (data) {
    var overallHashrate = 0;
    
    var overview = $('#overview');
    var overviewTable = $(overview).find('.panel-body-overview div table tbody');
    $(overviewTable).find('tr').remove();

    $.each(data, function( rigIndex, rig ) {
        var rigId = (rigIndex+1);
        var rigElm = $('#rig-'+rigId);
        var rigNavElm = $(rigElm).find('.nav');
        var rigTabContentElm = $(rigElm).find('.tab-content');
        var rigTitle = $('h1', rigElm);
        var devWarning = false;
        var devDanger = false;

        if (rig == null || typeof rig.summary == 'undefined' || typeof rig.devs == 'undefined') {
            $(rigElm).find('.toggle-panel-body').hide();
            $(rigNavElm).hide();
            $(rigTabContentElm).hide();
            $(rigElm).find('.panel-footer').hide();
            if ($(rigTitle).html().indexOf(' - OFFLINE') == -1) {
                $(rigTitle).append(' - OFFLINE');
            }
            return true;
        } else {
            $(rigElm).find('.toggle-panel-body').show();
            $(rigNavElm).show();
            $(rigTabContentElm).show();
            $(rigElm).find('.panel-footer').show();
            $(rigTitle).html($(rigTitle).html().replace(' - OFFLINE', ''));
        }
    
        // Clear nav items
        var selectedNav = $(rigNavElm).find('.active').index();
        if (selectedNav == -1) selectedNav = 0;
        $(rigNavElm).find('li').remove();
        
        // Update Summary
        $(rigNavElm).append('<li><a class="blue" href="#rig-'+ rigId +'-summary" data-toggle="tab">Summary <i class="icon icon-dotlist"></i></a></li>');
        var summaryContentTab = $(rigTabContentElm).find('#rig-' + rigId + '-summary').find('.panel-body-summary');
        $(summaryContentTab).find('div').remove();
        var totalShares = rig.summary.accepted + rig.summary.rejected + rig.summary.stale;
        $.each(rig.summary, function (k,v) {
            var sharePercent = 0;
            if (k == 'accepted' || k == 'rejected' || k == 'stale') {
                sharePercent = ((v/totalShares)*100).toFixed(0);
            }
            var progressStyle = '';
            if (k == 'accepted') {
                progressStyle = 'success';
            } else if (k == 'rejected') {
                progressStyle = 'danger';
            } else if (k == 'stale') {
                progressStyle = 'danger';
            } else if (k == 'hashrate_5s' || k == 'hashrate_avg') {
                if (k == 'hashrate_5s') {
                    overallHashrate += v;
                }
                
                if (v < 1) {
                    v = (v*1000) + ' KH/S';
                } else if(v > 1024) {
                    v = (v/1000) + ' GH/S';
                } else {
                    v = parseFloat(v).toFixed(2) + ' MH/S';
                }
            }
            
            $(summaryContentTab).append('<div class="stat-pair"><div class="stat-value">'+v+'</div><div class="stat-label">'+k.replace(/_|-|\./g, ' ')+'</div><div class="progress progress-striped"><div class="progress-bar progress-bar-'+progressStyle+'" style="width: '+sharePercent+'%"></div></div></div>');
        });
        var summaryContentTabTable = $(rigTabContentElm).find('#rig-' + rigId + '-summary').find('.table-summary');
        var summaryContentTabTableHead = $(rigTabContentElm).find('thead');
        var summaryContentTabTableBody = $(rigTabContentElm).find('tbody');
        $(summaryContentTabTableHead).find('tr').remove();
        $(summaryContentTabTableBody).find('tr').remove();
        var removeTable = false;
        if (rig.summary.type == 'cgminer') {
            $(summaryContentTabTableHead).append('<tr><th></th><th>DEV #</th><th>Temperature</th><th>Fan Speed</th><th>Fan %</th><th>Hashrate (5s)</th><th>Utility</th></tr>');
        } else if (rig.summary.type == 'dualminer') {
            $(summaryContentTabTableHead).append('<tr><th></th><th>DEV #</th><th>Hashrate 5s</th><th>Accepted</th><th>Rejected</th><th>Utility</th><th>HW Errors</th></tr>');
        } else {
            removeTable = true;
            $(summaryContentTabTable).remove();
        }
        
        var rigStatus = 'green';
        var rigIcon = 'check';
        
        // Update Devices
        $.each(rig.devs, function (devIndex, dev) {
            // Status colours
            var status = dev.health;
            var icon = '';
            if (dev.enabled == 'N') {
                status = 'grey';
                icon = 'ban-circle';
            } else if (status == 'Dead' || dev.hw_errors > 10) {
                status = 'red';
                icon = 'danger';
                rigStatus = 'red';
                rigIcon = 'danger';
            } else if (status == 'Sick' || (dev.hw_errors > 0 && dev.hw_errors <= devHWWarning)) {
                status = 'orange';
                icon = 'warning-sign';
                if (rigIcon != 'danger') {
                    rigStatus = 'orange';
                    rigIcon = 'warning-sign';
                }
            } else if (devHeatDanger <= dev.temperature) {
                status = 'red';
                icon = 'hot';
                if (rigIcon != 'danger' && rigIcon != 'warning-sign') {
                    rigStatus = 'red';
                    rigIcon = 'hot';
                }
            } else if (devHeatWarning <= dev.temperature) {
                status = 'orange';
                icon = 'fire';
                if (rigIcon != 'danger' && rigIcon != 'warning-sign' && rigIcon != 'hot') {
                    rigStatus = 'orange';
                    rigIcon = 'fire';
                }
            } else {
                status = 'green';
                icon = 'cpu-processor';
            }
            
            // add dev to Nav
            $(rigNavElm).append('<li><a class="rig-'+ rigId +'-dev-'+ devIndex +' '+ status +'" href="#rig-'+ rigId +'-dev-'+ devIndex +'" data-toggle="tab">dev'+ devIndex +' <i class="icon icon-'+ icon +'"></i></a></li>');
            $(rigTabContentElm).find('#rig-'+ rigId +'-dev-'+ devIndex).remove();
            $(rigTabContentElm).append('<div class="tab-pane fade in" id="rig-'+ rigId +'-dev-'+ devIndex +'"><div class="panel-body panel-body-stats"></div></div>');
            
            // Updating DEV Content Tab
            var devContentTab = $(rigTabContentElm).find('#rig-' + rigId + '-dev-' + dev.id).find('.panel-body-stats');
            $(devContentTab).find('div').remove();
            $.each(dev, function(k, v) {
                if (k != 'id' && k != 'enabled') {
                    if (k == 'temperature') {
                        v = v + '&deg;C';
                    } else if (k == 'hashrate_5s' || k == 'hashrate_avg') {
                        if (v < 1) {
                            v = (v*1000) + ' KH/S';
                        } else if (v > 1024) {
                            v = (v/1000) + ' GH/S';
                        } else {
                            v = v + ' MH/S';
                        }
                    }
                    
                    $(devContentTab).append('<div class="stat-pair"><div class="stat-value">'+v+'</div><div class="stat-label">'+k.replace(/_|-|\./g, ' ')+'</div></div>');
                }
            });
            
            // Update Summary Page of DEVs
            if (!removeTable) {
            
            if (dev.hashrate_5s < 1) {
                dev.hashrate_5s = (dev.hashrate_5s*1000) + ' KH/S';
            } else if (dev.hashrate_5s > 1024) {
                dev.hashrate_5s = parseFloat(dev.hashrate_5s/1000).toFixed(2) + ' GH/S';
            } else {
                dev.hashrate_5s += ' MH/S';
            }
            
                if (rig.summary.type == 'cgminer') {
                    $(summaryContentTabTableBody).append('<tr><td><i class="icon icon-'+ icon +' '+status+'"></i></td><td class="'+status+'">dev'+dev.id+'</td><td>'+dev.temperature+'&deg;C</td><td>'+dev.fan_speed+'</td><td>'+dev.fan_percent+'</td><td>'+dev.hashrate_5s+'</td><td>'+dev.utility+'</td></tr>');
                } else if(rig.summary.type == 'dualminer') {
                    $(summaryContentTabTableBody).append('<tr><td><i class="icon icon-'+ icon +' '+status+'"></i></td><td class="'+status+'">dev'+dev.id+'</td><td>'+dev.hashrate_5s+'</td><td>'+dev.accepted+'</td><td>'+dev.rejected+'</td><td>'+dev.utility+'</td><td>'+dev.hw_errors+'</td></tr>');
                }
            }
            
        });
        
        $(rigNavElm).find('li:eq('+ selectedNav +')').addClass('active');
        $(rigTabContentElm).find('.tab-pane:eq('+ selectedNav +')').addClass('active');
                        
        // Update Overview Panel
        if (rig.summary.hashrate_5s < 1) {
            rig.summary.hashrate_5s = (rig.summary.hashrate_5s * 1000) + ' KH/S';
        } else if (rig.summary.hashrate_5s > 1024) {
            rig.summary.hashrate_5s = (rig.summary.hashrate_5s / 1000) + ' GH/S';
        } else {
            rig.summary.hashrate_5s = parseFloat(rig.summary.hashrate_5s).toFixed(2) + ' MH/S';
        }
        $(overviewTable).append('<tr><td><i class="icon icon-'+ rigIcon +' '+ rigStatus +'"></i></td><td><a href="#rig-'+ rigId +'" class="anchor-offset rig-'+ rigId +' '+ rigStatus +'">'+ $('h1', rigElm).html() +'</a></td><td>'+ rig.summary.hashrate_5s +'</td><td>'+ rig.summary.active_mining_pool +'</td><td>'+ rig.summary.uptime +'</td></tr>');
    });
    
    // Total amount of hash power
    if (overallHashrate < 1) {
        overallHashrate *= 1000;
        overallHashrateMetric = 'KH/S';
    } else if (overallHashrate > 1024) {
        overallHashrate /= 1000;
        overallHashrateMetric = 'GH/s';
    } else {
        overallHashrateMetric = 'MH/s';
    }
    $('#total-hashrate').html(overallHashrate.toFixed(2) + ' <small>'+ overallHashrateMetric +'</small>');
    
}