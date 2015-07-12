var poolCollection; // Global Variable

!function ($){

    /*=================================
    =            The Pools            =
    =================================*/

    poolCollection = new PoolCollection();
    poolCollection.start();

    // Pool modal
    $('#selectPoolType').change(function() {
        var type = $(this).val();
        poolCollection.modal(type);
    });

    // Edit Pool
    $document.on('click', '.btn-edit-pool', function (evt) {        
        var poolId = this.getAttribute('data-attr')
        poolCollection.edit(poolId);
    });

    /*-----  End of The Pools  ------*/

}(window.jQuery)
