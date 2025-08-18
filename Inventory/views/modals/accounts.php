<!-- CREATE ACCOUNT -->
<div class="modal fade" id="add_account" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h6 class="modal-title"><span class="fa fa-user"></span> Create Account</h6>
            </div>
            <div class="modal-body">
                <label for="add_name" class="mb-2">Name</label>
                <input required type="text" name="" id="add_name" class="form-control">
                <label for="add_email" class="mb-2 mt-2">Email <i class="f-13">(optional)</i></label>
                <input required type="text" name="" id="add_email" class="form-control">
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="add_username" class="mb-2">User ID</label>
                        <input required type="text" name="" id="add_username" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="add_password" class="mb-2">Password</label>
                        <input readonly required type="text" name="" value="12345" id="add_password" class="form-control">
                    </div>
                </div>
                <label for="add_privilege" class="mb-2 mt-2">Account Privilege</label>
                <select class="form-control" name="" id="add_privilege">
                    <option value="Administrator">Administrator</option>
                    <option value="Supervisor">Supervisor</option>
                    <option selected value="User">User</option>
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
                <button id="add_account_btn" class="btn btn-sm btn-primary"><span class="fa fa-save"></span> Save</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT ACCOUNT -->
<div class="modal fade" id="edit_account" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h6 class="modal-title" id="edit_account_title"><span class="fa fa-user"></span> Edit Account: </h6>
            </div>
            <div class="modal-body">
                <label for="edit_account_name" class="mb-2">Name</label>
                <input required type="text" name="" id="edit_account_name" class="form-control">
                <label for="edit_email" class="mb-2 mt-2">Email <i class="f-13">(optional)</i></label>
                <input required type="text" name="" id="edit_email" class="form-control">
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="edit_username" class="mb-2">User ID</label>
                        <input required type="text" name="" id="edit_username" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="edit_password" class="mb-2">Password</label>
                        <input required type="text" name="" value="12345" id="edit_password" class="form-control">
                    </div>
                </div>
                <label for="edit_privilege" class="mb-2 mt-2">Account Privilege</label>
                <select class="form-control" name="" id="edit_privilege">
                    <option value="Administrator">Administrator</option>
                    <option value="Supervisor">Supervisor</option>
                    <option selected value="User">User</option>
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
                <button id="edit_account_btn" class="btn btn-sm btn-primary"><span class="fa fa-save"></span> Save</button>
            </div>
        </div>
    </div>
</div>

<!-- DELETE ACCOUNT MODAL -->
<div class="modal fade" id="delete_account" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header text-center">
                <div class="w-100">
                    <span class="fa fa-exclamation-triangle text-danger h2"></span>
                    <h5 id="delete_entry_title" class="modal-title fw-bolder">Delete Account</h5>    
                </div>
            </div>
            <div class="modal-header text-center">
                <div class="w-100">
                    <div>You're going to delete the account of <b>"<span id="delete_account_name">Name</span>"</b>.</div>
                    <div>This can't be undone. Do you wish to proceed?</div>    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><span class="fa fa-remove"></span> No</button>
                <button id="delete_account_btn" e-id="" type="button" data-bs-dismiss="" class="btn btn-danger btn-sm"><span class="fa fa-trash-o"></span> Yes</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT ACCOUNT -->
<div class="modal fade" id="account_edit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h6 class="modal-title" id="edit_account_title"><span class="fa fa-user"></span> Account Information</h6>
            </div>
            <div class="modal-body">
                <label for="account_email" class="mb-2 mt-2">Email <i class="f-13">(recommended)</i></label>
                <input required type="text" name="" id="account_email" class="form-control">
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="account_new_password" class="mb-2">New Password</label>
                        <input required type="password" name="" id="account_new_password" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="account_confirm_password" class="mb-2">Confirm New Password</label>
                        <input required type="password" name="" id="account_confirm_password" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
                <button id="account_submit_btn" class="btn btn-sm btn-primary"><span class="fa fa-save"></span> Save</button>
            </div>
        </div>
    </div>
</div>