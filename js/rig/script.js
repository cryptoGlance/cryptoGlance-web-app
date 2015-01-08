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
    =              Pools             =
    =================================*/

    $document.on('click', '.editPoolConfig', function (evt) {
      evt.preventDefault()

      var $tr = $(this).parents('tr');
      var $td = $tr.children().slice(1, 5);
      var poolId = $tr.attr('data-id');

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
      .find('.icon').removeClass('icon-edit').addClass('icon-ok').parents('.savePoolConfig')
      .next().addClass('cancelPoolConfig').removeClass('removePoolConfig')
      .find('.red').removeClass('red').addClass('blue')
      .find('.icon').removeClass('icon-remove').addClass('icon-undo');

    })

    $document.on('click', '.savePoolConfig', function (evt) {
        evt.preventDefault();

        var $tr = $(this).parents('tr');
        var $td = $tr.children().slice(1, 5);
        var values = [];
        var ridId = $('#rig-wrap').attr('data-rigId');
        var poolId = $tr.attr('data-id');

        // Turn inputs into hidden, change span value to what input it
        $td.each(function(){
            var elmText = $('span', this);
            var elmInput = $('input', this);
            elmText.html(elmInput.val());
            elmInput.attr('type', 'hidden');
            elmText.show();
        })

        $(this).addClass('editPoolConfig').removeClass('savePoolConfig')
        .find('.icon').removeClass('icon-ok').addClass('icon-edit').parents('.editPoolConfig')
        .next().addClass('removePoolConfig').removeClass('cancelPoolConfig')
        .find('.blue').removeClass('blue').addClass('red')
        .find('.icon').removeClass('icon-undo').addClass('icon-remove');
    })

    $document.on('click', '.cancelPoolConfig', function (evt) {
        evt.preventDefault()

        var $tr = $(this).parents('tr');
        var $td = $tr.children().slice(1, 5);

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
        .find('.icon').removeClass('icon-ok').addClass('icon-edit')

    })

    $document.on('click', '.removePoolConfig', function (evt) {
        evt.preventDefault()

        // Remove the pool
        var $tr = $(this).parents('tr');
        $tr.remove();

        // re-calculate ids
        var $rigPools = $('#pools .table-pools tr');
        $rigPools.each(function(pKey, pVal){
            var $poolRow = $(this);
            var $inputs = $(this).find('input');
            $poolRow.attr('data-id', pKey-1);
            $inputs.each(function(iKey, iVal) {
                $(this).attr('name', 'pools['+ (pKey-1) +']['+ $(this).parent().attr('data-type') +']');
            });
        });

    })

    $document.on('click', '#btnAddPool', function (evt) {
        evt.preventDefault()

        $.each($('#addNewPool input:not([type="hidden"])'), function(key, val) {
            $(this).val('');
        })

        $('#btnAddPool').hide();
        $('#addNewPool').show();
    })

    $document.on('click', '#btnCancelPool', function (evt) {
        evt.preventDefault()

        $('#addNewPool').hide();
        $('#btnAddPool').show();
    });

    $document.on('click', '#btnSavePool', function (evt) {
        evt.preventDefault()

        var $form = $('#addNewPool');
        var $inputs = $form.find('input');
        var $rigPools = $('#pools .table-pools');
        var totalPools = $rigPools.find('tr').length-1;

        var poolInputsValid = true;
        var invalidMsg = '';
        $inputs.each(function(){
            var elmType = $(this).attr('data-type');
            if (elmType != 'priority' && $(this).val() == '') {
                if (elmType == 'url') {
                    invalidMsg = 'Pool requires a URL to connect to!';
                } else if (elmType == 'user') {
                    invalidMsg = 'Pools require some sort of username. Either an coin address or a username/worker.';
                } else if (elmType == 'password') {
                    invalidMsg = 'Use atleast 1 character for a password. For example: "x".';
                }
                poolInputsValid = false;
                return false;
            }
        });
        if (!poolInputsValid) {
            $().toastmessage('showToast', {
                sticky  : false,
                text    : '<b>Error!</b><br />' + invalidMsg,
                type    : 'error'
            });
            return false;
        }

        var elmTr = document.createElement('tr');
        elmTr.setAttribute('data-id', totalPools);
        elmTr.innerHTML += '<td><input type="radio" name="poolActive" class="form-control" /></td>';
        $inputs.each(function(){
            var elmTd = document.createElement('td');
            var elmSpan = document.createElement('span');
            var elmInput = document.createElement('input');
            if ($(this).attr('data-type') == 'priority' && $(this).val() == '') {
                $(this).val(totalPools);
            }

            // Set TD type
            elmTd.setAttribute('data-type', $(this).attr('data-type'));

            // Set Span Value
            elmSpan.textContent = $(this).val();
            elmTd.appendChild(elmSpan);

            // Set Input name, value, type
            elmInput.type = 'hidden';
            elmInput.value = $(this).val();
            elmInput.className = 'form-control';
            elmInput.name = 'pools['+ totalPools +']['+ $(this).attr('data-type') +']';
            elmTd.appendChild(elmInput);

            elmTr.appendChild(elmTd);
        });
        elmTr.innerHTML += '<td><a href="#editPoolConfig" class="editPoolConfig"><span class="green"><i class="icon icon-edit"></i></span></a> &nbsp; <a href="#removePoolConfig" class="removePoolConfig"><span class="red"><i class="icon icon-remove"></i></span></a><br /></td>';

        $rigPools.append(elmTr);
        prettifyInputs();

        $('#addNewPool').hide();
        $('#btnAddPool').show();
    })

    /*-----  End of Pools  ------*/

    /*=============================================
    =            Global Event Handling            =
    =============================================*/

    // Save Button
    $document.on('click', '#btnSaveRig', function (evt) {
        var btnIcon = $('i', this);
        $(btnIcon).addClass('ajax-saver');

        var form = $('form', '#rigDetails .tab-content .active');

        $.post( document.URL, form.serialize())
        .done(function( data ) {
            setTimeout(function() {
                $(btnIcon).removeClass('ajax-saver');
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
