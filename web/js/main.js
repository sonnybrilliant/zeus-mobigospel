$(document).ready(function() {
  $('.search').focus(function() {
    this.value = "";
  });
  
  $('.hint').tooltip({
      selector: "a[rel=tooltip]"
  });
  
  $('.carousel').carousel()
  
  $(function () {
        $.scrollUp({
            scrollName: 'scrollUp', // Element ID
            topDistance: '300', // Distance from top before showing element (px)
            topSpeed: 300, // Speed back to top (ms)
            animation: 'fade', // Fade, slide, none
            animationInSpeed: 200, // Animation in speed (ms)
            animationOutSpeed: 200, // Animation out speed (ms)
            scrollText: 'Scroll to top', // Text for element
            activeOverlay: false // Set CSS color to display scrollUp active point, e.g '#00FFFF'
        });
   });
  
  alertify.log( 'hello world');
 
  $(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );
});
