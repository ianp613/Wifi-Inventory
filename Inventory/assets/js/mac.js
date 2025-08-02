if(document.getElementById("mac")){
    let ipTable = new DataTable('#mac_table',{
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
           sLengthMenu: "Show _MENU_entries <button class=\"btn btn-sm btn-danger\"><span class=\"fa fa-plus\"></span> Add Entry</button>",
           search: "<button id=\"ip_import\" style=\"margin-right: 10px; padding-left: 10px;\" class=\"btn btn-sm btn-secondary rounded-pill position-relative\"><span class=\" fa fa-upload\"></span> Import</button><button id=\"ip_export\" style=\"margin-right: 10px; padding-left: 10px;\" class=\"btn btn-sm btn-secondary rounded-pill position-relative\"><span class=\" fa fa-download\"></span> Export</button>   Search: "
        }
    });

    const add_wifi = new bootstrap.Modal(document.getElementById('add_wifi'),unclose);

    var add_wifi_btn = document.getElementById("add_wifi_btn")
    var wifi_name = document.getElementById("wifi_name")
    var wifi_password = document.getElementById("wifi_password")

    add_wifi_btn.addEventListener("click",function(){
        
    })
}