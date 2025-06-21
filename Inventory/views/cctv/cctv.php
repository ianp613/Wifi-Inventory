<div id="cctv">
    <div class="w-100 d-flex justify-content-between">
        <div>
            <button data-bs-toggle="modal" data-bs-target="#add_cctv_map" class="btn btn-sm btn-danger"><span class="fa fa-plus"></span> Add Map</button>
            <button hidden id="save_map_btn" class="btn btn-sm btn-secondary"><span class="fa fa-download"></span> Save Map</button>    
        </div>
        
        <div class="col-md-6 d-flex justify-content-end align-items-end">
            <div class="dropdown">
                <div id="cctv_dropdown_toggle" tabindex="0" title="Right-Click cctv to Edit" class="dropdown-toggle d-inline-block" type="button" data-bs-toggle="dropdown" aria-expanded="false">-- Select Map --</div>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" id="cctv_dropdown">
                <!-- DROP DOWN SITE -->
                </ul>
            </div>
            <button id="manage_camera_btn" class="btn btn-sm btn-danger" style="margin-bottom: -5px; margin-left: 10px;"><span class="fa fa-edit"></span> Manage Camera</button>
        </div>
    </div>
    <div class="w-100 d-flex justify-content-center mt-3">
        <canvas hidden class="cctv_canvas" id="cctvCanvas"></canvas>
    </div>
</div>