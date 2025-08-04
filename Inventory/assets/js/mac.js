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
        // if(localStorage.getItem("selected_network")){
        //     sole.post("../../controllers/ipaddress/get_ip.php", {
        //         nid: localStorage.getItem("selected_network_id")
        //     }).then(res => loadIP(res))
        // }
    }

    const add_wifi = new bootstrap.Modal(document.getElementById('add_wifi'),unclose);

    var add_wifi_btn = document.getElementById("add_wifi_btn")
    var wifi_name = document.getElementById("wifi_name")
    var wifi_password = document.getElementById("wifi_password")

    add_wifi_btn.addEventListener("click",function(){
        
    })


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
        if(localStorage.getItem("selected_wifi")){
            sole.post("../../controllers/ipaddress/get_ip.php", {
                nid: localStorage.getItem("selected_wifi_id")
            }).then(res => loadIP(res))
        }
        wifi_dropdown.innerHTML = ""
        console.log(res)
        res.wifis.forEach(wifi => {
            wifi_dropdown.innerHTML += "<li><a href=\"#\" class=\"dropdown-item\" id=\""+ wifi["id"] +"\" >"+ wifi["name"] +"</a></li>"
        });
    }
}