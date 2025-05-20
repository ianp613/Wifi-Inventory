if(document.getElementById("routers")){
    let routerTable = new DataTable('#router_table',{
        order: [[5, 'asc']],
        rowCallback: function(row) {
            $(row).addClass("trow");
        },
        columnDefs: [
            {
                target: 0,
                visible: false,
                searchable: false
            },
            { 
                className: 'dt-left', 
                targets: '_all' 
            }
        ],
        autoWidth: false,
        language: {
           sLengthMenu: "Show _MENU_entries",
           search: "<button data-bs-toggle=\"modal\" data-bs-target=\"#add_router\" class=\"btn btn-sm btn-danger me-3\"><span class=\"fa fa-plus\"></span> Add Router</button> Search: "
        }
    });

    let routerISPTable = new DataTable('#router_isp_table',{
        order: [[5, 'asc']],
        rowCallback: function(row) {
            $(row).addClass("trow");
        },
        columnDefs: [
            { 
                className: 'dt-left', 
                targets: '_all' 
            }
        ],
        autoWidth: false,
        language: {
           sLengthMenu: "Show _MENU_entries",
           search: "Search: ",
           emptyTable: 'Not yet set'
        },
        searching: false,
        paging: false,
        info: false
    });
}