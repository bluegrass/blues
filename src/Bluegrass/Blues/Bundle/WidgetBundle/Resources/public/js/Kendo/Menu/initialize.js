$(document).ready( function (){        
    
    $(".bluegrass_blues_widget_kendo_menu").bind( 'load', function (){
        
        $(".bluegrass_blues_widget_kendo_menu>ul").kendoMenu( 
            {  
                orientation: "vertical",  
                direction: "bottom"
            } 
        );
    });
    
    $(".bluegrass_blues_widget_kendo_menu").trigger( 'load' );
})