$(document).ready( function (){        
    
    $(".bluegrass_blues_menu").bind( 'load', function (){
        
        $(".bluegrass_blues_menu>ul").kendoMenu( 
            {  
                orientation: "vertical",  
                direction: "bottom"
            } 
        );
    });
    
    $(".bluegrass_blues_menu").trigger( 'load' );
})