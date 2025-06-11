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
                    <option value="Senior Technician">Senior Technician</option>
                    <option value="Assistant Technician" selected>Assistant Technician</option>
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
                    <option value="Senior Technician">Senior Technician</option>
                    <option value="Assistant Technician" selected>Assistant Technician</option>
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
                <button id="edit_account_btn" class="btn btn-sm btn-primary"><span class="fa fa-save"></span> Save</button>
            </div>
        </div>
    </div>
</div>

