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

    const add_consumables_modal = new bootstrap.Modal(document.getElementById('add_consumables'),unclose);
    add_consumables_modal.show()

    var add_consumables = document.getElementById("add_consumables")

    var consumable_description = document.getElementById("consumable_description")
    var consumable_stock = document.getElementById("consumable_stock")
    var consumable_restock_point = document.getElementById("consumable_restock_point")
    var add_consumables_btn = document.getElementById("add_consumables_btn")

    add_consumables.addEventListener('shown.bs.modal', function () {
        sole.get("../../controllers/consumables/get_code.php")
        .then(res => console.log(res))
        consumable_description.focus()
    })

    add_consumables_btn.addEventListener("click",function(){
        if(consumable_description.value){
            
        }else{
            bs5.toast("warning","Please add description.")
        }
    })
}