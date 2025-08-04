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

    loadPage();
    // LOAD PAGE DATA
    function loadPage(){
        sole.get("../../controllers/mac/get_wifi.php").then(res => loadWifi(res))
        // if(localStorage.getItem("selected_wifi")){
        //     sole.post("../../controllers/ipaddress/get_ip.php", {
        //         nid: localStorage.getItem("selected_wifi_id")
        //     }).then(res => loadIP(res))
        // }
    }

    const add_wifi_modal = new bootstrap.Modal(document.getElementById('add_wifi'),unclose);
    const edit_wifi_modal = new bootstrap.Modal(document.getElementById('edit_wifi'),unclose);

    

    var add_wifi = document.getElementById("add_wifi")
    var edit_wifi = document.getElementById("edit_wifi")
    var add_wifi_btn = document.getElementById("add_wifi_btn")
    var wifi_name = document.getElementById("wifi_name")
    var wifi_password = document.getElementById("wifi_password")

    var edit_wifi_btn = document.getElementById("edit_wifi_btn")
    var edit_wifi_name = document.getElementById("edit_wifi_name")
    var edit_wifi_password = document.getElementById("edit_wifi_password")
    


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

        // sole.post("../../controllers/mac/edit_wifi.php",{
        //     id: edit_wifi_btn.getAttribute("wid"),
        //     edit_wifi_name: edit_wifi_name.value,
        //     edit_wifi_password: edit_wifi_password.value,
        // }).then(res => validateResponse(res,"edit_network")) 
    })

    // TOGGLE EDIT WIFI MODAL
    var wifi_dropdown = document.getElementById("wifi_dropdown");
    var wifi_dropdown_toggle = document.getElementById("wifi_dropdown_toggle");
    wifi_dropdown.addEventListener("contextmenu", e=>{
        if(e.target.classList.contains("dropdown-item")){
            sole.post("../../controllers/mac/find_wifi.php",{
                id: e.target.getAttribute("id")
            }).then(res => editwifiForm(res))
        }
    })

    function editwifiForm(res){
        if(res.status){
            edit_wifi_name.value = res.wifi[0].name
            edit_wifi_password.value = res.wifi[0].password != "-" ? res.wifi[0].password : ""
            edit_wifi_btn.setAttribute("wid",res.wifi[0].id)
            // delete_wifi_name.innerText = res.wifi[0].name
            // delete_wifi_btn.setAttribute("wid",res.wifi[0].id)
            edit_wifi_modal.show()
        }else{
            bs5.toast(res.type,res.message,res.size)
        }
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
        //     sole.post("../../controllers/ipaddress/get_ip.php", {
        //         nid: localStorage.getItem("selected_wifi_id")
        //     }).then(res => loadIP(res))
        // }
        wifi_dropdown.innerHTML = ""
        res.wifis.forEach(wifi => {
            wifi_dropdown.innerHTML += "<li><a href=\"#\" class=\"dropdown-item\" id=\""+ wifi["id"] +"\" >"+ wifi["name"] +"</a></li>"
        });
    }

    function validateResponse(res, func){
        if(res.status){
            if(func == "add_wifi"){
                wifi_name.value = ""
                wifi_password.value = ""
                add_wifi_modal.hide()
                sole.get("../../controllers/mac/get_wifi.php").then(res => loadWifi(res))
            }
            bs5.toast(res.type,res.message,res.size)
        }else{
            bs5.toast(res.type,res.message,res.size)    
        }
    }
}