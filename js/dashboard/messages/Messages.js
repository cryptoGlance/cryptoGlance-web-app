!function (root, $) {

  'use strict';

  var Messages = function () {
    this.collection         = []

    this.apiData            = { type: 'messages', action: 'update' }
    this._ready             = true

    this.$overviewTableBody = $('#messages tbody')
  }

  Messages.prototype.start = function () {
    var _self = this;
    $.when(_self._getData()).done(function (data) {
        _self.update()
        setInterval(function () {
          if (_self._ready) {
              _self.update()
          }
      }, root.messageUpdateTime);
    });
  }

  /*-----  End of RigCollection Public Methods  ------*/

  /*=====================================================
  =            RigCollection Private Methods            =
  =====================================================*/

  Messages.prototype._buildAjax = function (callback){
    var _self = this // caching self ref for passing down in scope
    var overviewData = [];

    if (_self._ready) {
        _self._ready = false;

        $.when.apply($, callback).done(function (data) {
        	if (typeof data == 'object'){
        		_self._buildOverview(data);
        	}
            _self._ready = true;
        });
    } else {
        return false;
    }
  }
  
  Messages.prototype.update = function () {
	  return this._buildAjax([this._getData()]);
  }

  Messages.prototype.deleteMessage = function(id) {
	  return this._buildAjax([this._deleteMessage(id)]);
  }
	  
  
  Messages.prototype._buildOverview = function (data) {
	var _self = this;
	if (data.length){
		_self.$overviewTableBody.find('tr').attr('data-message-ok', 0);
		$.each(data, function(index, message){
			var $el = _self.$overviewTableBody.find('[data-message-id="'+message.id+'"]'); 
			if (!$el.length){
				var date = new Date(message.time * 1000);
				$el = $('<tr data-message-id="'+message.id+'" data-message-ok="1">'+
						'<td><span class="icon-severity-'+message.severity+'">'+message.severity+'</span></td>'+
						'<td>'+date.toLocaleString()+'</td>'+
						'<td>'+message.message+'</td>'+
						'<td><a class="removeMessage"><span class="red"><i class="icon icon-remove"></i></span></a>'+
						'</tr>');
				_self.$overviewTableBody.append($el.fadeIn());
			} else {
				$el.attr('data-message-ok', 1);
			}
		});
		_self.$overviewTableBody.find('tr[data-message-ok="0"]').fadeOut(function(){
			$(this).remove();
		});
	} else {
		_self.$overviewTableBody.find('tr[data-message-id]').fadeOut(function(){
			$(this).remove();
		});
	}
  } 
  
  Messages.prototype._getData = function () {
    var _self = this;

    var ajaxPromise = $.ajax({
        url: 'ajax.php',
        data: _self.apiData,
        dataType: 'json'
    });

    return ajaxPromise;
  }

  Messages.prototype._deleteMessage = function (messageId) {
	    var _self = this;

	    var ajaxPromise = $.ajax({
	        url: 'ajax.php',
	        data: $.extend({}, _self.apiData, {action : 'delete', id : messageId}),
	        dataType: 'json'
	    });

	    return ajaxPromise;
	  }
  
  root.Messages = Messages
}(window, window.jQuery)
