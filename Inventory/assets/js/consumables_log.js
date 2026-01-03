var link = "";
var g_name_display = document.getElementById("g_name_display");
var g_search = document.getElementById("g_search");
var g_id = null;

var log_consumables_code = document.getElementById("log_consumables_code")
var log_consumables_stock = document.getElementById("log_consumables_stock")
var log_consumables_description = document.getElementById("log_consumables_description")


var log_consumable_badge_danger = document.getElementById("log_consumable_badge_danger")
var log_consumable_badge_success = document.getElementById("log_consumable_badge_success")

loadPage()

function loadPage() {
    link = window.location.href.split("glog=")
    if(link.length){
        sole.post("../../controllers/consumables/consumables_log/get_link_data.php",{
            link: link[1]
        }).then(res => {
            if(res.status){
                g_name_display.innerHTML = "<span class=\"fa fa-users\"></span> " + res.g_name + " |"
                g_name_display.classList.add("me-2")
                g_id = res.g_id
                console.log(res)
            }else{
                bs5.toast("warning", "<code> The link provided is invalid. Please contact your supervisor to obtain a valid link. Redirecting to home page <span class='fa fa-spin fa-spinner'></span></code>","lg",false,false)
                locationRedirect()
            }
        })    
    }else{
        locationRedirect()
    }
}

g_search.addEventListener("input", e => {
    search()
})

function search(){
    sole.post("../../controllers/consumables/search_consumable.php",{
        search: g_search.value,
        g_id: g_id
    }).then(res => {
        console.log(res)
        if(res.length && g_search.value){
            log_consumables_code.innerText = res[0].code
            log_consumables_description.innerText = res[0].description
            log_consumables_stock.innerText = res[0].stock
            if(parseFloat(res[0].stock) <= parseFloat(res[0].log_point)){
                log_consumable_badge_danger.hidden = false
                log_consumable_badge_success.hidden = true
            }else{
                log_consumable_badge_danger.hidden = true
                log_consumable_badge_success.hidden = false
            }
        }else{
            log_consumables_code.innerText = ""
            log_consumables_description.innerText = ""
            log_consumables_stock.innerText = ""
            log_consumable_badge_danger.hidden = true
            log_consumable_badge_success.hidden = true
        }
    }) 
}

function locationRedirect(){
    setTimeout(() => {
        window.location.replace("../index.php");
    }, 5000);
}

setdatetime()

function setdatetime(){
    const date = new Date();
    document.getElementById("date_today").valueAsDate = date;

    const formatTime = (date) => {
        const hours = date.getHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');
        return `${hours}:${minutes}`;
    };

    document.getElementById('time_today').value = formatTime(date);    
}
