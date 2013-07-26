$(document).ready( function (){        
    
    $('.bluegrass_blues_widget_kendo_grid').each(function() {
        
        $(this).kendoGrid({
            dataSource: {
                data: $(this).data( 'datasource' ).data,
                pageSize: $(this).data( 'pagesize' )                
            },
            columns: $(this).data( 'columns' ),
            sortable: {
                mode: "multiple",
                allowUnsort: true
            },
            reorderable: true,
            pageable: {
                refresh: true,
                input: true
            }
        });    
    });
})