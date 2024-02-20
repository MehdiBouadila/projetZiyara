(function( $ ) {
    'use strict';
     
    //booking form date dropdown
     if ( $( ".tour_date_form" ).length > 0 ) {          
        var date = new Date();
        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var day = date.getDate();
		month = month < 10 ? '0' + month : month;
		day = day < 10 ? '0' + day : day;
        var defaultDate = year + '-' + month + '-' + day;
        $(".tour_date_form").dateDropdowns({
            required: true,
            defaultDate: defaultDate,
            minYear: year,
            maxYear: year + 10,
            monthFormat: 'short',
            daySuffixes: false,
            monthSuffixes: false,
            dayLabel: ( typeof travelicious_js_object != 'undefined' ) ? travelicious_js_object.label_day : day,
            monthLabel: ( typeof travelicious_js_object != 'undefined' ) ? travelicious_js_object.label_month : month,
            yearLabel: ( typeof travelicious_js_object != 'undefined' ) ? travelicious_js_object.label_year : year,
            monthShortValues: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
            initialDayMonthYearValues: [day, month, year],
        });
    }
        
    $( document ).ready(function() {
         
                // woocommerce pagination
                if ( $('.woocommerce-pagination li:first a').hasClass( "prev" ) ){
                    $('.woocommerce-pagination li:first').addClass('woo-first-page');
                }
                if ( $('.woocommerce-pagination li:last a').hasClass( "next" ) ){
                    $('.woocommerce-pagination li:last').addClass('woo-last-page');
                }
                
                //search destinations autocomplete and icon click
                if ( $( "#bt_tour_search_destination" ).length > 0 ) { 
                    $('#bt_tour_search_destination').autocomplete({
                            source: function( request, response ) {  
                                 $.getJSON( ajax_object.ajax_url + "?callback=?&action=bt_get_destinations_autocomplete_action", request, function( data ) {  
                                     response( $.map( data, function( item ) {
                                         $.each( item, function( i, val ) {
                                             item.label = val; 
                                         } );
                                         return item;
                                     } ) );
                                 } ); 
                             },
                             appendTo: '#auto-bt_tour_search_destination',
                             minLength: 0,
                    });         

                    $("div.btFieldDestination > div.btFieldWrapper > span.bt_tour_search_destination_span").on( 'click', function(event) { 
                            event.preventDefault();
                            
                            $('#bt_tour_search_destination').val('');
                            if ( $("div#auto-bt_tour_search_destination > ul.ui-autocomplete").is(":hidden") ) {
                                $("div#auto-bt_tour_search_destination > ul.ui-autocomplete").show();
                                $('#bt_tour_search_destination').keydown();
                            }else{
                                $("div#auto-bt_tour_search_destination > ul.ui-autocomplete").hide();
                            }
                    });
                }
                


                //search datepicker and icon click
                if ( $( "#bt_tour_search_date" ).length > 0 ) { 
                    $("div.btFieldDate > div.btFieldWrapper > span.bt_tour_search_date_span").on( 'click', function(event) { 
                        event.preventDefault();                       
                        if ( $("#ui-datepicker-div").is(":hidden") ) {
                            $("#bt_tour_search_date").datepicker("show");
                        }else{
                            $("#bt_tour_search_date").datepicker("hide");
                        }
                    });
                    bt_show_datepicker();
                }
            
                function bt_show_datepicker() { 
                    
                    var show_only_months = 0;
                    var label_current_month = '';
                    var label_clear = '';
                    var date_format = '';
                    if ( typeof travelicious_js_object != 'undefined' ){
                        show_only_months        = travelicious_js_object.show_only_months;
                        label_current_month     = travelicious_js_object.label_current_month;
                        label_clear             = travelicious_js_object.label_clear;
                        date_format             = travelicious_js_object.date_format;
                    }
                    if ( typeof travelicious_js_object_shortcode != 'undefined' ){
                        show_only_months        = travelicious_js_object_shortcode.show_only_months;
                        label_current_month     = travelicious_js_object_shortcode.label_current_month;
                        label_clear             = travelicious_js_object_shortcode.label_clear;
                        date_format             = travelicious_js_object_shortcode.date_format;
                    }
                   
                    if ( show_only_months == 1 ){
                         $( "#bt_tour_search_date" ).datepicker({
                            minDate: new Date(),
                            showAnim: "fade",
                            currentText: label_current_month,
                            closeText: 'Select',
                            changeMonth: true,
                            changeYear: true,
                            changeDay: false,
                            //dateFormat: date_format,
                            dateFormat: 'yy-mm',
                            showButtonPanel: true,
                            beforeShow: function (input, datepicker) {
                                $("#ui-datepicker-div").addClass("hide-calendar");
                                $("#ui-datepicker-div").addClass('MonthDatePicker');
                                $('#ui-datepicker-div').addClass('tour-datepicker-div');
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
                                       .on( 'click', function() {
                                            $(input)
                                                .datepicker('setDate', null)
                                                .datepicker('hide');
                                            $('#bt_tour_search_date').val('');
                                       });
                                }, 1);
         
                            },
                            onClose: function(dateText, inst) {                                
                                var month = $(".ui-datepicker-month :selected").val();
                                var year = $(".ui-datepicker-year :selected").val();
                                //$(this).val($.datepicker.formatDate(date_format, new Date(year, month, 1)));
                                //$(this).val(new Date(year, month, 1));
                                $(this).datepicker('setDate', new Date(year, month, 1));
                                
                            },
                        });
                    }else{
                         $( "#bt_tour_search_date" ).datepicker({
                            minDate: new Date(),
                            showAnim: "fade",
                            dateFormat: 'yy-mm-dd',
                            //dateFormat: date_format,
                            beforeShow: function (e, t) {
                                $('#ui-datepicker-div').addClass('tour-datepicker-div');
                            },
                        });
                    }
                }
    });
  
})( jQuery );

