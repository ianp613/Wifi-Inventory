if(document.getElementById("ipaddress")){
    let entryTable = new DataTable('#network_table',{
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
        }
    });

    const add_network_modal = new bootstrap.Modal(document.getElementById('add_network'));

    var add_network = document.getElementById("add_network")
    var network_name = document.getElementById("network_name")
    var ip_range_from = document.getElementById("ip_range_from")
    var ip_range_to = document.getElementById("ip_range_to")
    var ip_subnet = document.getElementById("ip_subnet")
    var add_network_btn = document.getElementById("add_network_btn")
    var ready_state = document.getElementById("ready_state")
    var saving_state = document.getElementById("saving_state")

    add_network.addEventListener('shown.bs.modal', function () {
        network_name.focus()
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

    function validateResponse(res, func){
        if(res.status){
            if(func == "add_network"){
                ready_state.style = ""
                saving_state.style = "display: none;"
                network_name.removeAttribute("readonly")
                ip_range_from.removeAttribute("readonly")
                ip_range_to.removeAttribute("readonly")
                ip_subnet.removeAttribute("readonly")

                network_name.value = ""
                ip_range_from.value = ""
                ip_range_to.value = ""
                ip_subnet.value = ""

                add_network_modal.hide();
            }
            bs5.toast(res.type,res.message,res.size)
        }else{
            bs5.toast(res.type,res.message,res.size)
        }
        
    }
}
// validateResponse(res,"add_equipment")