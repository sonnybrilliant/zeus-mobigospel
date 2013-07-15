$(document).ready(function() {
    $('.search').focus(function() {
        this.value = "";
    });
  
    $('.isGroup').click(function(){
       var checked = $(this).is(":checked");
       
       if(checked){
           //hide first, middle  and last name fields
           isBand();
       }else{
           isArtist();
       }
       
    });
    
    
    if($('.isGroup').is(":checked")){
        isBand();
    }
    
    $('.hideBand').hide();  
  
    $('.helpers').tooltip({
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
   
    $(".phone").mask("+27 (99) 999-9999");
    
    $('select.chosen').chosen(); 
    $('span.chosen select').chosen();
 
    $(function () {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    } );
});


function isBand(){
    $('.isBand').hide();    
}

function isArtist(){
    $('.isBand').show();
}