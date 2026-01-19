<div class="modal fade" id="tms_nofication_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 id="tms_time">08:00 AM</h6>
            </div>
            <div class="modal-body">
                <p id="tms_message" class="w-100 text-center mb-0">snaokekj</p>
            </div>
            <div class="modal-footer">
                <div class="w-100 text-center">
                    <button data-bs-dismiss="modal" class="btn btn-sm btn-primary rounded-pill" style="width: 50px;">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- ADD TASK -->
 <div class="modal fade" tabindex="-1" id="add_task_modal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6>Add Task: <span id="task_name"></span></h6>
            </div>
            <div class="modal-body">
                <label for="task_description">Description</label>
                <textarea name="" id="task_description" class="form-control mt-2 mb-2" rows="5" placeholder="Aa"></textarea>
                <label for="task_deadline">Deadline <i class="f-13"> (Optional)</i></label>
                <input type="text" name="" id="task_deadline" class="form-control mt-2 mb-2" placeholder="MM/DD/YYYY">
                <label for="task_co_worker">Buddies / Associates</label>
                <button class="btn btn-sm btn-primary rounded-pill ms-2" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#buddy_selector">Select</button>
                <div id="buddy_selected" class="w-100 pe-3 ps-3 pt-2 d-block">
                    <!-- BUDDIES HERE -->
                </div>
            </div>
            <div class="modal-footer">
                <div data-bs-dismiss="modal" class="btn btn-sm btn-secondary rounded-pill"><span class="fa fa-remove"></span> Cancel</div>
                <div id="task_submit_btn" class="btn btn-sm btn-primary rounded-pill"><span class="fa fa-save"></span> Submit</div>
            </div>
        </div>
    </div>
 </div>

 <!-- BUDDY SELECTOR -->
<div class="modal fade" id="buddy_selector" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6>Select Buddies / Associates</h6>
            </div>
            <div class="modal-body" id="buddy_list">
                <!-- BUDDIES HERE -->
            </div>
            <div class="modal-footer">
                <div class="btn btn-sm btn-primary rounded-pill wd-70" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#add_task_modal"><span class="fa fa-check"></span> Done</div>
            </div>
        </div>
    </div>
</div>