if(document.getElementById("tasks")){
    var task_pane                       = document.getElementById("task_pane")
    var task_user_list                  = document.getElementById("task_user_list")
    var tms_user_list                   = document.getElementById("tms_user_list")
    var add_task_btn                    = document.getElementById("add_task_btn")
    var task_submit_btn                 = document.getElementById("task_submit_btn")
    var task_name                       = document.getElementById("task_name")
    var task_description                = document.getElementById("task_description")
    var task_note                       = document.getElementById("task_note")
    var task_deadline                   = document.getElementById("task_deadline")
    var buddy_list                      = document.getElementById("buddy_list")
    var buddy_selected                  = document.getElementById("buddy_selected")

    var task_file                       = document.getElementById("task_file")
    var task_file_upload                = document.getElementById("task_file_upload")
    var task_file_container             = document.getElementById("task_file_container")

    var task_location                   = document.getElementById("task_location")
    var task_location_others            = document.getElementById("task_location_others")

    var edit_task_submit_btn            = document.getElementById("edit_task_submit_btn")
    var edit_task_name                  = document.getElementById("edit_task_name")
    var edit_task_description           = document.getElementById("edit_task_description")
    var edit_task_note                  = document.getElementById("edit_task_note")
    var edit_task_deadline              = document.getElementById("edit_task_deadline")
    var edit_buddy_list                 = document.getElementById("edit_buddy_list")
    var edit_buddy_selected             = document.getElementById("edit_buddy_selected")
    var edit_task_status                = document.getElementById("edit_task_status")
    var edit_task_status_label          = document.getElementById("edit_task_status_label")
    var edit_task_modal_body            = document.getElementById("edit_task_modal_body")
    var show_remarks_btn                = document.getElementById("show_remarks_btn")

    var edit_task_file                  = document.getElementById("edit_task_file")
    var edit_task_file_upload           = document.getElementById("edit_task_file_upload")
    var edit_task_file_container        = document.getElementById("edit_task_file_container")
    var files_to_remove                 = []

    var edit_task_location              = document.getElementById("edit_task_location")
    var edit_task_location_others       = document.getElementById("edit_task_location_others")

    var remark_container                = document.getElementById("remark_container")

    var remarks_control                 = document.getElementById("remarks_control")
    var remark_attachment_btn           = document.getElementById("remark_attachment_btn")
    var remark_attachment_file          = document.getElementById("remark_attachment_file")
    var remark_message                  = document.getElementById("remark_message")
    var remark_send                     = document.getElementById("remark_send")

    var remark_attachment               = document.getElementById("remark_attachment")
    var remark_attachment_name          = document.getElementById("remark_attachment_name")
    var remark_attachment_size          = document.getElementById("remark_attachment_size")
    var remark_attachment_remove        = document.getElementById("remark_attachment_remove")

    var delete_task_btn                 = document.getElementById("delete_task_btn")
    var delete_task_btn_confirm         = document.getElementById("delete_task_btn_confirm")

    var pending_task_title              = document.getElementById("pending_task_title")
    var ongoing_task_title              = document.getElementById("ongoing_task_title")
    var accomplished_task_title         = document.getElementById("accomplished_task_title")

    var pending_task                    = document.getElementById("pending_task")
    var ongoing_task                    = document.getElementById("ongoing_task")
    var accomplished_task               = document.getElementById("accomplished_task")

    var view_accomplished_task          = document.getElementById("view_accomplished_task")
    var task_empty                      = document.getElementById("task_empty")

    var tech_task_status                = document.getElementById("tech_task_status")
    var tech_task_turnover              = document.getElementById("tech_task_turnover")
    var tech_update_btn                 = document.getElementById("tech_update_btn")

    var buddies                         = []
    var edit_buddies                    = []
    var status_                         = ["Pending","Ongoing","Accomplished"]

    var task_modal_focus                = false;
    var edit_task_modal_focus           = false;
    
    var users                           = []
    var locations                       = []
    var remarkers                       = []

    const add_task_modal                = new bootstrap.Modal(document.getElementById('add_task_modal'),unclose);
    const edit_task_modal               = new bootstrap.Modal(document.getElementById('edit_task_modal'),unclose);
    const buddy_selector                = new bootstrap.Modal(document.getElementById('buddy_selector'),unclose);
    const edit_buddy_selector           = new bootstrap.Modal(document.getElementById('edit_buddy_selector'),unclose);
    const delete_task_confirmation      = new bootstrap.Modal(document.getElementById('delete_task_confirmation'),unclose);
    const remarks_modal                 = new bootstrap.Modal(document.getElementById('remarks'),unclose);
    const tech_update_task              = new bootstrap.Modal(document.getElementById('tech_update_task'),unclose);

    localStorage.getItem("task_files") === null ? localStorage.setItem("task_files","") : null
    localStorage.getItem("edit_task_files") === null ? localStorage.setItem("edit_task_files","") : null
    localStorage.getItem("edit_task_files_temp") === null ? localStorage.setItem("edit_task_files_temp","") : null

    // DROP DOWN START ===================================================================================================
    const dropdown = document.getElementById("tms_dropdown");
    const label = dropdown.querySelector(".dropdown-label");

    // create dropdown list
    const list = document.createElement("div");
    list.className = "dropdown-list";
    // toggle dropdown
    dropdown.onclick = (e) => {
        e.stopPropagation();
        list.style.display = list.style.display === "block" ? "none" : "block";
    };

    dropdown.appendChild(list);

    // close on outside click
    document.addEventListener("click", () => {
        list.style.display = "none";
    });
    // DROP DOWN END   ===================================================================================================    

    sole.get("../../controllers/st/tasks/get_users.php")
    .then(res => {
        users = res
        res.forEach(user => {
            var opt        = document.createElement("option")
            opt.value      = user.id
            opt.innerText  = user.name
            task_user_list.appendChild(opt)
        });
    })

    loadTask()

    if(localStorage.getItem("privileges") != localStorage.getItem("restricted")){
        tms_user_list.removeAttribute("hidden")
        tms_user_list.classList.add("d-flex")
    }

    function loadTask(){
        pending_task_title.hidden       = true
        ongoing_task_title.hidden       = true
        accomplished_task_title.hidden  = true

        view_accomplished_task.hidden   = true

        pending_task.hidden             = true
        ongoing_task.hidden             = true
        accomplished_task.hidden        = true

        pending_task.innerHTML          = ""
        ongoing_task.innerHTML          = ""
        accomplished_task.innerHTML     = ""

        delete_task_btn.hidden          = true

        sole.post("../../controllers/st/tasks/get_tasks.php",{
            id          : task_user_list.value,
            location    : label.textContent == "-- Select Location --" ? "" : label.textContent
        }).then(res => {
            locations                       = res.locations
            task_location.innerHTML         = ""
            edit_task_location.innerHTML    = ""
            list.innerHTML                  = ""
            res.locations.forEach(location => {
                var opt         = document.createElement("option")
                opt.value       = location
                opt.innerText   = location
                task_location.appendChild(opt)

                var opt         = document.createElement("option")
                opt.value       = location
                opt.innerText   = location
                task_location.appendChild(opt)
                edit_task_location.appendChild(opt)


                const item = document.createElement("div");
                item.className = "dropdown-item";
                item.textContent = location;

                item.onclick = (e) => {
                    e.stopPropagation();
                    label.textContent = location;
                    list.style.display = "none";
                    loadTask()
                };

                list.appendChild(item);

            })
            if(!res.count){
                task_empty.hidden = false
            }else{
                task_empty.hidden = true
            }
            if(res.pending.length){
                pending_task_title.hidden   = false
                pending_task.hidden         = false
                res.pending.forEach(pending => {
                    pending_task.insertAdjacentHTML("beforeend",
                        `<div tid="${pending["id"]}" class="d-flex justify-content-between tms-message-field tmf tmf-con">`+
                            `<p class="tms-message tmf tmf-message">${pending["description"]}</p>`+
                            `<p style="width: 90px; padding-right: 10px;" class="text-end tmf tmf-time">${new Intl.DateTimeFormat("en-US", { month: "2-digit", day: "2-digit", year: "2-digit" }).format(new Date(pending["created_at"]))}</p>`+
                        `</div>`    
                    )
                })
            }
            if(res.ongoing.length){
                ongoing_task_title.hidden   = false
                ongoing_task.hidden         = false
                res.ongoing.forEach(ongoing => {
                    ongoing_task.insertAdjacentHTML("beforeend",
                        `<div tid="${ongoing["id"]}" class="d-flex justify-content-between tms-message-field tmf tmf-con">`+
                            `<p class="tms-message tmf tmf-message">${ongoing["description"]}</p>`+
                            `<p style="width: 90px; padding-right: 10px;" class="text-end tmf tmf-time">${new Intl.DateTimeFormat("en-US", { month: "2-digit", day: "2-digit", year: "2-digit" }).format(new Date(ongoing["created_at"]))}</p>`+
                        `</div>`    
                    )
                })
            }
            if(res.accomplished.length){
                // view_accomplished_task.hidden = false
                accomplished_task_title.hidden   = false
                accomplished_task.hidden         = false
                res.accomplished.forEach(accomplished => {
                    accomplished_task.insertAdjacentHTML("beforeend",
                        `<div tid="${accomplished["id"]}" class="d-flex justify-content-between tms-message-field tmf tmf-con">`+
                            `<p class="tms-message tmf tmf-message">${accomplished["description"]}</p>`+
                            `<p style="width: 90px; padding-right: 10px;" class="text-end tmf tmf-time">${new Intl.DateTimeFormat("en-US", { month: "2-digit", day: "2-digit", year: "2-digit" }).format(new Date(accomplished["created_at"]))}</p>`+
                        `</div>`    
                    )
                })
            }
        })
    }

    task_user_list.addEventListener("change", e => {
        loadTask()
    })

    add_task_btn.addEventListener("click", e => {
        if(label.textContent != "-- Select Location --"){
            task_location.value = label.textContent
        }
        task_modal_focus = true
        if (!task_user_list.value) return

        buddy_list.innerText        = ""
        buddy_selected.innerHTML    = "<i>No Buddy Selected</i>"
        buddies                     = []
        var buddies_                = []
        sole.get("../../controllers/st/tasks/get_users.php")
        .then(res => {
            res.forEach(user => {
                buddies_ = res
                if(user.id == parseInt(task_user_list.value)){
                    task_name.innerText = user.name
                }
                
                if(user.id != parseInt(task_user_list.value)){
                    buddy_list.insertAdjacentHTML("beforeend",
                        `<div class="form-check">`+
                            `<input class="form-check-input" type="checkbox" value="`+user.id+`" id="buddy_`+user.id+`">`+
                            `<label class="form-check-label" for="buddy_`+user.id+`">`+
                                user.name+
                            `</label>`+
                        `</div>`
                    )
                    var buddy = document.getElementById("buddy_"+user.id)
                    buddy.addEventListener("change", e => {
                        if(buddy.checked && !buddies.includes(buddy.value)){
                            buddies.push(buddy.value)
                        }else{
                            const i = buddies.indexOf(buddy.value);
                            i !== -1 && buddies.splice(i, 1);
                        }

                        buddies.length ? buddy_selected.innerHTML = "" : buddy_selected.innerHTML = "<i>No Buddy Selected</i>"

                        buddies_.forEach(user => {
                            if(buddies.includes(user.id.toString())){
                                buddy_selected.insertAdjacentHTML("beforeend",`<i>`+user.name+`</i><br>`)
                            }
                        })
                    })
                }
            });
        })

        task_submit_btn.setAttribute("aid",task_user_list.value)
        add_task_modal.show()
    })

    task_pane.addEventListener("click", e => {
        var el                  = e.target.parentNode
        var task_assignment     = null
        if(el.classList.contains("tms-message-field")){
            sole.post("../../controllers/st/tasks/get_task.php",{
                id : el.getAttribute("tid")
            }).then(res => {
                remarkers = res.remarker
                edit_task_file_container.innerHTML  = ""
                var file_temp = localStorage.getItem("edit_task_files").split("+++")
                if(!file_temp.length){
                    exit
                }
                if(file_temp[0] == "null" || !file_temp[0]){
                    file_temp.shift()
                }
                file_temp.forEach(file => {
                    if(file != 'null' && file){
                        edit_task_file_container.insertAdjacentHTML("beforeend",
                            '<div class="d-flex justify-content-between ">'+
                                '<a target="blank_" href="../../assets/uploads/task_file_attachments/'+file.split("==")[1]+'"><span class="fa fa-download"></span> <i>'+file.split("==")[0]+'</i></a>'+
                                '<span dname="'+file.split("==")[0]+'" fname="'+file.split("==")[1]+'" class="disabler task_file_remove fa fa-remove text-danger mt-1 ms-2"></span>'+
                            '</div>'
                        )
                    }
                })

                delete_task_btn.hidden      = res["task"][0].status == "Pending" && localStorage.getItem("privileges") != localStorage.getItem("restricted") ? false : true
                
                edit_task_status.innerHTML  = ""
                status_.forEach(stat => {
                    var opt                 = document.createElement("option")
                    opt.value               = stat
                    opt.innerText           = stat
                    if(stat == res["task"][0].status){
                        opt.selected        = true
                    }
                    edit_task_status.appendChild(opt)
                })


                tech_task_status.innerHTML  = ""
                status_.forEach(stat => {
                    var opt                 = document.createElement("option")
                    opt.value               = stat
                    opt.innerText           = stat
                    if(stat == res["task"][0].status){
                        opt.selected        = true
                    }
                    tech_task_status.appendChild(opt)

                    if(res["task"][0].status == "Accomplished"){
                        tech_task_turnover.setAttribute("style","pointer-events: none;")
                        tech_task_status.setAttribute("style","pointer-events: none;")
                        tech_update_btn.setAttribute("style","pointer-events: none;")
                    }else{
                        tech_task_turnover.removeAttribute("style")
                        tech_task_status.removeAttribute("style")
                        tech_update_btn.removeAttribute("style")
                    }
                })

                if(res["task"][0].status == "Accomplished" || localStorage.getItem("privileges") == localStorage.getItem("restricted")){
                    edit_task_status.hidden         = true
                    edit_task_status_label.hidden   = true

                    var el_ = document.getElementsByClassName("disabler")
                    for (let i = 0; i < el_.length; i++) {
                        if(el_[i].classList.contains("remarks-control")){
                            if(res.task[0].status == "Accomplished"){
                                el_[i].setAttribute("style","pointer-events: none;")
                            }
                        }else{
                            el_[i].setAttribute("style","pointer-events: none;")    
                        }
                        
                    }
                }else{
                    edit_task_status.hidden         = false
                    edit_task_status_label.hidden   = false
                    var el_ = document.getElementsByClassName("disabler")
                    for (let i = 0; i < el_.length; i++) {
                        el_[i].removeAttribute("style","pointer-events: none;")
                    }
                }

                if(localStorage.getItem("privileges") == localStorage.getItem("restricted")){
                    var el_ = document.getElementsByClassName("hidder")
                    for (let i = 0; i < el_.length; i++) {
                        if(el_[i].classList.contains("tech_update_task")){
                            if(res.task[0].status == "Accomplished" || res.task[0].aid != localStorage.getItem("user_id")){
                                el_[i].setAttribute("hidden","")
                            }else{
                                el_[i].removeAttribute("hidden","")
                            }
                        }else{
                            el_[i].setAttribute("hidden","")    
                        }
                    }
                    var el_ = document.getElementsByClassName("shower")
                    for (let i = 0; i < el_.length; i++) {
                        el_[i].removeAttribute("hidden")
                    }
                }else{
                    var el_ = document.getElementsByClassName("hidder")
                    for (let i = 0; i < el_.length; i++) {
                        el_[i].removeAttribute("hidden")
                    }
                    var el_ = document.getElementsByClassName("shower")
                    for (let i = 0; i < el_.length; i++) {
                        el_[i].setAttribute("hidden","")
                    }
                }

                users.forEach(user => {
                    if(user.id == parseInt(res["task"][0].aid)){
                        task_assignment             = user.id
                        edit_task_name.innerText    = user.name
                    }
                })
                edit_task_modal_focus               = true
                edit_task_location.value            = locations.includes(res["task"][0].location) ? res["task"][0].location : ""
                edit_task_location_others.value     = locations.includes(res["task"][0].location) ? "" : res["task"][0].location
                edit_task_description.value         = res["task"][0].description
                edit_task_note.value                = res["task"][0].note != "-" ? res["task"][0].note : ""
                edit_task_deadline.value            = res["task"][0].deadline != "-" ? res["task"][0].deadline : ""
                localStorage.setItem("edit_task_files",res["task"][0].attachment != "-" ? res["task"][0].attachment : "")

                if(res["task"][0].buddies != "-"){
                    edit_buddies = res["task"][0].buddies.split("|") 
                }else{
                    edit_buddies = []
                }

                if(edit_buddies.length){
                    edit_buddy_selected.innerHTML   = ""
                    users.forEach(user => {
                        edit_buddies.includes(user.id.toString()) ? edit_buddy_selected.insertAdjacentHTML("beforeend",`<i>`+user.name+`</i><br>`) : null
                    })
                }else{
                    edit_buddy_selected.innerHTML   = "<i>No Buddy Selected</i>"
                }
                edit_buddy_list.innerText           = ""
                var buddies_                        = []
                sole.get("../../controllers/st/tasks/get_users.php")
                .then(res => {
                    buddies_ = res
                    res.forEach(user => {
                        if(user.id != parseInt(task_user_list.value)){
                            var checked_ = edit_buddies.includes(user.id.toString()) ? "checked" : ""
                            if(task_assignment != user.id){
                                edit_buddy_list.insertAdjacentHTML("beforeend",
                                    `<div class="form-check">`+
                                        `<input class="form-check-input" `+checked_+` type="checkbox" value="`+user.id+`" id="buddy_`+user.id+`">`+
                                        `<label class="form-check-label" for="buddy_`+user.id+`">`+
                                            user.name+
                                        `</label>`+
                                    `</div>`
                                )  
                                var edit_buddy = document.getElementById("buddy_"+user.id)
                                edit_buddy.addEventListener("change", e => {
                                    if(edit_buddy.checked && !buddies.includes(edit_buddy.value)){
                                        edit_buddies.push(edit_buddy.value)
                                    }else{
                                        const i = edit_buddies.indexOf(edit_buddy.value);
                                        i !== -1 && edit_buddies.splice(i, 1);
                                    }

                                    edit_buddies.length ? edit_buddy_selected.innerHTML = "" : edit_buddy_selected.innerHTML = "<i>No Buddy Selected</i>"

                                    buddies_.forEach(user => {
                                        if(edit_buddies.includes(user.id.toString())){
                                            edit_buddy_selected.insertAdjacentHTML("beforeend",`<i>`+user.name+`</i><br>`)
                                        }
                                    })
                                }) 
                            }
                        }
                        
                        if(user.id != localStorage.getItem("user_id")){
                            var opt         = document.createElement("option")
                            opt.value       = user.id
                            opt.innerText   = user.name
                            tech_task_turnover.appendChild(opt)
                        }
                    });
                })
                delete_task_btn.setAttribute("tid",res["task"][0].id)
                edit_task_submit_btn.setAttribute("tid",res["task"][0].id)
                show_remarks_btn.setAttribute("tid",res["task"][0].id)
                remark_send.setAttribute("tid",res["task"][0].id)
                edit_task_modal.show()
                if(res.task[0].status != "Accomplished" && res.remarker_id.includes(res.your_id.toString())){
                    remarks_control.removeAttribute("hidden")
                }else{
                    remarks_control.setAttribute("hidden","")
                }
            })
        }
    })

    remark_attachment_btn.addEventListener("click", e => {
        remark_attachment_file.click()
    })

    remark_attachment_file.addEventListener("change", e => {
        const file = remark_attachment_file.files[0];
        const MAX_SIZE = 6 * 1024 * 1024; // 5MB

        if (!file) return;
        if (file.size > MAX_SIZE) {
            alert("File exceeds 5MB limit");
            remark_attachment_file.value = "";
            return;
        }

        const fileName = file.name;
        let fileSize;

        if (file.size >= 1024 * 1024) {
            fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB';
        } else {
            fileSize = (file.size / 1024).toFixed(2) + ' KB';
        }

        remark_attachment_name.innerText = fileName
        remark_attachment_size.innerText = fileSize

        remark_attachment.removeAttribute("hidden")
        remark_attachment.classList.add("d-flex")
    })
    
    remark_attachment_remove.addEventListener("click", e => {
        remark_attachment_file.value = ""
        remark_attachment.setAttribute("hidden","")
        remark_attachment.classList.remove("d-flex")
    })

    remark_send.addEventListener("click", e => {
        if(remark_attachment_file.value){
            if(remark_message.value){
                const file = remark_attachment_file.files[0];
                const formData = new FormData();
                formData.append("type", "file_with_remark");
                formData.append("tid", remark_send.getAttribute("tid"));
                formData.append("size",remark_attachment_size.innerText);
                formData.append("file", file);
                formData.append("remark", remark_message.value);
                sole.file("../../controllers/st/tasks/save_remark.php",formData).then(res => {
                    if(res.status){
                        remark_attachment.setAttribute("hidden","")
                        remark_attachment.classList.remove("d-flex")
                        remark_attachment_file.value = ""
                        remark_message.value = ""
                        loadRemarks(show_remarks_btn.getAttribute("tid"))
                    }else{
                        alert(res.message)
                    }
                })
            }else{
                const file = remark_attachment_file.files[0];
                const formData = new FormData();
                formData.append("type", "file_only");
                formData.append("tid", remark_send.getAttribute("tid"));
                formData.append("size",remark_attachment_size.innerText);
                formData.append("file", file);
                sole.file("../../controllers/st/tasks/save_remark.php",formData).then(res => {
                    if(res.status){
                        remark_attachment.setAttribute("hidden","")
                        remark_attachment.classList.remove("d-flex")
                        remark_attachment_file.value = ""
                        remark_message.value = ""
                        loadRemarks(show_remarks_btn.getAttribute("tid"))
                    }else{
                        alert(res.message)
                    }
                })
            }
        }else{
            if(remark_message.value){
                const formData = new FormData();
                formData.append("type", "remark_only");
                formData.append("tid", remark_send.getAttribute("tid"));
                formData.append("remark", remark_message.value);
                sole.file("../../controllers/st/tasks/save_remark.php",formData).then(res => {
                    if(res.status){
                        remark_attachment.setAttribute("hidden","")
                        remark_attachment.classList.remove("d-flex")
                        remark_attachment_file.value = ""
                        remark_message.value = ""
                        loadRemarks(show_remarks_btn.getAttribute("tid"))
                    }else{
                        alert(res.message)
                    }
                })
            }
        }
    })

    console.log()
    delete_task_btn_confirm.addEventListener("click", e => {
        if(localStorage.getItem("privileges") == localStorage.getItem("restricted")){
            alert("You do not have enough privileges to continue this action.")
            delete_task_confirmation.hide()
            return
        }
        sole.post("../../controllers/st/tasks/delete_task.php",{
            id : delete_task_btn.getAttribute("tid")
        }).then(res => {
            bs5.toast(res.type,res.message)
            delete_task_confirmation.hide()
            loadTask()
        }) 
    })

    task_user_list.addEventListener("change", e =>{
        buddy_selected.innerHTML    = "<i>No Buddy Selected</i>"
        buddies                     = []
    })

    task_submit_btn.addEventListener("click", e => {
        if(localStorage.getItem("privileges") == localStorage.getItem("restricted")){
            alert("You do not have enough privileges to continue this action.")
            window.location.reload()
            return
        }
        if(!task_description.value){
            bs5.toast("warning","Please input description.")
            return
        }
        var attachment = "";
        if(localStorage.getItem("task_files") === null || !localStorage.getItem("task_files") || localStorage.getItem("task_files") == "null"){
            attachment = "-"
        }else{
            attachment = localStorage.getItem("task_files")
        }
        sole.post("../../controllers/st/tasks/add_task.php",{
            id              : task_submit_btn.getAttribute("aid"),
            location        : task_location_others.value ? task_location_others.value : task_location.value,
            description     : task_description.value,
            note            : task_note.value ? task_note.value : "-",
            deadline        : task_deadline.value ? task_deadline.value : "-",
            attachment      : attachment,
            buddies         : buddies.length ? buddies.join("|") : "-"
        }).then(res => {
            if(!res.status){
                bs5.toast(res.type,res.message)
                return
            }
            loadTask()
            task_location_others.value  = ""
            task_location.value         = ""
            task_description.value      = ""
            task_note.value             = ""
            task_deadline.value         = ""
            localStorage.removeItem("task_files")
            bs5.toast(res.type,res.message)
        })
    })

    edit_task_submit_btn.addEventListener("click", e => {
        if(localStorage.getItem("privileges") == localStorage.getItem("restricted")){
            alert("You do not have enough privileges to continue this action.")
            window.location.reload()
            return
        }
        if(!edit_task_description.value){
            bs5.toast("warning","Please input description.")
            return
        }
        var attachment = "";
        if(localStorage.getItem("edit_task_files") === null || !localStorage.getItem("edit_task_files") || localStorage.getItem("edit_task_files") == "null"){
            attachment = "-"
        }else{
            attachment = localStorage.getItem("edit_task_files")
        }
        sole.post("../../controllers/st/tasks/edit_task.php",{
            id              : edit_task_submit_btn.getAttribute("tid"),
            location        : edit_task_location_others.value ? edit_task_location_others.value : edit_task_location.value,
            description     : edit_task_description.value,
            note            : edit_task_note.value ? edit_task_note.value : "-",
            deadline        : edit_task_deadline.value ? edit_task_deadline.value : "-",
            attachment      : attachment,
            files_to_remove : files_to_remove.join("+++"),
            buddies         : edit_buddies.length ? edit_buddies.join("|") : "-",
            status          : edit_task_status.value
        }).then(res => {
            if(!res.status){
                bs5.toast(res.type,res.message)
                return
            }
            loadTask()
            edit_task_location_others.value = ""
            edit_task_description.value     = ""
            edit_task_note.value            = ""
            edit_task_deadline.value        = ""
            edit_task_file.value            = ""
            localStorage.setItem("edit_task_files", "")
            localStorage.setItem("edit_task_files_temp", "")
            bs5.toast(res.type,res.message)
        })
    })

    tech_update_btn.addEventListener("click", e => {

    })

    document.getElementById("add_task_modal").addEventListener('shown.bs.modal', function () {
        if(task_modal_focus){
            task_description.focus()
            task_modal_focus = false  
        }
    })

    document.getElementById("edit_task_modal").addEventListener('shown.bs.modal', function () {
        if(edit_task_modal_focus && edit_task_status.value != "Accomplished" && localStorage.getItem("privileges") != localStorage.getItem("restricted")){
            edit_task_description.focus()
            edit_task_modal_focus = false  
        }
    })

    document.getElementById("remarks").addEventListener('hidden.bs.modal', function () {
        remark_attachment.setAttribute("hidden","")
        remark_attachment.classList.remove("d-flex")
        remark_attachment_file.value = ""
        remark_message.value = ""
        scrollToBottom()
    })

    show_remarks_btn.addEventListener("click", e => {
        loadRemarks(show_remarks_btn.getAttribute("tid"))
    })

    // remarks_modal.show()

    function loadRemarks(tid){
        sole.post("../../controllers/st/tasks/get_remarks.php",{
            tid : tid
        }).then(res => {
            if(res.length){
                remark_container.innerHTML = ""
                res.forEach(rem => {
                    var name        = "Other User"
                    var position    = "start";
                    var rem_content = [];
                    remarkers.forEach(rems => {
                        if(rem.uid == rems.id){
                            name    = rems.name
                        }
                    })

                    if(rem.uid == localStorage.getItem("user_id")){
                        position    = "end"
                    }

                    if(rem.type == "remark_only"){
                        rem_content = rem.content.split("\n");
                        
                        remark_container.insertAdjacentHTML("beforeend",
                            `<div class="w-100 mb-2 text-`+position+`">`+
                                `<p class="m-0 remark-user text-primary">`+name+`</p>`+
                                `<p class="m-0 mb-1 text-primary remark-date">`+formatDateTime(rem.created_at)+`</p>`+
                                `<div class="w-100 d-flex justify-content-`+position+`">`+
                                    `<div class="f-14 remark-content bg-light rounded-3 p-2 text-start">`+rem_content.join("\n")+`</div>`+
                                ` </div>`+
                            `</div>`
                        )
                    }

                    if(rem.type == "file_with_remark"){
                        var store_name;
                        var disp_name;
                        var size;
                        var temp;
                        temp        = rem.content.split("***")
                        store_name  = temp[0].split("+++")[1]
                        disp_name   = temp[0].split("+++")[0]
                        size        = temp[0].split("+++")[2]

                        rem_content = temp[1].split("\n");
                        remark_container.insertAdjacentHTML("beforeend",
                            `<div class="w-100 mb-2 text-`+position+`">`+
                                `<p class="m-0 remark-user text-primary">`+name+`</p>`+
                                `<p class="m-0 mb-1 text-primary remark-date">`+formatDateTime(rem.created_at)+`</p>`+
                                `<div class="d-flex justify-content-`+position+` w-100">`+
                                    `<div sname="`+store_name+`" class="open_file text-start d-flex p-3 pb-0 mb-1 rounded-3 border remark-file">`+
                                        `<span class="fa fa-file m-2 me-2"></span>`+
                                        `<div sname="`+store_name+`" class="open_file w-100">`+
                                            `<h6 class="p-0 m-0 f-14">`+disp_name+`</h6>`+
                                            `<p sname="`+store_name+`" class="open_file f-12"><i>`+size+`</i></p>`+
                                        `</div>`+
                                    `</div>`+
                                `</div>`+
                                `<div class="w-100 d-flex justify-content-`+position+`">`+
                                    `<div class="f-14 remark-content bg-light rounded-3 p-2 text-start">`+rem_content.join("\n")+`</div>`+
                                ` </div>`+
                            `</div>`
                        )
                    }

                    if(rem.type == "file_only"){
                        var store_name;
                        var disp_name;
                        var size;
                        var temp;
                        temp        = rem.content.split("***")
                        store_name  = temp[0].split("+++")[1]
                        disp_name   = temp[0].split("+++")[0]
                        size        = temp[0].split("+++")[2]

                        remark_container.insertAdjacentHTML("beforeend",
                            `<div class="w-100 mb-2 text-`+position+`">`+
                                `<p class="m-0 remark-user text-primary">`+name+`</p>`+
                                `<p class="m-0 mb-1 text-primary remark-date">`+formatDateTime(rem.created_at)+`</p>`+
                                `<div class="d-flex justify-content-`+position+` w-100">`+
                                    `<div sname="`+store_name+`" class="open_file text-start d-flex p-3 pb-0 mb-1 rounded-3 border remark-file">`+
                                        `<span class="fa fa-file m-2 me-2"></span>`+
                                        `<div sname="`+store_name+`" class="open_file w-100">`+
                                            `<h6 class="p-0 m-0 f-14">`+disp_name+`</h6>`+
                                            `<p sname="`+store_name+`" class="open_file f-12"><i>`+size+`</i></p>`+
                                        `</div>`+
                                    `</div>`+
                                `</div>`+
                            `</div>`
                        )
                    }
                })
            }else{
                remark_container.innerHTML = "<p><i>Nothing to show.</i></p>"
            }
        })
    }

    remark_container.addEventListener("click", e => {
        if(e.target.parentNode.classList.contains("open_file")){
            const url = "../../assets/uploads/remark_file_attachments/" + e.target.parentNode.getAttribute("sname"); // or wherever your link is
            window.open(url, "_blank");
        }
    })

    // Function to scroll to bottom
    function scrollToBottom(smooth = false) {
        remark_container.scrollTo({
            top: remark_container.scrollHeight,
            behavior: smooth ? "smooth" : "auto"
        });
    }

    // MutationObserver to auto scroll on content change
    const observer = new MutationObserver(() => {
        scrollToBottom(true); // smooth scroll on update
    });

    observer.observe(remark_container, {
        childList: true,
        subtree: true,
        characterData: true
    });

    function formatDateTime(dateStr) {
        return new Date(dateStr.replace(" ", "T"))
            .toLocaleString("en-US", {
                month: "2-digit",
                day: "2-digit",
                year: "2-digit",
                hour: "2-digit",
                minute: "2-digit",
                hour12: true
            })
            .replace(",", "");
    }

    flatpickr("#task_deadline", {
        dateFormat:     "m/d/Y",
        allowInput:     true,
        disableMobile:  true,
        position:       "above"
    });
    flatpickr("#edit_task_deadline", {
        dateFormat:     "m/d/Y",
        allowInput:     true,
        disableMobile:  true,
        position:       "above"
    });


    if(localStorage.getItem("task_files") !== null){
        sole.post("../../controllers/st/tasks/delete_files_temp.php",{
            files : localStorage.getItem("task_files")
        }).then(res => {
            // console.log(res)
        })
        localStorage.setItem("task_files","");
    }

    if(localStorage.getItem("edit_task_files_temp") !== null){
        sole.post("../../controllers/st/tasks/delete_files_temp.php",{
            files : localStorage.getItem("edit_task_files_temp")
        }).then(res => {
            // console.log(res)
        })
        localStorage.setItem("task_files","");
    }

    task_file_container.addEventListener("click",e => {
        var file_to_remove = e.target.getAttribute("dname")+"=="+e.target.getAttribute("fname")
        var file_temp = localStorage.getItem("task_files").split("+++")
        file_temp = file_temp.filter(item => item !== file_to_remove);
        localStorage.setItem("task_files",file_temp.join("+++"))

        sole.post("../../controllers/st/tasks/delete_file_temp.php",{
            file : e.target.getAttribute("fname")
        }).then(res => {
            console.log(res)
        })

        if(e.target.classList.contains("task_file_remove")){
            e.target.parentNode.remove()
        }
    })

    edit_task_file_container.addEventListener("click",e => {
        var file_to_remove = e.target.getAttribute("dname")+"=="+e.target.getAttribute("fname")
        var file_temp = localStorage.getItem("edit_task_files").split("+++")
        file_temp = file_temp.filter(item => item !== file_to_remove);
        localStorage.setItem("edit_task_files",file_temp.join("+++"))
        files_to_remove.push(e.target.getAttribute("fname"))

        // sole.post("../../controllers/st/tasks/delete_file_temp.php",{
        //     file : e.target.getAttribute("fname")
        // }).then(res => {
        //     console.log(res)
        // })

        if(e.target.classList.contains("task_file_remove")){
            e.target.parentNode.remove()
        }
    })


    const MAX_SIZE = 6 * 1024 * 1024; // 5MB

    task_file_upload.addEventListener("click", () => {
        const file = task_file.files[0];
        if (!file) {
            alert("Please select a file");
            return;
        }
        if (file.size > MAX_SIZE) {
            alert("File exceeds 5MB limit");
            task_file.value = "";
            return;
        }
        const formData = new FormData();
        formData.append("file", file);
        sole.file("../../controllers/st/tasks/upload_file.php",formData).then(res => {
            if(res.status){
                localStorage.setItem("task_files",localStorage.getItem("task_files") + "+++" + res.name + "==" + res.storage_name)
                task_file_container.insertAdjacentHTML("beforeend",
                    '<div class="d-flex justify-content-between ">'+
                        '<a target="blank_" href="../../assets/uploads/task_file_attachments/'+res.storage_name+'"><span class="fa fa-download"></span> <i>'+res.name+'</i></a>'+
                        '<span dname="'+res.name+'" fname="'+res.storage_name+'" class="task_file_remove fa fa-remove text-danger mt-1 ms-2"></span>'+
                    '</div>'
                )
                task_file.value = ""
            }else{
                alert(res.message)
            }
        })
    });

    edit_task_file_upload.addEventListener("click", () => {
        const file = edit_task_file.files[0];
        if (!file) {
            alert("Please select a file");
            return;
        }
        if (file.size > MAX_SIZE) {
            alert("File exceeds 5MB limit");
            edit_task_file.value = "";
            return;
        }
        const formData = new FormData();
        formData.append("file", file);
        sole.file("../../controllers/st/tasks/upload_file.php",formData).then(res => {
            if(res.status){
                localStorage.setItem("edit_task_files",localStorage.getItem("edit_task_files") + "+++" + res.name + "==" + res.storage_name)
                localStorage.setItem("edit_task_files_temp",localStorage.getItem("edit_task_files_temp") + "+++" + res.name + "==" + res.storage_name)
                edit_task_file_container.insertAdjacentHTML("beforeend",
                    '<div class="d-flex justify-content-between ">'+
                        '<a target="blank_" href="../../assets/uploads/task_file_attachments/'+res.storage_name+'"><span class="fa fa-download"></span> <i>'+res.name+'</i></a>'+
                        '<span dname="'+res.name+'" fname="'+res.storage_name+'" class="task_file_remove fa fa-remove text-danger mt-1 ms-2"></span>'+
                    '</div>'
                )
                edit_task_file.value = ""
            }else{
                alert(res.message)
            }
        })
    });
}