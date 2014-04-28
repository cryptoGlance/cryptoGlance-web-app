// UI JavaScript for RigWatch
// 	by George Merlocco (george@merloc.co) // https://github.com/scar45/

// ***** NOTE ***** JS optimization/clean-up is needed, don't laugh!

// Javascript Open in New Window (validation workaround)
//
function externalLinks() {
  if (!document.getElementsByTagName) return;
  var anchors = document.getElementsByTagName("a");
  for (var i=0; i<anchors.length; i++) {
    var anchor = anchors[i];
    if (anchor.getAttribute("href") &&
      anchor.getAttribute("rel") == "external")
      anchor.target = "_blank";
  }
}


// Dashboard Panel Sorting and Repositioning
//

// $(function() {
//   $( "#dashboard-wrap:not(.login-container)" ).sortable({
//     placeholder: "panel",
//     opacity: 0.75,
//     scrollSpeed: 50,
//     handle: '.panel-heading',
//     containment: '#dashboard-wrap',    
//     forcePlaceholderSize: false,
//     scroll: true,
//     scrollSensitivity: 100,
//     update: function(event, ui) {
//       var cooked = [];
//       $("#dashboard-wrap:not(.login-container)").each(function(index, domEle){ cooked[index]=  $(domEle).sortable('toArray');});
//       $.cookie('cookie_dashboard_layout', 'x'+cooked.join('|'), { expires: 365, path: '/'});
//     }
//   }).disableSelection();
// });
// 
// 
// function restoreDashboard() {
//   var cookie = $.cookie('cookie_dashboard_layout');
//   if (!cookie) return;
//   var SavedID = cookie.split('|');
//   for ( var u=0, ul=SavedID.length; u < ul; u++ ){ SavedID[u] = SavedID[u].split(',');}
//   for (var Scolumn=0, n = SavedID.length; Scolumn < n; Scolumn++) {
//     for (var Sitem=0, m = SavedID[Scolumn].length; Sitem < m; Sitem++) {
//       $("#dashboard-wrap:not(.login-container)").eq(Scolumn).append($("#dashboard-wrap:not(.login-container)").children("#" + SavedID[Scolumn][Sitem]));
//     }
//   }
// }

// Wallet/Address stat-pair Sorting and Repositioning
//

// TEMP DISABLED (bug when ajax fires and wallets refresh)

// $(function() {
//  $( "#wallet .panel-body" ).sortable({
//     placeholder: "stat-pair-dropzone",
//     handle: ".stat-value img",
//     opacity: 0.75,
//     scrollSpeed: 50,
//     forcePlaceholderSize: true,
//     scroll: true,
//     scrollSensitivity: 100,
//     update: function(event, ui) {
//      var cooked = [];
//      $("#wallet-1 .panel-body").each(function(index, domEle){ cooked[index]=  $(domEle).sortable('toArray');});
//      $.cookie('cookie_wallet_panel', 'x'+cooked.join('|'), { expires: 31, path: '/'});
//     }
//  });
// //  $( "#wallet-1 .panel-body" ).disableSelection();
// });
// 
// 
// function restoreWalletOrder() {
//    var cookie = $.cookie('cookie_wallet_panel');
//    if (!cookie) return;
//    var SavedID = cookie.split('|');
//    for ( var u=0, ul=SavedID.length; u < ul; u++ ){ SavedID[u] = SavedID[u].split(',');}
//    for (var Scolumn=0, n = SavedID.length; Scolumn < n; Scolumn++) {
//     for (var Sitem=0, m = SavedID[Scolumn].length; Sitem < m; Sitem++) {
//        $("#wallet-1 .panel-body").eq(Scolumn).append($("#wallet-1 .panel-body").children("#" + SavedID[Scolumn][Sitem]));
//     }
//    }
// }


// Setup Masonry Layout
function initMasonry() {
  $('#dashboard-wrap, .full-content').css('width','100%');
  $('.panel:not(.panel-in-footer, .panel-no-grid)').addClass('panel-masonry');
  $('#dashboard-wrap').masonry({
    itemSelector: '.panel',
    columnWidth: 1
  });
  $.cookie("use_masonry_layout", "yes");
  $(".site-width-slider").fadeOut();
}

function destroyMasonry() {
  $('#dashboard-wrap').masonry('destroy');
  $('.panel:not(.panel-in-footer, .panel-no-grid)').removeClass('panel-masonry');
  $.removeCookie("use_masonry_layout");
  restorePanelWidth();
  $(".site-width-slider").fadeIn();
}

function restoreSiteLayout() {
  var siteLayout = $.cookie('use_masonry_layout');
  var viewportWidth  = $(window).width();
    
  if (siteLayout == null) {
    $('#layout-grid').removeClass('active-layout');
    $('#layout-list').addClass('active-layout');
  } 
  else if (viewportWidth >= 1600 && siteLayout == 'yes') {
    initMasonry();
    $('#layout-list').removeClass('active-layout');
    $('#layout-grid').addClass('active-layout');
  }  
}

// Modify Panel width
//

$(function() {

  //Store frequently elements in variables
  var slider  = $('#slider');
  
  //Call the Slider
  slider.slider({
    range: "min",
    min: 59,
    max:100,
    value: 90,

    start: function(event,ui) {
    },

    //Slider Event
    slide: function(event, ui) { //When the slider is sliding

     var value  = slider.slider('value'),
        actualWidth = $('.width-reading'),
        container = $('#dashboard-wrap, .full-content'),
        viewportWidth  = $(window).width();

     if (viewportWidth > 1200) {
        container.css('width', value + '%');
        actualWidth.html(value + '%');
        $.cookie("cookie_panel_width", value);
     }
          
    },

    stop: function(event,ui) {
      var viewportWidth  = $(window).width(),
        siteLayout = $.cookie('use_masonry_layout');
      if (siteLayout == 'yes' && viewportWidth > 1200) {
        initMasonry();
      }  
    },
  });

});

function restorePanelWidth() {
  var panelWidth = $.cookie('cookie_panel_width'),
    siteLayout = $.cookie('use_masonry_layout');

  if (!panelWidth) return;
  
  if (siteLayout != "yes") {
    $('#dashboard-wrap, .full-content').css('width', panelWidth + '%');
    $('.width-reading').html(panelWidth + '%');
    $('.width-reading').html(panelWidth + '%');
    $('#slider').slider("value", panelWidth);
  };
}

function mobileWidthFixer() {
  var viewportWidth  = $(window).width(),
    container = $('#dashboard-wrap, .full-content'),
    siteLayout = $.cookie('use_masonry_layout'),
    currentWidth = $('#slider').slider("option", "value");
    
  if(viewportWidth < 770) {
    container.css('width', '99%');
  } else if (viewportWidth < 1200) {
    container.css('width', '90%');
  } else {
    if(siteLayout != "yes"){
      container.css('width', currentWidth + '%');
    }
  }
  
}

function expandAllPanels() {
  $('#dashboard-wrap .panel-body:not(.tab-content .panel-body), #dashboard-wrap .panel-footer, #dashboard-wrap .tab-content, #dashboard-wrap .panel-rig .nav-pills').slideDown();
    return false;
}

function collapseAllPanels() {
  $('#dashboard-wrap .panel-body:not(.tab-content .panel-body), #dashboard-wrap .panel-footer, #dashboard-wrap .tab-content, #dashboard-wrap .panel-rig .nav-pills').slideUp('slow'); 
    return false;
}
  

// Close navbar after click on mobile
//

$(function(){ 
  var navMain = $(".navbar-collapse");

  navMain.on("click", "a:not(a.dropdown-toggle, .site-width-slider a)", null, function () {
    var viewportWidth  = $(window).width();

    if(viewportWidth < 770) {
      navMain.collapse('hide');
    }
  });
});
  
  
// Pretty checkable styling
function prettifyInputs() {
  var inputs = $('input[type=radio], input[type=checkbox]').each(function() {
    $(this).bootstrapSwitch({
      'offText':'<i class="icon icon-remove"></i>',
      'onText':'<i class="icon icon-ok"></i>',
      'onColor':'success',
      'offColor':'danger'
    });
  });
} 

 
// Toggle Mobile Navbar
//
function toggleMobileNavbar() {
  var viewportWidth  = $(window).width();

  if(viewportWidth < 768) {
    $('.navbar-collapse').collapse('toggle');
  } else {
    $('.navbar').collapse('toggle');
  }
}

// Show Mobile Hashrate
//
function toggleMobileHashrate() {
  $('#mobile-hashrate').slideToggle('slow');
}

// App-specific fixes needed after page loads
//
function fixApp() {
  $('.container.sub-nav').css({
    paddingTop : "65px"
    }
  );
  $('#mobile-hashrate').css('top','0px');

  var viewportWidth  = $(window).width();

  if(viewportWidth < 768) {
    $('.navbar-collapse').slideUp();
    $('.navbar, .navbar-header').css({
      'min-height':'0px',
      'height':'0px'
    });
    $('.navbar-header').css('overflow','hidden');
    $('a.navbar-brand img').hide();
  } else {
    $('.navbar').collapse('hide');
  }
}


// Smooth scrolling
//
  
function scrollTo(id){
  $('html,body').animate({scrollTop: $(id).offset().top},'slow');
};


// Smooth scroll to active rig from the Overview panel

$(function() {
    $('#overview').on('click', '.anchor-offset', function(e) {
        e.preventDefault();
        var target = $(this).attr('href');
        $('body').scrollTo(target, 750, { margin: true, offset: -100 });
    });
});
    
    
// Setup Toast Messages
//
function setToasts() {
  // setting toast defaults
  $().toastmessage({
      position : 'top-center',
      stayTime : 5000,
      sticky   : true
  });
}

// (Toast) New cG Update available
function showToastUpdate(currentVersion, newestVersion) {
  $().toastmessage('showToast', {
    sticky  : true,
    text    : '<b>Update available!</b> You are running <b class="current">'+currentVersion+'</b>, but the latest release is <b class="latest">'+newestVersion+'</b>.<span><a href="update.php"><button type="button" class="btn btn-warning btn-xs" data-type="all"><i class="icon icon-refresh"></i> Update Now</button></a></span>',
    type    : 'notice',
    close    : function () {
        $.cookie('cryptoglance_version', currentVersion, { expires: 1 });
    }
  });
}

// (Toast) Saved settings
function showToastSettingsSaved() {
  $().toastmessage('showToast', {
    sticky  : false,
    text    : '<b>Success!</b> Your configuration was saved.',
    type    : 'success'
  });
  
}

// (Toast) Unable to save settings
function showToastSettingsNOTSaved() {
  $().toastmessage('showToast', {
    sticky  : true,
    text    : '<b>Failure!</b> Your configuration was <b>not</b> updated. Check your user data or refer to the <a href="help.php#faq">FAQ in the README</a>.',
    type    : 'error'
  });
  
}

// (Toast) Unable to write to dir
function showToastWriteError() {
  $().toastmessage('showToast', {
    sticky  : false,
    text    : '<b>Failed!</b> Please make sure <em>/'+DATA_FOLDER+'/configs/</em> is writable.',
    type    : 'error'
  });
}


// (Toast) No .htaccess in user_data
function showToastNoHTACCESS() {
  $().toastmessage('showToast', {
    sticky  : true,
    text    : '<b>No .htaccess in /'+DATA_FOLDER+'!</b> Using this file to block access to your user data directory is a good idea. It\'s included in the source, but for some reason it does not exist in your installation. Ensure it contains the <a href="https://raw.githubusercontent.com/cryptoGlance/cryptoGlance-web-app/master/user_data/.htaccess" rel="external">contents of the source file</a>.',
    type    : 'warning'
  });
}


// Only change custom width (via slider) for viewports over 1200px
//

$(window).resize(function() {
  mobileWidthFixer();  
});

$(window).ready(function() {
  restoreSiteLayout();  
});
  
// Execute when the DOM is ready
//
$(document).ready(function() {
setToasts();
  externalLinks();
  prettifyInputs();
  restoreSiteLayout();
  
  //restoreDashboard();
  restorePanelWidth();
  
  // Reveal hidden settings
  //
  $('#btnAddPool').click( function() {
    $(this).fadeOut('fast', function() {
      $(this).next('.add-new-wrapper').fadeIn('slow');
    });
  });
  
  // Pulsate "Add Panel" button
  //
  $('#flash-add-panel').click( function() {
    $('#dash-add-panel').removeClass('flash', function() {
    $('#dash-add-panel').addClass('flash');
    });
  });
  
  // Start Update Process
  //
  // TODO: Fix my derpy code below to work nice (show disabled, loader gif button duing process, then back to a green 'update complete' after, which logs the user out)
  //
  $('#btn-update-process').click( function() {
    $(this).html('<img src="images/ajax-loader.gif" alt="loading" />').prop('disabled', true).delay(5000).prop('disabled', false).html('Update Complete!').addClass('btn-success');
    $('pre').fadeIn('slow');
  });
  
  // Toggle App Update Types
  //
  $('input[name="check-app-updates"]').on('switchChange.bootstrapSwitch', function(event, state) {
    $('.app-update-types').fadeToggle();
  });
  
  $('#layout-grid').click(function() {
    initMasonry();
    $('#layout-list').removeClass('active-layout');
    $(this).addClass('active-layout');
    return false;
  });
  
  $('#layout-list').click(function() {
    destroyMasonry();
    $('#layout-grid').removeClass('active-layout');
    $(this).addClass('active-layout');
    restorePanelWidth();
    return false;
  });
  
  $('#collapse-all-panels').click(function(event) {
    event.preventDefault();
    collapseAllPanels();
    $('.toggle-panel-body').addClass("minimized");
    $('.toggle-panel-body').html("<i class='icon icon-chevron-down'></i>");
  });

  $('#expand-all-panels').click(function(event) {
    event.preventDefault();
    expandAllPanels();
    $('.toggle-panel-body').removeClass("minimized");
    $('.toggle-panel-body').html("<i class='icon icon-chevron-up'></i>");
  });

  $('.toggle-panel-body').click(function() {
    var $toggleButton = $(this);
    
    $(this).parent().nextAll('.panel-body, .panel-footer, .tab-content, .panel-rig .nav-pills').slideToggle('slow');
    
    $toggleButton.toggleClass("minimized");

    if ($toggleButton.hasClass("minimized")) {
     $toggleButton.html("<i class='icon icon-chevron-down'></i>");
    } else {
     $toggleButton.html("<i class='icon icon-chevron-up'></i>");
    }
  });
    
  $('button.btn-updater').click(function() {
    var $currentButton = $(this);
    
    $currentButton.html("<i class='icon icon-refresh'></i> Updating...");
    $currentButton.children().addClass('icon-spin');
    $currentButton.prop({
     disabled: true
    });
    setTimeout(function() { 
     $currentButton.html("<i class='icon icon-refresh'></i> Update");
     $currentButton.prop({
        disabled: false
     });
    }, 3000);

  });  

  $('.anchor-offset').click(function() {
    var target = $(this).attr('href');
    $('body').scrollTo(target, 750, { margin: true, offset: -120 });
    return false;
  });  

  $('.anchor').click(function() {
    var target = $(this).attr('href');
    $('body').scrollTo(target, 750, { margin: true });
    return false;
  });  

  $('#btnSaveHost').click(function() {
    $("#alert-saved-host").fadeIn('slow').delay( 4000 ).fadeOut(3000);
    prettifyInputs();
  });  

  $('#btnAddHost').click(function() {
    $("#alert-added-host").fadeIn('slow').delay( 4000 ).fadeOut(3000);
    prettifyInputs();
  }); 
  
  $('#btnSaveWallets').click(function() {
    $("#alert-saved-wallet").fadeIn('slow').delay( 4000 ).fadeOut(3000);
    prettifyInputs();
  });  

  
//  $('#btnSavePool').click(function() {
//    $("#alert-saved-pool").fadeIn('slow').delay( 4000 ).fadeOut(3000);
//  })  
//
//  $('#btnAddPool').click(function() {
//    $("#alert-added-pool").fadeIn('slow').delay( 4000 ).fadeOut(3000);
//  })
  
    // Delete
    $('.btn-delete').click(function() {
        var panelType = $(this).parentsUntil('.panel').parent().attr('data-type');
        var panelId = $(this).parentsUntil('.panel').parent().attr('data-id');
        $('#deletePrompt').attr('data-type', panelType);
        $('#deletePrompt').attr('data-id', panelId);
        $('.panelName', '#deletePrompt').html($('h1', '#' + panelType + '-' + panelId).text());
        prettifyInputs();
    });
  
    $('#deletePrompt').on('shown.bs.modal', function () {
        $('input[name="type"]', this).val($(this).attr('data-type'));
        $('input[name="id"]', this).val($(this).attr('data-id'));
        prettifyInputs();
    });
    
        
    // Pool modal
    $('#selectPoolType').change(function() {
        var type = $(this).val();
        $('#addPool').find('.form-group').hide();
        $('#addPool').find('.' + type).show();
        $('#addPool').find('.all').show();
        
        if (type == 'simplecoin') {
            $('#inputPoolURL').attr('placeholder', 'http://simpledoge.com');
        } else if (type == 'mpos') {
            $('#inputPoolURL').attr('placeholder', 'http://vertsquad.com');
        }
        
        prettifyInputs();
    });
    
    // Wallet Page \\
    // Edit Address Action
    $('#walletAddresses').on('click', '.editAddress', function(e) {
        e.preventDefault();
        // row Parent
        var addrRow = $(this).parents('tr');
        $(addrRow).addClass('wallet-inline-edit');
        
        // Get Label and value
        var addrLabelTd = $('[data-name="label"]', addrRow);
        var addrLabelVal = $(addrLabelTd).html();
        
        // Create input field, populate, and style
        var addrLabelInput = document.createElement("input");
        $(addrLabelInput).val(addrLabelVal);
        $(addrLabelInput).addClass('form-control');
        $(addrLabelInput).attr('name', 'label');
        $(addrLabelTd).html(addrLabelInput);

        // get Last column (action buttons)
        var actionTd = $('td:last', addrRow);
        $(actionTd).html('<a href="#saveAddress" class="saveEditAddress"><span class="blue"><i class="icon icon-save-floppy"></i></span></a>');
    });
    // Save Edit Address Action
    $('#walletAddresses').on('click', '.saveEditAddress', function(e) {
        e.preventDefault();
        
        // Wallet Id
        var walletId = $('#walletAddresses').attr('data-walletId');
        
        // row Parent
        var addrRow = $(this).parents('tr');
        var addrKey = $(addrRow).attr('data-key');
        var addrLabelInput = $('[name="label"]', addrRow);
        
        // on done:
        $.ajax({
            type: 'post',
            url: 'ajax.php?type=update&action=edit-config',
            data: { type: 'address', walletId: walletId, addrId: addrKey, label: $(addrLabelInput).val() },
            statusCode: {
                202: function() {
                    var addrLabelTd = $('[data-name="label"]', addrRow);
                    $(addrLabelTd).html($(addrLabelInput).val());
                    $(addrLabelInput).remove();
                    
                    $('#alert-save-fail-address').fadeOut();
                    $('#alert-saved-address').fadeIn();
                    
                    // get Last column (action buttons)
                    var actionTd = $('td:last', addrRow);
                    $(actionTd).html('<a href="#editAddress" class="editAddress"><span class="green"><i class="icon icon-edit"></i></span></a> &nbsp; <a href="#removeAddress" class="removeAddress"><span class="red"><i class="icon icon-remove"></i></span></a>');
                },
                406: function() {
                    $(addrLabelInput).removeClass('red');
                    $(addrLabelInput).addClass('red');
                    $('.errormsg', '#alert-save-fail-address').html('You need to provide a label for this address.');
                    $('#alert-saved-address').fadeOut();
                    $('#alert-save-fail-address').fadeIn();
                }
            }
        });
    });
    // Remove Address Action
    $('#walletAddresses').on('click', '.removeAddress', function(e) {
        e.preventDefault();
        
        // Wallet Id
        var walletId = $('#walletAddresses').attr('data-walletId');
        
        // row Parent
        var addrRow = $(this).parents('tr');
        var addrKey = $(addrRow).attr('data-key');
        
        // on done:
        $.ajax({
            type: 'post',
            url: 'ajax.php?type=update&action=remove-config',
            data: { type: 'address', walletId: walletId, addrId: addrKey },
            statusCode: {
                202: function() {
                    location.reload(true);
                }
            }
        });
    });
    // Add Address Action
    $('#walletAddresses').on('click', '.saveNewAddress', function(e) {
        e.preventDefault();
        
        // Wallet Id
        var walletId = $('#walletAddresses').attr('data-walletId');
        
        // row Parent
        var addrRow = $(this).parents('tr');
        var addrKey = $(addrRow).attr('data-key');
        var addrLabel = $('[name="label"]', addrRow);
        var addrAddress = $('[name="address"]', addrRow);
        
        // on done:
        $.ajax({
            type: 'post',
            url: 'ajax.php?type=update&action=add-config',
            data: { type: 'address', walletId: walletId, addrId: addrKey, label: $(addrLabel).val(), address: $(addrAddress).val() },
            statusCode: {
                202: function() {
                    location.reload(true);
                },
                406: function() {
                    $(addrLabel).removeClass('red');
                    $(addrAddress).removeClass('red');
                    $(addrLabel).addClass('red');
                    $(addrAddress).addClass('red');
                    $('.errormsg', '#alert-save-fail-address').html('You need to provide a label and address.');
                    $('#alert-save-fail-address').fadeIn();
                },
                409: function() {
                    $(addrLabel).removeClass('red');
                    $(addrAddress).removeClass('red');
                    $(addrAddress).addClass('red');
                    $('.errormsg', '#alert-save-fail-address').html('This address already exists in the wallet.');
                    $('#alert-save-fail-address').fadeIn();
                }
            }
        });
    });
    // Save Wallet
    var btnSaveWallets = false;
    $('#btnSaveWallets').click(function(e) {
        e.preventDefault();
        if (!btnSaveWallets) {
            btnSaveWallets = true;
            $.ajax({
                type: 'post',
                url: 'ajax.php?type=update&action=add-config',
                data: $('form', '#walletDetails').serialize()
            }).done(function(data, statusText, xhr) {
                var status = xhr.status;
                if (status == 202) {
                    if ($('[name="walletId"]', '#walletDetails').val() == 0) {
                        var walletId = data;
                        window.location.href = 'wallet.php?id=' + walletId;
                    }
                    $('.panel-title', '#walletAddresses').html($('[name="label"]', '#walletDetails').val());
                    $('#alert-saved-wallet').fadeIn();
                    $('#alert-save-fail-wallet').fadeOut();
                    btnSaveWallets = false;
                }
            }).fail(function(data, statusText, xhr) {
                var status = data.status;
                if (status == 406) {
                    $('#alert-saved-wallet').fadeOut();
                    $('#alert-save-fail-wallet').fadeIn();
                    btnSaveWallets = false;
                }
            });
        }
    });
    // Remove Wallet
    var btnDeleteWallet = false;
    $('#btnDeleteWallet').click(function(e) {
        e.preventDefault();
        if (!btnDeleteWallet) {
            btnDeleteWallet = true;
            $.ajax({
                type: 'post',
                url: 'ajax.php?type=update&action=remove-config',
                data: $('form', '#walletDetails').serialize()
            }).done(function(data, statusText, xhr){
                var status = xhr.status;
                if (status == 202) {
                    window.location.href = 'index.php';
                } else if (status == 406) {
                    $('#alert-save-fail-wallet').fadeIn();
                    btnDeleteWallet = false;
                }
            });
        }
    });
      
});
