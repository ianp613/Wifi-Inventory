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
           search: "<button id=\"add_router_btn\" data-bs-toggle=\"modal\" data-bs-target=\"#add_router\" class=\"btn btn-sm btn-danger me-3\"><span class=\"fa fa-plus\"></span> Add Router</button> Search: "
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


    const add_router_modal = new bootstrap.Modal(document.getElementById('add_router'),unclose)

    var add_router_btn = document.getElementById("add_router_btn")
    var router_wan1 = document.getElementById("router_wan1")
    var router_wan2 = document.getElementById("router_wan2")
    var router_wan1_icon = document.getElementById("router_wan1_icon")
    var router_wan2_icon = document.getElementById("router_wan2_icon")
    var wan1_info = document.getElementById("wan1_info")
    var wan2_info = document.getElementById("wan2_info")
    var add_router = document.getElementById("add_router")

    var save_router_btn = document.getElementById("save_router_btn")

    var router_name = document.getElementById("router_name")
    var router_ip = document.getElementById("router_ip")
    var router_subnet = document.getElementById("router_subnet")
    var router_wan1 = document.getElementById("router_wan1")
    var router_wan2 = document.getElementById("router_wan2")

    loadPage();
    // LOAD PAGE DATA
    function loadPage(){
        sole.get("../../controllers/routers/get_router.php").then(res => loadRouter(res))
    }

    function loadRouter(res){
        console.log(res)
    }

    // ADD ROUTER FOCUS
    add_router.addEventListener('shown.bs.modal', function () {
        router_name.focus()
    })

    add_router_btn.addEventListener("click",function(){
        wan1_info.innerText = "NOT SET"
        wan2_info.innerText = "NOT SET"
        router_wan1_icon.setAttribute("hidden","")   
        router_wan2_icon.setAttribute("hidden","")   
        sole.get("../../controllers/routers/get_available_isp.php").then(res => selectDrop(res))
    })

    router_wan1.addEventListener("change",function(){
        sole.post("../../controllers/routers/find_isp.php",{
            id: this.value
        }).then(res => setWan(res,"wan1"))
    })

    router_wan2.addEventListener("change",function(){
        sole.post("../../controllers/routers/find_isp.php",{
            id: this.value
        }).then(res => setWan(res,"wan2"))
    })

    save_router_btn.addEventListener("click",function(){
        var message = ""
        !router_subnet.value ? message = "Please provide router subnet." : null
        !router_ip.value ? message = "Please provide router ip." : null
        !router_name.value ? message = "Please provide router name." : null

        if(!message){
            if(router_wan1.value && router_wan2.value && router_wan1.value != "0" && router_wan2.value != "0"){
                if(router_wan1.value != router_wan2.value){
                    postRouter()
                }else{
                    bs5.toast("warning","WAN 1 (Primary) should not be the same as WAN 2 (Secondary).")
                }
            }else{
                postRouter()
            }
        }else{
            bs5.toast("warning",message)
        }
    })

    function postRouter(){
        sole.post("../../controllers/routers/add_router.php",{
            router_name: router_name.value,
            router_ip: router_ip.value,
            router_subnet: router_subnet.value,
            router_wan1: router_wan1.value,
            router_wan2: router_wan2.value
        }).then(res => console.log(res))

        router_name.value = ""
        router_ip.value = ""
        router_subnet.value = ""
        add_router_modal.hide()
    }

    function setWan(res,func){
        if(res.length){
            if(func == "wan1"){
                if(res[0]["isp_name"] == "PLDT Inc."){
                    router_wan1_icon.setAttribute("src","../../assets/img/pldt.png")
                    router_wan1_icon.setAttribute("class","ht-20")
                    router_wan1_icon.removeAttribute("hidden")
                }
                if(res[0]["isp_name"] == "Globe Telecom, Inc."){
                    router_wan1_icon.setAttribute("src","../../assets/img/globe.png")
                    router_wan1_icon.setAttribute("class","ht-30")
                    router_wan1_icon.removeAttribute("hidden")
                }
                if(res[0]["isp_name"] == "Converge ICT Solutions Inc."){
                    router_wan1_icon.setAttribute("src","../../assets/img/converge.png")
                    router_wan1_icon.setAttribute("class","ht-30")
                    router_wan1_icon.removeAttribute("hidden")
                }

                wan1_info.innerHTML = "ISP: " + res[0]["isp_name"] + "<br>" +
                "Name: " + res[0]["name"] + "<br>" +
                "WAN IP: " + res[0]["wan_ip"] + "<br>" +
                "<div class=\"row mt-2\">" + 
                    "<div class=\"col-md-6\">" +
                        "Subnet: " + res[0]["subnet"] + "<br>" +
                    "</div>" +
                    "<div class=\"col-md-6\">" +
                        "Gateway: " + res[0]["gateway"] + "<br>" +
                    "</div>" +
                "</div>" +
                "<div class=\"row\">" + 
                    "<div class=\"col-md-6\">" +
                        "DNS 1: " + res[0]["dns1"] + "<br>" +
                    "</div>" +
                    "<div class=\"col-md-6\">" +
                        "DNS 2: " + res[0]["dns2"] + "<br>"
                    "</div>" +
                "</div>"      
            }
            if(func == "wan2"){
                if(res[0]["isp_name"] == "PLDT Inc."){
                    router_wan2_icon.setAttribute("src","../../assets/img/pldt.png")
                    router_wan2_icon.setAttribute("class","ht-20")
                    router_wan2_icon.removeAttribute("hidden")
                }
                if(res[0]["isp_name"] == "Globe Telecom, Inc."){
                    router_wan2_icon.setAttribute("src","../../assets/img/globe.png")
                    router_wan2_icon.setAttribute("class","ht-30")
                    router_wan2_icon.removeAttribute("hidden")
                }
                if(res[0]["isp_name"] == "Converge ICT Solutions Inc."){
                    router_wan2_icon.setAttribute("src","../../assets/img/converge.png")
                    router_wan2_icon.setAttribute("class","ht-30")
                    router_wan2_icon.removeAttribute("hidden")
                }

                wan2_info.innerHTML = "ISP: " + res[0]["isp_name"] + "<br>" +
                "Name: " + res[0]["name"] + "<br>" +
                "WAN IP: " + res[0]["wan_ip"] + "<br>" +
                "<div class=\"row mt-2\">" + 
                    "<div class=\"col-md-6\">" +
                        "Subnet: " + res[0]["subnet"] + "<br>" +
                    "</div>" +
                    "<div class=\"col-md-6\">" +
                        "Gateway: " + res[0]["gateway"] + "<br>" +
                    "</div>" +
                "</div>" +
                "<div class=\"row\">" + 
                    "<div class=\"col-md-6\">" +
                        "DNS 1: " + res[0]["dns1"] + "<br>" +
                    "</div>" +
                    "<div class=\"col-md-6\">" +
                        "DNS 2: " + res[0]["dns2"] + "<br>"
                    "</div>" +
                "</div>"
            }    
        }else{
            if(func == "wan1"){
                router_wan1_icon.setAttribute("hidden","")    
                wan1_info.innerText = "NOT SET"
            }
            if(func == "wan2"){
                router_wan2_icon.setAttribute("hidden","")  
                wan2_info.innerText = "NOT SET"
            }
        }
    }

    function selectDrop(res){
        router_wan1.innerHTML = ""
        router_wan2.innerHTML = ""

        var op1_sel = document.createElement("option")
        op1_sel.setAttribute("disabled","")
        op1_sel.setAttribute("selected","")
        op1_sel.setAttribute("value","0")
        op1_sel.innerText = "-- Select WAN 1 --"
        router_wan1.appendChild(op1_sel)

        var op2_sel = document.createElement("option")
        op2_sel.setAttribute("disabled","")
        op2_sel.setAttribute("selected","")
        op2_sel.setAttribute("value","0")
        op2_sel.innerText = "-- Select WAN 2 --"
        router_wan2.appendChild(op2_sel)


        res.isp.forEach(e => {
            var op1 = document.createElement("option")
            op1.setAttribute("value",e["id"])
            op1.innerText = e["name"]
            router_wan1.appendChild(op1)
        });

        var wan1op = document.createElement("option")
        wan1op.setAttribute("value","0")
        wan1op.innerText = "N/A"

        router_wan1.appendChild(wan1op)
        
        res.isp.forEach(e => {
            var op2 = document.createElement("option")
            op2.setAttribute("value",e["id"])
            op2.innerText = e["name"]
            router_wan2.appendChild(op2)
        });

        var wan2op = document.createElement("option")
        wan2op.setAttribute("value","0")
        wan2op.innerText = "N/A"
        router_wan2.appendChild(wan2op)
    }
}