if(document.getElementById("ipaddress")){
    let ipTable = new DataTable('#network_table',{
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
                target: 5,
                visible: false,
            },
            { 
                className: 'dt-left', 
                targets: '_all' 
            }
        ],
        autoWidth: false,
        language: {
           sLengthMenu: "Show _MENU_entries",
           search: "<button style=\"margin-right: 10px; padding-left: 10px;\" class=\"btn btn-sm btn-secondary rounded-pill position-relative\"><span class=\" fa fa-download\"></span> Export</button>   Search: "
        }
    });

    loadPage();
    // LOAD PAGE DATA
    function loadPage(){
        sole.get("../../controllers/ipaddress/get_network.php").then(res => loadNetwork(res))
        if(localStorage.getItem("selected_network")){
            sole.post("../../controllers/ipaddress/get_ip.php", {
                nid: localStorage.getItem("selected_network_id")
            }).then(res => loadIP(res))
        }
    }

    const add_network_modal = new bootstrap.Modal(document.getElementById('add_network'),unclose);
    const edit_network_modal = new bootstrap.Modal(document.getElementById('edit_network'),unclose);
    const edit_ip_modal = new bootstrap.Modal(document.getElementById('edit_ip'),unclose);
    

    var add_network = document.getElementById("add_network")
    var edit_network = document.getElementById("edit_network")
    var network_name = document.getElementById("network_name")
    var ip_range_from = document.getElementById("ip_range_from")
    var ip_range_to = document.getElementById("ip_range_to")
    var ip_subnet = document.getElementById("ip_subnet")
    var add_network_btn = document.getElementById("add_network_btn")
    var ready_state = document.getElementById("ready_state")
    var saving_state = document.getElementById("saving_state")
    var edit_network_name = document.getElementById("edit_network_name")
    var edit_ip_range_from = document.getElementById("edit_ip_range_from")
    var edit_ip_range_to = document.getElementById("edit_ip_range_to")
    var edit_ip_subnet = document.getElementById("edit_ip_subnet")
    var edit_network_btn = document.getElementById("edit_network_btn")
    var edit_ready_state = document.getElementById("edit_ready_state")
    var edit_saving_state = document.getElementById("edit_saving_state")

    // EDIT ENTRY FOCUS
    var edit_ip = document.getElementById('edit_ip')
    // var edit_entry_description_input = document.getElementById('edit_entry_description_input')
    var edit_ip_btn = document.getElementById('edit_ip_btn')
    var edit_ip_title = document.getElementById('edit_ip_title')
    var edit_network_name_temp = "";

    edit_ip.addEventListener('shown.bs.modal', function () {
        // edit_entry_description_input.focus()
    })

    // ADD NETWORK FOCUS
    add_network.addEventListener('shown.bs.modal', function () {
        network_name.focus()
    })
    // EDIT NETWORK FOCUS
    edit_network.addEventListener('shown.bs.modal', function () {
        edit_network_name_temp = edit_network_name.value;
        edit_network_name.focus()
    })

    // POST EDIT NETWORK
    edit_network_btn.addEventListener("click", function(){
        !edit_network_name.value ? bs5.toast("warning","Please provide network name.") : null
        !edit_ip_subnet.value ? bs5.toast("warning","Please provide subnet mask.") : null

        sole.post("../../controllers/ipaddress/edit_network.php",{
            id: edit_network_btn.getAttribute("nid"),
            name: edit_network_name.value,
            subnet: edit_ip_subnet.value
        }).then(res => validateResponse(res,"edit_network"))  
    })

    // POST ADD NETWORK
    add_network_btn.addEventListener("click", function () {
        ready_state.style = "display: none;"
        saving_state.style = "display: flex;"
        network_name.setAttribute("readonly","true")
        ip_range_from.setAttribute("readonly","true")
        ip_range_to.setAttribute("readonly","true")
        ip_subnet.setAttribute("readonly","true")
        sole.post("../../controllers/ipaddress/add_network.php", {
            name: network_name.value,
            from: ip_range_from.value,
            to: ip_range_to.value,
            subnet: ip_subnet.value
        }).then(res => validateResponse(res,"add_network"))
    })

    // TOGGLE EDIT NETWORK MODAL
    var network_dropdown = document.getElementById("network_dropdown");
    var network_dropdown_toggle = document.getElementById("network_dropdown_toggle");
    network_dropdown.addEventListener("contextmenu", e=>{
        if(e.target.classList.contains("dropdown-item")){
            sole.post("../../controllers/ipaddress/find_network.php",{
                id: e.target.getAttribute("id")
            }).then(res => editNetworkForm(res))
        }
    })

    // SELECT NETWORK
    network_dropdown.addEventListener("click", e=>{
        if(e.target.classList.contains("dropdown-item")){
            network_dropdown_toggle.innerText = e.target.innerText
            localStorage.setItem("selected_network", e.target.innerText);
            localStorage.setItem("selected_network_id", e.target.getAttribute("id"));
            sole.post("../../controllers/ipaddress/get_ip.php", {
                nid: localStorage.getItem("selected_network_id")
            }).then(res => loadIP(res))
        }
    })

    function editNetworkForm(res){
        if(res.status){
            edit_network_name.value = res.network[0].name
            edit_ip_range_from.value = res.network[0].from
            edit_ip_range_to.value = res.network[0].to
            edit_ip_subnet.value = res.network[0].subnet
            edit_network_btn.setAttribute("nid",res.network[0].id)
            edit_network_modal.show()
        }else{
            bs5.toast(res.type,res.message,res.size)
        }
    }
    function loadIP(res){
        ipTable.clear().draw();
        ip_count = [0,0];
        var used_ip = document.getElementById("used_ip");
        var available_ip = document.getElementById("available_ip");

        res.ip.forEach(e => {
            e["status"] == "ASSIGNED" ? ip_count[0]++ : ip_count[1]++
            ipTable.row.add([
                e["id"],
                e["ip"],
                e["hostname"],
                e["site"],
                e["server"],
                e["status"] == "UNASSIGNED" ? "USED" : "AVAILABLE",
                e["status"] == "UNASSIGNED" ? "<div class=\"red-circle mx-auto\"></div>" : "<div class=\"green-circle mx-auto\"></div>",
                e["webmgmtpt"],
                e["username"] + " - " + e["password"],
                " <button id=\"edit_ip_"+ e["id"] +"\" i-id=\""+ e["id"] +"\" class=\"edit_ip_row btn btn-sm btn-secondary\"><i i-id=\""+ e["id"] +"\" class=\"edit_ip_row fa fa-edit\"></i></button>"
            ]).draw(false)   
        });

        used_ip.innerText = "Used IP: " + ip_count[0]
        available_ip.innerText = "Available IP: " + ip_count[1]
        document.querySelector('#network_table').addEventListener("click", e=>{
            if (e.target.classList.contains('edit_ip_row')) {
                let tr = "";
                if(e.target.tagName == "I"){
                    tr = e.target.parentNode.parentNode.parentNode.children
                }
                if(e.target.tagName == "BUTTON"){
                    tr = e.target.parentNode.parentNode.children    
                }
                edit_ip_title.innerText = "Edit IP: " + tr[0].innerText
                edit_ip_btn.setAttribute("i-id",e.target.getAttribute("i-id"))
                sole.post("../../controllers/ipaddress/find_ip.php",{
                    id: e.target.getAttribute("i-id")
                }).then(res => editForm(res))
            }
        })
        // res.ip.forEach(e => {
        //     document.getElementById('edit_ip_'+e["id"]).addEventListener("click", e=>{
                
        //         edit_ip_btn.addEventListener("click", e =>{
        //             console.log("OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOK")
        //             let invalid = [];

                    // if (!edit_entry_description_input.value) invalid.push('Description');
                    // if (!edit_entry_model_no_input.value) invalid.push('Model No.');
                    // if (!edit_entry_barcode_input.value) invalid.push('Barcode');
                    // if (!edit_entry_specifications_input.value) invalid.push('Specifications');
                    // if (!edit_entry_status_input.value) invalid.push('Status');
                    // if (!edit_entry_remarks_input.value) invalid.push('Remarks');

                    // let message = "";

                    // for (let i = 0; i < invalid.length; i++) {
                    //     if(i != invalid.length-1){
                    //         message += invalid[i] + ", "
                    //     }else{
                    //         if(invalid.length != 1){
                    //             message += "and " + invalid[i] + " doesn't have a default value. Please put <b class=\"text-warning\"><i>N/A</i></b> if not applicable."
                    //         }else{
                    //             message += invalid[i] + " doesn't have a default value. Please put <b class=\"text-warning\"><i>N/A</i></b> if not applicable."
                    //         }
                    //     }
                    // }

                    // if(!message){
                    //     if(localStorage.getItem("selected_equipment")){
                    //         var id = null;
                    //         e.target.tagName == "SPAN" ? id = e.target.parentNode.getAttribute("e-id") : id = e.target.getAttribute("e-id")
                    //         sole.post("../../controllers/equipments/edit_entry.php",{
                    //             id: id,
                    //             description: edit_entry_description_input.value,
                    //             model_no: edit_entry_model_no_input.value,
                    //             barcode: edit_entry_barcode_input.value,
                    //             specifications: edit_entry_specifications_input.value,
                    //             status: edit_entry_status_input.value,
                    //             remarks: edit_entry_remarks_input.value
                    //         }).then(res => validateResponse(res,"edit_entry"))
                    //     }else{
                    //         bs5.toast("warning","Please select equipment first.")
                    //     }
                    // }else{
                    //     bs5.toast("warning",message)
                    // }
                    
        //         })
        //     })
        // });
    }

    function editForm(res){
        edit_ip_modal.show()
        console.log(res)

















    }

    function validateResponse(res, func){
        if(func == "add_network"){
            sole.get("../../controllers/ipaddress/get_network.php").then(res => loadNetwork(res))
            ready_state.style = ""
            saving_state.style = "display: none;"
            network_name.removeAttribute("readonly")
            ip_range_from.removeAttribute("readonly")
            ip_range_to.removeAttribute("readonly")
            ip_subnet.removeAttribute("readonly")
            add_network_modal.hide();
        }
        if(res.status){
            if(func == "add_network"){
                sole.get("../../controllers/ipaddress/get_network.php").then(res => loadNetwork(res))
                network_name.value = ""
                ip_range_from.value = ""
                ip_range_to.value = ""
                ip_subnet.value = ""
            }
            if(func == "edit_network"){
                if(edit_network_name_temp == localStorage.getItem("selected_network")){
                    network_dropdown_toggle.innerText = edit_network_name.value
                    localStorage.setItem("selected_network", edit_network_name.value);
                    localStorage.setItem("selected_network_id", edit_network_name.getAttribute("id"));
                }
                edit_network_modal.hide();
                sole.get("../../controllers/ipaddress/get_network.php").then(res => loadNetwork(res))
            }
            bs5.toast(res.type,res.message,res.size)
        }else{
            bs5.toast(res.type,res.message,res.size)
        }
        
    }

    function loadNetwork(res){
        if(network_dropdown_toggle.innerText == "-- Select Network --"){
            if (localStorage.getItem("selected_network") && res.networks.length){
                network_dropdown_toggle.innerText = localStorage.getItem("selected_network")
            }else{
                if(res.networks.length){
                    network_dropdown_toggle.innerText = res.networks[0]["name"]
                    localStorage.setItem("selected_network", res.networks[0]["name"]);
                    localStorage.setItem("selected_network_id", res.networks[0]["id"]);
                }else{
                    localStorage.removeItem("selected_network");
                    localStorage.removeItem("selected_network_id");
                }
            }
        }
        if(localStorage.getItem("selected_network")){
            sole.post("../../controllers/ipaddress/get_ip.php", {
                nid: localStorage.getItem("selected_network_id")
            }).then(res => loadIP(res))
        }
        network_dropdown.innerHTML = ""
        res.networks.forEach(equipment => {
            network_dropdown.innerHTML += "<li><a href=\"#\" class=\"dropdown-item\" id=\""+ equipment["id"] +"\" >"+ equipment["name"] +"</a></li>"
        });
    }

    document.getElementById("ip_range_from").addEventListener("input", function() {
        this.value = this.value.replace(/[^0-9.]/g, "");
    });
    
    document.getElementById("ip_range_to").addEventListener("input", function() {
        this.value = this.value.replace(/[^0-9.]/g, "");
    });
    
    document.getElementById("ip_subnet").addEventListener("input", function() {
        this.value = this.value.replace(/[^0-9.]/g, "");
    });
    
    document.getElementById("edit_ip_subnet").addEventListener("input", function() {
        this.value = this.value.replace(/[^0-9.]/g, "");
    });
}
// validateResponse(res,"add_equipment")