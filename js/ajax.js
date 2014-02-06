var ajaxCall;
var gpuHeatWarning = 69;
var gpuHeatDanger = 73;
/*
 *
 * Update functionality
 *
 */
 // On Load Ajax Call
 ajaxUpdateCall('all');
 
// 5 second Update call
setInterval(function() {
    ajaxUpdateCall('all');
}, 5000);

// BTN Updates
// this needs to be fixed for the current btn-updater
$('.btn-updater').click(function() {
    if ($(this).attr('data-type') == 'all') {
        ajaxUpdateCall('all');
    } else {
        ajaxUpdateCall($(this).attr('data-type'), $(this).attr('data-attr'));
    }
});


// Update json data
function ajaxUpdateCall(action, actionAttr) {
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
        if (typeof data.wallets != 'undefined') {
            updateWallets(data.wallets);
        }
        if (typeof data.rigs != 'undefined') {
            updateRigs(data.rigs);
        }
    });
}

function updateWallets (data) {
    var walletPanel = $('#wallet');
    var addressesPanel = $(walletPanel).find('.panel-body-addresses');
    $(addressesPanel).html('');
    $.each(data, function( walletIndex, wallet) {
        var walletId = (walletIndex+1);
        $(addressesPanel).append('<div class="stat-pair" id="wallet-address-'+ walletId +'"><div class="stat-value"><img src="images/icon-'+ wallet.currency +'.png" alt="'+ wallet.currency +'" /><span class="green">'+ wallet.balance +' '+ wallet.currency_code +'</span><span class="address-label">in '+ wallet.label +'</span></div><div class="stat-label">'+ wallet.address +'</div></div>');
    });
}

function updateRigs (data) {
    var overview = $('#overview');
    var overviewTable = $(overview).find('.panel-body-overview div table tbody');
    $(overviewTable).find('tr').remove();
        
    $.each(data, function( rigIndex, rig ) {
        var rigId = (rigIndex+1);
        var rigElm = $('#rig'+rigId);
        var rigNavElm = $(rigElm).find('.nav');
        var rigTabContentElm = $(rigElm).find('.tab-content');
        var rigTitle = $(rigElm).find('.panel-title span');
        var gpuWarning = false;
        var gpuDanger = false;
        
        if (typeof rig.summary == 'undefined' || typeof rig.gpus == 'undefined') {
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
        console.log(selectedNav);
        $(rigNavElm).find('li').remove();
        
        // Update Summary
        $(rigNavElm).append('<li><a class="blue" href="#rig'+ rigId +'-summary" data-toggle="tab">Summary <i class="icon icon-dotlist"></i></a></li>');
        var summaryContentTab = $(rigTabContentElm).find('#rig' + rigId + '-summary').find('.panel-body-summary');
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
            }
            
            $(summaryContentTab).append('<div class="stat-pair"><div class="stat-value">'+v+'</div><div class="stat-label">'+k.replace(/_|-|\./g, ' ')+'</div><div class="progress progress-striped"><div class="progress-bar progress-bar-'+progressStyle+'" style="width: '+sharePercent+'%"></div></div></div>');
        });
        var summaryContentTabTable = $(rigTabContentElm).find('#rig' + rigId + '-summary').find('.table-summary').find('tbody');
        $(summaryContentTabTable).find('tr').remove();
        
        var rigStatus = 'green';
        var rigIcon = 'check';
        
        // Update GPUs
        $.each(rig.gpus, function (gpuIndex, gpu) {
            // Status colours
            var status = gpu.health;
            var icon = '';
            if (gpu.enabled == 'N') {
                status = 'grey';
                icon = 'stop';
            } else if (status == 'Dead') {
                status = 'red';
                icon = 'danger';
                rigStatus = 'red';
                rigIcon = 'danger';
            } else if (status == 'Sick') {
                status = 'orange';
                icon = 'warning-sign';
                if (rigIcon != 'danger') {
                    rigStatus = 'orange';
                    rigIcon = 'warning-sign';
                }
            } else if (gpuHeatDanger <= gpu.temperature) {
                status = 'red';
                icon = 'fire';
                if (rigIcon != 'danger' && rigIcon != 'warning-sign') {
                    rigStatus = 'red';
                    rigIcon = 'fire';
                }                icon = 'fire';
            } else if (gpuHeatWarning <= gpu.temperature) {
                status = 'orange';
                icon = 'fire';
                if (rigIcon != 'danger' && rigIcon != 'warning-sign') {
                    rigStatus = 'orange';
                    rigIcon = 'fire';
                }
            } else {
                status = 'green';
                icon = 'cpu-processor';
            }
            
            // add gpu to Nav
            $(rigNavElm).append('<li><a class="rig'+ rigId +'-gpu'+ gpuIndex +' '+ status +'" href="#rig'+ rigId +'-gpu'+ gpuIndex +'" data-toggle="tab">GPU '+ gpuIndex +' <i class="icon icon-'+ icon +'"></i></a></li>');
            $(rigTabContentElm).find('#rig'+ rigId +'-gpu'+ gpuIndex).remove();
            $(rigTabContentElm).append('<div class="tab-pane fade in" id="rig'+ rigId +'-gpu'+ gpuIndex +'"><div class="panel-body panel-body-stats"></div></div>');
            
            // Updating GPU Content Tab
            var gpuContentTab = $(rigTabContentElm).find('#rig' + rigId + '-gpu' + gpu.id).find('.panel-body-stats');
            $(gpuContentTab).find('div').remove();
            $.each(gpu, function(k, v) {
                if (k != 'id' && k != 'enabled') {
                    if (k == 'temperature') {
                        v = v + '&deg;C';
                    }
                    $(gpuContentTab).append('<div class="stat-pair"><div class="stat-value">'+v+'</div><div class="stat-label">'+k.replace(/_|-|\./g, ' ')+'</div></div>');
                }
            });
            
            // Update Sumamry Page of GPUs
            $(summaryContentTabTable).append('<tr><td><i class="icon icon-'+ icon +' '+status+'"></i></td><td class="'+status+'">gpu'+gpu.id+'</td><td>'+gpu.temperature+'&deg;C</td><td>'+gpu.fan_speed+'</td><td>'+gpu.fan_percent+'</td><td>'+gpu.hashrate_5s+'</td><td>'+gpu.utility+'</td></tr>');
            
        });
        
        $(rigNavElm).find('li:eq('+ selectedNav +')').addClass('active');
        $(rigTabContentElm).find('.tab-pane:eq('+ selectedNav +')').addClass('active');
                        
        // Update Overview Panel
        $(overviewTable).append('<tr><td><i class="icon rig'+ rigId +' icon-'+ rigIcon +' '+ rigStatus +'"></i></td><td><a href="#rig'+ rigId +'" class="anchor-offset rig'+ rigId +' '+ rigStatus +'">'+ $(rigElm).find('.panel-title span').html() +'</a></td><td>'+ rig.summary.hashrate_5s +'</td><td>'+ rig.summary.active_mining_pool +'</td><td>'+ rig.summary.uptime +'</td></tr>');
        
    });
}