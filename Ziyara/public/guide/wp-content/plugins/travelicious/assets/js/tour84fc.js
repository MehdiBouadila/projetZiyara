(function( $ ) {
     'use strict'; 
     
     $( document ).ready(function() { 
           
            bt_load_tour_images(); 
            
            $( window ).on( 'scroll', function() {
                    bt_load_tour_images();
            });
            
            $('#btTourSimilarToursTab').on('click', function(event) {
                event.preventDefault();
                bt_load_tour_images();
            }); 
            
            // after comments submit    
            if ( window.location.hash.substr(0,8) == '#comment' ) {                
                if ( $('.bt_bb_tabs_header').length > 0 ){
                        $( '.bt_bb_tabs_header li').removeClass('on');
                        $( '.bt_bb_tabs_tabs div').removeClass('on');
                        $( '.btTourReviewsTab' ).addClass('on');
                        window.location.href = window.location.hash;
                }
            }
            
            //forms
            $('.btTourBookBottom a').on('click', function(event) {
                var address = $(this).attr("href");
                if ( address == '#' ) {
                    event.preventDefault();
                    event.stopPropagation();
                    bt_show_popup_form('all');  
                    $('body').addClass('bt-form-popup-on');
                }
            }); 
            
            $('.btTourBook a').on('click', function(event) {
                var address = $(this).attr("href");
                if ( address == '#' ) {
                    event.preventDefault();
                    event.stopPropagation();
                    bt_show_popup_form('all');
                    $('body').addClass('bt-form-popup-on');
                }
            }); 
            
            $('.bt-forms-container-toggle').on("click",function(){            
                var href = $(this).attr('href');
                if (typeof href  !== "undefined"){                
                    $( '.bt-form-booking-container' ).hide();
                    $( '.bt-form-enquiry-container' ).hide(); 
                    $('.bt-forms-container-toggle').removeClass('bt-tab-on');
                    $(this).addClass('bt-tab-on');
                    $(href).fadeIn('fast');
                }
            }); 
            
            $( document ).on( 'click', '.bt-forms-container-modal-overlay, .bt-forms-container-modal-close a', function( e ){
                e.preventDefault();
                e.stopPropagation();
                bt_login_styler_esc();
                $('body').removeClass('bt-form-popup-on');
             });

    });
    
    $( window ).load(function() { 
         bt_load_tour_images();
         
         $( window ).on( 'scroll', function() {
            bt_load_tour_images();
         });
         
         if ( $( '.bt-video-container' ).length > 0 ) {
            $( '.mejs-overlay-play' ).show();
         }
    });


        
})( jQuery );

function bt_load_tour_images() {   
     jQuery( 'img[data-loaded="0"]' ).each(function() {
         var $image = jQuery( this );
         if ( inViewportTour( $image ) ) {
             var img_src     = $image.data( 'src' );
             var img_loaded  = $image.data( 'loaded' );

             var downloadingImage = new Image();
             downloadingImage.onload = function () {
                     $image.attr('src',img_src);
                     $image.data('loaded','1');
                     $image.addClass( 'bt_src_loaded' );      
             };
             downloadingImage.src = $image.data( 'src' );
             $image.addClass( 'bt_src_loading' );
         }
     });
 }

 function inViewportTour(ele) {
     var lBound = jQuery(window).scrollTop(),
         uBound = lBound + jQuery(window).height(),
         top = ele.offset().top,
         bottom = top + ele.outerHeight(true);

     return (top > lBound && top < uBound)
         || (bottom > lBound && bottom < uBound)
         || (lBound >= top && lBound <= bottom)
         || (uBound >= top && uBound <= bottom);
 }
 
 function bt_show_popup_form(type) {
     jQuery( '#bt-forms-container-modal').addClass('bt-forms-container-modal-on');
     jQuery( '#bt-forms-container-modal-overlay').addClass('bt-forms-container-modal-overlay-on');
     
     if ( jQuery( '#bt-form-booking-container' ).length > 0  ){
        jQuery( '#bt-form-booking-container' ).show();
     }else{
         if ( jQuery( '#bt-form-enquiry-container' ).length > 0  ){
            jQuery( '#bt-form-enquiry-container' ).show();
         }
     }

 }
 
 function bt_login_styler_esc(){
     jQuery( '#bt-forms-container-modal').removeClass('bt-forms-container-modal-on');
     jQuery( '#bt-forms-container-modal-overlay').removeClass('bt-forms-container-modal-overlay-on');
     
     jQuery( '.bt-form-booking-container' ).hide();
     jQuery( '.bt-form-enquiry-container' ).hide(); 
     jQuery( '.bt-forms-container-toggle').removeClass('bt-tab-on');
     jQuery( '.bt-forms-container-toggle-booking-container' ).addClass('bt-tab-on');
    
}

