$(document).ready( function (){        
    
    $(".bluegrass_blues_widget_html_filterablemenu input").keyup( function( e ){

        var input = $(this);
        
        if(e.keyCode === 27) { // ESC KEY
            input.val('');        
        }
        
        bluegrass_blues_filterablemenu_pattern_filter_value = input.val();

        if ( $.trim( bluegrass_blues_filterablemenu_pattern_filter_value ) == '' ){
            bluegrass_blues_filterablemenu_load_url = input.parent(".bluegrass_blues_widget_html_filterablemenu").attr('data-filterablemenu-default-url');  
        }else{
            bluegrass_blues_filterablemenu_load_url = input.parent(".bluegrass_blues_widget_html_filterablemenu").attr('data-filterablemenu-pattern-filter-url').replace("__PLACEHOLDER__",bluegrass_blues_filterablemenu_pattern_filter_value);              
        }        
        
        $.ajax({
          url: bluegrass_blues_filterablemenu_load_url         
        }).done(function ( data ) {
            
            $( ".bluegrass_blues_widget_html_menu" , input.parent(".bluegrass_blues_widget_html_filterablemenu") ).html( $( data ).html() );            
            $( ".bluegrass_blues_widget_html_menu" , input.parent(".bluegrass_blues_widget_html_filterablemenu") ).trigger( 'load' );
        });        

    });    
})

