if(document.getElementById("tms_menu")){
    var tms_home            = document.getElementById("tms_home");
    var tms_tasks           = document.getElementById("tms_tasks");
    var tms_notifications   = document.getElementById("tms_notifications");
    var tms_settings        = document.getElementById("tms_settings");
    var setting_selection        = document.getElementById("setting_selection");

    tms_home.addEventListener("click",() => {
        window.location.href = "dashboard.php";
    })

    tms_tasks.addEventListener("click",() => {
        window.location.href = "tasks.php";
    })

    tms_notifications.addEventListener("click",() => {
        window.location.href = "notifications.php";
    })

    tms_settings.addEventListener("click", (e) => {
        if(setting_selection.classList.contains("shown") && e.target.parentNode.classList.contains("tms_")){
            setting_selection.classList.remove("shown")
        }else{
            setting_selection.classList.add("shown")
        }
    })

    document.addEventListener("click", (e) => {
        if(e.target.parentNode.classList){
            if(setting_selection.classList.contains("shown") && !e.target.parentNode.classList.contains("tms_")){
                setting_selection.classList.remove("shown")
            }    
        }else{
            setting_selection.classList.remove("shown")
        }
        
    })

    sole.get("../../controllers/get_user.php").then(res => {
        localStorage.setItem("user_id",res[0]["id"])
        localStorage.setItem("privileges",res[0]["privileges"])
    })

    localStorage.setItem("restricted","Technician")
}
