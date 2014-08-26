!function ($){

    var $document = $(document)

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

    /*-----  End of The Thresholds  ------*/


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
            console.log(data);
            // $(btnIcon).removeClass('ajax-saver');
        });
        setTimeout(function() {
            $(btnIcon).removeClass('ajax-saver');
        }, 1300);
    });

    $document.on('click', '.editPoolConfig', function (evt) {
      evt.preventDefault()

      var $tr = $(this).parents('tr')
      var $td = $tr.children().slice(1, 4)

      $td.each(function(){
        var input = document.createElement('input')
        input.value = this.textContent
        input.type = /\*/.test(this.textContent) ? 'password' : 'text'
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
      .find('.icon')
      .removeClass('icon-undo')
      .addClass('icon-remove')

      alert('do ajax-y stuff with ' + values.join('|') + ' here')
    })

    $document.on('click', '.cancelPoolConfig', function (evt) {
      evt.preventDefault()

      var $tr = $(this).parents('tr')
      var $inputs = $tr.children().slice(1, 4).find('input')
      var values = []

      $inputs.each(function(){
        values.push(this.value)
        this.parentNode.textContent = this.value
      })

      $(this)
      .addClass('removePoolConfig')
      .removeClass('cancelPoolConfig')
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

}(window.jQuery)
