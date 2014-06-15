!function ($){

  window.interval = 5e3

  /*================================
  =            The Rigs            =
  =================================*/

  var rigCollection = new RigCollection()
  rigCollection.start()

  /*-----  End of The Rigs  ------*/


  /*=================================
  =            The Pools            =
  =================================*/

  var poolCollection = new PoolCollection()
  poolCollection.start()

  /*-----  End of The Pools  ------*/


  /*===================================
  =            The Wallets            =
  ===================================*/

  var walletCollection = new WalletCollection()
  walletCollection.start()

  /*-----  End of The Wallets  ------*/


  /*=============================================
  =            Global Event Handling            =
  =============================================*/

  $(document)
  // Manage Rig
  .on('click', '.btn-manage-rig', function (evt) {
    var minerId = this.getAttribute('data-attr')
    var $manageRig = $('#manageRig')

    $manageRig.attr('data-attr', minerId)
    $manageRig.find('.rig-name').html($('#rig-' + minerId + ' .panel-title .value').text())
    $manageRig.find('.btn-details').attr('href', 'rig.php?id=' + minerId)

    prettifyInputs()
  })
  // Switch Pools
  .on('click', '#manageRig .btn-switchpool', function (evt) {
    var minerId = this.getAttribute('data-attr')
    var $switchPoolModal = $('#switchPool .checkbox')
    $switchPoolModal.html('<img src="images/ajax-loader.gif" alt="Loading..." class="ajax-loader" />')
    $.ajax({
        type: 'post',
        data: {
          type: 'miner',
          action: 'get-pools',
          miner: minerId
        },
        url: 'ajax.php',
        dataType: 'json'
    })
    .done(function (data) {
      if (typeof data != 'undefined') {
        $('#switchPool').attr('data-minerId', minerId);
        $.each(data, function (v,k) {
            var poolUrl = k.url.replace(/\:[0-9]{1,4}/, '').slice(poolUrl.indexOf("/") + 2)

            $switchPoolModal.append('<label for="rig'+ minerId +'-pool'+ k.id +'">' +
                                    '<input type="radio" name="switchPoolList" id="rig'+ minerId +'-pool'+ k.id +'" value="'+ k.id +'">' +
                                    '<span>'+ poolUrl +'</span>' +
                                    '</label>')
            if (k.active == 1) {
                $('input:radio[id=rig'+ minerId +'-pool'+ k.id +']', $switchPoolModal).prop('checked', true);
            }
        });

        prettifyInputs()

        $switchPoolModal.find('.ajax-loader').remove()
      }
    })
  })
  .on('click', '#switchPool .btn-success', function (evt) {
    var minerId = this.getAttribute('data-attr')
    var selectedPoolId = $('input[name=switchPoolList]:checked', '#switchPool .checkbox').val()
    if (typeof selectedPoolId != 'undefined') {
      $.ajax({
        type: 'post',
        data: {
          type: 'miners',
          action: 'switch-pool',
          miner: minerId,
          pool: parseInt(selectedPoolId, 10) + 1
        },
        url: 'ajax.php',
        dataType: 'json'
      })
      .done(function (data) {
          ajaxUpdateCall('rig');
      });
    }
  })
  // Restart
  .on('click', '#manageRig .btn-restart', function (evt) {
    var minerId = this.getAttribute('data-attr')
    $.ajax({
      type: 'post',
      data: {
        type: 'miners',
        action: 'restart',
        miner: minerId
      },
      url: 'ajax.php',
      dataType: 'json'
    })
  })
  .on('shown.bs.tab', 'a[data-toggle="tab"]', function (evt) {
    var siteLayout = $.cookie('use_masonry_layout');
    if (siteLayout == 'yes') {
        initMasonry();
    }
  })

  /*-----  End of Global Event Handling  ------*/

}(window.jQuery)
