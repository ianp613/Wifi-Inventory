if(document.getElementById("tasks_st")){
    var task_user_list          = document.getElementById("task_user_list")
    var add_task_btn            = document.getElementById("add_task_btn")
    var task_submit_btn         = document.getElementById("task_submit_btn")
    var task_name               = document.getElementById("task_name")
    var task_description        = document.getElementById("task_description")
    var task_deadline           = document.getElementById("task_deadline")
    var buddy_list              = document.getElementById("buddy_list")
    var buddy_selected          = document.getElementById("buddy_selected")

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

    add_task_btn.addEventListener("click", e => {
        if (!task_user_list.value) return

        buddy_list.innerText        = ""
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

    task_user_list.addEventListener("change", e =>{
        buddy_selected.innerHTML    = "<i>No Buddy Selected</i>"
        buddies                     = []
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