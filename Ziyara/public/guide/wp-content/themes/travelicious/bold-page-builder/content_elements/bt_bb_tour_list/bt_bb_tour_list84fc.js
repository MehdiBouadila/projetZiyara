(function( $ ) {
    
    'use strict';   

    var bt_bb_tour_list_grid_load_items = function( root ) {               
		root.each(function() {
			var loading = root.data( 'loading' );
			if ( loading === undefined || ( loading != 'loading' && loading != 'no_more' ) ) {
				var page_bottom = $( window ).scrollTop() + $( window ).height();
				$( this ).find( '.bt_bb_grid_item' ).each(function() {
					var this_top = $( this ).offset().top;                                        
					if ( this_top < page_bottom + $( window ).height() ) {
						if ( $( this ).is( ':last-child' ) ) {
							var root_data_offset = root.data( 'offset' );
							var offset = parseInt( root_data_offset === undefined ? 0 : root_data_offset ) + parseInt( root.data( 'number-posts' ) );
							bt_bb_tour_list_load_posts( root, offset );                                                        
							return false;
						}
					}
				});
			}
		});
	}
        
	var bt_bb_tour_list_load_posts = function( root, offset ) {  
	   bt_tour_tiles_resize();
	   root.masonry({
				columnWidth: '.bt_bb_grid_sizer',
				itemSelector: '.bt_bb_grid_item',
				gutter: 0,
				percentPosition: true
		});
		root.removeClass( 'bt_bb_grid_hide' );
		$( '.bt_bb_grid_container' ).css( 'height', 'auto' );            
	}
        
        var bt_tour_tiles_resize = function() { 
            $( '.bt_bb_masonry_tour_list_content .bt_bb_grid_item .bt_bb_grid_item_inner' ).each( function() {
                    $( this ).css( 'height', '' );
                    var h = Math.ceil( $( this ).width() * $( this ).data( 'hw' ) );
                    $( this ).css( 'height', h );
            });
            $( '.bt_bb_masonry_tour_list_content .bt_bb_grid_item .bt_bb_grid_item_inner  .bt_bb_grid_item_inner_image' ).each( function() {
                    $( this ).css( 'height', '' );
                    var h = Math.ceil( $( this ).width() * $( this ).data( 'hw' ) );
                    $( this ).css( 'height', h );
            });	
            
            $( '.bt_bb_masonry_tour_list_content' ).each( function() {
                    $( this ).width( 'initial' );
                    var child_left_margin = parseInt( $( this ).find( '.bt_bb_masonry_post_image_content' ).css( 'margin-left' ) );
                    var base_item_width =  ( $( this ).width() - child_left_margin ) / ( $( this ).data( 'columns' ) ) ;
                    if ( Math.ceil( base_item_width ) != base_item_width ) {
                            $( this ).width( $( this ).data( 'columns' ) * Math.ceil( base_item_width ) + child_left_margin );
                    } 				
            });
        }
		
		var linkRewriter = function(a, b) {
			$('a[href*="' + a + '"]').each(function() {
				$(this).attr('href', $(this).attr('href').replace(a, b));
			});
		};

	$( document ).ready(function() {
		$( window ).on( 'scroll', function() {
				var grid_content = $( '.bt_bb_masonry_tour_list_content' );                        
				bt_load_tour_images();
				bt_bb_tour_list_grid_load_items( grid_content );
		});
                
        $( '.bt_bb_masonry_tour_list_content' ).each(function() {
			var grid_content = $( this );
            bt_bb_tour_list_load_posts( grid_content, 0 );                       
		});
                
         var grid_content = $( this ).closest( '.bt_bb_masonry_post_tiles' ).find( '.bt_bb_masonry_tour_list_content' );
		 
		 //linkRewriter('http://travelicious.omnicom-dev.com/', 'https://touring.mytravelxp.com/');
                
	});


	//$( window ).ready(function() {
		window.bt_bb_tour_list_resize = function() {
			$( '.bt_bb_masonry_tour_list_content .bt_bb_grid_item .bt_bb_grid_item_inner' ).each( function() {
				$( this ).css( 'height', '' );
				var h = Math.ceil( $( this ).width() * $( this ).data( 'hw' ) );
				$( this ).css( 'height', h );
			});
			$( '.bt_bb_masonry_tour_list_content .bt_bb_grid_item .bt_bb_grid_item_inner  .bt_bb_grid_item_inner_image' ).each( function() {
				$( this ).css( 'height', '' );
				var h = Math.ceil( $( this ).width() * $( this ).data( 'hw' ) );
				$( this ).css( 'height', h );
			});	
			
            $( '.bt_bb_masonry_tour_list_content' ).each( function() {
				$( this ).width( 'initial' );
				var child_left_margin = parseInt( $( this ).find( '.bt_bb_masonry_post_image_content' ).css( 'margin-left' ) );
				var base_item_width =  ( $( this ).width() - child_left_margin ) / ( $( this ).data( 'columns' ) ) ;
				if ( Math.ceil( base_item_width ) != base_item_width ) {
					$( this ).width( $( this ).data( 'columns' ) * Math.ceil( base_item_width ) + child_left_margin );
				} 				
			});
		}		
	//});


	$( window ).load(function() { 
        bt_bb_tour_list_resize();	
                
		$( '.bt_bb_masonry_post_image_content' ).masonry({
			columnWidth: '.bt_bb_grid_sizer',
			itemSelector: '.bt_bb_grid_item',
			gutter: 0,
			percentPosition: true
		});
                
		$( window ).on( 'resize', function() {
			bt_bb_tour_list_resize();
		});		
		setTimeout(function() {
			$( '.bt_bb_masonry_post_image_content' ).masonry( 'layout' );
		}, 10 );
                
		$(document).ajaxStop(function () {
			bt_load_tour_images();
	   });
	});

})( jQuery );