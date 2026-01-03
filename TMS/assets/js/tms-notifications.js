if(document.getElementById("notifications")){
    const tms_nofication_modal = new bootstrap.Modal(document.getElementById('tms_nofication_modal'),unclose);
    var notification_field = document.getElementById("notification_field");
    var tms_time = document.getElementById("tms_time");
    var tms_message = document.getElementById("tms_message");
    
    notification_field.addEventListener("click", (e) => {
        if(e.target.classList.contains("tmf")){
            let message = "";
            let time = "";

            if(e.target.classList.contains("tmf-con")){
                message = e.target.children[0].innerText
                time = e.target.children[1].innerText
            }
            if(e.target.classList.contains("tmf-message") || e.target.classList.contains("tmf-time")){
                message = e.target.parentNode.children[0].innerText
                time = e.target.parentNode.children[1].innerText
            }
            tms_message.innerText = message
            tms_time.innerText = time
            
            tms_nofication_modal.show()

            // set notification to read
        }
    })
}