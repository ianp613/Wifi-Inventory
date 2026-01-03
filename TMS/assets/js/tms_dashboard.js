if(document.getElementById("dashboard")){
    var tms_time_in = document.getElementById("tms_time_in");

    tms_time_in.addEventListener("click", () => {
        window.location.href = "tms-time-in.php"
    })
}