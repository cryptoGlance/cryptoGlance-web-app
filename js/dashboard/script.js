!function ($){

  /*================================
  =            The Rigs            =
  =================================*/

  var rigCollection = new RigCollection()
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
    var $manageRig = $('#manageRig')

    $manageRig.attr('data-attr', rigId)
    $manageRig.find('.rig-name').html($('#rig-' + rigId + ' h1').html())
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
            var poolUrl = k.url.slice(k.url.indexOf("/") + 2)

            var active = (k.active == 1) ? 'Yes' : 'No';
            var status = (k.status == 1) ? 'Alive' : 'Dead';

            $('.table tbody', $switchPoolModalBody).append(
                '<tr data-pool="'+ k.id +'">' +
                    '<td>'+ k.id +'</td>' +
                    '<td>'+ '<input type="radio" name="switchPoolList" id="rig'+ rigId +'-pool'+ k.id +'" value="'+ k.id +'">' +'</td>' +
                    '<td>'+ status +'</td>' +
                    '<td>'+ poolUrl +'</td>' +
                    '<td>'+ k.priority +'</td>' +
                '</tr>'
            );

            if (k.active == 1) {
                $('input:radio[id=rig'+ rigId +'-pool'+ k.id +']', $switchPoolModalBody).prop('checked', true);
            }
        });

        $switchPoolModalBody.find('.ajax-loader').remove()
        $('.table', $switchPoolModalBody).show();
        $('.resetStats', $switchPoolModalBody).show();
        prettifyInputs()
      }
    })
  })

  $document.on('click', '#switchPool .btn-success', function (evt) {
    var rigId = $('#switchPool').attr('data-attr')
    var selectedPoolId = $('input[name=switchPoolList]:checked', '#switchPool').val()
    var resetStats = $('input[name=resetStats]:checked', '#switchPool').val()

    if (typeof selectedPoolId != 'undefined') {
      $.ajax({
        type: 'post',
        data: {
          id: rigId,
          type: 'rigs',
          action: 'switch-pool',
          pool: parseInt(selectedPoolId, 10) + 1,
          reset: resetStats
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
    var rigId = $('#manageRig').attr('data-attr')
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

  // Reset
  $document.on('click', '#manageRig .btn-reset', function (evt) {
    var rigId = $('#manageRig').attr('data-attr')
    $.ajax({
      type: 'post',
      data: {
        id: rigId,
        type: 'rigs',
        action: 'reset-stats'
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


  /*-----  End of The Rigs  ------*/


  /*=================================
  =            The Pools            =
  =================================*/

  var poolCollection = new PoolCollection()
  poolCollection.start()

  // Pool modal
  $('#selectPoolType').change(function() {
      var type = $(this).val();
      $('#addPool').find('.form-group').hide();
      $('#addPool').find('.' + type).show();
      $('#addPool').find('.all').show();

      prettifyInputs();
  });

  // Edit Pool
  $document.on('click', '.btn-edit-pool', function (evt) {
    var poolId = this.getAttribute('data-attr')
    var $addPool = $('#addPool')

    $addPool.attr('data-attr', poolId)

    // Get Pool Config:
    $.ajax({
      type: 'get',
      data: {
        type: 'pools',
        action: 'config',
        id: poolId
      },
      url: 'ajax.php',
      dataType: 'json'
    })
    .done(function (data) {
        $.each(data, function(k, v) {
            if (k == 'type') {
                $addPool.find('select[name="poolType"]').val(v).change()
            } else {
                switch(k) {
                    case 'name':
                        k = 'label'
                        break
                    case 'apikey':
                        k = 'api'
                        break
                    case 'apiurl':
                        k = 'url'
                        break
                }

                $addPool.find('input[name="'+ k +'"]').val(v)
            }
        });
        $('<input type="hidden" name="id" value="'+poolId+'" />').appendTo($addPool.find('form'));
    });

    prettifyInputs()
  })

  /*-----  End of The Pools  ------*/


  /*===================================
  =            The Wallets            =
  ===================================*/

  var walletCollection = new WalletCollection()
  walletCollection.start()

  /*-----  End of The Wallets  ------*/


  /*===================================
  =            MobileMiner            =
  ===================================*/

    if (typeof MobileMiner != 'undefined') {
        var mobileMiner = new MobileMiner();
        mobileMiner.start();
    }

  /*-----  End of MobileMiner  ------*/


  /*=============================================
  =            Global Event Handling            =
  =============================================*/

    // Update BTN
    $document.on('click', 'button.btn-updater', function (evt) {
        var $currentButton = $(this);

        $currentButton.html("<i class='icon icon-refresh'></i> Updating...");
        $currentButton.children().addClass('icon-spin');
        $currentButton.prop({ disabled: true });

        var type = this.getAttribute('data-type');
        var btnTimeout = 500;
        var updateReturn = true;

        var updateObject = null;
        if (type == 'rig') {
            updateObject = rigCollection;
            updateReturn = updateObject._update();
        } else if (type == 'wallet') {
            updateObject = walletCollection;
            updateReturn = updateObject.update();
        }

        var updateReadyCheck = setInterval(function() {
            if (updateObject._ready === true || updateReturn === false) {
                $currentButton.html("<i class='icon icon-refresh'></i> Update");
                $currentButton.prop({ disabled: false });
                clearInterval(updateReadyCheck);
            }
        }, 1000);

    });

    // Add Config BTN
    $document.on('click', 'button.btn-saveConfig', function (evt) {
        var modal = $(this).parentsUntil('.modal').parent();
        var errorMsg = $('.error', modal);

        $.ajax({
            type: 'post',
            url: 'ajax.php?action=create',
            data: $('form', modal).serialize(),
            statusCode: {
                202: function() {
                    errorMsg.html('');
                    location.reload(true);
                },
                406: function(msg) {
                    errorMsg.html(msg.responseText);
                },
                409: function(msg) {
                    errorMsg.html(msg.responseText);
                }
            }
        })
        .fail(function (xhr, status, message) {
            //console.error(xhr, status, message)
        })
        .done()
        .always(function() {
            $('form', modal)[0].reset();
            $('input[name="id"]', modal).remove();
        })
    });
    $document.on('click', 'button.btn-cancelConfig, button.close', function (evt) {
        var modal = $(this).parentsUntil('.modal').parent();
        $('form', modal)[0].reset();
        $('input[name="id"]', modal).remove();
    });

    // Remove Config BTN
    $document.on('click', 'button.btn-removeConfig', function (evt) {
        var prompt = $('#deletePrompt');
        $.ajax({
            type: "post",
            url: 'ajax.php',
            data: { type: prompt.attr('data-type'), action: 'remove', id: prompt.attr('data-id') },
            dataType: 'json',
            statusCode: {
                202: function() {
                    location.reload(true);
                }
            }
        })
        .fail(function (xhr, status, message) {
            //console.error(xhr, status, message)
        })
        .done()
    });

  /*-----  End of Global Event Handling  ------*/

}(window.jQuery)
