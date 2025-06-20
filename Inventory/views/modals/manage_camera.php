<!-- MANAGE CAMERA -->
<div class="modal fade" id="manage_camera" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h6 id="manage_camera_title" class="modal-title"></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="camera_menu" id="camera_menu">
                <div class="modal-body">
                    <table  id="camera_table" class="table border table-hover">
                        <thead>
                            <tr>
                                <td class="text-start">ID</td>
                                <td class="text-start">Camera ID</td>
                                <td class="text-start">Type</td>
                                <td class="text-start">Subtype</td>
                                <td style="width: 100px; !important">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Entry Here -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <div class="btn-group btn-sm m-0">
                        <button class="btn btn-sm text-end" style="width: 120px;">Set Camera Size: </button>
                        <select name="" id="camera_size" class="form-control pt-0 pb-0" style="width: 40px; height: 31px !important;">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>    
                    </div>
                    <button id="" class="m-0 btn btn-sm btn-primary"><span class="fa fa-save"></span> Save</button>
                </div>
            </div>
            

            <div hidden class="camera_form" id="camera_form">
                <div class="modal-body">
                    <h6>Primary Information</h6>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="camera_id" class="mb-1">Alias / DVR or NVR Port No.</label>
                            <input type="text" name="" id="camera_id" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="camera_type" class="mb-1">Type</label>
                            <select name="" id="camera_type" class="form-control">
                                <option disabled value="-" selected>-- Select Type --</option>
                                <option value="Bullet Type Camera">Bullet Type Camera</option>
                                <option value="Dome Camera">Dome Camera</option>
                                <option value="Wireless Camera">Wireless Camera</option>
                                <option value="Network Camera">Network Camera</option>
                                <option value="Discreet CCTV">Discreet CCTV</option>
                                <option value="Infrared Camera">Infrared Camera</option>
                                <option value="Day/Night Type">Day/Night Type</option>
                                <option value="Varifocal Camera">Varifocal Camera</option>
                                <option value="PTZ Camera">PTZ Camera</option>
                                <option value="High Definition Camera">High Definition Camera</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="camera_subtype" class="mb-1">Subtype</label>
                            <select name="" id="camera_subtype" class="form-control">
                                <option disabled selected value="-">-- Select Subtype --</option>
                                <option value="IP Camera">IP Camera</option>
                                <option value="Coaxial Camera">Coaxial Camera</option>
                                <option value="Wi-Fi Camera">Wi-Fi Camera</option>
                                <option value="Fiber Camera">Fiber Camera</option>
                            </select>
                        </div>
                    </div>
                    <div hidden id="camera_subtype_form" class="row mb-2">
                        <div class="col-md-4">
                            <label for="camera_ip_address" class="mb-1">IP Address</label>
                            <input type="text" name="" id="camera_ip_address" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label for="camera_port_no" class="mb-1">Port No.</label>
                            <input type="text" name="" id="camera_port_no" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="camera_username" class="mb-1">Username</label>
                            <input type="text" name="" id="camera_username" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="camera_password" class="mb-1">Password</label>
                            <input type="text" name="" id="camera_password" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="camera_angle" class="mb-2">Camera Angle <i class="f-13">(°degree)</i></label>
                            <input type="number" value="0" min="0" max="360" name="" id="camera_angle" class="form-control">
                        </div>
                    </div>
                    <hr>
                    <h6>Additional Information</h6>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label for="camera_location" class="mb-2">Location</label>
                            <input type="text" name="" id="camera_location" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="camera_brand" class="mb-2">Brand</label>
                            <input type="text" name="" id="camera_brand" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-5">
                            <label for="camera_model_no" class="mb-2">Model No.</label>
                            <input required style="text-transform: uppercase" type="text" name="" id="camera_model_no" class="form-control">
                        </div>
                        <div class="col-md-5">
                            <label for="camera_barcode" class="mb-2">Barcode (FPOSI)</label>
                            <input required style="text-transform: uppercase" type="text" name="" id="camera_barcode" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label for="camera_status" class="mb-2">Status</label>
                            <select name="" id="camera_status" class="form-control">
                                <option value="UP">UP</option>
                                <option value="DOWN">DOWN</option>
                            </select>
                        </div>
                    </div>
                    <label for="camera_remarks" class="mb-2">Remarks</label>
                    <textarea maxlength="1000" rows="5" name="" id="camera_remarks" class="form-control" placeholder="Aa"></textarea>
                </div>
            </div>
            <div hidden class="camera_form_control" id="camera_form_control">
                <div class="modal-footer">
                    <button id="cancel_camera_form_btn" class="btn btn-sm btn-secondary"><span class="fa fa-remove"></span> Cancel</button>
                    <button id="save_camera_form_btn" class="btn btn-sm btn-primary"><span class="fa fa-save"></span> Save</button>
                    <button id="update_camera_form_btn" class="btn btn-sm btn-success"><span class="fa fa-save"></span> Update</button>
                </div>    
            </div>
        </div>
    </div>
</div>