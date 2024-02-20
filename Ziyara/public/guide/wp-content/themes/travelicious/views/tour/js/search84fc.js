(function( $ ) {
    'use strict';      
    
    $( document ).ready(function() {        
 
        //fancyselect on search form sort select
        $('#bt_tour_search_sorting').fancySelect();

        /* search tours on enter button */
        $(document).keyup(function(e) {
           if (e.keyCode == 13) {
               var root    = $('.listing_results');
               root.data('paged', 1);
               if ( ajax_object.search_type == 'ajax' )
               {
                    var bt_tour_search_categories = [];
                    $("input[name='bt_tour_search_category[]']:checked").each(function() {
                        bt_tour_search_categories.push($(this).val()); 
                    });                
                    bt_get_listing_results( 
                        $('#bt_tour_search_list_view').val(),
                        ajax_object.search_limit,
                        ajax_object.search_orderby,
                        ajax_object.search_order,
                        $('#bt_tour_search_keyword').val(),
                        $('#bt_tour_search_destination').val(),
                        $('#bt_tour_search_date').val(),
                        $('#bt_tour_search_price_from').val(),
                        $('#bt_tour_search_price_to').val(),                        
                        bt_tour_search_categories,
                        $('#bt_tour_search_list_type').val(),
                        $('#bt_tour_search_list_gap').val(),
                        $('#bt_tour_search_list_columns').val(),
                        1,
                        ajax_object.posts_per_page,
                        false,
                        false,
                        $('#bt_tour_search_show_months').val(),
                        $('#bt_tour_search_date_format').val()
                    );
                    return false;
               }else{ 
                    $( "#tour_search_form" ).submit();
                    return false;
               }
           }
        });
        
        /* search tours on form submit button */
        $("#bt_bb_tour_search_submit").on( 'click', function() {
            var root    = $('.listing_results');
            root.data('paged', 1);
            if ( ajax_object.search_type == 'ajax' ){                     
                var bt_tour_search_categories = [];
                $("input[name='bt_tour_search_category[]']:checked").each(function() {
                    bt_tour_search_categories.push($(this).val()); 
                });                
                bt_get_listing_results( 
                    $('#bt_tour_search_list_view').val(),
                    ajax_object.search_limit,
                    $('#bt_tour_search_sorting').val(),
                    ajax_object.search_order,
                    $('#bt_tour_search_keyword').val(),
                    $('#bt_tour_search_destination').val(),
                    $('#bt_tour_search_date').val(),
                    $('#bt_tour_search_price_from').val(),
                    $('#bt_tour_search_price_to').val(),                        
                    bt_tour_search_categories,
                    $('#bt_tour_search_list_type').val(),
                    $('#bt_tour_search_list_gap').val(),
                    $('#bt_tour_search_list_columns').val(),
                    1,
                    ajax_object.posts_per_page,
                    false,
                    false,
                    $('#bt_tour_search_show_months').val(),
                    $('#bt_tour_search_date_format').val()
                );
                return false;
            }else{
                $( "#tour_search_form" ).submit();
                return false;
            }
        });  
        
        /* search tours by order */
	$('#bt_tour_search_sorting').fancySelect().on('change.fs', function () {
            var root    = $('.listing_results');
            root.data('paged', 1);
            if ( ajax_object.search_type == 'ajax' ){   
                var bt_tour_search_categories = [];
                $("input[name='bt_tour_search_category[]']:checked").each(function() {
                    bt_tour_search_categories.push($(this).val()); 
                }); 
                
                bt_get_listing_results( 
                    $('#bt_tour_search_list_view').val(),
                    ajax_object.search_limit,
                    $( this ).val(),
                    ajax_object.search_order,
                    $('#bt_tour_search_keyword').val(),
                    $('#bt_tour_search_destination').val(),
                    $('#bt_tour_search_date').val(),
                    $('#bt_tour_search_price_from').val(),
                    $('#bt_tour_search_price_to').val(),                        
                    bt_tour_search_categories,
                    $('#bt_tour_search_list_type').val(),
                    $('#bt_tour_search_list_gap').val(),
                    $('#bt_tour_search_list_columns').val(),
                    1,
                    ajax_object.posts_per_page,
                    false,
                    false,
                    $('#bt_tour_search_show_months').val(),
                    $('#bt_tour_search_date_format').val()
                );
            }
	});
        
        $(document).on('click', '.bt_bb_loadmore', function(event) {
                event.preventDefault();
                
                var root    = $('.listing_results');
                var button  = $('.bt_bb_loadmore');
                $( this ).hide();
                //  current page
                var maxpage     = button.data('maxpage');
                var offset      = root.data('paged') + 1;
                root.data('paged', offset);
                
                var show_loadmore = offset == maxpage ? false : true;
                
                var bt_tour_search_categories = [];
                $("input[name='bt_tour_search_category[]']:checked").each(function() {
                    bt_tour_search_categories.push($(this).val()); 
                });  
                        
		bt_get_listing_results(
                    $('#bt_tour_search_list_view').val(),
                    ajax_object.search_limit,
                    $('#bt_tour_search_sorting').val(),
                    ajax_object.search_order,
                    $('#bt_tour_search_keyword').val(),
                    $('#bt_tour_search_destination').val(),
                    $('#bt_tour_search_date').val(),
                    $('#bt_tour_search_price_from').val(),
                    $('#bt_tour_search_price_to').val(),                        
                    bt_tour_search_categories,
                    $('#bt_tour_search_list_type').val(),
                    $('#bt_tour_search_list_gap').val(),
                    $('#bt_tour_search_list_columns').val(),
                    offset,
                    ajax_object.posts_per_page,
                    true,
                    show_loadmore,
                    $('#bt_tour_search_show_months').val(),
                    $('#bt_tour_search_date_format').val()
                 );
         
                if ( offset > maxpage  ){
                     offset = maxpage;
                     button.hide(); 
                     return false;
                }
	});
        
        $( window ).load(function() {
            bt_load_images();
            
            $( window ).on( 'scroll', function() {
               bt_load_images();
            });  
        });
        
        $(document).ajaxStart(function () {
            $('#bt_listing_loading').show();
        });
        
        $(document).ajaxStop(function () {
             bt_load_images();
             $('#bt_listing_loading').hide();
        });
                
    });
    
    function bt_get_listing_results(
                listing_view,
                search_limit,
                search_orderby,
                search_order,
                search_keyword,
                search_destination,
                search_start_date,
                search_price_from,
                search_price_to,
                search_categories,
                search_list_type,
                search_list_gap,
                search_list_columns,
                paged,
                posts_per_page,
                loadmore,
                show_loadmore,
                search_show_months,
                search_date_format
        ) { 
    
                
        var button  = $('.bt_bb_loadmore');
                
        if ( $('#bt_bb_tour_list_container').length > 0 ){
                var data= {
                        'action':                           'bt_get_tour_search_action',
                        'listing_view':                     listing_view,
                        'bt_tour_search_list_count':        search_limit,
                        'bt_tour_search_sorting':           search_orderby,
                        'search_order':                     search_order,
                        'bt_tour_search_keyword':           search_keyword,
                        'bt_tour_search_destination':       search_destination,
                        'bt_tour_search_date':              search_start_date,
                        'bt_tour_search_price_from':        search_price_from,
                        'bt_tour_search_price_to':          search_price_to,
                        'bt_tour_search_category':          search_categories,
                        'tour_single_design':               search_list_type,
                        'tour_similar_tours_list_gap':      search_list_gap,
                        'tour_similar_tours_list_columns':  search_list_columns,
                        'paged':                            paged,
                        'posts_per_page':                   posts_per_page,
                        'bt_tour_search_show_months':       search_show_months,
                        'bt_tour_search_date_format':       search_date_format,
                };
                
                $.ajax({
                        type: 'GET',
                        url: ajax_object.ajax_url,
                        data: data,
                        async: true,
                        beforeSend : function ( xhr ) {
                            if ( show_loadmore == false ) {
                                button.html('<span>Loading tours</span>')
                            }else{
                                $('.bt_bb_loadmore_box').remove();
                            }
                        },
                        success: function( response ) {	                           
                            if ( response)
                            { 
                                if( loadmore ){
                                    $('#bt_bb_tour_list_container').append( response );
                                    if ( show_loadmore == false ) {
                                        $('.bt_bb_loadmore_box').remove();
                                    }
                                }else{
                                    $('#bt_bb_tour_list_container').html( response );
                                }
                            }
                        },
                        error: function( xhr, status, error ) {
                                console.log('error is: ' +  status + ' ' + error);
                        }
                });
                
                /* change url if it is ajax loading*/                
                if ( ajax_object.search_type == 'ajax' ) {
                    var data_form = $('#tour_search_form').serializeArray();
                    var currentURL = window.location.href.split('?')[0];
                    var queryURL = "?page=1";
                    data_form.forEach(function(entry) {
                         if ( entry['value'] ){
                             queryURL += "&" + entry['name'] + "=" + entry['value'];
                         }
                    });
                    var url = currentURL + queryURL;
                    history.pushState(undefined, '', url);
                }
            }
            
        return false; 
    }
    
    function bt_load_images() {
        jQuery( 'img[data-loaded="0"]' ).each(function() {
            var $image = jQuery( this );
            if ( inViewport( $image ) ) {
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

    function inViewport(ele) {
        var lBound = jQuery(window).scrollTop(),
            uBound = lBound + jQuery(window).height(),
            top = ele.offset().top,
            bottom = top + ele.outerHeight(true);

        return (top > lBound && top < uBound)
            || (bottom > lBound && bottom < uBound)
            || (lBound >= top && lBound <= bottom)
            || (uBound >= top && uBound <= bottom);
    }
    
    function getElementsByTagAndName(tag, name) {
        var elem = document.getElementsByTagName(tag);  
        var arr = new Array();
        var i = 0;
        var iarr = 0;
        var att;
        for(; i < elem.length; i++) {
            att = elem[i].getAttribute("name");
            if(att == name) {
                arr[iarr] = elem[i];
                iarr++;
            }
        }
        return arr;
    }
})( jQuery );


