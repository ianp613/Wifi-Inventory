if(document.getElementById("tasks_st")){
    var task_pane               = document.getElementById("task_pane")
    var task_user_list          = document.getElementById("task_user_list")
    var add_task_btn            = document.getElementById("add_task_btn")
    var task_submit_btn         = document.getElementById("task_submit_btn")
    var task_name               = document.getElementById("task_name")
    var task_description        = document.getElementById("task_description")
    var task_note               = document.getElementById("task_note")
    var task_deadline           = document.getElementById("task_deadline")
    var buddy_list              = document.getElementById("buddy_list")
    var buddy_selected          = document.getElementById("buddy_selected")

    var pending_task_title      = document.getElementById("pending_task_title")
    var ongoing_task_title      = document.getElementById("ongoing_task_title")
    var accomplished_task_title = document.getElementById("accomplished_task_title")

    var pending_task            = document.getElementById("pending_task")
    var ongoing_task            = document.getElementById("ongoing_task")
    var accomplished_task       = document.getElementById("accomplished_task")

    var view_accomplished_task  = document.getElementById("view_accomplished_task")
    var task_empty              = document.getElementById("task_empty")

    var buddies                 = []

    const add_task_modal        = new bootstrap.Modal(document.getElementById('add_task_modal'),unclose);
    const buddy_selector        = new bootstrap.Modal(document.getElementById('buddy_selector'),unclose);
    

    sole.get("../../controllers/st/tasks/get_users.php")
    .then(res => {
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

        sole.post("../../controllers/st/tasks/get_tasks.php",{
            id : task_user_list.value
        }).then(res => {
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
        })
    }

    task_user_list.addEventListener("change", e => {
        loadTask()
    })

    add_task_btn.addEventListener("click", e => {
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

        task_submit_btn.setAttribute("uid",task_user_list.value)
        add_task_modal.show()
    })

    task_pane.addEventListener("click", e => {
        var el = e.target.parentNode
        if(el.classList.contains("tms-message-field")){
            sole.post("../../controllers/st/tasks/get_task.php",{
                id : el.getAttribute("tid")
            }).then(res => {
                console.log(res)
            })
        }
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
            id              : task_submit_btn.getAttribute("uid"),
            description     : task_description.value,
            note            : task_note.value ? task_note.value : "-",
            deadline        : task_deadline.value ? task_deadline.value : "-",
            buddies         : buddies.length ? buddies.join("|") : "-"
        }).then(res => {
            loadTask()
            task_description.value  = ""
            task_note.value  = ""
            task_deadline.value     = ""
            bs5.toast(res.type,res.message)
        })
    })

    document.getElementById("add_task_modal").addEventListener('shown.bs.modal', function () {
        task_description.focus()
    })

    flatpickr("#task_deadline", {
        dateFormat:     "m/d/Y",
        allowInput:     true,
        disableMobile:  true,
        position:       "above"
    });

}