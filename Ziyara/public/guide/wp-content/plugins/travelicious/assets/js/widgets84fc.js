(function( $ ) {
    'use strict';      
    
    $( document ).ready(function() {
   
        //search tour widget other categories
        $('.btSearchCategoriesIncludeLinkViewOtherCategories a').on('click', function(event) {
            event.preventDefault();
            $(this).toggleClass('on');
            $('#btSearchCategoriesIncludeContentOtherCategories').toggle('fast');
            
            if ( $(this).hasClass('on') ){
                $(this).html(ajax_widgets_object.label_less_cats);
            }else{
                $(this).html(ajax_widgets_object.label_more_cats);
            }
        }); 
        
        //search destinations autocomplete and icon click in widget
        if ( $( '#bt_tour_search_destination_widget' ).length > 0 ) { 
            $('#bt_tour_search_destination_widget').autocomplete({                
                    open:function( event, ui ) { 
                        $('div#auto-bt_tour_search_destination_widget > ul.ui-autocomplete').addClass('bt_tour_search_destination_widget_open');
                    },
                    close:function( event, ui ) {
                        $('div#auto-bt_tour_search_destination_widget > ul.ui-autocomplete').removeClass('bt_tour_search_destination_widget_open');
                    },
                    source: function( request, response ) {  
                         $.getJSON( ajax_widgets_object.ajax_url + "?callback=?&action=bt_get_destinations_autocomplete_action", request, function( data ) {  
                             response( $.map( data, function( item ) {
                                 $.each( item, function( i, val ) {
                                     item.label = val; 
                                 } );
                                 return item;
                             } ) );
                         } ); 
                     },
                     appendTo: '#auto-bt_tour_search_destination_widget',
                     minLength: 0,
            });         

            $("div.btFieldDestinationWidget > div.btFieldWrapperWidget > span.bt_tour_search_destination_widget_span").on( 'click', function(event) {                     
                    event.preventDefault();
                    $('#bt_tour_search_destination_widget').val('');
                    if ( $("div#auto-bt_tour_search_destination_widget > ul.ui-autocomplete").is(":hidden") ) {
                        $("div#auto-bt_tour_search_destination_widget > ul.ui-autocomplete").show();
                        $('#bt_tour_search_destination_widget').keydown();
                    }else{
                        $("div#auto-bt_tour_search_destination_widget > ul.ui-autocomplete").hide();
                    }
            });
        }
         
         //search datepicker and icon click in widget
        if ( $( "#bt_tour_search_date_widget" ).length > 0 ) {
                $("div.btFieldDateWidget > div.btFieldWrapperWidget > span.bt_tour_search_date_widget_span").on( 'click', function(event) { 
                    event.preventDefault();
                    $("#ui-datepicker-div").addClass("ui-datepicker-div-widget");                
                    if ( $(".ui-datepicker-div-widget").is(":hidden") ) {
                        $("#bt_tour_search_date_widget").datepicker("show");
                    }else{
                        $("#bt_tour_search_date_widget").datepicker("hide");
                    }
                });
                bt_show_datepicker_widget(); 
        }
        
        function bt_show_datepicker_widget() {
            
            var show_only_months = 0;
            var label_current_month = '';
            var label_clear = '';
            var date_format = '';
            if ( typeof ajax_widgets_object != 'undefined' ){
                show_only_months        = ajax_widgets_object.show_only_months;
                label_current_month     = ajax_widgets_object.label_current_month;
                label_clear             = ajax_widgets_object.label_clear;
                date_format             = ajax_widgets_object.date_format;
            }
                    
            if ( show_only_months == 1 ){                            
                $( "#bt_tour_search_date_widget" ).datepicker({
                   minDate: new Date(),
                   showAnim: "fade",
                   currentText: label_current_month,
                   closeText: 'Select',
                   changeMonth: true,
                   changeYear: true,
                   changeDay: false,
                   dateFormat: date_format,
                   //dateFormat: 'yy-mm',
                   showButtonPanel: true,
                   beforeShow: function (input, datepicker) {
                       $(".ui-datepicker-div-widget").addClass("hide-calendar");
                       $(".ui-datepicker-div-widget").addClass('MonthDatePicker');
                       $('.ui-datepicker-div-widget').addClass('tour-datepicker-div-widget');
                       var datestr;var yearstr;var monthstr;                                
                       if ( (yearstr = $(this).val()).length > 0 && ( monthstr = $(this).val()).length > 0  ) {
                           var year    = yearstr.substr( 0, yearstr.length - 3 );
                           var month   = monthstr.substr( monthstr.length-2, 2 );
                           $(this).datepicker('option', 'defaultDate', new Date(year, month, 0));
                           $(this).datepicker('setDate', new Date(year, month, 0));
                       }

                       setTimeout(function() {
                           datepicker.dpDiv.find('.ui-datepicker-current')
                              .text(label_clear)
                              .click(function() {
                                   $(input)
                                       .datepicker('setDate', null)
                                       .datepicker('hide');
                                   $('#bt_tour_search_date_widget').val('');
                              });
                       }, 1);

                   },
                   onClose: function(dateText, inst) {                                
                       var month = $(".ui-datepicker-month :selected").val();
                       var year = $(".ui-datepicker-year :selected").val();
                       $(this).val($.datepicker.formatDate(date_format, new Date(year, month, 1)));
                   },
               });
           }else{
                $( "#bt_tour_search_date_widget" ).datepicker({
                   minDate: new Date(),
                   showAnim: "fade",
                   //dateFormat: 'yy-mm-dd',
                   dateFormat: date_format,
                   beforeShow: function (e, t) {
                       $('#ui-datepicker-div').addClass('tour-datepicker-div-widget');
                   },
               });
           }
       }

     });

})( jQuery );

