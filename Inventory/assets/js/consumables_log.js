var link = "";
var g_name_display = document.getElementById("g_name_display");

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

function locationRedirect(){
    setTimeout(() => {
        window.location.replace("../index.php");
    }, 5000);
}