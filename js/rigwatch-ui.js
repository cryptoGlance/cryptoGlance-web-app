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

$.easing.easeOutElasticSingleBounce = function (x, t, b, c, d) {
    var s=1.70158;var p=0;var a=c;
    if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
    if (a < Math.abs(c)) { a=c; var s=p/4; }
    else var s = p/(2*Math.PI) * Math.asin (c/a);
    return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
};
   
// Close navbar after click on mobile
//

$(function(){ 
   var navMain = $(".navbar-collapse");

   navMain.on("click", "a:not(a.dropdown-toggle)", null, function () {
      var viewportWidth  = $(window).width();

      if(viewportWidth < 770) {
         navMain.collapse('hide');
      }
   });
});
   
// Smooth scrolling
//
  
function scrollTo(id){
   $('html,body').animate({scrollTop: $(id).offset().top},'slow');
};
   
 
// Execute when the DOM is ready
//
$(document).ready(function() {

   externalLinks();
   
   $('.anchor-offset').click(function() {
      var target = $(this).attr('href');
      $('body').scrollTo(target, 1000, { margin: true, offset: -60, easing:'easeOutBack'});
      navMain.collapse('slideUp');
      // TODO: Set the active/last-clicked nav-pill to toggle '.active'
      
      // $(this).prevAll("li").toggleClass("active");
      return false;
   })    

   $('.anchor').click(function() {
      var target = $(this).attr('href');
      $('body').scrollTo(target, 750, { margin: true });
      return false;
   })
   
   // Hide the feature spans first (they need 'display: block' set)
   $('.feature').find('span').hide();

   $('.feature').hover(function() {
      $(this).find('span').slideToggle();
   })
   
    
    
});