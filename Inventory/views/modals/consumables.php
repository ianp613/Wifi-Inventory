<div class="modal" id="add_consumables" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6>Add Consumable</h6>
            </div>
            <div class="modal-body">
                <label id="consumable_code">Code: <b>0</b></label>
                <hr>
                <label for="consumable_description">Description</label>
                <input type="text" name="" id="consumable_description" class="form-control mt-2">
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="consumable_stock">Stock</label>
                        <input type="number" min="0" value="0" name="" id="consumable_stock" class="form-control mt-2">
                    </div>
                    <div class="col-md-6">
                        <label for="consumable_restock_point">Restock Point</label>
                        <input type="number" min="0" value="0" name="" id="consumable_restock_point" class="form-control mt-2">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button data-bs-dismiss="modal" class="btn btn-sm btn-secondary"><span class="fa fa-remove"></span> Cancel</button>
                <button id="add_consumables_btn" class="btn btn-sm btn-primary"><span class="fa fa-save"></span> Save</button>
            </div>
        </div>
    </div>
</div>