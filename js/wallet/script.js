!function ($){

    /*================================
    =            Addresses           =
    =================================*/



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
