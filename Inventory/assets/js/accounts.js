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
           search: "Search: "
        }
    });

    sole.get("../../controllers/administrator/get_accounts.php").then(res => loadAccounts(res))

    const edit_account_modal = new bootstrap.Modal(document.getElementById('edit_account'),unclose);
    const delete_account_modal = new bootstrap.Modal(document.getElementById('delete_account'),unclose);
    const add_group_modal = new bootstrap.Modal(document.getElementById('add_group'),unclose);

    var add_group = document.getElementById("add_group")
    var group_name = document.getElementById("group_name")
    var group_supervisor = document.getElementById("group_supervisor")
    var group_user = document.getElementById("group_user")

    var add_account = document.getElementById("add_account")
    var add_account_btn = document.getElementById("add_account_btn")
    var add_name = document.getElementById("add_name")
    var add_email = document.getElementById("add_email")
    var add_username = document.getElementById("add_username")
    var add_password = document.getElementById("add_password")
    var add_privilege = document.getElementById("add_privilege")

    var edit_account = document.getElementById("edit_account")
    var edit_account_btn = document.getElementById("edit_account_btn")
    var edit_account_name = document.getElementById("edit_account_name")
    var edit_email = document.getElementById("edit_email")
    var edit_username = document.getElementById("edit_username")
    var edit_password = document.getElementById("edit_password")
    var edit_privilege = document.getElementById("edit_privilege")
    var edit_account_title = document.getElementById("edit_account_title")

    var delete_account_btn = document.getElementById("delete_account_btn")
    var delete_account_name = document.getElementById("delete_account_name")

    add_group.addEventListener('shown.bs.modal', function () {
        sole.get("../../controllers/administrator/get_accounts_dropdown.php")
        .then(res => {
            group_supervisor.innerHTML = "<option value=\"\" selected disabled>Select User</option>"

            res["supervisor"].forEach(su => {
                var op = document.createElement("option")
                op.value = su["username"] + " - " + su["name"]
                op.innerText = su["username"] + " - " + su["name"]
                group_supervisor.appendChild(op)
            });

            group_user.innerHTML = "<option value=\"\" selected disabled>Select User</option>"

            res["user"].forEach(us => {
                var op = document.createElement("option")
                op.value = us["username"] + " - " + us["name"]
                op.innerText = us["username"] + " - " + us["name"]
                group_user.appendChild(op)
            });
        })
        group_name.focus()
    })

    group_supervisor.addEventListener("change",function(){
        console.log(this.value)
        this.value = ""
    })

    group_user.addEventListener("change",function(){
        console.log(this.value)
        this.value = ""
    })

    add_account.addEventListener('shown.bs.modal', function () {
        add_name.focus()
    })

    add_account_btn.addEventListener("click",function(){
        var message = "";
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        !add_username.value ? message = "Please input user ID." : null
        !add_name.value ? message = "Please input name." : null

        if(add_email.value){
            var bol = regex.test(add_email.value)
            if(!bol){
                message = "Please input a valid email."
            }
        }
        if(!message){
            sole.post("../../controllers/administrator/create_account.php",{
                name: add_name.value,
                email: add_email.value,
                username: add_username.value,
                password: add_password.value,
                privilege: add_privilege.value
            })
            .then(res => validateResponse(res,"create_account"))    
        }else{
            bs5.toast("warning",message)    
        }
    })

    edit_account.addEventListener('shown.bs.modal', function () {
        edit_account_name.focus()
    })

    edit_account_btn.addEventListener("click",function(){
        var message = "";
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        !edit_account_name.value ? message = "Please input name." : null
        !edit_username.value ? message = "Please input user ID." : null
        !edit_password.value ? alert("Password field is empty, it will be set to default password \"12345\".") : null

        if(edit_email.value){
            var bol = regex.test(edit_email.value)
            if(!bol){
                message = "Please input a valid email."
            }
        }
        
        if(!message){
            sole.post("../../controllers/administrator/edit_account.php",{
                id: this.getAttribute("u-id"),
                name: edit_account_name.value,
                email: edit_email.value,
                username: edit_username.value,
                password: edit_password.value,
                privilege: edit_privilege.value
            }).then(res => validateResponse(res,"edit_account"))    
        }else{
            bs5.toast("warning",message);
        }
        
    })

    delete_account_btn.addEventListener("click",function(){
        sole.post("../../controllers/administrator/delete_account.php",{
            id: this.getAttribute("u-id")
        }).then(res => validateResponse(res,"delete_account"))
    })

    function loadAccounts(res){
        accounts_table.clear().draw();
        res.user.forEach(e => {
            accounts_table.row.add([
                e["id"],
                e["name"],
                e["email"] != "-" ? e["email"] : "",
                e["username"],
                e["privileges"] == "Administrator" ? "<div class=\"text-primary\">"+e["privileges"]+"</div>" : e["privileges"] == "Senior Technician" ? "<div class=\"text-success\">"+e["privileges"]+"</div>" : e["privileges"],
                e["id"] != localStorage.getItem("userid") ? "<button id=\"edit_account_"+ e["id"] +"\" u-id=\""+ e["id"] +"\" class=\"edit_account_row btn btn-sm btn-secondary\"><i u-id=\""+ e["id"] +"\" class=\"edit_account_row fa fa-edit\"></i></button>" +
                "<button id=\"delete_account_"+ e["id"] +"\" u-id=\""+ e["id"] +"\" class=\"delete_account_row btn btn-sm btn-danger ms-1\"><i u-id=\""+ e["id"] +"\" class=\"delete_account_row fa fa-trash\"></i></button>" : ""
            ]).draw(false)   
        });
        document.querySelector('#accounts_table').addEventListener("click", e=>{
            let tr = "";
            if(e.target.tagName == "I"){
                tr = e.target.parentNode.parentNode.parentNode.children
            }
            if(e.target.tagName == "BUTTON"){
                tr = e.target.parentNode.parentNode.children    
            }
            if(e.target.classList.contains('edit_account_row')) {
                edit_account_title.innerHTML = "<span class=\"fa fa-user\"></span> Edit Account: " + tr[0].innerText
                edit_account_btn.setAttribute("u-id",e.target.getAttribute("u-id"))
                sole.post("../../controllers/administrator/find_account.php",{
                    id: e.target.getAttribute("u-id")
                }).then(res => {
                    edit_account_name.value = res.user[0].name
                    edit_email.value = res.user[0].email != "-" ? res.user[0].email : ""
                    edit_username.value = res.user[0].username
                    edit_password.value = res.user[0].password
                    edit_privilege.value = res.user[0].privileges
                    edit_account_modal.show()
                })
            }
            if(e.target.classList.contains('delete_account_row')) {
                delete_account_name.innerText = tr[0].innerText
                delete_account_btn.setAttribute("u-id",e.target.getAttribute("u-id"))
                delete_account_modal.show()
            }
        })
    }

    function validateResponse(res,func){
        if(res.status){
            if(func == "create_account"){
                add_name.value = ""
                add_email.value = ""
                add_username.value = ""
                sole.get("../../controllers/administrator/get_accounts.php").then(res => loadAccounts(res))
            }
            if(func == "edit_account"){
                edit_account_modal.hide()
                sole.get("../../controllers/administrator/get_accounts.php").then(res => loadAccounts(res))
            }
            if(func == "delete_account"){
                delete_account_modal.hide()
                sole.get("../../controllers/administrator/get_accounts.php").then(res => loadAccounts(res))
            }
            bs5.toast(res.type,res.message,res.size)
        }else{
            bs5.toast(res.type,res.message,res.size)
        }
    }
}