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
                <label for="task_location">Location</label>
                <select class="form-control mt-1 mb-2" name="" id="task_location"></select>
                <label for="task_location_others">Others <i class="f-13">(specify other location, if not present above.)</i></label>
                <input id="task_location_others" type="text" class="form-control mt-1 mb-2">
                <label for="task_description">Description</label>
                <textarea name="" id="task_description" class="form-control mt-1 mb-2" rows="3" placeholder="Aa"></textarea>
                <label for="task_note">Notes / Reminders</label>
                <textarea name="" id="task_note" class="form-control mt-1 mb-2" rows="5" placeholder="Aa"></textarea>
                <label for="task_deadline">Deadline <i class="f-13"> (Optional)</i></label>
                <input type="text" name="" id="task_deadline" class="form-control mt-1 mb-2" placeholder="MM/DD/YYYY">
                <label for="task_file">Attach Files</label>
                <div class="d-flex">
                    <input class="mt-1 mb-2 w-100" id="task_file" type="file">
                    <button id="task_file_upload" style="width: 100px;" class="btn btn-sm"><span class="fa fa-upload"></span> Upload</button> 
                </div>
                <div id="task_file_container" class="task_files_container pe-3 ps-3 pt-2 pb-3">
                    <!-- Files Here -->
                </div>
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

 <!-- EDIT TASK -->
 <div class="modal fade" tabindex="-1" id="edit_task_modal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6>Edit Task: <span id="edit_task_name"></span></h6>
                <div>
                    <button data-bs-toggle="modal" data-bs-target="#delete_task_confirmation" data-bs-dismiss="modal" id="delete_task_btn" class="btn btn-sm btn-danger rounded-pill"><span class="fa fa-trash"></span> Delete</button>
                </div>
            </div>
            <div id="edit_task_modal_body" class="modal-body">
                <div class="disabler">
                    <label id="edit_task_status_label" for="edit_task_status">Status</label>
                    <select name="" id="edit_task_status" class="form-control mt-1 mb-2"></select>
                    <label for="edit_task_location">Location</label>
                    <select name="" id="edit_task_location" class="form-control mt-1 mb-2"></select>
                    <label for="edit_task_location_others">Others <i class="f-13">(specify other location, if not present above.)</i></label>
                    <input id="edit_task_location_others" type="text" class="form-control mt-1 mb-2">
                    <label for="edit_task_description">Description</label>
                    <textarea name="" id="edit_task_description" class="form-control mt-1 mb-2" rows="3" placeholder="Aa"></textarea>
                    <label for="edit_task_note">Notes / Reminders</label>
                    <textarea name="" id="edit_task_note" class="form-control mt-1 mb-2" rows="5" placeholder="Aa"></textarea>
                    <label for="edit_task_deadline">Deadline <i class="f-13"> (Optional)</i></label>
                    <input type="text" name="" id="edit_task_deadline" class="form-control mt-1 mb-2" placeholder="MM/DD/YYYY">
                    <div class="d-flex">
                        <input class="mt-1 mb-2 w-100" id="edit_task_file" type="file">
                        <button id="edit_task_file_upload" style="width: 100px;" class="btn btn-sm"><span class="fa fa-upload"></span> Upload</button> 
                    </div>    
                </div>
                
                <div id="edit_task_file_container" class="edit_task_files_container pe-3 ps-3 pt-2 pb-3">
                    <!-- Files Here -->
                </div>

                <div class="disabler">
                    <label for="edit_task_co_worker">Buddies / Associates</label>
                    <button class="btn btn-sm btn-primary rounded-pill ms-2" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#edit_buddy_selector">Select</button>
                    <div id="edit_buddy_selected" class="w-100 pe-3 ps-3 pt-2 d-block">
                        <!-- BUDDIES HERE -->
                    </div>    
                </div>
            </div>
            <button class="btn bg-light me-3 ms-3 mb-2 fw-bold"><span class="fa fa-comments-o"></span> Remarks</button>
            <div class="modal-footer">
                <div data-bs-dismiss="modal" class="btn btn-sm btn-secondary rounded-pill"><span class="fa fa-remove"></span> Cancel</div>
                <div id="edit_task_submit_btn" class="disabler btn btn-sm btn-primary rounded-pill"><span class="fa fa-save"></span> Save</div>
            </div>
        </div>
    </div>
 </div>

<!-- EDIT BUDDY SELECTOR -->
<div class="modal fade" id="edit_buddy_selector" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6>Select Buddies / Associates</h6>
            </div>
            <div class="modal-body" id="edit_buddy_list">
                <!-- BUDDIES HERE -->
            </div>
            <div class="modal-footer">
                <div class="btn btn-sm btn-primary rounded-pill wd-70" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#edit_task_modal"><span class="fa fa-check"></span> Done</div>
            </div>
        </div>
    </div>
</div>

<!-- DELETE TASK CONFIRMATION -->
<div class="modal fade" id="delete_task_confirmation" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header text-center">
                <div class="w-100">
                    <span class="fa fa-exclamation-triangle text-danger h2"></span>
                    <h5 id="delete_network_title" class="modal-title fw-bolder">Delete Task</h5>    
                </div>
            </div>
            <div class="modal-body text-center">
                <div class="w-100">
                    <div>You're going to delete this task. This action cannot be undone. Do you wish to proceed?</div>    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm rounded-pill" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#edit_task_modal"><span class="fa fa-remove"></span> No</button>
                <button id="delete_task_btn_confirm" type="button" class="btn btn-danger btn-sm rounded-pill"><span class="fa fa-trash"></span> Yes</button>
            </div>
        </div>
    </div>
</div>


