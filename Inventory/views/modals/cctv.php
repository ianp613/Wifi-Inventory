<!-- ADD CCTV SITE -->
<div class="modal fade" id="add_cctv_map" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Add CCTV Site</h6>
            </div>
            <div class="modal-body">
                <label for="map_location" class="mb-2">Location</label>
                <input required type="text" name="map_location" id="map_location" class="form-control">
                <label for="floorplan" class="mb-2 mt-2">Select Floor Plan</label>
                <input required accept="image/*" type="file" name="floorplan" id="floorplan" class="form-control">
                <label for="map_remarks" class="mb-2 mt-2">Remarks</label>
                <textarea maxlength="1000" rows="5" name="" id="map_remarks" class="form-control" placeholder="Aa"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
                <button id="add_site_btn" type="button" class="btn btn-primary btn-sm"><span class="fa fa-save"></span> Save</button>    
            </div>     
        </div>
    </div>
</div>