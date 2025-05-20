<!-- ADD Router MODAL -->
<div class="modal fade" id="add_router" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Add Router</h6>
            </div>
            <div class="modal-body">
                <label for="router_name" class="mb-2">Name</label>
                <input required type="text" name="router_name" id="router_name" class="form-control">
                <div class="row mb-2 mt-2">
                    <div class="col-md-6">
                        <label for="router_ip" class="mb-2">IP Address</label>
                        <input required type="text" name="router_ip" id="router_ip" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="router_subnet" class="mb-2">Subnet Mask</label>
                        <input required type="text" name="router_subnet" id="router_subnet" class="form-control">
                    </div>
                </div>
                <h6 class="mt-3">WAN Settings</h6>
                <hr>



                <div class="w-100 d-flex justify-content-between mb-2">
                    <label for="router_wan1" class="mb-2">WAN 1 <i>(Primary)</i></label>
                    <img hidden id="router_wan1_icon" src="../../assets/img/hero.png" class="ht-30"  style="margin-top: -5px;" alt="" srcset="">
                </div>
                <select name="router_wan1" id="router_wan1" class="form-control">
                    <option value="" disabled selected>-- Select WAN 1 --</option>
                </select>
                <div class="ht-160 p-2">
                    <!-- Name: 2nd Floor Annex Main Line <br>
                    WAN IP: 192.168.15.225 <br>
                    Subnet Mask: 255.255.248.0 <br>
                    Gateway: 192.168.15.254 <br>
                    DNS 1: 8.8.8.8 <br>
                    DNS 2: 8.8.4.4 <br> -->
                    <!-- ISP INFO -->
                </div>



                <div class="w-100 d-flex justify-content-between mb-2">
                    <label for="router_wan2" class="mb-2">WAN 2 <i>(Secondary)</i></label>
                    <img hidden id="router_wan2_icon" src="../../assets/img/hero.png" class="ht-30"  style="margin-top: -5px;" alt="" srcset="">
                </div>
                <select name="router_wan2" id="router_wan2" class="form-control">
                    <option value="" disabled selected>-- Select WAN 2 --</option>
                </select>
                <div class="ht-160 p-2">
                    <!-- ISP INFO -->
                </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
                <button id="add_isp_btn" type="button" class="btn btn-primary btn-sm"><span class="fa fa-save"></span> Save</button>    
            </div>     
        </div>
    </div>
</div>