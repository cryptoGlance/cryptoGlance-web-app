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

      var $tr = $(this).parents('tr')
      var $td = $tr.children().slice(1, 4)
      var poolId = $tr.attr('data-id')

      $td.each(function(){
        var input = document.createElement('input')
        input.name = 'pools[' + poolId + '][' + $(this).attr('data-name') + ']'
        input.className = 'form-control'
        input.value = this.textContent
        input.type = /\*/.test(this.textContent) ? 'password' : 'text'
        $(this).attr('data-val', this.textContent)
        this.textContent = ''
        this.appendChild(input)
      })

      $(this)
      .addClass('savePoolConfig')
      .removeClass('editPoolConfig')
      .find('.icon')
      .removeClass('icon-edit')
      .addClass('icon-save-floppy')
      .parents('.savePoolConfig')
      .next()
      .addClass('cancelPoolConfig')
      .removeClass('removePoolConfig')
      .find('.red')
      .removeClass('red')
      .addClass('blue')
      .find('.icon')
      .removeClass('icon-remove')
      .addClass('icon-undo')

    })

    $document.on('click', '.savePoolConfig', function (evt) {
      evt.preventDefault()

      var $tr = $(this).parents('tr')
      var $inputs = $tr.children().slice(1, 4).find('input')
      var values = []

      $inputs.each(function(){
        values.push(this.value)
        this.parentNode.textContent = this.value
      })

      $(this)
      .addClass('editPoolConfig')
      .removeClass('savePoolConfig')
      .find('.icon')
      .removeClass('icon-save-floppy')
      .addClass('icon-edit')
      .parents('.editPoolConfig')
      .next()
      .addClass('removePoolConfig')
      .removeClass('cancelPoolConfig')
      .find('.blue')
      .removeClass('blue')
      .addClass('red')
      .find('.icon')
      .removeClass('icon-undo')
      .addClass('icon-remove')

      alert('do ajax-y stuff with ' + values.join('|') + ' here')
    })

    $document.on('click', '.cancelPoolConfig', function (evt) {
      evt.preventDefault()

      var $tr = $(this).parents('tr')
      var $inputs = $tr.children().slice(1, 4).find('input')

      $inputs.each(function(){
        this.parentNode.textContent = $(this).parent().attr('data-val')
      })

      $(this)
      .addClass('removePoolConfig')
      .removeClass('cancelPoolConfig')
      .find('.blue')
      .removeClass('blue')
      .addClass('red')
      .find('.icon')
      .removeClass('icon-undo')
      .addClass('icon-remove')
      .parents('.removePoolConfig')
      .prev()
      .addClass('editPoolConfig')
      .removeClass('savePoolConfig')
      .find('.icon')
      .removeClass('icon-save-floppy')
      .addClass('icon-edit')

    })

    $document.on('click', '.removePoolConfig', function (evt) {
      evt.preventDefault()

      alert('pool removed!')
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
