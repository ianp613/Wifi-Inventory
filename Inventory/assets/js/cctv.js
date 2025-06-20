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
    var camera_subtype_form = document.getElementById("camera_subtype_form")

    var camera_size = document.getElementById("camera_size")


    var camera_id = document.getElementById("camera_id")
    var camera_type = document.getElementById("camera_type")
    var camera_subtype = document.getElementById("camera_subtype")
    var camera_ip_address = document.getElementById("camera_ip_address")
    var camera_port_no = document.getElementById("camera_port_no")
    var camera_username = document.getElementById("camera_username")
    var camera_password = document.getElementById("camera_password")
    var camera_angle = document.getElementById("camera_angle")
    var camera_location = document.getElementById("camera_location")
    var camera_brand = document.getElementById("camera_brand")
    var camera_model_no = document.getElementById("camera_model_no")
    var camera_barcode = document.getElementById("camera_barcode")
    var camera_status = document.getElementById("camera_status")
    var camera_remarks = document.getElementById("camera_remarks")


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
            cctv_dropdown.innerHTML += "<li><a href=\"#\" class=\"dropdown-item\" id=\""+ cctv["id"] +"\" size=\""+ cctv["camera_size"] +"\">"+ cctv["map_location"] +"</a></li>"
        });
    }

    // SELECT SITE
    cctv_dropdown.addEventListener("click", e=>{
        if(e.target.classList.contains("dropdown-item")){
            manage_camera_title.innerHTML = "<span class=\"fa fa-video-camera\"></span> " + e.target.innerText
            manage_camera_title.setAttribute("s-id",e.target.getAttribute("id"))
            cctv_dropdown_toggle.innerText = e.target.innerText
            camera_size.value = e.target.getAttribute("size")
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
        camera_id.value = ""
        camera_type.value = "-"
        camera_subtype.value = "-"
        camera_angle.value = 0
        camera_location.value = ""
        camera_brand.value = ""
        camera_model_no.value = ""
        camera_barcode.value = ""
        camera_status.value = "UP"
        camera_remarks.value = ""
        camera_subtype_form.setAttribute("hidden","")
    }

    camera_angle.addEventListener("input",function(){
        if(!this.value){
            this.value = 0
        }else{
            this.value = parseInt(this.value)
        }
    })
    camera_subtype.addEventListener("change",function(){
        if(this.value != "Coaxial Camera"){
            camera_subtype_form.removeAttribute("hidden")
        }else{
            camera_subtype_form.setAttribute("hidden","")
        }
    })
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


