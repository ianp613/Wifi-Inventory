if(document.getElementById("consumables")){
    let consumablesTable = new DataTable('#consumables_table',{
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
            },
            { 
                className: 'dt-right', 
                targets: 7
            }
        ],
        autoWidth: false,
        language: {
           sLengthMenu: "Show _MENU_entries",
           search: "Search: "
        }
    });

    loadPage();
    // LOAD PAGE DATA
    function loadPage(){
        sole.get("../../controllers/consumables/get_consumables.php").then(res => loadConsumables(res))
    }

    const add_consumables_modal = new bootstrap.Modal(document.getElementById('add_consumables'),unclose);
    const restock_consumables_modal = new bootstrap.Modal(document.getElementById('restock_consumables'),unclose);
    const add_log_modal = new bootstrap.Modal(document.getElementById('add_log'),unclose);

    var add_consumables = document.getElementById("add_consumables")
    var restock_consumables = document.getElementById("restock_consumables")

    var consumable_code = document.getElementById("consumable_code")
    var consumable_description = document.getElementById("consumable_description")
    var consumable_measurement = document.getElementById("consumable_measurement")
    var consumable_unit = document.getElementById("consumable_unit")
    var consumable_stock = document.getElementById("consumable_stock")
    var consumable_restock_point = document.getElementById("consumable_restock_point")
    var add_consumables_btn = document.getElementById("add_consumables_btn")

    var search_consumable = document.getElementById("search_consumable")
    var restock_consumables_code = document.getElementById("restock_consumables_code")
    var restock_consumables_stock = document.getElementById("restock_consumables_stock")
    var restock_consumables_description = document.getElementById("restock_consumables_description")
    var restock_consumables_btn = document.getElementById("restock_consumables_btn")
    var restock_quantity = document.getElementById("restock_quantity")

    var consumable_badge_danger = document.getElementById("consumable_badge_danger")
    var consumable_badge_success = document.getElementById("consumable_badge_success")

    var generate_link_btn = document.getElementById("generate_link_btn")
    var add_log_link = document.getElementById("add_log_link")

    add_consumables.addEventListener('shown.bs.modal', function () {
        sole.get("../../controllers/consumables/get_code.php")
        .then(res => {
            consumable_code.innerHTML = "Code: <b>" + res + "</b>"
        })
        consumable_description.focus()
    })

    restock_consumables.addEventListener('shown.bs.modal', function () {
        search_consumable.focus()
    })

    add_consumables_btn.addEventListener("click",function(){
        if(consumable_description.value){
            sole.post("../../controllers/consumables/add_consumables.php",{
                uid: localStorage.getItem("userid"),
                description: consumable_description.value,
                measurement: consumable_measurement.value,
                unit: consumable_unit.value,
                stock: consumable_stock.value,
                restock_point: consumable_restock_point.value
            }).then(res => validateResponse(res,"add_consumables"))
        }else{
            bs5.toast("warning","Please add description.")
        }
    })

    consumable_measurement.addEventListener("change",function(){
        var op_length = [
            "Meter (m)",
            "Centimeter (cm)",
            "Millimeter (mm)",
            "Foot (ft)",
            "Inch (in)",
            "Yard (yd)",
            "Kilometer (km)",
            "Decimeter (dm)",
            "Light Year (ly)",
            "Micrometer (µm)",
            "Parsec (pc)",
            "Astronomical Unit (AU)",
            "Lunar Distance (LD)",
            "Picometer (pm)",
            "Nanometer (nm)",
            "Furlong (fur)",
            "Fathom (fm)",
            "Nautical mile (nmi)",
            "Mile (mi)"
        ];
        var op_weight = [
            "Kilogram (kg)",
            "Milligram (mg)",
            "Gram (g)",
            "Microgram (µg)",
            "Quintal (q)",
            "Carat (ct)",
            "Ton (t)",
            "Short Ton (st)",
            "Long Ton (lt)",
            "Ounce (oz)",
            "Grain (gr)",
            "Dram (dr)",
            "Short Hundredweight (sh cwt)",
            "Long Hundredweight (lg cwt)",
            "Pound (lb)",
            "Stone (st)",
        ];
        var op_others = [
            "Piece (pc)",
            "Box (bx)",
            "Sachet (sac)"
        ];
        consumable_unit.innerText = ""
        if(this.value == "Length"){
            op_length.forEach(op => {
                var opt = document.createElement("option")
                opt.value = op
                opt.innerText = op
                consumable_unit.appendChild(opt)
            });
        }else if(this.value == "Weight"){
            op_weight.forEach(op => {
                var opt = document.createElement("option")
                opt.value = op
                opt.innerText = op
                consumable_unit.appendChild(opt)
            });
        }else if(this.value == "Volume"){
            op_volume.forEach(op => {
                var opt = document.createElement("option")
                opt.value = op
                opt.innerText = op
                consumable_unit.appendChild(opt)
            });
        }else if(this.value == "Others"){
            op_others.forEach(op => {
                var opt = document.createElement("option")
                opt.value = op
                opt.innerText = op
                consumable_unit.appendChild(opt)
            });
        }else{
            consumable_unit.innerHTML = "<option value=\"\">-- Select Unit --</option>"
        }
    })

    consumable_stock.addEventListener("input",function(){
        if(/^0+\d/.test(consumable_stock.value)) {
            consumable_stock.value = consumable_stock.value.replace(/^0+(?=\d)/, '');
        }
        if(consumable_stock.value < 0){
            consumable_stock.value = 0
        }
        if(!consumable_stock.value){
            consumable_stock.value = 0
        }
    })

    consumable_restock_point.addEventListener("input",function(){
        if(/^0+\d/.test(consumable_restock_point.value)) {
            consumable_restock_point.value = consumable_restock_point.value.replace(/^0+(?=\d)/, '');
        }
        if(consumable_restock_point.value < 0){
            consumable_restock_point.value = 0
        }
        if(!consumable_restock_point.value){
            consumable_restock_point.value = 0
        }
    })

    search_consumable.addEventListener("input",function(){
        sole.post("../../controllers/consumables/search_consumable.php",{
            search: search_consumable.value
        }).then(res => {
            if(res.length && search_consumable.value){
                restock_consumables_code.innerText = res[0].code
                restock_consumables_description.innerText = res[0].description
                restock_consumables_stock.innerText = res[0].stock
                restock_consumables_btn.setAttribute("sid",res[0].id)   
                if(parseFloat(res[0].stock) <= parseFloat(res[0].restock_point)){
                    consumable_badge_danger.hidden = false
                    consumable_badge_success.hidden = true
                }else{
                    consumable_badge_danger.hidden = true
                    consumable_badge_success.hidden = false
                }
            }else{
                restock_consumables_code.innerText = "-"
                restock_consumables_description.innerText = "-"
                restock_consumables_stock.innerText = "-"
                restock_consumables_btn.setAttribute("sid","")
                consumable_badge_danger.hidden = true
                consumable_badge_success.hidden = true
            }
        })
    })

    restock_consumables_btn.addEventListener("click",function(){
        if(restock_consumables_btn.getAttribute("sid")){
            if(restock_quantity.value > 0){
                sole.post("../../controllers/consumables/restock_consumables.php",{
                    sid: restock_consumables_btn.getAttribute("sid"),
                    quantity: restock_quantity.value,
                }).then(res => validateResponse(res,"restock_consumables"))
            }else{
                bs5.toast("warning","Please enter a valid quantity.")
            }
        }
    })

    restock_quantity.addEventListener("input",function(){
        if(/^0+\d/.test(restock_quantity.value)) {
            restock_quantity.value = restock_quantity.value.replace(/^0+(?=\d)/,    '');
        }
        if(restock_quantity.value < 0){
            restock_quantity.value = 0
        }
        if(!restock_quantity.value){
            restock_quantity.value = 0
        }
    })

    generate_link_btn.addEventListener("click",function(){
        let url = window.location.origin + window.location.pathname;
        let baseUrl = url.substring(0, url.lastIndexOf('/') + 1);

        add_log_link.setAttribute("target","_blank");

        add_log_link.setAttribute("href",baseUrl + "consumables-log.php");
        add_log_link.innerText = baseUrl + "consumables-log.php";
    })

    

    function loadConsumables(res){
        console.log(res)
        consumablesTable.clear().draw();
        res.consumables.forEach(e => {
            consumablesTable.row.add([
                e["id"],
                e["code"],
                e["description"],
                e["measurement"],
                e["unit"],
                e["stock"],
                parseFloat(e["stock"]) <= parseFloat(e["restock_point"]) ? "<span class=\"badge bg-danger\">Low Stock</span>" :  "<span class=\"badge bg-success\">In Stock</span>",
                " <button id=\"edit_mac_"+ e["id"] +"\" m-id=\""+ e["id"] +"\" class=\"edit_mac_row btn btn-sm btn-secondary mb-1\"><i m-id=\""+ e["id"] +"\" class=\"edit_mac_row fa fa-edit\"></i></button>"+
                " <button id=\"delete_mac_"+ e["id"] +"\" m-id=\""+ e["id"] +"\" class=\"delete_mac_row btn btn-sm btn-danger mb-1\"><i m-id=\""+ e["id"] +"\" class=\"delete_mac_row fa fa-trash-o\"></i></button>"
            ]).draw(false) 
        });
    }

    function validateResponse(res,func){
        if(res.status){
            if(func == "add_consumables"){
                consumable_description.value = ""
                consumable_measurement.value = ""
                consumable_unit.innerHTML = "<option value=\"\">-- Select Unit --</option>"
                consumable_stock.value = 0
                consumable_restock_point.value = 0
                add_consumables_modal.hide()
                loadPage()
            }
            if(func == "restock_consumables"){
                restock_quantity.value = 0
                search_consumable.value = ""
                restock_consumables_btn.setAttribute("sid","")
                restock_consumables_code.innerText = "-"
                restock_consumables_description.innerText = "-"
                restock_consumables_stock.innerText = "-"
                consumable_badge_danger.hidden = true
                consumable_badge_success.hidden = true
                restock_consumables_modal.hide()
                loadPage()
            }
            bs5.toast(res.type,res.message,res.size)
        }else{
            bs5.toast(res.type,res.message,res.size)
        }
    }
}