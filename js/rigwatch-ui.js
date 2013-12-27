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


$(function() {
   $( "#top-ltc-panel .panel-body" ).sortable({
      placeholder: "stat-pair-dropzone",
      opacity: 0.75,
      scrollSpeed: 50,
      forcePlaceholderSize: true,
      scroll: true,
      scrollSensitivity: 100,
      update: function(event, ui) {
         var cooked = [];
         $("#top-ltc-panel .panel-body").each(function(index, domEle){ cooked[index]=    $(domEle).sortable('toArray');});
         $.cookie('cookie_top_ltc_panel', 'x'+cooked.join('|'), { expires: 31, path: '/'});
      }
   });
   $( "#top-ltc-panel .panel-body" ).disableSelection();
});


function restoreStatPairOrder() {
    var cookie = $.cookie('cookie_top_ltc_panel');
    if (!cookie) return;
    var SavedID = cookie.split('|');
    for ( var u=0, ul=SavedID.length; u < ul; u++ ){ SavedID[u] = SavedID[u].split(',');}
    for (var Scolumn=0, n = SavedID.length; Scolumn < n; Scolumn++) {
        for (var Sitem=0, m = SavedID[Scolumn].length; Sitem < m; Sitem++) {
            $("#top-ltc-panel .panel-body").eq(Scolumn).append($("#top-ltc-panel .panel-body").children("#" + SavedID[Scolumn][Sitem]));
        }
    }
}


// We will need to set a variable in order to dynamically create 'pens'/containers for uniquely sortable sets of data (i.e. top coins panel, rig-hostname-1-summary, rig-hostname-1-gpu0, rig-hostname-1-gpu1, etc.

// We must also set a var on teh cookie name

// For both vars, use the ID name, but for the cookie var, dashes must be converted to underscores

// Also, the function name to restore the cookie needs to be uniqueID

// I'M SURE THERE IS A BETTER WAY TO DO ALL OF THIS PROGRAMMATICALLY!!! :(

// TL;DR: THIS NEEDS A LOT, A LOT, A LOT OF RE-WORK!

// Below is for testing purposes, and should be deleted after the above functions are amended with variables


$(function() {
   $( "#rig-hostname-1-summary .panel-body" ).sortable({
      placeholder: "stat-pair-dropzone",
      opacity: 0.75,
      scrollSpeed: 50,
      forcePlaceholderSize: true,
      scroll: true,
      scrollSensitivity: 100,
      update: function(event, ui) {
         var cooked = [];
         $("#rig-hostname-1-summary .panel-body").each(function(index, domEle){ cooked[index]=    $(domEle).sortable('toArray');});
         $.cookie('cookie_rig_hostname_1_summary', 'x'+cooked.join('|'), { expires: 31, path: '/'});
      }
   });
   $( "#rig-hostname-1-summary .panel-body" ).disableSelection();
});


function restoreRig1Summary() {
    var cookie = $.cookie('cookie_rig_hostname_1_summary');
    if (!cookie) return;
    var SavedID = cookie.split('|');
    for ( var u=0, ul=SavedID.length; u < ul; u++ ){ SavedID[u] = SavedID[u].split(',');}
    for (var Scolumn=0, n = SavedID.length; Scolumn < n; Scolumn++) {
        for (var Sitem=0, m = SavedID[Scolumn].length; Sitem < m; Sitem++) {
            $("#rig-hostname-1-summary .panel-body").eq(Scolumn).append($("#rig-hostname-1-summary .panel-body").children("#" + SavedID[Scolumn][Sitem]));
        }
    }
}


$(function() {
   $( "#rig-hostname-1-gpu0 .panel-body" ).sortable({
      placeholder: "stat-pair-dropzone",
      opacity: 0.75,
      scrollSpeed: 50,
      forcePlaceholderSize: true,
      scroll: true,
      scrollSensitivity: 100,
      update: function(event, ui) {
         var cooked = [];
         $("#rig-hostname-1-gpu0 .panel-body").each(function(index, domEle){ cooked[index]=    $(domEle).sortable('toArray');});
         $.cookie('cookie_rig_hostname_1_gpu0', 'x'+cooked.join('|'), { expires: 31, path: '/'});
      }
   });
   $( "#rig-hostname-1-gpu0 .panel-body" ).disableSelection();
});


function restoreRig1GPU0() {
    var cookie = $.cookie('cookie_rig_hostname_1_gpu0');
    if (!cookie) return;
    var SavedID = cookie.split('|');
    for ( var u=0, ul=SavedID.length; u < ul; u++ ){ SavedID[u] = SavedID[u].split(',');}
    for (var Scolumn=0, n = SavedID.length; Scolumn < n; Scolumn++) {
        for (var Sitem=0, m = SavedID[Scolumn].length; Sitem < m; Sitem++) {
            $("#rig-hostname-1-gpu0 .panel-body").eq(Scolumn).append($("#rig-hostname-1-gpu0 .panel-body").children("#" + SavedID[Scolumn][Sitem]));
        }
    }
}








$(function() {
   $( "#dashboard-wrap" ).sortable({
      placeholder: "dashboard-dropzone",
      opacity: 0.75,
      scrollSpeed: 50,
      handle: '.panel-heading',
      forcePlaceholderSize: true,
      scroll: true,
      scrollSensitivity: 100,
      update: function(event, ui) {
         var cooked = [];
         $("#dashboard-wrap").each(function(index, domEle){ cooked[index]=    $(domEle).sortable('toArray');});
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
            $("#dashboard-wrap").eq(Scolumn).append($("#dashboard-wrap").children("#" + SavedID[Scolumn][Sitem]));
        }
    }
}



$(function() {
   $( "#rig-hostname-1-gpu1 .panel-body" ).sortable({
      placeholder: "stat-pair-dropzone",
      opacity: 0.75,
      scrollSpeed: 50,
      forcePlaceholderSize: true,
      scroll: true,
      scrollSensitivity: 100,
      update: function(event, ui) {
         var cooked = [];
         $("#rig-hostname-1-gpu1 .panel-body").each(function(index, domEle){ cooked[index]=    $(domEle).sortable('toArray');});
         $.cookie('cookie_rig_hostname_1_gpu1', 'x'+cooked.join('|'), { expires: 31, path: '/'});
      }
   });
   $( "#rig-hostname-1-gpu1 .panel-body" ).disableSelection();
});


function restoreRig1GPU1() {
    var cookie = $.cookie('cookie_rig_hostname_1_gpu1');
    if (!cookie) return;
    var SavedID = cookie.split('|');
    for ( var u=0, ul=SavedID.length; u < ul; u++ ){ SavedID[u] = SavedID[u].split(',');}
    for (var Scolumn=0, n = SavedID.length; Scolumn < n; Scolumn++) {
        for (var Sitem=0, m = SavedID[Scolumn].length; Sitem < m; Sitem++) {
            $("#rig-hostname-1-gpu1 .panel-body").eq(Scolumn).append($("#rig-hostname-1-gpu1 .panel-body").children("#" + SavedID[Scolumn][Sitem]));
        }
    }
}





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


function expandAllPanels() {
   $('.panel-body, .panel-footer, .tab-content, .panel-rig .nav-pills').slideDown();
}

function collapseAllPanels() {
   $('.panel-body, .panel-footer, .tab-content, .panel-rig .nav-pills').slideUp('slow');
}

// Execute when the DOM is ready
//
$(document).ready(function() {

   externalLinks();
   
   restoreDashboard();
   restoreStatPairOrder();
   
   $('input[type=checkbox], input[type=radio]').prettyCheckable({
      color: 'blue'
   });
   
  
   $('#collapse-all-panels').click(function() {
      collapseAllPanels();
      $('.toggle-panel-body').addClass("minimized");
      $('.toggle-panel-body').html("<i class='icon icon-chevron-down'></i>");
   })

   $('#expand-all-panels').click(function() {
      expandAllPanels();
      $('.toggle-panel-body').removeClass("minimized");
      $('.toggle-panel-body').html("<i class='icon icon-chevron-up'></i>");
   })

   $('.toggle-panel-body').click(function() {
      var $toggleButton = $(this);
      
      $(this).parent().nextAll('.panel-body, .panel-footer, .tab-content, .panel-rig .nav-pills').slideToggle('slow');
      
      $toggleButton.toggleClass("minimized");

      if ($toggleButton.hasClass("minimized")) {
         $toggleButton.html("<i class='icon icon-chevron-down'></i>");
      } else {
         $toggleButton.html("<i class='icon icon-chevron-up'></i>");
      }
   })

      
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

   })    

   $('#btnSaveHost').click(function() {
      $("#alert-saved-host").fadeIn('slow').delay( 4000 ).fadeOut(3000);
   })    

   $('#btnAddHost').click(function() {
      $("#alert-added-host").fadeIn('slow').delay( 4000 ).fadeOut(3000);
   })    

   $('#btnSavePool').click(function() {
      $("#alert-saved-pool").fadeIn('slow').delay( 4000 ).fadeOut(3000);
   })    

   $('#btnAddPool').click(function() {
      $("#alert-added-pool").fadeIn('slow').delay( 4000 ).fadeOut(3000);
   })    

   $('#myTab a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
   })    
    
});