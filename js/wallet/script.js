!function ($){

    /*================================
    =         Wallet Details         =
    =================================*/

    // Show/Hide panels
    // $('.enabler', '#rig-settings-thresholds').on('switchChange.bootstrapSwitch', function (evt) {
    $document.on('change', '#walletCurrency', function (evt) {
        var selectedCurrency = $(this).val();
        $('#currencyImage').attr('src', 'images/coin/'+selectedCurrency+'.png');
    });

    // Save Button
    $document.on('click', '#btnSaveWallet', function (evt) {
        var btnIcon = $('i', this);
        $(btnIcon).addClass('ajax-saver');

        var walletId = $('#walletDetails').attr('data-id');
        var form = $('form', '#walletDetails');
        $('#btnDeleteWallet').attr('disabled', 'disabled');

        $.ajax({
            url: document.URL,
            type: 'post',
            data: {
                id: walletId,
                type: 'details',
                action: 'update',
                label: $('#walletName').val(),
                currency: $('#walletCurrency').val(),
                fiat: $('#walletFiat').val()
            },
            dataType: 'json'
        })
        .done(function( id ) {
            $('#btnSaveWallet').attr('disabled', 'disabled');
            setTimeout(function() {
                $().toastmessage('showToast', {
                    sticky  : false,
                    text    : '<b>Saved!</b><br />Your settings have successfully been saved.<br />Please wait while the wallet loads.',
                    type    : 'success'
                });

                setTimeout(function() {
                    window.location.href = 'wallet.php?id='+id;
                }, 2500);
            }, 500);
        })
        .fail(function() {
            setTimeout(function() {
                $(btnIcon).removeClass('ajax-saver');
            }, 500);
        })
    });

    // Delete Wallet
    $document.on('click', '#btnDeleteWallet', function (evt) {
        var btnIcon = $('i', this);
        $(btnIcon).addClass('ajax-saver');

        var walletId = $('#walletDetails').attr('data-id');
        $('#btnSaveWallet').attr('disabled', 'disabled');

        $.ajax({
            url: document.URL,
            type: 'post',
            data: {
                id: walletId,
                action: 'remove'
            },
            dataType: 'json'
        })
        .done(function( id ) {
            $('#btnDeleteWallet').attr('disabled', 'disabled');
            setTimeout(function() {
                $().toastmessage('showToast', {
                    sticky  : false,
                    text    : '<b>Saved!</b><br />Your wallet has successfully been deleted.<br />Will now bring you back to the dashboard.',
                    type    : 'success'
                });

                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 2500);
            }, 500);
        })
        .fail(function() {
            setTimeout(function() {
                $(btnIcon).removeClass('ajax-saver');
            }, 500);
        })
    });

    /*--  End of Wallet Details  ---*/

    /*================================
    =        Wallet Addresses        =
    =================================*/

    $document.on('click', '.saveAddress', function (evt) {
        evt.preventDefault();

        var $_self = $(this);

        var $tr = $(this).parents('tr');
        var $inputs = $tr.children().find('input');
        var values = {};
        var walletId = $('#walletAddresses').attr('data-walletId');
        var addressId = $tr.attr('data-id');

        $inputs.each(function(){
            var typeName = $(this).parent().attr('data-type');
            values[typeName] = this.value;
        });

        $.ajax({
            type: 'post',
            data: {
                id: walletId,
                type: 'wallets',
                action: 'edit-address',
                addressId: addressId,
                values: values // label, address
            },
            url: 'ajax.php',
            dataType: 'json'
        })
        .done(function (data) {
            if ($inputs[1].value != $($inputs[1]).parent().find('span').text()) {
                $_self.find('i').removeClass('icon-save-floppy');
                $_self.find('i').addClass('ajax-saver');

                $().toastmessage('showToast', {
                    sticky  : false,
                    text    : '<b>Saved!</b><br />Address was successfully modified<br />Please wait while the wallet loads.',
                    type    : 'success'
                });

                setTimeout(function() {
                    location.reload(true);
                }, 2500);
            }
            $inputs.each(function(){
                $inputs.each(function(){
                    var $parent = $(this).parent();
                    var elmText = $('span', $parent);
                    var elmInput = $('input', $parent);
                    elmInput.attr('type', 'hidden');
                    elmText.text(this.value);
                    elmText.show();
                });
            });

            $_self.addClass('editAddress').removeClass('saveAddress')
            .find('.icon').removeClass('icon-save-floppy').addClass('icon-edit').parents('.editAddress')
            .next().addClass('removeAddress').removeClass('cancelAddress')
            .find('.blue').removeClass('blue').addClass('red')
            .find('.icon').removeClass('icon-undo').addClass('icon-remove');
        })
        .fail(function() {
            $_self.find('i').removeClass('ajax-saver');
            $_self.find('i').addClass('icon-save-floppy');
        })
    })

    $document.on('click', '.addAddress', function (evt) {
        evt.preventDefault();

        var $_self = $(this);
        var $tr = $(this).parents('tr');
        var $inputs = $tr.children().find('input');
        var values = {};
        var walletId = $('#walletAddresses').attr('data-walletId');

        // Fancy Animation
        $_self.find('i').removeClass('icon-save-floppy');
        $_self.find('i').addClass('ajax-saver');

        // If successfull, move on
        $inputs.each(function(){
            var typeName = $(this).parent().attr('data-type');
            values[typeName] = this.value;
        });

        $.ajax({
            type: 'post',
            data: {
                id: walletId,
                type: 'wallets',
                action: 'add-address',
                values: values // label, address
            },
            url: 'ajax.php',
            dataType: 'json'
        })
        .done(function( data ) {
            $().toastmessage('showToast', {
                sticky  : false,
                text    : '<b>Saved!</b><br />Address was successfully added to the wallet.<br />Please wait while the wallet loads.',
                type    : 'success'
            });

            setTimeout(function() {
                location.reload(true);
            }, 2500);
        }).fail(function() {
            $_self.find('i').removeClass('ajax-saver');
            $_self.find('i').addClass('icon-save-floppy');
        })
    })

    $document.on('click', '.removeAddress', function (evt) {
        evt.preventDefault()

        var $tr = $(this).parents('tr');
        var walletId = $('#walletAddresses').attr('data-walletId');
        var addressId = $tr.attr('data-id');

        $.ajax({
            type: 'post',
            data: {
                id: walletId,
                type: 'wallets',
                action: 'remove-address',
                addressId: addressId
            },
            url: 'ajax.php',
            dataType: 'json'
        })
        .done(function (data) {
            $tr.remove();
        });
    })

    $document.on('click', '.editAddress', function (evt) {
        evt.preventDefault()

        var $tr = $(this).parents('tr');
        var $inputs = $tr.children().find('input');

        $inputs.each(function(){
            var $td = $(this).parent();
            var elmText = $('span', $td);
            var elmInput = $('input', $td);
            elmInput.attr('type', 'text');
            elmText.hide();
        })

        $(this).addClass('saveAddress').removeClass('editAddress')
        .find('.icon').removeClass('icon-edit').addClass('icon-save-floppy').parents('.saveAddress')
        .next().addClass('cancelAddress').removeClass('removeAddress')
        .find('.red').removeClass('red').addClass('blue')
        .find('.icon').removeClass('icon-remove').addClass('icon-undo');

    })

    $document.on('click', '.cancelAddress', function (evt) {
        evt.preventDefault()

        var $tr = $(this).parents('tr');
        var $inputs = $tr.children().find('input');

        $inputs.each(function(){
            var $td = $(this).parent();
            var elmText = $('span', $td);
            var elmInput = $('input', $td);
            elmInput.attr('type', 'hidden');
            elmText.show();
        })

        $(this).addClass('removeAddress').removeClass('cancelAddress')
        .find('.blue').removeClass('blue').addClass('red')
        .find('.icon').removeClass('icon-undo').addClass('icon-remove').parents('.removeAddress')
        .prev().addClass('editAddress').removeClass('saveAddress')
        .find('.icon').removeClass('icon-save-floppy').addClass('icon-edit')

    })

    /*--  End of Wallet Addresses ---*/

}(window.jQuery)
