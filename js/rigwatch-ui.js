// UI JavaScript for RigWatch
// 	by George Merlocco (george@merloc.co) // https://github.com/scar45/


// Javascript Open in New Window (validation workaround)
//
function externalLinks() {
    if (!document.getElementsByTagName) return;
    var anchors = document.getElementsByTagName("a");
    for (var i=0; i<anchors.length; i++) {
        var anchor = anchors[i];
        if (anchor.getAttribute("href") &&
            anchor.getAttribute("rel") == "external")
            anchor.target = "_blank";
    }
}

// Execute when the DOM is ready
//
$(document).ready(function() {

   externalLinks();

   $('input[type=checkbox], input[type=radio]').prettyCheckable({
      color: 'blue'
   });
  
   $(".alert").alert();

   $('#btnSaveHost').click(function() {
      $("#alert-saved-host").fadeIn('slow').delay( 4000 ).fadeOut(3000);
   })    

   $('#btnAddHost').click(function() {
      $("#alert-added-host").fadeIn('slow').delay( 4000 ).fadeOut(3000);
   })    

   $('#btnSavePool').click(function() {
      $("#alert-saved-pool").fadeIn('slow').delay( 4000 ).fadeOut(3000);
   })    

   $('#btnAddPool').click(function() {
      $("#alert-added-pool").fadeIn('slow').delay( 4000 ).fadeOut(3000);
   })    

   $('#myTab a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
   })    
    
});