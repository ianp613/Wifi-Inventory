<!-- ADD NETWORK MODAL -->
<div class="modal fade" id="add_network" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Add Network</h6>
            </div>
            <div class="modal-body">
                <label for="network_name" class="mb-2">Network Name</label>
                <input required type="text" name="network_name" id="network_name" class="form-control mb-2">
                <label for="ip_range_from" class="mb-2">IP Range <i class="f-13 text-danger">(Can't be edited after saving.)</i></label>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <input required type="text" name="ip_range_from" id="ip_range_from" class="form-control" placeholder="FROM">
                    </div>
                    <div class="col-md-6">
                        <input required type="text" name="ip_range_to" id="ip_range_to" class="form-control" placeholder="TO">
                    </div>
                </div>
                <label for="ip_subnet" class="mb-2">Subnet Mask</i></label>
                <input required type="text" name="ip_subnet" id="ip_subnet" class="form-control mb-2">
            </div>
            <div class="modal-footer" style="display: flex;">
                <div id="ready_state">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
                    <button id="add_network_btn" type="button" class="btn btn-primary btn-sm"><span class="fa fa-save"></span> Save</button>    
                </div>
                <div id="saving_state" style="display: none;">
                    <button class="btn btn-primary btn-sm" type="button">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Saving
                    </button>    
                </div>
            </div>     
        </div>
    </div>
</div>

<!-- EDIT NETWORK MODAL -->
<div class="modal fade" id="edit_network" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Network Info</h6>
                <button class="btn btn-danger btn-sm" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#delete_network"><span class="fa fa-trash"></span></button>
            </div>
            <div class="modal-body">
                <label for="edit_network_name" class="mb-2">Network Name</label>
                <input required type="text" name="edit_network_name" id="edit_network_name" class="form-control mb-2">
                <label for="ip_range_from" class="mb-2">IP Range <i class="f-13 text-danger">(Can't be edited.)</i></label>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <input required disabled type="text" name="edit_ip_range_from" id="edit_ip_range_from" class="form-control" placeholder="FROM">
                    </div>
                    <div class="col-md-6">
                        <input required disabled type="text" name="edit_ip_range_to" id="edit_ip_range_to" class="form-control" placeholder="TO">
                    </div>
                </div>
                <label for="edit_ip_subnet" class="mb-2">Subnet Mask</i></label>
                <input required type="text" name="edit_ip_subnet" id="edit_ip_subnet" class="form-control mb-2">
            </div>
            <div class="modal-footer" style="display: flex;">
                <div id="edit_ready_state">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
                    <button id="edit_network_btn" type="button" class="btn btn-primary btn-sm"><span class="fa fa-save"></span> Save</button>    
                </div>
                <div id="edit_saving_state" style="display: none;">
                    <button class="btn btn-primary btn-sm" type="button">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Saving
                    </button>    
                </div>
            </div>     
        </div>
    </div>
</div>

<!-- DELETE NETWORK MODAL -->
<div class="modal fade" id="delete_network" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header text-center">
                <div class="w-100">
                    <span class="fa fa-exclamation-triangle text-danger h2"></span>
                    <h5 id="delete_network_title" class="modal-title fw-bolder">Delete Network</h5>    
                </div>
            </div>
            <div class="modal-header text-center">
                <div class="w-100">
                    <div>You're going to delete network "<b><span id="delete_network_name">NETWORK</span></b>".</div>
                    <div>All of the recorded IP address will also be deleted, this can't be undone. Do you wish to proceed?</div>    
                </div>
            </div>
            <div class="modal-footer">
                <div id="delete_ready_state">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#edit_network"><span class="fa fa-remove"></span> No</button>
                    <button id="delete_network_btn" type="button" data-bs-dismiss="" class="btn btn-danger btn-sm"><span class="fa fa-trash-o"></span> Yes</button>
                </div>
                <div id="delete_saving_state" style="display: none;">
                    <button class="btn btn-danger btn-sm" type="button">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Deleting
                    </button>    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- EDIT EQUIPMENT MODAL -->
<!-- <div class="modal fade" id="edit_equipment" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Edit Equipment</h6>
            </div>
            <div class="modal-body">
                <label for="edit_equipment_input" class="mb-2">Equipment Name</label>
                <input required type="text" name="" id="edit_equipment_input" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
                <button id="edit_equipment_btn" type="button" class="btn btn-warning btn-sm"><span class="fa fa-save"></span> Save</button>
            </div>
        </div>
    </div>
</div> -->

<!-- ADD ENTRY MODAL -->
<!-- <div class="modal fade" id="add_entry" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h6 id="add_entry_title" class="modal-title">Add Entry to Selected Equipment</h6>    
                    <div style="color: #ff0000;"><i>*Note: put <b>N/A</b> if not applicable.</i></div>
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
                        <input required style="text-transform: uppercase" type="text" name="" id="add_entry_barcode_input" class="form-control">
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
</div> -->

<!-- EDIT IP MODAL -->
<div class="modal fade" id="edit_ip" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h6 id="edit_ip_title" class="modal-title">Edit Selected IP</h6>    
                </div>
            </div>
            <div class="modal-body">
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="hostname" class="mb-2">Hostname</label>
                        <input required type="text" name="" id="hostname" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="site" class="mb-2">Site / Location</label>
                        <input required type="text" name="" id="site" class="form-control">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="server" class="mb-2">Server</label>
                        <input required type="text" name="" id="server" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="webmgmtpt" class="mb-2">Web Management Port</label>
                        <input required type="text" name="" id="webmgmtpt" class="form-control">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="username" class="mb-2">Username</label>
                        <input required type="text" name="" id="username" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="mb-2">Password</label>
                        <div class="ps-field">
                            <input type="password" id="password" class="form-control">
                            <span id="togglePassword" class="fa fa-eye-slash text-secondary"></span>
                        </div>
                    </div>
                </div>
                <label for="edit_entry_remarks_input" class="mb-2 mt-2">Remarks</label>
                <textarea maxlength="1000" rows="5" name="" id="edit_entry_remarks_input" class="form-control" placeholder="Aa"></textarea>
            </div>
            <!-- <div class="modal-body">
                <label for="edit_entry_description_input" class="mb-2">Description</label>
                <input required type="text" name="" id="edit_entry_description_input" class="form-control">
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="edit_entry_model_no_input" class="mb-2">Model No.</label>
                        <input required style="text-transform: uppercase" type="text" name="" id="edit_entry_model_no_input" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="edit_entry_barcode_input" class="mb-2">Barcode (FPOSI)</label>
                        <input required style="text-transform: uppercase" type="text" name="" id="edit_entry_barcode_input" class="form-control">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="edit_entry_specifications_input" class="mb-2">Specifications</label>
                        <input required type="text" name="" id="edit_entry_specifications_input" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="edit_entry_status_input" class="mb-2">Status</label>
                        <select name="" id="edit_entry_status_input" class="form-control">
                            <option value="" selected disabled>-- Select Status --</option>
                            <option value="Standby">Standby</option>
                            <option value="In Use">In Use</option>
                            <option value="For Status">For Status</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </div>
                </div>
                <label for="edit_entry_remarks_input" class="mb-2 mt-2">Remarks</label>
                <textarea maxlength="1000" rows="5" name="" id="edit_entry_remarks_input" class="form-control" placeholder="Aa"></textarea>
            </div> -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
                <button id="edit_ip_btn" type="button" data-bs-dismiss="" class="btn btn-primary btn-sm"><span class="fa fa-save"></span> Save</button>
            </div>
        </div>
    </div>
</div>

<!-- IMPORT MODAL -->
<div class="modal" id="import_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header text-center">
                <div id="import_message" class="w-100 text-center"></div>
            </div>
        </div>
    </div>
</div>

<!-- DELETE ENTRY MODAL -->
<!-- <div class="modal fade" id="delete_entry" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header text-center">
                <div class="w-100">
                    <span class="fa fa-exclamation-triangle text-danger h2"></span>
                    <h5 id="delete_entry_title" class="modal-title fw-bolder">Delete Entry</h5>    
                </div>
            </div>
            <div class="modal-header text-center">
                <div class="w-100">
                    <div>You're going to delete "<b><span id="delete_entry_name">AiOS Mac 10Gbits Monitoring FS</span></b>" entry.</div>
                    <div>This can't be undone. Do you wish to proceed?</div>    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><span class="fa fa-remove"></span> No</button>
                <button id="delete_entry_btn" e-id="" type="button" data-bs-dismiss="" class="btn btn-danger btn-sm"><span class="fa fa-trash-o"></span> Yes</button>
            </div>
        </div>
    </div>
</div> -->

<!-- FOR STATUS MODAL -->
<!-- <div class="modal" id="for_status" tabindex="-1">
    <div class="modal-dialog  modal-dialog-scrollable modal-fullscreen modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">FOR STATUS</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="w-100 text-dark">
                    <div class="ms-5 me-5 mt-2">
                        <div class="w-100 row border border-dark">
                            <div class="col-md-3 p-0 d-flex align-items-center justify-content-center">
                                <img class="w-100 ht-80" src="../../assets/img/fposi-logo.png" alt="">
                            </div>
                            <div class="col-md-7 p-0 text-center border-start border-end border-dark">
                                <div class="pt-2 f-12 ht-35 border-bottom border-dark">Information Security Management System</div>
                                <div class="p-3 ht-70 d-flex align-items-center justify-content-center">
                                    <h6>Hardware Status Report For Computer Parts</h6>
                                </div>
                            </div>
                            <div class="p-0 col-md-2 f-10 fw-bold">
                                <div class="ht-35 border-bottom border-dark">
                                    <div class="ps-1">Document Form No.</div>
                                    <div class="w-100 text-center fw-bold">ISMS-IT-FR-075</div>    
                                </div>
                                <div class="ht-25  border-bottom border-dark"></div>
                                <div class="ps-1 p-1">Record Control No.085</div>
                                <div class="ht-25  border-top border-dark"></div>
                            </div>
                        </div>    
                    </div>
                    <div class="ms-5 me-5 mt-3 fw-bold">
                        <div class="d-flex mb-1">
                            <h6 class="fw-bold f-12 wd-60 text-end mr-3">SITE:</h6>
                            <span style="margin-left: 10px; margin-top: -2px; width: 200px;" class="f-11 border-bottom border-dark text-center">FPOSI MAIN BUILDING, 2ND FLOOR</span>    
                        </div>
                        <div class="d-flex mb-1">
                            <h6 class="fw-bold f-12 wd-60 text-end mr-3">PROJECT:</h6>
                            <span style="margin-left: 10px; margin-top: -2px; width: 200px;" class="f-11 border-bottom border-dark text-center">IT DEPARTMENT</span>    
                        </div>
                        <div class="d-flex mb-1">
                            <h6 class="fw-bold f-12 wd-60 text-end mr-3">SITE:</h6>
                            <span style="margin-left: 10px; margin-top: -2px; width: 200px;" class="f-11 border-bottom border-dark text-center">04/09/2025</span>    
                        </div>
                    </div>
                    <div class="ms-5 me-5 mt-3">
                        <div class="row w-100 border pt-1 border-dark">
                            <div class="col-md-10">
                                <p class="f-9"><i>This material is intended for FPOSI use only. It must not be reproduced in whole or in part, in any form, or by any means without a formal agreement or the written consent of the Document Record Controller (DRC) or Information Security Management Representative (ISMR). Any hard copy or unprotected soft copy of this document shall be regarded as uncontrolled copy.</i></p>
                            </div>
                            <div class="col-md-1 f-9">
                                <div>Document Class:</div>
                                <div>INTERNAL</div>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm"><span class="fa fa-download"></span> Download</button>
                <button id="edit_equipment_btn" type="button" class="btn btn-primary btn-sm"><span class="fa fa-print"></span> Print</button>
            </div>
        </div>
    </div>
</div> -->