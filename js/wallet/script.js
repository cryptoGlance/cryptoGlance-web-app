!function ($){

    /*================================
    =            Addresses           =
    =================================*/

    // Edit Address Action
    $('#walletAddresses').on('click', '.editAddress', function(e) {
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
        $(actionTd).html('<a href="#saveAddress" class="saveEditAddress"><span class="blue"><i class="icon icon-save-floppy"></i></span></a>');
    });
    // Save Edit Address Action
    $('#walletAddresses').on('click', '.saveEditAddress', function(e) {
        e.preventDefault();

        // Wallet Id
        var walletId = $('#walletAddresses').attr('data-walletId');

        // row Parent
        var addrRow = $(this).parents('tr');
        var addrKey = $(addrRow).attr('data-key');
        var addrLabelInput = $('[name="label"]', addrRow);

        // on done:
        $.ajax({
            type: 'post',
            url: 'ajax.php?type=update&action=edit-config',
            data: { type: 'address', walletId: walletId, addrId: addrKey, label: $(addrLabelInput).val() },
            statusCode: {
                202: function() {
                    var addrLabelTd = $('[data-name="label"]', addrRow);
                    $(addrLabelTd).html($(addrLabelInput).val());
                    $(addrLabelInput).remove();

                    $('#alert-save-fail-address').fadeOut();
                    $('#alert-saved-address').fadeIn();

                    // get Last column (action buttons)
                    var actionTd = $('td:last', addrRow);
                    $(actionTd).html('<a href="#editAddress" class="editAddress"><span class="green"><i class="icon icon-edit"></i></span></a> &nbsp; <a href="#removeAddress" class="removeAddress"><span class="red"><i class="icon icon-remove"></i></span></a>');
                },
                406: function() {
                    $(addrLabelInput).removeClass('red');
                    $(addrLabelInput).addClass('red');
                    $('.errormsg', '#alert-save-fail-address').html('You need to provide a label for this address.');
                    $('#alert-saved-address').fadeOut();
                    $('#alert-save-fail-address').fadeIn();
                }
            }
        });
    });
    // Remove Address Action
    $('#walletAddresses').on('click', '.removeAddress', function(e) {
        e.preventDefault();

        // Wallet Id
        var walletId = $('#walletAddresses').attr('data-walletId');

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
    $('#walletAddresses').on('click', '.saveNewAddress', function(e) {
        e.preventDefault();

        // Wallet Id
        var walletId = $('#walletAddresses').attr('data-walletId');

        // row Parent
        var addrRow = $(this).parents('tr');
        var addrKey = $(addrRow).attr('data-key');
        var addrLabel = $('[name="label"]', addrRow);
        var addrAddress = $('[name="address"]', addrRow);

        // on done:
        $.ajax({
            type: 'post',
            url: 'ajax.php?type=update&action=add-config',
            data: { type: 'address', walletId: walletId, addrId: addrKey, label: $(addrLabel).val(), address: $(addrAddress).val() },
            statusCode: {
                202: function() {
                    location.reload(true);
                },
                406: function() {
                    $(addrLabel).removeClass('red');
                    $(addrAddress).removeClass('red');
                    $(addrLabel).addClass('red');
                    $(addrAddress).addClass('red');
                    $('.errormsg', '#alert-save-fail-address').html('You need to provide a label and address.');
                    $('#alert-save-fail-address').fadeIn();
                },
                409: function() {
                    $(addrLabel).removeClass('red');
                    $(addrAddress).removeClass('red');
                    $(addrAddress).addClass('red');
                    $('.errormsg', '#alert-save-fail-address').html('This address already exists in the wallet.');
                    $('#alert-save-fail-address').fadeIn();
                }
            }
        });
    });


    /*-----  End of Pools  ------*/

    /*=============================================
    =            Global Event Handling            =
    =============================================*/

    // Save Button
    // $document.on('click', '#btnSaveWallets', function (evt) {
    //     var btnIcon = $('i', this);
    //     $(btnIcon).addClass('ajax-saver');
    //
    //     var form = $('form', '#rigDetails .tab-content .active');
    //
    //     $.post( document.URL, form.serialize())
    //     .done(function( data ) {
    //         setTimeout(function() {
    //             $(btnIcon).removeClass('ajax-saver');
    //         }, 500);
    //     })
    //     .fail(function() {
    //         setTimeout(function() {
    //             $(btnIcon).removeClass('ajax-saver');
    //         }, 500);
    //     })
    // });

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
            }).done(function(data, statusText, xhr) {
                var status = xhr.status;
                if (status == 202) {
                    if ($('[name="walletId"]', '#walletDetails').val() == 0) {
                        var walletId = data;
                        window.location.href = 'wallet.php?id=' + walletId;
                    }
                    $('.panel-title', '#walletAddresses').html($('[name="label"]', '#walletDetails').val());
                    $('#alert-saved-wallet').fadeIn();
                    $('#alert-save-fail-wallet').fadeOut();
                    btnSaveWallets = false;
                }
            }).fail(function(data, statusText, xhr) {
                var status = data.status;
                if (status == 406) {
                    $('#alert-saved-wallet').fadeOut();
                    $('#alert-save-fail-wallet').fadeIn();
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
                    $('#alert-save-fail-wallet').fadeIn();
                    btnDeleteWallet = false;
                }
            });
        }
    });

    /*-----  End of Global Event Handling  ------*/

}(window.jQuery)
