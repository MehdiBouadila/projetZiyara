(function( $ ) {
    'use strict';      
    
    $( document ).ready(function() {
       
        if ( window.location.hash.substr(0,9) == '#book-now' ) {    
            bt_show_popup_form('all');   
        }
        
        // Show more reviews button in listing single comments
        $( 'body' ).on( 'click', '#tour_single_comment_show_more_reviews', function(e) {
                $( 'body' ).addClass( 'btCommentsExpanded' );
                return false;
        });
        
        $('.btDiscoverDestinationLink').on('click', function(event) {
            event.preventDefault();
            var link = $(event.target).data('link');
            if ( link == '' ) {
                $( '.bt_bb_tabs_header li').removeClass('on');
                $( '#btTourLocationTab' ).addClass('on');
                $( '.bt_bb_tabs_tabs div').removeClass('on');
                $( '.btTourLocationTab' ).addClass('on');
            }else{
                location.href = link;
            }
        }); 
        
        //tour plan days scrolling
        $('#btTourPlanPaging').on('click', function(event) {
            event.preventDefault();            
            $('#btTourPlanPaging li').removeClass('on');
            $(event.target).addClass('on');    
            
            var header_height = $( ".mainHeader" ).height(); 
            var href    = $(event.target).data('href');            
            $('html, body').stop().animate({
                scrollTop: $(href).offset().top - header_height
            }, 500);  
            return false;
        });
        
        if ( $("#btTourPlanPaging").length > 0 ) {
            $("#btTourPlanPaging li").tooltip();
        }
        
        //tour other start days
        $('.btTourSingleIncludeLinkViewOtherTime a').on('click', function(event) {
            event.preventDefault();
            $('#btTourSingleIncludeContentOtherTimes').toggle('fast');
        }); 
 
        //tour days pagination scrolling
       $(window).scroll(function(e) { 
           
            if ( $(".btTourPlan").length > 0 && $("#btTourPlanTab").hasClass('on') ) {
                var scroller_anchor = $(".btTourPlan").offset().top - 100;
                var header_height   = $( ".mainHeader" ).height() + 50;
                
                if ( $(this).scrollTop() >= scroller_anchor && $('.btTourPlanPaging').css('position') != 'fixed' ) 
                {
                    
                    $('.btTourPlanPaging').addClass('btTourPlanPagingFixed');
                    $('.btTourPlanPaging').css({
                        'top': header_height,
                    });  
                } 
                else if ( $(this).scrollTop() < scroller_anchor && $('.btTourPlanPaging').css('position') != 'relative') 
                { 
                    $('.btTourPlanPaging').removeClass('btTourPlanPagingFixed');
                    $('.btTourPlanPaging').css({
                            'top': '.5em',
                    });
                }
                
                var scroller_anchor_bottom = $(".btTourPlan").offset().top + $(".btTourPlan").outerHeight(true);
                if ( $(this).scrollTop() >= scroller_anchor_bottom ){
                    $('.btTourPlanPaging').removeClass('btTourPlanPagingFixed');
                    $('.btTourPlanPaging').css({
                            'top': '.5em',
                    });
                    $('#btTourPlanPaging li').removeClass('on');
                    $('#btTourPlanPaging li:last').addClass('on');    
                }
            }
        });
                
    });

})( jQuery );

