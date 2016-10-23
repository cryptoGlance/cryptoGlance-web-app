!function ($){

  /*===================================
  =            MobileMiner            =
  ===================================*/

    // if (typeof MobileMiner != 'undefined') {
    //     var mobileMiner = new MobileMiner();
    //     mobileMiner.start();
    // }

  /*-----  End of MobileMiner  ------*/


  /*=============================================
  =            Global Event Handling            =
  =============================================*/

    // Add New Panel
    $document.on('click', '.new-panel-btn', function (evt) {
        var target = $(this).attr('data-target');
        $('.title-add', target).show();
        $('.title-edit', target).hide();
    })

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

        $.ajax({
            type: 'post',
            url: 'ajax.php?action=create',
            data: $('form', modal).serialize(),
            statusCode: {
                202: function() {
                    location.reload(true);
                }
            }
        })
        .fail(function (xhr, status, message) {
            //console.error(xhr, status, message)
        })
        .done(function() {
            $('form', modal)[0].reset();
            $('input[name="id"]', modal).remove();
        })
    });

    // Cancel BTN
    $document.on('click', 'button.btn-cancelConfig, button.close', function (evt) {
        var modal = $(this).parentsUntil('.modal').parent();
        if (typeof $('form', modal)[0] != 'undefined') {
            $('form', modal)[0].reset();
        }
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


    // Add Show/Hide btn
    $document.on('click', 'button.toggle-panel-body', function (evt) {
        var elmPanel = $(this).parent().parent();
        var elmType = elmPanel.attr('data-type');
        if (typeof elmType == 'undefined') {
            elmType = 'CryptoGlance';
        }
        var elmId = elmPanel.attr('data-id');
        if (typeof elmId == 'undefined') {
            elmId = elmPanel.attr('id');
        }

        var $toggleButton = $(this);
        var $hideElm = $toggleButton.parent().next('.panel-content, .panel-body').slideToggle('fast', function() {
            if ($(this).is(":visible")) {
                $toggleButton.html("<i class='icon icon-chevron-up'></i>");
                var toggleDirection = 'open';
            } else {
                $toggleButton.html("<i class='icon icon-chevron-down'></i>");
                var toggleDirection = 'close';
            }
            $(document).trigger('masonry-update');

            // Save this data
            $.ajax({
                type: 'post',
                url: 'ajax.php',
                data: { type: elmType, action: 'toggle', id: elmId, toggle: toggleDirection }
            });
        });
    });

  /*-----  End of Global Event Handling  ------*/
    $document.on('ready', function(){
    	var $dashboard = $('#dashboard-wrap');
    	if (typeof panelOrder == 'object'){
    		$dashboard.find('>div.panel').sort(function(a, b){
    			return panelOrder[a.id] > panelOrder[b.id];
    		}).each(function () {
    		    var elem = $(this);
    		    elem.remove();
    		    $(elem).appendTo("#dashboard-wrap");
    		});
    	}
    	sortable('#dashboard-wrap',{
    		handle: 'div.panel > h1',
    		items : 'div.panel[id]',
    		placeholderClass: 'panel placeholder',
    		forcePlaceholderSize: true,
    	})[0].addEventListener('sortupdate', function(e) {
    		var order = {};
    		$('#dashboard-wrap > div.panel').each(function(index){
    			order[$(this).attr('id')] = index;
    		});
    		$.ajax({
    			type: 'post',
    			url: 'ajax.php',
    			data: {
    				type : 'panel',
    				action : 'order', 
    				order : order
    			}
    		})
    	});
    });

}(window.jQuery)
