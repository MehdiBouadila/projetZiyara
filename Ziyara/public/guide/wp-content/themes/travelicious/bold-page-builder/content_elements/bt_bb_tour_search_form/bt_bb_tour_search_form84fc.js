(function( $ ) {
    'use strict';      
    
    $( document ).ready(function() {        
 
        $('#bt_tour_search_sorting').fancySelect();
        $('#bt_autocomplete_footer').append( $('#auto-bt_tour_search_destination') );        
        
        $(document).keyup(function(e) {
           if (e.keyCode == 13) { 
              $( "#tour_search_form" ).on( "submit", function( event ) {
                    event.stopPropagation();
              });
              return false;
           }
        }); 
        
    });
})( jQuery );


