if(document.getElementById("cctv")){
    let cameraTable = new DataTable('#camera_table',{
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
           search: "<button id=\"add_camera_btn\" class=\"btn btn-sm btn-danger me-3\"><span class=\"fa fa-plus\"></span> Add Camera</button> Search: "
        }
    });
    const canvas = document.getElementById("cctvCanvas");
    const ctx = canvas.getContext("2d");
    const add_cctv_map_modal = new bootstrap.Modal(document.getElementById('add_cctv_map'),unclose);
    const manage_camera_modal = new bootstrap.Modal(document.getElementById('manage_camera'),unclose);

    manage_camera_modal.show()
    var add_site_btn = document.getElementById("add_site_btn")
    var map_location = document.getElementById("map_location")
    var floorplan = document.getElementById("floorplan")
    var map_remarks = document.getElementById("map_remarks")
    var manage_camera_title = document.getElementById("manage_camera_title")

    var manage_camera_btn = document.getElementById("manage_camera_btn")

    var add_camera_btn = document.getElementById("add_camera_btn")
    var camera_form_control = document.getElementById("camera_form_control")
    var cancel_camera_form_btn = document.getElementById("cancel_camera_form_btn")
    var save_camera_form_btn = document.getElementById("save_camera_form_btn")
    var update_camera_form_btn = document.getElementById("update_camera_form_btn")
    var camera_menu = document.getElementById("camera_menu")
    var camera_form = document.getElementById("camera_form")

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
            add_cctv_map_modal.hide()
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
            manage_camera_title.innerHTML = "<span class=\"fa fa-video-camera\"></span> " + cctv["map_location"]
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

    manage_camera_btn.addEventListener("click",function(){
        if(cctv_dropdown_toggle.innerText == "-- Select Map --"){
            bs5.toast("warning","Please select map first.")
        }else{
            manage_camera_modal.show()
        }
    })

    function loadCCTVMap(res){
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

    canvas.addEventListener("contextmenu", function (e) {
        e.preventDefault();

        const rect = canvas.getBoundingClientRect();
        const clickX = e.clientX - rect.left;
        const clickY = e.clientY - rect.top;

        // Store clicked position for modal to use later
        canvas.dataset.clickX = clickX;
        canvas.dataset.clickY = clickY;

        console.log(canvas.dataset)

        // // Open your camera selection modal here
        // openCameraModal(); // your function to show the modal
    });















    add_camera_btn.addEventListener("click",function(){
        camera_menu.setAttribute("hidden","")
        camera_form.removeAttribute("hidden")
        camera_form_control.removeAttribute("hidden")
        
        update_camera_form_btn.setAttribute("hidden","")
        save_camera_form_btn.removeAttribute("hidden")
    })

    cancel_camera_form_btn.addEventListener("click",function(){
        camera_menu.removeAttribute("hidden")
        camera_form.setAttribute("hidden","")
        camera_form_control.setAttribute("hidden","")
        clearForm();
    })

    function clearForm(){

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


