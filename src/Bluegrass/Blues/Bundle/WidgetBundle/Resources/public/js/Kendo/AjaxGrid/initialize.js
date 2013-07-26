$(document).ready( function (){        
    
    $('.bluegrass_blues_widget_kendo_ajaxgrid').each(function() {
        
        $(this).kendoGrid({
            dataSource: {
                pageSize: $(this).data( 'pagesize' ),
                serverPaging: true,
                serverSorting: true,
                transport: {
                    read: {
                        url: $(this).data( 'dataajaxrequesturl' ),
                        dataType: "json"
                    }
                },
                schema: {
                    data: "data",
                    total: "total"
                }
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