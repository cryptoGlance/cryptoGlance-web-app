var lastMasonryUpdate = new Date();

// Modal Update Stuff
// Add Config
$('.submitAddConfig').click(function(e) {
    e.preventDefault();
    $.ajax({
        type: 'post',
        url: 'ajax.php?type=update&action=add-config',
        data: $(this).parentsUntil('form').parent().serialize(),
        statusCode: {
            202: function() {
                location.reload(true);
            },
            406: function() {
                // error - Not Accepted
            },
            409: function() {
                // error - Conflict (same IP + Port found)
            }
        }
    });
});

// Remove Config
$('.submitRemoveConfig').click(function(e) {
    e.preventDefault();
    // put this somewhere: .replace(/%PANNELNAME%/g, 'pannelname');
    $.ajax({
        type: 'post',
        url: 'ajax.php?type=update&action=remove-config',
        data: $(this).parentsUntil('form').parent().serialize(),
        statusCode: {
            202: function() {
                location.reload(true);
            },
            406: function() {
                // error - Not Accepted
            }
        }
    });
});