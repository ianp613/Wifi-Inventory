<div id="qr_generator_modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">QR Code Generator</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="qr_type">QR Type</label>
                        <select name="qr_type" id="" class="form-control mt-2">
                            <option value="text">Text QR Code</option>
                            <option value="wifi">Wifi QR Code</option>
                        </select>    
                    </div>
                    <div class="col-md-6">
                        <label for="qr_logo_overlay">Logo Overlay</label>
                        <select name="qr_logo_overlay" id="" class="form-control mt-2">
                            <option value="none">None</option>
                            <option value="default">Default Logo</option>
                            <option value="custom">Custom Logo</option>
                        </select>    
                    </div>
                </div>
                <div id="qr_type_text">
                    <label for="qr_text" class="mb-2 mt-2">Text <i class="f-13">(Max Length: 300 Characters)</i></label>
                    <textarea maxlength="300" rows="5" name="" id="qr_text" class="form-control" placeholder="Aa"></textarea>
                </div>
                <div id="qr_type_wifi">
                    <label for="qr_ssid" class="mb-2 mt-2">Wifi SSID</label>
                    <input required type="text" name="qr_ssid" id="qr_ssid" class="form-control">
                    <label for="qr_key" class="mb-2 mt-2">Wifi Key</label>
                    <input required type="text" name="qr_key" id="qr_key" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button class="w-100 btn btn-success"><span class="fa fa-qrcode"></span> Generate</button>
            </div>
        </div>
    </div>
</div>