!function ($){

    /*================================
    =           Thresholds           =
    =================================*/

    // Show/Hide panels
    $('.enabler', '#rig-settings-thresholds').on('switchChange.bootstrapSwitch', function (evt) {
        var container = $(this).parentsUntil('fieldset').parent();
        var formGroup = $('.setting-thresholds', container);

        if (evt.target.checked) {
            formGroup.fadeIn({"queue":false});
        } else {
            formGroup.fadeOut();
        }
    });

    // Usability - Remove % sign when focused to edit
    $document.on('focus', '#rig-settings-thresholds input[type="text"]', function (evt) {
        var $input = $(this);
        var percentValue = $(this).val().replace('%','');
        $input.val(percentValue);
    })

    // Usability - Verify input is numeric
    $document.on('blur', '#rig-settings-thresholds input[type="text"]', function (evt) {
        var $input = $(this);
        var percentValue = $(this).val();

        if (isNaN(percentValue.replace('%',''))) {
            percentValue = '0';
        }
    })

    // Usability - Verify warning is not greater than danger
    $document.on('blur', '#rig-settings-thresholds input[type="text"]', function (evt) {
        var $input = $(this);

        if ($input.hasClass('warning')) {
            var warningVal = $input.val();
            var dangerVal = $input.parent().next().find('input').val();
        } else if ($input.hasClass('danger')) {
            var dangerVal = $input.val();
            var warningVal = $input.parent().prev().find('input').val();
        }

        warningVal = warningVal.replace('%','');
        dangerVal = dangerVal.replace('%','');
        if (parseFloat(warningVal) >= parseFloat(dangerVal)) {
            $().toastmessage('showToast', {
              sticky  : false,
              text    : '<b>Error!</b> Warning setting <b>cannot</b> be a higher value than your danger setting.',
              type    : 'error'
            });
        }
    })

    // Add % if not added
    $document.on('blur', '.setting-hw-errors-percent input', function (evt) {
        var $input = $(this);
        var percentValue = $(this).val();

        if (percentValue.indexOf('%') === -1) {
            $input.val(percentValue + '%');
        }
    })

    /*--  End of The Thresholds  ---*/

    /*================================
    =             Devices            =
    =================================*/

    $document.on('switchChange.bootstrapSwitch', '.devEnabled', function (evt) {
        var $tr = $(this).parents('tr');
        var devEnabled = $(this).is(':checked');
        var ridId = $('#rig-wrap').attr('data-rigId');
        var devId = $tr.attr('data-id');
        var devType = $tr.attr('data-type');

        $.ajax({
            type: 'post',
            data: {
                id: ridId,
                type: 'rigs',
                action: 'change-device-status',
                devId: devId,
                devType: devType,
                enable: devEnabled
            },
            url: 'ajax.php',
            dataType: 'json'
        });
    });

    /*--  End of The Devices  ---*/


    /*================================
    =              Pools             =
    =================================*/

    $document.on('click', '.editPoolConfig', function (evt) {
      evt.preventDefault()

      var $tr = $(this).parents('tr');
      var $td = $tr.children().slice(2, 6);

      $td.each(function(){
        var elmText = $('span', this);
        var elmInput = $('input', this);
        if (elmText.val() == '********') {
            elmInput.val('');
        }
        elmInput.attr('type', 'text');
        elmText.hide();
      })

      $(this).addClass('savePoolConfig').removeClass('editPoolConfig')
      .find('.icon').removeClass('icon-edit').addClass('icon-save-floppy').parents('.savePoolConfig')
      .next().addClass('cancelPoolConfig').removeClass('removePoolConfig')
      .find('.red').removeClass('red').addClass('blue')
      .find('.icon').removeClass('icon-remove').addClass('icon-undo');

    })

    $document.on('click', '.savePoolConfig', function (evt) {
        evt.preventDefault();

        var $_self = $(this);

        var $tr = $(this).parents('tr');
        var $inputs = $tr.children().slice(2, 6).find('input');
        var values = {};
        var ridId = $('#rig-wrap').attr('data-rigId');
        var poolId = $tr.attr('data-id');

        $inputs.each(function(){
            var typeName = $(this).parent().attr('data-type');
            values[typeName] = this.value;
        });

        $.ajax({
            type: 'post',
            data: {
                id: ridId,
                type: 'rigs',
                action: 'edit-pool',
                poolId: poolId,
                values: values // pool_url, worker, password
            },
            url: 'ajax.php',
            dataType: 'json'
        })
        .done(function (data) {
            $inputs.each(function(){
                var $parent = $(this).parent();
                var elmText = $('span', $parent);
                var elmInput = $('input', $parent);
                elmInput.attr('type', 'hidden');
                elmText.text(this.value);
                elmText.show();
            });

            $_self.addClass('editPoolConfig').removeClass('savePoolConfig')
            .find('.icon').removeClass('icon-save-floppy').addClass('icon-edit').parents('.editPoolConfig')
            .next().addClass('removePoolConfig').removeClass('cancelPoolConfig')
            .find('.blue').removeClass('blue').addClass('red')
            .find('.icon').removeClass('icon-undo').addClass('icon-remove');
        });
    })

    $document.on('click', '.addPoolConfig', function (evt) {
        evt.preventDefault();

        var $tr = $(this).parents('tr');
        var $inputs = $tr.children().slice(2, 6).find('input');
        var values = {};
        var ridId = $('#rig-wrap').attr('data-rigId');

        // If successfull, move on
        $inputs.each(function(){
            var typeName = $(this).parent().attr('data-type');
            values[typeName] = this.value;
        });

        $.ajax({
            type: 'post',
            data: {
                id: ridId,
                type: 'rigs',
                action: 'add-pool',
                values: values // pool_url, worker, password
            },
            url: 'ajax.php',
            dataType: 'json'
        })
        .done(function( data ) {
            location.reload(true);
        })
    })

    $document.on('click', '.cancelPoolConfig', function (evt) {
        evt.preventDefault()

        var $tr = $(this).parents('tr');
        var $td = $tr.children().slice(2, 6);

        // Turn inputs into hidden, set input value from span value
        $td.each(function(){
            var elmText = $('span', this);
            var elmInput = $('input', this);
            if (elmText.html() != '********') {
                elmInput.val(elmText.html());
            }
            elmInput.attr('type', 'hidden');
            elmText.show();
        })

        $(this).addClass('removePoolConfig').removeClass('cancelPoolConfig')
        .find('.blue').removeClass('blue').addClass('red')
        .find('.icon').removeClass('icon-undo').addClass('icon-remove').parents('.removePoolConfig')
        .prev().addClass('editPoolConfig').removeClass('savePoolConfig')
        .find('.icon').removeClass('icon-save-floppy').addClass('icon-edit')

    })

    $document.on('click', '.removePoolConfig', function (evt) {
        evt.preventDefault()

        var $tr = $(this).parents('tr');
        var $table = $tr.parent();
        var ridId = $('#rig-wrap').attr('data-rigId');
        var poolId = $tr.attr('data-id');

        $.ajax({
            type: 'post',
            data: {
                id: ridId,
                type: 'rigs',
                action: 'remove-pool',
                poolId: poolId
            },
            url: 'ajax.php',
            dataType: 'json'
        })
        .done(function (data) {
            $tr.remove();
            $('tr', $table).each(function(k, v) {
                if ($(this).attr('data-id') > poolId) {
                    $(this).find('td[data-type="priority"] span').text(k);
                    $(this).attr('data-id', ($(this).attr('data-id')-1));
                }
                $(this).find('td[data-type="priority"] input').val(k);
            });
        });
    })

    $document.on('switchChange.bootstrapSwitch', '.poolActive', function (evt) {
        var $tr = $(this).parents('tr');
        var poolActive = $(this).is(':checked');
        var ridId = $('#rig-wrap').attr('data-rigId');
        var poolId = $tr.attr('data-id');

        $.ajax({
            type: 'post',
            data: {
                id: ridId,
                type: 'rigs',
                action: 'change-pool-status',
                poolId: poolId,
                active: poolActive
            },
            url: 'ajax.php',
            dataType: 'json'
        });
    });

    $('#rigDetails .table-pools tbody').sortable({
        items: 'tr:not(:last)',
        placeholder: "placeholder",
        opacity: 0.75,
        scrollSpeed: 70,
        handle: '.poolGrip',
        containment: 'parent',
        forcePlaceholderSize: true,
        scroll: true,
        scrollSensitivity: 100,
        update: function(event, ui) {
            var ridId = $('#rig-wrap').attr('data-rigId');
            var poolId = ui.item[0].dataset.id;
            var newPriority = $(ui.item[0]).index();

            $.ajax({
                type: 'post',
                data: {
                    id: ridId,
                    type: 'rigs',
                    action: 'prioritize-pool',
                    poolId: poolId,
                    priority: newPriority
                },
                url: 'ajax.php',
                dataType: 'json'
            })
            .done(function (data) {
                $('#rigDetails .table-pools tbody tr').each(function(k, v) {
                    $(this).find('td[data-type="priority"] span').text(k);
                    $(this).find('td[data-type="priority"] input').val(k);
                });
            });

            $('#rigDetails .table-pools tbody').enableSelection();
        }
    }).disableSelection();

    /*-----  End of Pools  ------*/

    /*=============================================
    =            Global Event Handling            =
    =============================================*/

    $document.ready(function() {
        var navItem = $('#rigDetails .nav-pills li.active a');

        if (navItem.attr('href') == '#pools') {
            $('#btnSaveRig').addClass('disabled');
        } else {
            $('#btnSaveRig').removeClass('disabled');
        }
    });

    // Navigation handling
    $document.on('click', '.nav-pills li', function (evt) {
        var navItem = $('a', this);

        if (navItem.attr('href') == '#pools') {
            $('#btnSaveRig').addClass('disabled');
        } else {
            $('#btnSaveRig').removeClass('disabled');
        }
    });

    // Save Button
    $document.on('click', '#btnSaveRig', function (evt) {
        var btnIcon = $('i', this);
        $(btnIcon).addClass('ajax-saver');

        var form = $('form', '#rigDetails .tab-content .active');

        $.post( document.URL, form.serialize())
        .done(function( data ) {
            setTimeout(function() {
                $(btnIcon).removeClass('ajax-saver');

                var successMsg = '<b>Saved!</b><br />Your settings have successfully been saved.';
                if ($('#rigDetails .nav-pills .active a').attr('href') == '#devices') {
                    successMsg = '<b>Saved!</b><br />Attempted to save new device settings.<br />Some devices do not allow settings to be changed.';
                }

                $().toastmessage('showToast', {
                    sticky  : false,
                    text    : successMsg,
                    type    : 'success'
                });
            }, 500);
        })
        .fail(function() {
            setTimeout(function() {
                $(btnIcon).removeClass('ajax-saver');
            }, 500);
        })
    });

    /*-----  End of Global Event Handling  ------*/

}(window.jQuery)
