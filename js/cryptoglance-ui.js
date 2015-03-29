
// UI JavaScript for CryptoGlance
// 	by George Merlocco (george@merloc.co) // https://github.com/scar45/

// ***** NOTE ***** JS optimization/clean-up is needed, don't laugh!

// CryptoGlance Namespace
var cG = {};

var $document = null;
var keyboardState = null;
var currFFZoom = 1;
var currIEZoom = 100;
!function ($) {
    $document = $(document)
    keyboardState = []
}(window.jQuery)

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

  if (!siteLayout) {
    $('#layout-grid').removeClass('active-layout');
    $('#layout-list').addClass('active-layout');
  }
  else if (viewportWidth < 1600 && siteLayout === 'yes') {
    destroyMasonry();
  }
  else if (viewportWidth >= 1600 && siteLayout === 'yes') {
    initMasonry();
    $('#layout-list').removeClass('active-layout');
    $('#layout-grid').addClass('active-layout');
  }
}

$document.on('masonry-update', function (evt) {
  restoreSiteLayout()
})

// Modify Panel width
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
        $.cookie("page_width", value);
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
  var panelWidth = $.cookie('page_width');
  var siteLayout = $.cookie('use_masonry_layout');

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

// Navigation Bar Dropdown
$(function(){
    // Trigger Open
    $('div.navbar-collapse .navbar-nav .dropdown .dropdown-toggle').on('click', function (event) {
        if (!$(this).parent().hasClass('open')) {
            $('div.navbar-collapse .navbar-nav .dropdown').removeClass('open');
        }
        $(this).parent().toggleClass("open");
    });

    // Trigger Close
    $('body').on('click', function (e) {
        if (
            !$('div.navbar-collapse .navbar-nav .dropdown').is(e.target)
            && $('div.navbar-collapse .navbar-nav .dropdown').has(e.target).length === 0
            && $('div.navbar-collapse .navbar-nav .open').has(e.target).length === 0
        ) {
            $('div.navbar-collapse .navbar-nav .dropdown').removeClass('open');
        }
    });

    cG.showTotalHashrate = $.cookie('show_total_hashrate'); // Might make this a cryptoglance setting instead of cookie
    if (typeof cG.showTotalHashrate == 'undefined') {
        cG.showTotalHashrate = 'true';
    }
    $('#showTotalHashrate').on('switchChange.bootstrapSwitch', function (evt) {
        if (evt.target.checked) {
            $.cookie("show_total_hashrate", 'true');
            cG.showTotalHashrate = 'true';
            $('#total-hashrates').fadeIn();
        } else {
            $.cookie("show_total_hashrate", 'false');
            cG.showTotalHashrate = 'false';
            $('#total-hashrates').fadeOut();
        }
    });
});

// Navigation hashtag URL
$(function(){
    // Javascript to enable link to tab
    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav.nav-pills li a[href=#'+url.split('#')[1]+']').tab('show') ;
    }

    // Change hash for page-reload
    $('.nav.nav-pills li a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
    })
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
    text    : '<b>Update available!</b><br />You are running <b class="current">'+currentVersion+'</b>,<br />but the latest release is <b class="latest">'+newestVersion+'</b>.<span><a href="update.php"><button type="button" class="btn btn-warning btn-xs" data-type="all"><i class="icon icon-refresh"></i> Update Now</button></a></span>',
    type    : 'notice'
  });
  $.cookie('cryptoglance_version', newestVersion, { expires: 1 });
}
function showToastNoUpdate(currentVersion) {
  $().toastmessage('showToast', {
    sticky  : true,
    text    : '<b>No Update Available</b><br />You are currently running the latest build (<b class="current">'+currentVersion+'</b>) of CryptoGlance.',
    type    : 'notice'
  });
}

// (Toast) Saved settings
function showToastSettingsSaved() {
  $().toastmessage('showToast', {
    sticky  : false,
    text    : '<b>Success!</b><br />Your configuration was saved.',
    type    : 'success'
  });

}

// (Toast) Unable to save settings
function showToastSettingsNOTSaved() {
  $().toastmessage('showToast', {
    sticky  : true,
    text    : '<b>Error!</b><br />Your configuration was <b>not</b> updated. Check your user data or refer to the <a href="help.php#faq">FAQ in the README</a>.',
    type    : 'error'
  });

}

// (Toast) Unable to write to dir
function showToastWriteError() {
  $().toastmessage('showToast', {
    sticky  : false,
    text    : '<b>Error!</b><br />Please make sure <em>/'+DATA_FOLDER+'/configs/</em> is writable.',
    type    : 'error'
  });
}


// (Toast) No .htaccess in user_data
function showToastNoHTACCESS() {
  $().toastmessage('showToast', {
    sticky  : true,
    text    : '<b>No .htaccess in /'+DATA_FOLDER+'!</b><br />Using this file to block access to your user data directory is a good idea. It\'s included in the source, but for some reason it does not exist in your installation. Ensure it contains the <a href="https://raw.githubusercontent.com/cryptoGlance/cryptoGlance-web-app/master/user_data/.htaccess" rel="external">contents of the source file</a>.',
    type    : 'warning'
  });
}

// (Toast) No .htaccess in user_data
function showToastRigOffline(name) {
  $().toastmessage('showToast', {
    sticky  : true,
    text    : 'cryptoGlance cannot connect to the rig "' + name + '".<br />This probably means the rig is offline.',
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

  // Pulsate "Add Panel" button
  //
  $('#flash-add-panel').click( function() {
    $('#dash-add-panel').removeClass('flash', function() {
    $('#dash-add-panel').addClass('flash');
    });
  });

  // Start Update Process
  $('#btn-update-process').click( function() {
    $(this).attr('disabled', true);
    $('iframe').slideDown();
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

    // Delete
    $('.btn-delete').click(function() {
        var panelType = $(this).parentsUntil('.panel').parent().attr('data-type');
        var panelId = $(this).parentsUntil('.panel').parent().attr('data-id');
        $('#deletePrompt').attr('data-type', (panelType+'s'));
        $('#deletePrompt').attr('data-id', panelId);
        $('.panelName', '#deletePrompt').html($('h1', '#' + panelType + '-' + panelId).text());
        prettifyInputs();
    });

    $('#deletePrompt').on('shown.bs.modal', function () {
        $('input[name="type"]', this).val($(this).attr('data-type'));
        $('input[name="id"]', this).val($(this).attr('data-id'));
        prettifyInputs();
    });

    // Global Stuff
    $document.ajaxError(function (evt, jqxhr, settings, thrownError) {
      switch (jqxhr.status) {
        case 400: // Bad Request
          break;
        case 401: // Unauthorized
          window.location.assign('login.php')
          break;
        case 404: // Not found
          break;
        case 406:
            $().toastmessage('showToast', {
              sticky  : false,
              text    : '<b>Error!</b> ' + jqxhr.responseText,
              type    : 'error'
            });
          break;
        case 500: // Internal Server Error
          break;
        default:
          return;
      }
    })

    // Global Keyboard Shortcuts
    //
    // Ctrl+D = redirect to debug.php
    $document.on('keydown', function (evt) {
      switch (evt.keyCode) {
        case 17: // CTRL
          keyboardState.indexOf('ctrl') === -1 && keyboardState.push('ctrl')
          break;
        case 68: // D
          keyboardState.indexOf('D') === -1 && keyboardState.push('D')
          break;
        case 188: // <
          keyboardState.indexOf('<') === -1 && keyboardState.push('<')
          break;
        case 190: // >
          keyboardState.indexOf('>') === -1 && keyboardState.push('>')
          break;
        case 191: // /
          keyboardState.indexOf('/') === -1 && keyboardState.push('/')
          break;
      }
      if (keyboardState.indexOf('ctrl') !== -1 && keyboardState.indexOf('D') !== -1) {
        window.location.assign('debug.php')
      } else if (keyboardState.indexOf('ctrl') !== -1 && keyboardState.indexOf('>') !== -1) { // zoom in
        currIEZoom += 10;
        $('body').css('zoom', currIEZoom + '%');
      } else if (keyboardState.indexOf('ctrl') !== -1 && keyboardState.indexOf('<') !== -1) { // zoom out
        if (currIEZoom > 10) {
            currIEZoom -= 10;
            $('body').css('zoom', currIEZoom + '%');
        }
      } else if (keyboardState.indexOf('ctrl') !== -1 && keyboardState.indexOf('/') !== -1) { // zoom out
        currIEZoom = 100;
        $('body').css('zoom', '100%');
      }
    })
    .on('keyup', function (evt) {
      switch (evt.keyCode) {
        case 17:
          keyboardState.splice(keyboardState.indexOf('ctrl'), 1)
          break;
        case 68:
          keyboardState.splice(keyboardState.indexOf('D'), 1)
          break;
        case 188: // <
          keyboardState.splice(keyboardState.indexOf('<'), 1)
          $(document).trigger('masonry-update');
          break;
        case 190: // >
          keyboardState.splice(keyboardState.indexOf('>'), 1)
          $(document).trigger('masonry-update');
          break;
        case 191: // /
          keyboardState.splice(keyboardState.indexOf('/'), 1)
          $(document).trigger('masonry-update');
          break;
      }
    })

});
