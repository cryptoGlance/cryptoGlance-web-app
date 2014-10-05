// Update call by seconds
//setInterval(function() {
//    ajaxUpdateCall('rig');
//}, rigUpdateTime);

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

var hashrateCollection = [];

// Manage Rig
$('.btn-manage-rig').click(function() {
    var minerId = $(this).attr('data-attr');
    var manageRig = $('#manageRig');
    $(manageRig).attr('data-attr', minerId);
    $('.rig-name', manageRig).html($('.panel-title .value', '#rig-'+minerId).text());
    prettifyInputs();
});

// Switch Pools
$('.btn-switchpool', '#manageRig').click(function() {
    var minerId = $('#manageRig').attr('data-attr');
    var switchPoolModal = $('#switchPool .checkbox');
    $(switchPoolModal).html('<img src="images/ajax-loader.gif" alt="Loading..." class="ajax-loader" />');
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
            
            prettifyInputs();
            
            $(switchPoolModal).find('.ajax-loader').remove();
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
        }).done(function(data) {
            ajaxUpdateCall('rig');
        });
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

function updateRigs(data) {
    var overallHashrate = 0;
    var overview = $('#overview');
    var overviewTable = $(overview).find('.panel-body-overview div table tbody');

    $.each(data, function( rigIndex, rig ) {
        var rigId = (parseInt(rigIndex)+1);
        var rigElm = $('#rig-'+rigId);
        var rigNavElm = $(rigElm).find('.nav');
        var rigTabContentElm = $(rigElm).find('.tab-content');
        var rigTitle = $('h1', rigElm);
        var devWarning = false;
        var devDanger = false; 
        var rigOverviewRow = $('tr[data-rig="'+ rigId +'"]', overviewTable);

        $(rigElm).removeClass('panel-warning');
        $(rigElm).removeClass('panel-danger');

        if (rig == null || typeof rig.summary == 'undefined' || typeof rig.devs == 'undefined') {
            $(rigElm).find('.toggle-panel-body').hide();
            $(rigNavElm).hide();
            $(rigTabContentElm).hide();
            $(rigElm).find('.panel-footer').hide();
            if (rigOverviewRow.length == 0) {
                $(overviewTable).append('<tr data-rig="'+ rigId +'"></tr>');
                rigOverviewRow = $('tr[data-rig="'+ rigId +'"]', overviewTable)
            }
            $(rigOverviewRow).html('<td><i class="icon icon-ban-circle grey"></i></td><td><a href="#rig-'+ rigId +'" class="anchor-offset rig-'+ rigId +' grey">'+ $('h1', rigElm).html().replace(' - OFFLINE', '') +'</a></td><td>--</td><td>--</td><td>--</td>');
//            if ($(rigTitle).html().indexOf(' - OFFLINE') == -1) {
//                $(rigTitle).append(' - OFFLINE');
//            }
            $(rigElm).removeClass('panel-warning');
            $(rigElm).removeClass('panel-danger');
            $(rigElm).addClass('panel-offline');
            $('.btn-manage-rig', rigElm).hide();
            return true;
        } else {
            $(rigElm).find('.toggle-panel-body').show();
            $(rigNavElm).show();
            $(rigTabContentElm).show();
            $(rigElm).find('.panel-footer').show();
//            $(rigTitle).html($(rigTitle).html().replace(' - OFFLINE', ''));
            $(rigElm).removeClass('panel-offline');
            $('.btn-manage-rig', rigElm).show();
        }
    
        // Clear nav items
        var selectedNav = $(rigNavElm).find('.active').index();
        if (selectedNav == -1) selectedNav = 0;
        $(rigNavElm).find('li').remove();
        
        // Update Summary
        $(rigNavElm).append('<li><a class="blue" href="#rig-'+ rigId +'-summary" data-toggle="tab">Summary <i class="icon icon-dotlist"></i></a></li>');
        var summaryContentTab = $(rigTabContentElm).find('#rig-' + rigId + '-summary').find('.panel-body-summary');
        $(summaryContentTab).find('div').remove();
        $(summaryContentTab).find('img').remove();
        var totalShares = rig.summary.accepted + rig.summary.rejected + rig.summary.stale;
        if (rig.summary.hashrate_5s == 0) {
            rig.summary.hashrate_5s = rig.summary.hashrate_avg;
        }
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
                    hashrateCollection[rigId] = v;
                }
                
                if (v < 1) {
                    v = (v*1000) + ' KH/S';
                } else if(v > 1000) {
                    v = parseFloat(v/1000).toFixed(2) + ' GH/S';
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
        if (typeof rig.devs.GPU != 'undefined' && rig.devs.GPU.length > 0) {
            $(summaryContentTabTableHead).append('<tr><th></th><th>Name</th><th>Temperature</th><th>Fan Speed</th><th>Fan %</th><th>Hashrate (5s)</th><th>Utility</th></tr>');
        } else if (typeof rig.devs.ASC != 'undefined' && rig.devs.ASC.length > 0) {
            $(summaryContentTabTableHead).append('<tr><th></th><th>Name</th><th>Hashrate 5s</th><th>Accepted</th><th>Rejected</th><th>Utility</th><th>HW Errors</th></tr>');
        } else {
            removeTable = true;
            $(summaryContentTabTable).remove();
        }
        
        var rigStatus = 'green';
        var rigIcon = 'check';
        var rigPanel = '';
        
        // Update Devices
        $.each(rig.devs, function (devType, devTypes) {
            $.each(devTypes, function (devIndex, dev) {
                // Status colours
                var status = dev.health;
                var icon = '';
                if (dev.enabled == 'N') {
                    status = 'grey';
                    icon = 'ban-circle';
                    rigPanel = 'offline';
                } else if (status == 'Dead' || (devHWEnabled && dev.hw_errors >= devHWDanger)) {
                    status = 'red';
                    icon = 'danger';
                    rigStatus = 'red';
                    rigIcon = 'danger';
                    rigPanel = 'danger';
                } else if (status == 'Sick' || (devHWEnabled && dev.hw_errors >= devHWWarning)) {
                    status = 'orange';
                    icon = 'warning-sign';
                    if (rigIcon != 'danger') {
                        rigStatus = 'orange';
                        rigIcon = 'warning-sign';
                        rigPanel = 'warning';
                    }
                } else if (devHeatDanger <= dev.temperature) {
                    status = 'red';
                    icon = 'hot';
                    if (rigIcon != 'danger' && rigIcon != 'warning-sign') {
                        rigStatus = 'red';
                        rigIcon = 'hot';
                        rigPanel = 'danger';
                    }
                } else if (devHeatWarning <= dev.temperature) {
                    status = 'orange';
                    icon = 'fire';
                    if (rigIcon != 'danger' && rigIcon != 'warning-sign' && rigIcon != 'hot') {
                        rigStatus = 'orange';
                        rigIcon = 'fire';
                        rigPanel = 'warning';
                    }
                } else {
                    status = 'green';
                    icon = 'cpu-processor';
                }
                
                if (rigPanel != '') {
                    $(rigElm).addClass('panel-' + rigPanel);
                }
                
                // add dev to Nav
                $(rigNavElm).append('<li><a class="rig-'+ rigId +'-'+ devType +'-'+ devIndex +' '+ status +'" href="#rig-'+ rigId +'-'+ devType +'-'+ devIndex +'" data-toggle="tab">'+ dev.name +' <i class="icon icon-'+ icon +'"></i></a></li>');
                $(rigTabContentElm).find('#rig-'+ rigId +'-'+ devType +'-'+ devIndex).remove();
                $(rigTabContentElm).append('<div class="tab-pane fade in" id="rig-'+ rigId +'-'+ devType +'-'+ devIndex +'"><div class="panel-body panel-body-stats"></div></div>');
                
                // Updating DEV Content Tab
                var devContentTab = $(rigTabContentElm).find('#rig-' + rigId + '-'+ devType +'-' + dev.id).find('.panel-body-stats');
                $(devContentTab).find('div').remove();
                $.each(dev, function(k, v) {
                    if (k != 'id' && k != 'enabled') {
                        if (k == 'temperature') {
                            v = v + '&deg;C';
                        } else if (k == 'hashrate_5s' || k == 'hashrate_avg') {
                            if (v < 1) {
                                v = (v*1000) + ' KH/S';
                            } else if (v > 1000) {
                                v = parseFloat(v/1000).toFixed(2) + ' GH/S';
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
                    } else if (dev.hashrate_5s > 1000) {
                        dev.hashrate_5s = parseFloat(dev.hashrate_5s/1000).toFixed(2) + ' GH/S';
                    } else {
                        dev.hashrate_5s += ' MH/S';
                    }
                
                    if (devType == 'GPU') {
                        $(summaryContentTabTableBody).append('<tr><td><i class="icon icon-'+ icon +' '+status+'"></i></td><td class="'+status+'">'+devType+ dev.id+'</td><td>'+dev.temperature+'&deg;C</td><td>'+dev.fan_speed+'</td><td>'+dev.fan_percent+'</td><td>'+dev.hashrate_5s+'</td><td>'+dev.utility+'</td></tr>');
                    } else if(devType == 'ASC') {
                        $(summaryContentTabTableBody).append('<tr><td><i class="icon icon-'+ icon +' '+status+'"></i></td><td class="'+status+'">'+dev.name+'</td><td>'+dev.hashrate_5s+'</td><td>'+dev.accepted+'</td><td>'+dev.rejected+'</td><td>'+dev.utility+'</td><td>'+dev.hw_errors+'</td></tr>');
                    }
                }
            
            });        
        });
        
        $(rigNavElm).find('li:eq('+ selectedNav +')').addClass('active');
        $(rigTabContentElm).find('.tab-pane:eq('+ selectedNav +')').addClass('active');
        
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var siteLayout = $.cookie('use_masonry_layout');
            if (siteLayout == 'yes') {
                initMasonry();
            }  
        });
        
        // Update Overview Panel
        if (rig.summary.hashrate_5s < 1) {
            rig.summary.hashrate_5s = (rig.summary.hashrate_5s * 1000) + ' KH/S';
        } else if (rig.summary.hashrate_5s > 1000) {
            rig.summary.hashrate_5s = parseFloat(rig.summary.hashrate_5s / 1000).toFixed(2) + ' GH/S';
        } else {
            rig.summary.hashrate_5s = parseFloat(rig.summary.hashrate_5s).toFixed(2) + ' MH/S';
        }
        
        // update overview
        if (rigOverviewRow.length == 0) {
            $(overviewTable).append('<tr data-rig="'+ rigId +'"></tr>');
            rigOverviewRow = $('tr[data-rig="'+ rigId +'"]', overviewTable)
        }
        $(rigOverviewRow).html('<td><i class="icon icon-'+ rigIcon +' '+ rigStatus +'"></i></td><td><a href="#rig-'+ rigId +'" class="anchor-offset rig-'+ rigId +' '+ rigStatus +'">'+ $('h1', rigElm).html() +'</a></td><td>'+ rig.summary.hashrate_5s +'</td><td>'+ rig.summary.active_mining_pool +'</td><td>'+ rig.summary.uptime +'</td>');
        
        $(summaryContentTabTable).show();
    });
    
    // Total amount of hash power
    overallHashrate = 0;
    for (key in hashrateCollection) {
        overallHashrate += parseFloat(hashrateCollection[key]);
    }    
    if (overallHashrate < 1) {
        overallHashrate *= 1000;
        overallHashrateMetric = 'KH/S';
    } else if (overallHashrate > 1000) {
        overallHashrate /= 1000;
        overallHashrateMetric = 'GH/s';
    } else {
        overallHashrateMetric = 'MH/s';
    }
    $('.total-hashrate').html(overallHashrate.toFixed(2) + ' <small>'+ overallHashrateMetric +'</small>');
    document.title = overallHashrate.toFixed(2) + ' ' + overallHashrateMetric + ' | ' + documentTitle
}
