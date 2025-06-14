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
                className: 'dt-left f-13', 
                targets: '_all' 
            },
            { 
                className: 'dt-right', 
                target: '2' 
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
    
    var select_log = document.getElementById("select_log")

    loadLogs()
    localStorage.getItem("privileges") ? loadUsers() : null;
    
    function loadLogs(){
        sole.get("../../controllers/logs/get_log.php")
        .then(res => {
            logTable.clear().draw();
            res.logs.forEach(e => {
                logTable.row.add([
                    e["id"],
                    e["log"],
                    e["created_at"],
                    localStorage.getItem("privileges") == "Administrator" ? "<button id=\"delete_log_"+ e["id"] +"\" r-id=\""+ e["id"] +"\" class=\"delete_log_row btn btn-sm btn-danger ms-1\"><i r-id=\""+ e["id"] +"\" class=\"delete_log_row fa fa-trash\"></i></button>" : ""
                ]).draw(false)   
            });
        })
    }

    function loadUsers(){
        sole.get("../../controllers/logs/get_users.php")
        .then(res => {
            res.forEach(e => {
                var op = document.createElement("option")
                op.value = e["id"]
                op.innerText = e["id"] == localStorage.getItem("userid") ? "Your logs" : e["name"]
                e["id"] == localStorage.getItem("userid") ? select_log.appendChild(op) : null
            });
            res.forEach(e => {
                var op = document.createElement("option")
                op.value = e["id"]
                op.innerText = e["id"] == localStorage.getItem("userid") ? "Your logs" : e["name"]
                e["id"] != localStorage.getItem("userid") ? select_log.appendChild(op) : null
            });
        })
    }
}









// NEED CHECK ID if LOG DIV EXIST TO USE