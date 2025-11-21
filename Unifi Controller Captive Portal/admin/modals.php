<div class="modal fade" tabindex="-1" id="authentication">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6><span class="fa fa-lock"></span> Authentication</h6>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="voucher">
                    <label class="form-check-label" for="voucher">Voucher</label>
                </div>
            </div>
            <div class="modal-body">
                <div id="default_">
                    <div class="d-flex">
                        <div class="col-md-6 pe-1">
                            <label for="expiration">Usage Time</label>
                            <input type="number" name="" id="expiration" class="form-control mt-2">
                        </div>
                        <div class="col-md-6 ps-1">
                            <label for="expiration">Unit</label>
                            <select class="form-control mt-2" name="" id="expiration_type">
                                <option value="1">Minutes</option>
                                <option value="60">Hours</option>
                                <option value="1440">Days</option>
                            </select>
                        </div>
                    </div>
                </div>



                <div id="voucher_">
                    <div class="d-flex">
                        <div class="col-md-10 pe-1">
                            <label for="voucher_name">Voucher Name</label>
                            <input type="text" name="" id="voucher_name" class="form-control mt-2">
                        </div>
                        <div class="col-md-2 ps-1">
                            <label for="voucher_amount">Amount</label>
                            <input type="number" name="" id="voucher_amount" class="form-control mt-2" value="1">
                        </div>
                    </div>

                    <div id="voucher_use_" class="d-flex mt-3">
                        <div class="form-check form-check-inline">
                            <input checked class="form-check-input" type="radio" name="inlineRadioOptions" id="single" value="single">
                            <label class="form-check-label" for="single"><h6>Single-use</h6></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="multiple" value="multiple">
                            <label class="form-check-label" for="multiple"><h6>Multiple-use</h6></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="unlimited" value="unlimited">
                            <label class="form-check-label" for="unlimited"><h6>Unlimited</h6></label>
                        </div>
                    </div>

                    <div hidden id="upv_" class="mt-2">
                        <div class="col-md-4">
                            <label for="voucher_use_per_voucher">Use Per Voucher</label>
                            <input type="number" name="" id="voucher_use_per_voucher" class="form-control mt-2" value="2">
                        </div>
                    </div>

                    <div class="d-flex mt-2">
                        <div class="col-md-6 pe-1">
                            <label for="voucher_expiration">Usage Time</label>
                            <input type="number" name="" id="voucher_expiration" class="form-control mt-2">
                        </div>
                        <div class="col-md-6 ps-1">
                            <label for="voucher_expiration">Unit</label>
                            <select class="form-control mt-2" name="" id="voucher_expiration_type">
                                <option value="1">Minutes</option>
                                <option value="60">Hours</option>
                                <option value="1440">Days</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</div>
                <div id="authentication_save" class="btn btn-sm btn-primary"><span class="fa fa-save"></span> Save</div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="voucher_m">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6><span class="fa fa-ticket"></span> Vouchers</h6>
                <button data-bs-dismiss="modal" class="btn btn-sm btn-light"><span class="fa fa-remove"></span></button>
            </div>
            <div class="modal-body" style="overflow-x: auto;">
                <table class="table table-hover" id="tb_voucher">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td >Name</td>
                            <td>Code</td>
                            <td>Usage Time</td>
                            <td>Use per voucher</td>
                            <td style="width: 80px;">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data Here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="usergroups">
    <div id="ugdialog" class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex">
                    <h6><span class="fa fa-tags mt-2"></span> User Groups</h6> 
                    <button id="ugcreate" class="btn btn-sm btn-secondary ms-3"><span class="fa fa-plus"></span> Create</button>   
                </div>
                
                <button data-bs-dismiss="modal" class="btn btn-sm btn-light"><span class="fa fa-remove"></span></button>
            </div>
            <div class="modal-body">
                <div id="ugtb_cont">
                    <table class="table table-hover" id="tb_usergroup">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Name</td>
                                <td>Download Limit</td>
                                <td>Upload Limit</td>
                                <td style="width: 80px;">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- DATA HERE -->
                        </tbody>
                    </table>
                </div>
                <div hidden id="ugform_cont">
                    <label for="ugname">Name</label>
                    <input type="text" name="" id="ugname" class="form-control mt-2">
                    <div class="d-flex mt-2">
                        <div class="col-md-6 pe-1">
                            <label for="ugdownload_limit">Download Limit [Mbps]</label>
                            <input type="number" name="" id="ugdownload_limit" class="form-control mt-2">
                        </div>
                        <div class="col-md-6 ps-1">
                            <label for="ugupload_limit">Upload Limit [Mbps]</label>
                            <input type="number" name="" id="ugupload_limit" class="form-control mt-2">
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-end pt-3">
                        <button id="ugcancel" class="btn btn-sm btn-secondary"><span class="fa fa-remove"></span> Cancel</button>
                        <button id="ugsave" class="btn btn-sm btn-primary"><span class="fa fa-save"></span> Save</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>