if(document.getElementById("accounts")){
    let accounts_table = new DataTable('#accounts_table',{
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
           search: "<button data-bs-toggle=\"modal\" data-bs-target=\"#add_account\" class=\"btn btn-sm btn-primary me-3\"><span class=\"fa fa-plus\"></span> Create Account</button> Search: "
        }
    });

    sole.get("../../controllers/administrator/get_accounts.php")
    .then(res => {
        res.user.forEach(e => {
            accounts_table.row.add([
                e["id"],
                e["name"],
                e["email"],
                e["username"],
                e["privileges"] == "Administrator" ? "<div class=\"text-primary\">"+e["privileges"]+"</div>" : e["privileges"] == "Head Technician" ? "<div class=\"text-success\">"+e["privileges"]+"</div>" : e["privileges"],
                e["id"] != localStorage.getItem("user_id") ? "<button id=\"edit_isp_"+ e["id"] +"\" i-id=\""+ e["id"] +"\" class=\"edit_isp_row btn btn-sm btn-secondary\"><i i-id=\""+ e["id"] +"\" class=\"edit_isp_row fa fa-edit\"></i></button>" +
                "<button id=\"delete_isp_"+ e["id"] +"\" i-id=\""+ e["id"] +"\" class=\"delete_isp_row btn btn-sm btn-danger ms-1\"><i i-id=\""+ e["id"] +"\" class=\"delete_isp_row fa fa-trash\"></i></button>" : ""
            ]).draw(false)   
        });
    })

    var add_account_btn = document.getElementById("add_account_btn")
    var add_name = document.getElementById("add_name")
    var add_email = document.getElementById("add_email")
    var add_username = document.getElementById("add_username")
    var add_password = document.getElementById("add_password")
    var add_privilege= document.getElementById("add_privilege")

    add_account_btn.addEventListener("click",function(){
        // sole.post
    })
}