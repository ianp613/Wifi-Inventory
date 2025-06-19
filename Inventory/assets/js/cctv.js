if(document.getElementById("cctv")){
    const add_cctv_map_modal = new bootstrap.Modal(document.getElementById('add_cctv_map'),unclose);

    var add_site_btn = document.getElementById("add_site_btn")
    var map_location = document.getElementById("map_location")
    var floorplan = document.getElementById("floorplan")
    var map_remarks = document.getElementById("map_remarks")

    var manage_camera = document.getElementById("manage_camera")

    sole.get("../../controllers/cctv/get_site.php").then(res => loadSite(res))

    add_site_btn.addEventListener("click",function(){
        !map_location.value ? bs5.toast("warning","Please input map location.") : null
        floorplan.files.length > 0 ? null : bs5.toast("warning","Please select floor plan.")

        const formData = new FormData();
        formData.append("uid",localStorage.getItem("userid"))
        formData.append("file",floorplan.files[0])
        formData.append("map_location",map_location.value)
        formData.append("map_remarks",map_remarks.value)
        sole.file("../../controllers/cctv/add_site.php",formData)
        .then(res => {
            bs5.toast(res.type,res.message,res.size)
            map_location.value = ""
            floorplan.value = ""
            map_remarks.value = ""
            loadSite(res)
        })
    })

    function loadSite(res){
        cctv_dropdown.innerHTML = ""
        res.cctvs.forEach(cctv => {
            cctv_dropdown.innerHTML += "<li><a href=\"#\" class=\"dropdown-item\" id=\""+ cctv["id"] +"\" >"+ cctv["map_location"] +"</a></li>"
        });
    }

    // SELECT SITE
    cctv_dropdown.addEventListener("click", e=>{
        if(e.target.classList.contains("dropdown-item")){
            cctv_dropdown_toggle.innerText = e.target.innerText
            // localStorage.setItem("selected_cctv", e.target.innerText);
            // localStorage.setItem("selected_cctv_id", e.target.getAttribute("id"));
            sole.post("../../controllers/cctv/get_site_info.php", {
                id: e.target.getAttribute("id")
            }).then(res => {
                document.getElementById("cctvCanvas").removeAttribute("hidden")
                loadCCTVMap(res)
            })
        }
    })

    manage_camera.addEventListener("click",function(){
        if(cctv_dropdown_toggle.innerText == "-- Select Map --"){
            bs5.toast("warning","Please select map first.")
        }
    })

    function loadCCTVMap(res){
        const canvas = document.getElementById("cctvCanvas");
        const ctx = canvas.getContext("2d");

        const background = new Image();
        background.src = res.cctv[0]["floorplan"]; // Replace with your actual image path

        background.onload = function () {
            const targetWidth = 1050; // or canvas container width
            const aspectRatio = background.height / background.width;
            const targetHeight = targetWidth * aspectRatio;

            canvas.width = targetWidth;
            canvas.height = targetHeight;

            ctx.drawImage(background, 0, 0, targetWidth, targetHeight);
        };
    }
}


// const canvas = document.getElementById("myCanvas");
// const ctx = canvas.getContext("2d");

// const background = new Image();
// background.src = "../../assets/img/floorplan.png"; // Replace with your actual image path

// background.onload = function () {
//     const targetWidth = 1050; // or canvas container width
//     const aspectRatio = background.height / background.width;
//     const targetHeight = targetWidth * aspectRatio;

//     canvas.width = targetWidth;
//     canvas.height = targetHeight;

//     ctx.drawImage(background, 0, 0, targetWidth, targetHeight);
// };

// canvas.addEventListener("contextmenu", function (e) {
//     e.preventDefault();

//     // Get mouse position relative to the canvas
//     const rect = canvas.getBoundingClientRect();
//     const x = e.clientX - rect.left;
//     const y = e.clientY - rect.top;

//     // Prompt the user
//     if (confirm("Do you want to add a circle here?")) {
//         // Draw the circle
//         ctx.beginPath();
//         ctx.arc(x, y, 20, 0, Math.PI * 2); // (x, y, radius, startAngle, endAngle)
//         ctx.fillStyle = "rgba(0, 0, 255, 0.6)";
//         ctx.fill();
//         ctx.closePath();
//     }
// });
