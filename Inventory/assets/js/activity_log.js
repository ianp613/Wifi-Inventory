var activity_log = document.getElementById("activity_log");

activity_log.addEventListener("click",function(){
    window.location.href = "inventory.php?loc=logs"
})

if(document.getElementById("logs")){
    let logTable = new DataTable('#log_table',{
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
            search: "Search: "
        },
        searching: true,
        paging: false,
        info: false,
        emptyTable: false
    });    
}









// NEED CHECK ID if LOG DIV EXIST TO USE