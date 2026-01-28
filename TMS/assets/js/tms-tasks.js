if(document.getElementById("tasks_st")){
    var task_pane                       = document.getElementById("task_pane")
    var task_user_list                  = document.getElementById("task_user_list")
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
    var task_file_temp                  = []

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

    var edit_task_location              = document.getElementById("edit_task_location")
    var edit_task_location_others       = document.getElementById("edit_task_location_others")

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

    var buddies                         = []
    var edit_buddies                    = []
    var status_                         = ["Pending","Ongoing","Accomplished"]

    var task_modal_focus                = false;
    var edit_task_modal_focus           = false;
    
    var users                           = []
    var locations                       = []

    const add_task_modal                = new bootstrap.Modal(document.getElementById('add_task_modal'),unclose);
    const edit_task_modal               = new bootstrap.Modal(document.getElementById('edit_task_modal'),unclose);
    const buddy_selector                = new bootstrap.Modal(document.getElementById('buddy_selector'),unclose);
    const edit_buddy_selector           = new bootstrap.Modal(document.getElementById('edit_buddy_selector'),unclose);
    const delete_task_confirmation      = new bootstrap.Modal(document.getElementById('delete_task_confirmation'),unclose);






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

                console.log(res)
                delete_task_btn.hidden      = res["task"][0].status == "Pending" ? false : true
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

                if(res["task"][0].status == "Accomplished"){
                    edit_task_status.hidden         = true
                    edit_task_status_label.hidden   = true
                    edit_task_modal_body.setAttribute("style","pointer-events: none;")
                    edit_task_submit_btn.setAttribute("style","pointer-events: none;")
                }else{
                    edit_task_status.hidden         = false
                    edit_task_status_label.hidden   = false
                    edit_task_modal_body.removeAttribute("style")
                    edit_task_submit_btn.removeAttribute("style")
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
                    res.forEach(user => {
                        buddies_ = res
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
                    });
                })
                delete_task_btn.setAttribute("tid",res["task"][0].id)
                edit_task_submit_btn.setAttribute("tid",res["task"][0].id)
                edit_task_modal.show()
            })
        }
    })

    delete_task_btn_confirm.addEventListener("click", e => {
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
        if(!task_description.value){
            bs5.toast("warning","Please input description.")
            return
        }

        sole.post("../../controllers/st/tasks/add_task.php",{
            id              : task_submit_btn.getAttribute("aid"),
            location        : task_location_others.value ? task_location_others.value : task_location.value,
            description     : task_description.value,
            note            : task_note.value ? task_note.value : "-",
            deadline        : task_deadline.value ? task_deadline.value : "-",
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
            bs5.toast(res.type,res.message)
        })
    })

    edit_task_submit_btn.addEventListener("click", e => {
        if(!edit_task_description.value){
            bs5.toast("warning","Please input description.")
            return
        }
        sole.post("../../controllers/st/tasks/edit_task.php",{
            id              : edit_task_submit_btn.getAttribute("tid"),
            location        : edit_task_location_others.value ? edit_task_location_others.value : edit_task_location.value,
            description     : edit_task_description.value,
            note            : edit_task_note.value ? edit_task_note.value : "-",
            deadline        : edit_task_deadline.value ? edit_task_deadline.value : "-",
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
            bs5.toast(res.type,res.message)
        })
    })

    document.getElementById("add_task_modal").addEventListener('shown.bs.modal', function () {
        if(task_modal_focus){
            task_description.focus()
            task_modal_focus = false  
        }
    })

    document.getElementById("edit_task_modal").addEventListener('shown.bs.modal', function () {
        if(edit_task_modal_focus && edit_task_status.value != "Accomplished"){
            edit_task_description.focus()
            edit_task_modal_focus = false  
        }
        
    })

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

    // localStorage.removeItem("task_files")
    if(localStorage.getItem("task_files") !== null){
        var file_temp = localStorage.getItem("task_files").split("+++")
        if(!file_temp.length){
            exit
        }
        if(file_temp[0] == "null"){
            file_temp.shift()
        }
        console.log(file_temp)
        file_temp.forEach(file => {
            if(file != 'null'){
                task_file_container.insertAdjacentHTML("beforeend",
                    '<div class="d-flex justify-content-between ">'+
                        '<a target="blank_" href="../../assets/uploads/task_file_attachments/'+file.split("==")[1]+'"><span class="fa fa-download"></span> <i>'+file.split("==")[0]+'</i></a>'+
                        '<span fname="'+file.split("==")[1]+'" class="task_file_remove fa fa-remove text-danger mt-1 ms-2"></span>'+
                    '</div>'
                )
            }
        })
    }


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
                        '<span fname="'+res.storage_name+'" class="task_file_remove fa fa-remove text-danger mt-1 ms-2"></span>'+
                    '</div>'
                )
                task_file.value = ""
            }else{
                alert(res.message)
            }
        })

        // fetch("upload.php", {
        //     method: "POST",
        //     body: formData
        // })
        // .then(res => res.text())
        // .then(data => msg(data))
        // .catch(() => msg("Upload failed"));
    });

    function msg(text) {
        alert(text)
    }

}