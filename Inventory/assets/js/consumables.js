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

    var add_consumables = document.getElementById("add_consumables")

    var consumable_code = document.getElementById("consumable_code")
    var consumable_description = document.getElementById("consumable_description")
    var consumable_stock = document.getElementById("consumable_stock")
    var consumable_restock_point = document.getElementById("consumable_restock_point")
    var add_consumables_btn = document.getElementById("add_consumables_btn")

    add_consumables.addEventListener('shown.bs.modal', function () {
        sole.get("../../controllers/consumables/get_code.php")
        .then(res => {
            consumable_code.innerHTML = "Code: <b>" + res + "</b>"
        })
        consumable_description.focus()
    })

    add_consumables_btn.addEventListener("click",function(){
        if(consumable_description.value){
            sole.post("../../controllers/consumables/add_consumables.php",{
                uid: localStorage.getItem("userid"),
                description: consumable_description.value,
                stock: consumable_stock.value,
                restock_point: consumable_restock_point.value
            }).then(res => validateResponse(res,"add_consumables"))
        }else{
            bs5.toast("warning","Please add description.")
        }
    })

    consumable_stock.addEventListener("input",function(){
        if(consumable_stock.value < 0){
            consumable_stock.value = 0
        }
        if(!consumable_stock.value){
            consumable_stock.value = 0
        }
    })

    consumable_restock_point.addEventListener("input",function(){
        if(consumable_restock_point.value < 0){
            consumable_restock_point.value = 0
        }
        if(!consumable_restock_point.value){
            consumable_restock_point.value = 0
        }
    })

    function loadConsumables(res){
        console.log(res)
    }

    function validateResponse(res,func){
        if(res.status){
            if(func == "add_consumables"){
                consumable_description.value = ""
                consumable_stock.value = 0
                consumable_restock_point.value = 0
                add_consumables_modal.hide()
            }
            bs5.toast(res.type,res.message,res.size)
        }else{
            bs5.toast(res.type,res.message,res.size)
        }
    }
}