$( document ).ready(function() {
    $.ajax({
        type: 'get',
        url: 'https://api.github.com/repos/scar45/rigWatch/releases',
        dataType: 'json',
        crossDomain: 'true'
    }).done(function(data) {
        // TODO: Load current version from some file...
        // TODO: check current version against returned data
        console.log('--- RELEASE VERSION ---------------------');
        console.log(data);
        console.log('-----------------------------------------');
    });
});