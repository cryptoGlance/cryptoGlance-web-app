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


function callAlert() {
    $(function(){

     Messenger.options = {
      extraClasses: "messenger-fixed messenger-on-bottom",
      theme: "flat"
     };

     var steps = [
      function() {
        var msg = Messenger().post({
         message: 'Refreshing Content...',
         type: 'info',
         actions: false
        });
        setTimeout(function(){
         msg.update({
          message: 'Update Complete!',
          type: 'success',
          actions: false
         });
        }, 4000);
        setTimeout(function(){ msg.hide(); }, 8000);
      }
     ];

     var i = 1;

     steps[0]();
     setInterval(function(){
      steps[i]();
      i = (i + 1) % steps.length;
     }, 6000);

    });
}

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
  else if (viewportWidth >= 1680 && siteLayout == 'yes')
  {
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
     $(this).prettyCheckable({
        color: 'blue'
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
        $('body').scrollTo(target, 750, { margin: true, offset: -120 });
    });
});
    
  
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

  externalLinks();
  prettifyInputs();
  
  //restoreDashboard();
  restorePanelWidth();
  
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

  
  // Dismiss Update Alert
  $('.alert-dismiss', '#alert-update').click(function(e) {
    e.preventDefault();
    $.cookie('cryptoglance_version', true, { expires: 3 });
    $('#alert-update').slideUp('fast');
  });
  
    // Delete
    $('.btn-delete').click(function() {
        $('#deletePrompt').attr('data-type', $(this).parentsUntil('.panel').parent().attr('data-type'));
        $('#deletePrompt').attr('data-id', $(this).parentsUntil('.panel').parent().attr('data-id'));
        prettifyInputs();
    });
  
    $('#deletePrompt').on('shown.bs.modal', function () {
        $('.modal-body', this).html($('.modal-body', this).html().replace(/%PANNELNAME%/g, 'pannelname'));
        $('input[name="type"]', this).val($(this).attr('data-type'));
        $('input[name="id"]', this).val($(this).attr('data-id'));
        prettifyInputs();
    });
    
        
    // Pool modal
    $('#selectPoolType').change(function() {
        var type = $(this).val();
        if (type == 'mpos') {
            $('#addPool').find('.form-group').hide();
            $('#addPool').find('.mpos').show();
            $('#addPool').find('.all').show();
        } else if (type == 'wafflepool') {
            $('#addPool').find('.form-group').hide();
            $('#addPool').find('.wafflepool').show();
            $('#addPool').find('.all').show();            
        }
        prettifyInputs();
    });
    
    // Wallet Page \\
    // Edit Address Action
    $('#wallet-details').on('click', '.editAddress', function(e) {
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
        $(actionTd).html('<a href="#saveAddress" class="saveAddress"><span class="blue"><i class="icon icon-save-floppy"></i></span></a>');
    });
    // Remove Address Action
    $('#wallet-details').on('click', '.removeAddress', function(e) {
        e.preventDefault();
        
        // Wallet Id
        var walletId = $('#wallet-details').attr('data-walletId');
        
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
    $('#wallet-details').on('click', '.saveAddress', function(e) {
        e.preventDefault();
        
        // Wallet Id
        var walletId = $('#wallet-details').attr('data-walletId');
        
        // row Parent
        var addrRow = $(this).parents('tr');
        var addrKey = $(addrRow).attr('data-key');
        var addrLabel = $('[name="label"]', addrRow).val();
        var addrAddress = $('[name="address"]', addrRow).val();
        
        // on done:
        $.ajax({
            type: 'post',
            url: 'ajax.php?type=update&action=add-config',
            data: { type: 'address', walletId: walletId, addrId: addrKey, label: addrLabel, address: addrAddress },
            statusCode: {
                202: function() {
                    location.reload(true);
                },
                406: function() {
                    alert('a field is missing a required value (label/address)');
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
            }).done(function(data, statusText, xhr){
                var status = xhr.status;
                if (status == 202) {
                    var walletId = data;
                    window.location.href = 'wallet.php?id=' + walletId;
                    $('#alert-saved-wallet').fadeIn('fast');
                    $('#alert-save-fail-wallet').fadeOut('fast');
                } else if (status == 406) {
                    $('#alert-save-fail-wallet').fadeIn('fast');
                    $('#alert-saved-wallet').fadeOut('fast');
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
                    $('#alert-save-fail-wallet').fadeIn('fast');
                    btnDeleteWallet = false;
                }
            });
        }
    });
      
});