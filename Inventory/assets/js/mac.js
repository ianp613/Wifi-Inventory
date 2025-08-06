if(document.getElementById("mac")){
    let macTable = new DataTable('#wifi_table',{
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

    loadPage();
    // LOAD PAGE DATA
    function loadPage(){
        sole.get("../../controllers/mac/get_wifi.php").then(res => loadWifi(res))
        if(localStorage.getItem("selected_wifi")){
            sole.post("../../controllers/mac/get_mac.php", {
                wid: localStorage.getItem("selected_wifi_id")
            }).then(res => loadMAC(res))
        }
    }

    const add_wifi_modal = new bootstrap.Modal(document.getElementById('add_wifi'),unclose);
    const edit_wifi_modal = new bootstrap.Modal(document.getElementById('edit_wifi'),unclose);
    const delete_wifi_modal = new bootstrap.Modal(document.getElementById('delete_wifi'),unclose);

    var add_wifi = document.getElementById("add_wifi")
    var edit_wifi = document.getElementById("edit_wifi")
    var add_wifi_btn = document.getElementById("add_wifi_btn")
    var wifi_name = document.getElementById("wifi_name")
    var wifi_password = document.getElementById("wifi_password")

    var edit_wifi_btn = document.getElementById("edit_wifi_btn")
    var edit_wifi_name = document.getElementById("edit_wifi_name")
    var edit_wifi_password = document.getElementById("edit_wifi_password")

    var delete_wifi_name = document.getElementById("delete_wifi_name")
    var delete_wifi_btn = document.getElementById("delete_wifi_btn")

    var delete_ready_state_wifi = document.getElementById("delete_ready_state_wifi")
    var delete_saving_state_wifi = document.getElementById("delete_saving_state_wifi")

        var wifi_dropdown = document.getElementById("wifi_dropdown")
    var wifi_dropdown_toggle = document.getElementById("wifi_dropdown_toggle")
    


    add_wifi.addEventListener('shown.bs.modal', function () {
        wifi_name.focus()
    })
    edit_wifi.addEventListener('shown.bs.modal', function () {
        edit_wifi_name.focus()
    })

    add_wifi_btn.addEventListener("click",function(){
        sole.post("../../controllers/mac/add_wifi.php", {
            uid: localStorage.getItem("userid"),
            wifi_name: wifi_name.value,
            wifi_password: wifi_password.value,
        }).then(res => validateResponse(res,"add_wifi"))
    })

    edit_wifi_btn.addEventListener("click",function(){
        !edit_wifi_name.value ? bs5.toast("warning","Please provide wifi name.") : null

        sole.post("../../controllers/mac/edit_wifi.php",{
            id: edit_wifi_btn.getAttribute("wid"),
            wifi_name: edit_wifi_name.value,
            wifi_password: edit_wifi_password.value,
        }).then(res => validateResponse(res,"edit_wifi")) 
    })

    // POST DELETE NETWOK
    delete_wifi_btn.addEventListener("click",function(){
        delete_ready_state_wifi.style = "display: none;"
        delete_saving_state_wifi.style = "display: flex;"
        sole.post("../../controllers/mac/delete_wifi.php",{
            id: this.getAttribute("wid")
        }).then(res => validateResponse(res,"delete_wifi"))
    })

    // SELECT WIFI
    wifi_dropdown.addEventListener("click", e=>{
        if(e.target.classList.contains("dropdown-item")){
            wifi_dropdown_toggle.innerText = e.target.innerText
            localStorage.setItem("selected_wifi", e.target.innerText);
            localStorage.setItem("selected_wifi_id", e.target.getAttribute("id"));
            macTable.clear().draw();
            sole.post("../../controllers/mac/get_mac.php", {
                wid: localStorage.getItem("selected_wifi_id")
            }).then(res => loadMAC(res))
        }
    })

    // TOGGLE EDIT WIFI MODAL
    wifi_dropdown.addEventListener("contextmenu", e=>{
        if(e.target.innerText.toLowerCase() != "show all"){
            if(e.target.classList.contains("dropdown-item")){
                sole.post("../../controllers/mac/get_mac.php",{
                    id: e.target.getAttribute("id")
                }).then(res => editwifiForm(res))
            }    
        }
    })

    function editwifiForm(res){
        if(res.status){
            edit_wifi_name.value = res.wifi[0].name
            edit_wifi_password.value = res.wifi[0].password != "-" ? res.wifi[0].password : ""
            edit_wifi_btn.setAttribute("wid",res.wifi[0].id)
            delete_wifi_name.innerText = res.wifi[0].name
            delete_wifi_btn.setAttribute("wid",res.wifi[0].id)
            edit_wifi_modal.show()
        }else{
            bs5.toast(res.type,res.message,res.size)
        }
    }

    function loadMAC(res){
        var mac_count = 0
        var mac_record = document.getElementById("mac_record")
        res.mac.forEach(e => {
            macTable.row.add([
                e["id"],
                e["mac"],
                e["name"],
                e["device"] != "-" ? e["device"] : "",
                e["project"] != "-" ? e["project"] : "",
                e["location"] != "-" ? e["location"] : "",
                ""
            ]).draw(false)   
        });
        mac_record.innerText = "MAC Address: " + mac_count

        document.querySelector('#wifi_table').addEventListener("click", e=>{
            let tr = "";
            if(e.target.tagName == "I"){
                tr = e.target.parentNode.parentNode.parentNode.children
            }
            if(e.target.tagName == "BUTTON"){
                tr = e.target.parentNode.parentNode.children    
            }
            alert("table clicked")
            // if(e.target.classList.contains('edit_ip_row')) {
            //     edit_ip_title.innerText = "Edit IP: " + tr[0].innerText
            //     edit_ip_btn.setAttribute("i-id",e.target.getAttribute("i-id"))
            //     sole.post("../../controllers/ipaddress/find_ip.php",{
            //         id: e.target.getAttribute("i-id")
            //     }).then(res => editForm(res))
            // }
            // if(e.target.classList.contains('unassign_ip_row')){
            //     unassign_ip_name.innerText = "Unassign IP: " + tr[0].innerText
            //     unassign_ip_btn.setAttribute("i-id",e.target.getAttribute("i-id"))
            //     unassign_ip_modal.show()
            // }
        })




        console.log(res)
    }


    function loadWifi(res){
        if(wifi_dropdown_toggle.innerText == "-- Select Wifi --"){
            if (localStorage.getItem("selected_wifi") && res.wifis.length){
                wifi_dropdown_toggle.innerText = localStorage.getItem("selected_wifi")
            }else{
                if(res.wifis.length){
                    wifi_dropdown_toggle.innerText = res.wifis[0]["name"]
                    localStorage.setItem("selected_wifi", res.wifis[0]["name"]);
                    localStorage.setItem("selected_wifi_id", res.wifis[0]["id"]);
                }else{
                    localStorage.removeItem("selected_wifi");
                    localStorage.removeItem("selected_wifi_id");
                }
            }
        }
        // if(localStorage.getItem("selected_wifi")){
        //     sole.post("../../controllers/mac/get_ip.php", {
        //         nid: localStorage.getItem("selected_wifi_id")
        //     }).then(res => loadIP(res))
        // }
        wifi_dropdown.innerHTML = ""
        res.wifis.forEach(wifi => {
            wifi_dropdown.innerHTML += "<li><a href=\"#\" class=\"dropdown-item\" id=\""+ wifi["id"] +"\" >"+ wifi["name"] +"</a></li>"
        });
    }

    function validateResponse(res, func){
        if(func == "delete_wifi"){
            delete_ready_state_wifi.style = ""
            delete_saving_state_wifi.style = "display: none;"
        }
        if(res.status){
            if(func == "add_wifi"){
                wifi_name.value = ""
                wifi_password.value = ""
                add_wifi_modal.hide()
                sole.get("../../controllers/mac/get_wifi.php").then(res => loadWifi(res))
            }
            if(func == "edit_wifi"){
                edit_wifi_modal.hide()
                sole.get("../../controllers/mac/get_wifi.php").then(res => loadWifi(res))
            }
            if(func == "delete_wifi"){
                delete_wifi_modal.hide()
                sole.get("../../controllers/mac/get_wifi.php").then(res => loadWifi(res))
            }
            bs5.toast(res.type,res.message,res.size)
        }else{
            bs5.toast(res.type,res.message,res.size)    
        }
    }
}