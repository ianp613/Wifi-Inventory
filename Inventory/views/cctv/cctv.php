<div id="cctv">
    <div class="w-100 d-flex justify-content-between">
        <button data-bs-toggle="modal" data-bs-target="#add_cctv_map" class="btn btn-sm btn-danger"><span class="fa fa-plus"></span> Add Map</button>
        <div class="col-md-6 d-flex justify-content-end align-items-end">
            <div class="dropdown">
                <div id="equipment_dropdown_toggle" tabindex="0" title="Right-Click Equipment to Edit" class="dropdown-toggle d-inline-block" type="button" data-bs-toggle="dropdown" aria-expanded="false">-- Select Site --</div>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" id="equipment_dropdown">
                <!-- DROP DOWN SITE -->
                </ul>
            </div>
            <button data-bs-target="#manage_camera" data-bs-toggle="modal" class="btn btn-sm btn-danger" style="margin-bottom: -5px; margin-left: 10px;"><span class="fa fa-edit"></span> Manage Camera</button>
        </div>
    </div>
    <div class="w-100 d-flex justify-content-center mt-3">
        <canvas class="cctv_canvas" id="myCanvas"></canvas>
    </div>
</div>