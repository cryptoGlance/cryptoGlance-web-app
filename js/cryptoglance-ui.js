// UI JavaScript for RigWatch
// 	by George Merlocco (george@merloc.co) // https://github.com/scar45/


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

$(function() {
  $( "#dashboard-wrap:not(.login-container)" ).sortable({
    placeholder: "dashboard-dropzone",
    opacity: 0.75,
    scrollSpeed: 50,
    handle: '.panel-heading',
    forcePlaceholderSize: true,
    scroll: true,
    scrollSensitivity: 100,
    update: function(event, ui) {
      var cooked = [];
      $("#dashboard-wrap:not(.login-container)").each(function(index, domEle){ cooked[index]=  $(domEle).sortable('toArray');});
      $.cookie('cookie_dashboard_layout', 'x'+cooked.join('|'), { expires: 31, path: '/'});
    }
  });
});


function restoreDashboard() {
  var cookie = $.cookie('cookie_dashboard_layout');
  if (!cookie) return;
  var SavedID = cookie.split('|');
  for ( var u=0, ul=SavedID.length; u < ul; u++ ){ SavedID[u] = SavedID[u].split(',');}
  for (var Scolumn=0, n = SavedID.length; Scolumn < n; Scolumn++) {
    for (var Sitem=0, m = SavedID[Scolumn].length; Sitem < m; Sitem++) {
      $("#dashboard-wrap:not(.login-container)").eq(Scolumn).append($("#dashboard-wrap:not(.login-container)").children("#" + SavedID[Scolumn][Sitem]));
    }
  }
}

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

// Modify Panel width
//

$(function() {

  //Store frequently elements in variables
  var slider  = $('#slider'),
    tooltip = $('.tooltip');
    
  //Hide the Tooltip at first
  tooltip.hide();

  //Call the Slider
  slider.slider({
    //Config
    range: "min",
    min: 49,
    max:96,
    value: 90,

    start: function(event,ui) {
      // tooltip.fadeIn('fast');
    },

    //Slider Event
    slide: function(event, ui) { //When the slider is sliding

     var value  = slider.slider('value'),
        actualWidth = $('.width-reading'),
        container = $('#dashboard-wrap, .full-content'),
        viewportWidth  = $(window).width();
     
     // tooltip.css('left', value).text(ui.value);  //Adjust the tooltip accordingly

     if(viewportWidth > 1200) {
        container.css('width', value + '%');
        actualWidth.html(value + '%');
        $.cookie("cookie_panel_width", value);
     }
     
    },

    stop: function(event,ui) {
      // tooltip.fadeOut('fast');
    },
  });

});

function restorePanelWidth() {
  var panelWidth = $.cookie('cookie_panel_width');
  if (!panelWidth) return;
     $('#dashboard-wrap, .full-content').css('width', panelWidth + '%');
     $('.width-reading').html(panelWidth + '%');
     $('.width-reading').html(panelWidth + '%');
     $('#slider').slider("value", panelWidth);
  // Set slider point !!!!!!!!!
}

function mobileWidthFixer() {
  var viewportWidth  = $(window).width(),
    container = $('#dashboard-wrap, .full-content');
    currentWidth = $('#slider').slider("option", "value");
    
  if(viewportWidth < 770) {
    container.css('width', '99%');
  } else if (viewportWidth < 1200) {
    container.css('width', '90%');
  } else {
    container.css('width', currentWidth + '%');
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
function toggleMobileNavbar() {
  $('.navbar-collapse').collapse('toggle');
}

// Hide Mobile Header
function hideMobileHeader() {
  $('.navbar').css({
    maxHeight : "0px",
    minHeight: "0px"
    }
  );
  $('.container.sub-nav').css({
    paddingTop : "65px"
    }
  );
  $('.navbar-header').hide();  
}


// Smooth scrolling
//
  
function scrollTo(id){
  $('html,body').animate({scrollTop: $(id).offset().top},'slow');
};
    
  
// Only change custom width (via slider) for viewports over 1200px
//

$(window).resize(function() {
  mobileWidthFixer();
  
});
  
// Execute when the DOM is ready
//
$(document).ready(function() {

  externalLinks();
  prettifyInputs();
  
  restoreDashboard();
  // restoreWalletOrder();
  
  restorePanelWidth();

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
     $currentButton.html("<i class='icon icon-refresh'></i> Update Now");
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
  });  

  $('#btnAddHost').click(function() {
    $("#alert-added-host").fadeIn('slow').delay( 4000 ).fadeOut(3000);
  }); 
  
  $('#btnSaveWallets').click(function() {
    $("#alert-saved-wallet").fadeIn('slow').delay( 4000 ).fadeOut(3000);
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
    $.cookie('rigwatch_version', true, { expires: 3, path: '/' });
    $('#alert-update').slideUp('fast');
  });
  
});