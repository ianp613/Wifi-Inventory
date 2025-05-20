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

    var add_router_btn = document.getElementById("add_router_btn")
    var router_wan1 = document.getElementById("router_wan1")
    var router_wan2 = document.getElementById("router_wan2")
    var router_wan1_icon = document.getElementById("router_wan1_icon")
    var router_wan2_icon = document.getElementById("router_wan2_icon")


    loadPage();
    // LOAD PAGE DATA
    function loadPage(){
        sole.get("../../controllers/routers/get_router.php").then(res => loadRouter(res))
    }

    function loadRouter(res){
        console.log(res)
    }

    add_router_btn.addEventListener("click",function(){
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

    function setWan(res,func){
        if(res.length){
            if(func == "wan1"){
                if(res[0]["isp_name"] == "PLDT Inc."){
                    router_wan1_icon.setAttribute("src","../../assets/img/pldt.png")
                    router_wan1_icon.setAttribute("class","ht-20")
                    router_wan1_icon.removeAttribute("hidden")
                }else if(res[0]["isp_name"] == "Globe Telecom, Inc."){
                    router_wan1_icon.setAttribute("src","../../assets/img/globe.png")
                    router_wan1_icon.setAttribute("class","ht-30")
                    router_wan1_icon.removeAttribute("hidden")
                }else if(res[0]["isp_name"] == "Converge ICT Solutions Inc."){
                    router_wan1_icon.setAttribute("src","../../assets/img/converge.png")
                    router_wan1_icon.setAttribute("class","ht-30")
                    router_wan1_icon.removeAttribute("hidden")
                }else{
                    router_wan1_icon.setAttribute("hidden","")
                }
            }
            if(func == "wan2"){
                console.log(res,func)  
            }    
        }else{
            bs5.toast("warning","Something went wrong.")
        }
    }

    function selectDrop(res){
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