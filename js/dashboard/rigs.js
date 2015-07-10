var rigCollection; // Global Variable

!function ($){

    /*================================
    =            The Rigs            =
    =================================*/
    rigCollection = new RigCollection()
    rigCollection.start()

    // Manage Rig Details
    $document.on('click', '#manageRig .btn-details', function (evt) {
        $('#manageRig').modal('hide');
    })

    // Edit Rig
    $document.on('click', '.btn-edit-rig', function (evt) {
        var rigId = this.getAttribute('data-attr')
        var rigUrl = this.getAttribute('data-url')

        window.open(rigUrl + '?id=' + rigId, "_blank");
    })

    // Manage Rig
    $document.on('click', '.btn-manage-rig', function (evt) {
        var rigId = this.getAttribute('data-attr')
        rigCollection.manage(rigId);
    })

    // Switch Pools
    $document.on('click', '#manageRig .btn-switchpool', function (evt) {
        var rigId = $('#manageRig').attr('data-attr');
        rigCollection.modal.switchPools(rigId);
    })

    $document.on('click', '#switchPool .btn-success', function (evt) {
        var rigId = $('#switchPool').attr('data-attr');
        var selectedPoolId = $('input[name=switchPoolList]:checked', '#switchPool').val();
        var resetStats = $('input[name=resetStats]:checked', '#switchPool').val();

        if (typeof selectedPoolId != 'undefined') {
            rigCollection.switchPools(rigId, selectedPoolId, resetStats);
        }
    })


    // Restart
    $document.on('click', '#manageRig .btn-restart', function (evt) {
        var rigId = $('#manageRig').attr('data-attr')
        rigCollection.restart(rigId);
    })

    // Reset
    $document.on('click', '#manageRig .btn-reset', function (evt) {
        var rigId = $('#manageRig').attr('data-attr')
        rigCollection.reset(rigId);
    })

    $document.on('shown.bs.tab', 'a[data-toggle="tab"]', function (evt) {
        var siteLayout = $.cookie('use_masonry_layout');
        if (siteLayout == 'yes') {
            initMasonry();
        }
    })

    $document.on('click', '[id$="-summary"] a[data-target]', function (evt) {
        evt.preventDefault();
        $(evt.target.getAttribute('data-target')).trigger('click');
    })

    /*-----  End of The Rigs  ------*/

}(window.jQuery)
