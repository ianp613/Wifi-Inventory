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

<!-- ADD MAC ENTRY MODAL -->
<div class="modal fade" id="add_mac" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h6 id="add_mac_entry_title" class="modal-title">Add Entry to Selected Equipment</h6>    
                </div>
            </div>
            <div class="modal-body">
                <label for="add_entry_description_input" class="mb-2">Description</label>
                <input required type="text" name="" id="add_entry_description_input" class="form-control">
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="add_entry_model_no_input" class="mb-2">Model No.</label>
                        <input required style="text-transform: uppercase" type="text" name="" id="add_entry_model_no_input" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="add_entry_barcode_input" class="mb-2">Barcode (FPOSI)</label>

                        <div class="btn-group form-control m-0 p-0 form-control-nooutline">
                            <input required style="text-transform: uppercase" type="text" name="" id="add_entry_barcode_input" class="form-control">
                            <button class="btn btn-dark" id="barcode_scanner_btn"><span class="fa fa-camera"></span></button>
                        </div>
                        
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="add_entry_specifications_input" class="mb-2">Specifications</label>
                        <input required type="text" name="" id="add_entry_specifications_input" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="add_entry_status_input" class="mb-2">Status</label>
                        <select name="" id="add_entry_status_input" class="form-control">
                            <option value="" selected disabled>-- Select Status --</option>
                            <option value="Standby">Standby</option>
                            <option value="In Use">In Use</option>
                            <option value="For Status">For Status</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </div>
                </div>
                <label for="add_entry_remarks_input" class="mb-2 mt-2">Remarks</label>
                <textarea maxlength="1000" rows="5" name="" id="add_entry_remarks_input" class="form-control" placeholder="Aa"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
                <button id="add_entry_btn" type="button" data-bs-dismiss="" class="btn btn-primary btn-sm"><span class="fa fa-save"></span> Save</button>
            </div>
        </div>
    </div>
</div>