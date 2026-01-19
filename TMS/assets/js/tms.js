if(document.getElementById("tms_menu")){
    var tms_home            = document.getElementById("tms_home");
    var tms_tasks           = document.getElementById("tms_tasks");
    var tms_notifications   = document.getElementById("tms_notifications");
    var tms_settings        = document.getElementById("tms_settings");

    tms_home.addEventListener("click",() => {
        window.location.href = "dashboard.php";
    })

    tms_tasks.addEventListener("click",() => {
        window.location.href = "tasks.php";
    })

    tms_notifications.addEventListener("click",() => {
        window.location.href = "notifications.php";
    })
}