!function ($){

  var $document = $(document)

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

  // Manage Rig
  $document.on('click', '.btn-manage-rig', function (evt) {
    var rigId = this.getAttribute('data-attr')
    var $manageRig = $('#manageRig')

    $manageRig.attr('data-attr', rigId)
    $manageRig.find('.rig-name').html($('#rig-' + rigId + ' .panel-title .value').text())
    $manageRig.find('.btn-details').attr('href', 'rig.php?id=' + rigId)

    prettifyInputs()
  })

  // Switch Pools
  $document.on('click', '#manageRig .btn-switchpool', function (evt) {
    var rigId = $('#manageRig').attr('data-attr');
    var $switchPoolModalBody = $('#switchPool .modal-body')
    $('.table tbody', $switchPoolModalBody).html('');
    $('.ajax-loader', $switchPoolModalBody).html('<img src="images/ajax-loader.gif" alt="Loading..." class="ajax-loader" />')
    $.ajax({
        url: 'ajax.php',
        data: {
          id: rigId,
          type: 'rigs',
          action: 'pools'
        },
        dataType: 'json'
    })
    .done(function (data) {
      if (typeof data != 'undefined') {
        $('#switchPool').attr('data-attr', rigId);
        $.each(data[0], function (v,k) {
            var poolUrl = k.url.replace(/\:[0-9]{1,4}/, '');
            poolUrl = poolUrl.slice(poolUrl.indexOf("/") + 2)
            
            var active = (k.active == 1) ? 'Yes' : 'No';
            var status = (k.status == 1) ? 'Alive' : 'Dead';

            $('.table tbody', $switchPoolModalBody).append(
                '<tr data-pool="'+ k.id +'">' +
                    '<td>'+ k.id +'</td>' +
                    '<td>'+ '<input type="radio" name="switchPoolList" id="rig'+ rigId +'-pool'+ k.id +'" value="'+ k.id +'">' +'</td>' +
                    '<td>'+ status +'</td>' +
                    '<td>'+ poolUrl +'</td>' +
//                    '<td>'+ k.user +'</td>' +
                    '<td>'+ k.priority +'</td>' +
                '</tr>'
            );

            if (k.active == 1) {
                $('input:radio[id=rig'+ rigId +'-pool'+ k.id +']', $switchPoolModalBody).prop('checked', true);
            }
        });
        
        $switchPoolModalBody.find('.ajax-loader').remove()
        $('.table', $switchPoolModalBody).show();
        prettifyInputs()
      }
    })
  })

  $document.on('click', '#switchPool .btn-success', function (evt) {
    var rigId = $('#manageRig').data('attr')
    var selectedPoolId = $('input[name=switchPoolList]:checked', '#switchPool').val()
    if (typeof selectedPoolId != 'undefined') {
      $.ajax({
        type: 'post',
        data: {
          id: rigId,
          type: 'rigs',
          action: 'switch-pool',
          pool: parseInt(selectedPoolId, 10) + 1
        },
        url: 'ajax.php',
        dataType: 'json'
      })
      .done(function (data) {
          rigCollection._update()
      });
    }
  })

  // Restart
  $document.on('click', '#manageRig .btn-restart', function (evt) {
    var rigId = $('#manageRig').data('attr')
    $.ajax({
      type: 'post',
      data: {
        id: rigId,
        type: 'rigs',
        action: 'restart'
      },
      url: 'ajax.php',
      dataType: 'json'
    })
    .done(function (data) {
        rigCollection._update()
    });
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

  /*-----  End of Global Event Handling  ------*/

}(window.jQuery)
