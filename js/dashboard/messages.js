var messages; // Global Variable

!function ($){

    /*===================================
    =            The Wallets            =
    ===================================*/

	messages = new Messages()
	messages.start()

    /*-----  End of The Wallets  ------*/

	$(document).on('click', 'a.removeMessage', function(e){
		e.preventDefault();
		messages.deleteMessage($(this).closest('tr').attr('data-message-id'));
	});
	
}(window.jQuery)

