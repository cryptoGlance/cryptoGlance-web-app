// BTN Updates
$('button').click(function(e) {
    if ($(this).attr('name') == 'clearCookies') {
        e.preventDefault();

        for (var cookie in $.cookie()) {
            $.removeCookie(cookie);
        }

        window.location.assign('logout.php');
    }
});

// Execute when the DOM is ready
//
$(document).ready(function() {

  // Toggle App Update Types
  //
  $('input[name="update"]', '#settings-wrap').on('switchChange.bootstrapSwitch', function(event, state) {
    $('.app-update-types').fadeToggle();
  });

  // Toggle Mobile Miner Reporting
  //
  $('input[name="mobileminer"]', '#settings-wrap').on('switchChange.bootstrapSwitch', function(event, state) {
    $('.mobileminer-settings').fadeToggle();
  });

});
