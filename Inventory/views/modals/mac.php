<!-- ADD WIFI MODAL -->
<div class="modal fade" id="add_wifi" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Add Wifi</h6>
            </div>
            <div class="modal-body">
                <label for="wifi_name">Wifi Name</label>
                <input type="text" name="" id="wifi_name" class="form-control mt-2 mb-2">
                <label for="wifi_password">Password</label>
                <input type="text" name="" id="wifi_password" class="form-control mt-2">
            </div>
            <div class="modal-footer">
                <button data-bs-dismiss="modal" class="btn btn-sm btn-secondary"><span class="fa fa-remove"></span> Cancel</button>
                <button id="add_wifi_btn" class="btn btn-sm btn-primary"><span class="fa fa-save"></span> Save</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT WIFI MODAL -->
<div class="modal fade" id="edit_wifi" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Wifi Info</h6>
                <button class="btn btn-danger btn-sm" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#delete_wifi"><span class="fa fa-trash"></span></button>
            </div>
            <div class="modal-body">
                <label for="edit_wifi_name">Wifi Name</label>
                <input type="text" name="" id="edit_wifi_name" class="form-control mt-2 mb-2">
                <label for="edit_wifi_password">Password</label>
                <input type="text" name="" id="edit_wifi_password" class="form-control mt-2">
            </div>
            <div class="modal-footer">
                <button data-bs-dismiss="modal" class="btn btn-sm btn-secondary"><span class="fa fa-remove"></span> Cancel</button>
                <button id="edit_wifi_btn" class="btn btn-sm btn-primary"><span class="fa fa-save"></span> Save</button>
            </div>
        </div>
    </div>
</div>

<!-- DELETE WIFI MODAL -->

<!-- DELETE wifi MODAL -->
<div class="modal fade" id="delete_wifi" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header text-center">
                <div class="w-100">
                    <span class="fa fa-exclamation-triangle text-danger h2"></span>
                    <h5 id="delete_wifi_title" class="modal-title fw-bolder">Delete Wifi</h5>    
                </div>
            </div>
            <div class="modal-header text-center">
                <div class="w-100">
                    <div>You're going to delete wifi <b>"<span id="delete_wifi_name">WIFI</span>"</b>.</div>
                    <div>All of the recorded MAC address will also be deleted, this can't be undone. Do you wish to proceed?</div>    
                </div>
            </div>
            <div class="modal-footer">
                <div id="delete_ready_state_wifi">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#edit_wifi"><span class="fa fa-remove"></span> No</button>
                    <button id="delete_wifi_btn" type="button" data-bs-dismiss="" class="btn btn-danger btn-sm"><span class="fa fa-trash-o"></span> Yes</button>
                </div>
                <div id="delete_saving_state_wifi" style="display: none;">
                    <button class="btn btn-danger btn-sm" type="button">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Deleting
                    </button>    
                </div>
            </div>
        </div>
    </div>
</div>