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

    let cameraListTable = new DataTable('#camera_list_table',{
        rowCallback: function(row) {
            $(row).addClass("trow");
        },
        columnDefs: [
            { 
                className: 'dt-left', 
                targets: '_all' 
            },
        ],
        autoWidth: false,
        language: {
           sLengthMenu: "Show _MENU_entries",
           search: "Search: ",
        },
        searching: false,
        paging: false,
        info: false,
        emptyTable: false
    });

    const canvas = document.getElementById("cctvCanvas");
    const ctx = canvas.getContext("2d");
    const add_cctv_map_modal = new bootstrap.Modal(document.getElementById('add_cctv_map'),unclose);
    const manage_camera_modal = new bootstrap.Modal(document.getElementById('manage_camera'),unclose);
    const camera_list_modal = new bootstrap.Modal(document.getElementById('camera_list'),unclose);

    // manage_camera_modal.show()
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
    var camera_preview = document.getElementById("camera_preview")
    var camera_location = document.getElementById("camera_location")
    var camera_brand = document.getElementById("camera_brand")
    var camera_model_no = document.getElementById("camera_model_no")
    var camera_barcode = document.getElementById("camera_barcode")
    var camera_status = document.getElementById("camera_status")
    var camera_remarks = document.getElementById("camera_remarks")

    var cameraList = null;
    var camera_list_title = document.getElementById("camera_list_title")


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
            camera_list_title.innerHTML = "<span class=\"fa fa-video-camera\"></span> <b>Unassigned Camera:</b> " + e.target.innerText
            manage_camera_title.setAttribute("s-id",e.target.getAttribute("id"))
            cctv_dropdown_toggle.innerText = e.target.innerText
            camera_size.value = e.target.getAttribute("size")
            // localStorage.setItem("selected_cctv", e.target.innerText);
            // localStorage.setItem("selected_cctv_id", e.target.getAttribute("id"));
            sole.post("../../controllers/cctv/get_site_info.php", {
                id: e.target.getAttribute("id")
            }).then(res => {
                document.getElementById("cctvCanvas").removeAttribute("hidden")
                loadCCTVList(res)
                setTimeout(() => {
                    loadCCTVMap(res)
                }, 100);
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

    function loadCCTVList(res){
        sole.post("../../controllers/cctv/get_camera.php",{
            lid : res.cctv[0]["id"]
        }).then(res => {
            cameraList = res
            cameraTable.clear().draw();
            res.camera.forEach(e => {
                cameraTable.row.add([
                    e["id"],
                    e["camera_id"],
                    e["camera_type"] != "-" ? e["camera_type"] : "",
                    e["camera_subtype"] != "-" ? e["camera_subtype"] : "",
                    "<button id=\"edit_isp_"+ e["id"] +"\" i-id=\""+ e["id"] +"\" class=\"edit_isp_row btn btn-sm btn-secondary\"><i i-id=\""+ e["id"] +"\" class=\"edit_isp_row fa fa-edit\"></i></button>" +
                    "<button id=\"delete_isp_"+ e["id"] +"\" i-id=\""+ e["id"] +"\" class=\"delete_isp_row btn btn-sm btn-danger ms-1\"><i i-id=\""+ e["id"] +"\" class=\"delete_isp_row fa fa-trash\"></i></button>" 
                ]).draw(false)   
            });
            cameraListTable.clear().draw();
            res.camera.forEach(e => {
                if(e.cx == "-" && e.cy == "-"){
                    cameraListTable.row.add([
                    "<img id=\""+e["id"]+"\" style=\"transform: rotate("+e["camera_angle"]+"deg);\" src=\"../../assets/img/camera/camera.png\" alt=\"camera_preview\" width=\"25px;\" height=\"25px\">",
                    e["camera_id"],
                    e["camera_id"],
                    e["camera_type"] != "-" ? e["camera_type"] : "",
                    e["camera_subtype"] != "-" ? e["camera_subtype"] : "",
                ]).draw(false)  
                }
            });
        })
    }

    function loadCCTVMap(res) {
        const background = new Image();
        background.src = res.cctv[0]["floorplan"];
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        background.onload = function () {
            const targetWidth = 1050;
            const aspectRatio = background.height / background.width;
            const targetHeight = targetWidth * aspectRatio;

            canvas.width = targetWidth;
            canvas.height = targetHeight;

            // Draw the background
            ctx.drawImage(background, 0, 0, targetWidth, targetHeight);

            // After background is drawn, place the camera icons
            cameraList.camera.forEach(cam => {
                if (cam.cx != "-" && cam.cy != "-") {
                    const camImage = new Image();
                    camImage.src = "../../assets/img/camera/camera.png";

                    camImage.onload = function () {
                        const size = 20;
                        const centerX = parseFloat(cam.cx);
                        const centerY = parseFloat(cam.cy);
                        const angle = (parseFloat(cam.camera_angle) || 0) * Math.PI / 180;

                        ctx.save();
                        ctx.translate(centerX, centerY);
                        ctx.rotate(angle);
                        ctx.drawImage(camImage, -size/2, -size/2, size, size);
                        ctx.restore();

                        const label = cam.camera_id;
                        ctx.font = "bold 12px Arial";
                        ctx.fillStyle = cam.camera_status == "UP" ? "green" : "red";
                        ctx.textAlign = "center";
                        ctx.fillText(label, centerX, centerY + size / 2 + 15); // 12px below the icon
                    };
                }
            });
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

        if(cameraList){
            camera_list_modal.show()
        }
    });




    save_camera_form_btn.addEventListener("click",function(){
        if(camera_id.value){
            sole.post("../../controllers/cctv/add_camera.php",{
                camera_lid : manage_camera_title.getAttribute("s-id"),
                camera_id : camera_id.value,
                camera_type : camera_type.value,
                camera_subtype : camera_subtype.value,
                camera_ip_address : camera_ip_address.value,
                camera_port_no : camera_port_no.value,
                camera_username : camera_username.value,
                camera_password : camera_password.value,
                camera_angle : camera_angle.value,
                camera_location : camera_location.value,
                camera_brand : camera_brand.value,
                camera_model_no : camera_model_no.value,
                camera_barcode : camera_barcode.value,
                camera_status : camera_status.value,
                camera_remarks : camera_remarks.value
            }).then(res => {
                validateResponse(res,"add_camera")
                console.log(res)
            })
        }else{
            alert("Please provide camera alias or input DVR or NVR port no.")
        }
    })

    function validateResponse(res,func){
        if(res.status){
            if(func == "add_camera"){
                clearForm()
            }
            bs5.toast(res.type,res.message,res.size)
        }else{
            bs5.toast(res.type,res.message,res.size)
        }
    }











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
        camera_ip_address.value = ""
        camera_port_no.value = ""
        camera_username.value = ""
        camera_password.value = ""
        camera_angle.value = 0
        camera_preview.setAttribute("style","transform: rotate(0deg);")
        camera_location.value = ""
        camera_brand.value = ""
        camera_model_no.value = ""
        camera_barcode.value = ""
        camera_status.value = "UP"
        camera_remarks.value = ""
        camera_subtype_form.setAttribute("hidden","")
    }

    camera_angle.addEventListener("input",function(){
        camera_preview.setAttribute("style","transform: rotate("+this.value+"deg);")
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
            camera_ip_address.value = ""
            camera_port_no.value = ""
            camera_username.value = ""
            camera_password.value = ""
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


