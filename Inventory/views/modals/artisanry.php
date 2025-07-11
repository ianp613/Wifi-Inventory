<div id="qr_generator_modal" class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">QR Code Generator</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="border rounded-3 p-3">
                            <label for="qr_type" class="mb-2 fwt-5">Select QR Code Type</label>
                            <select name="qr_type" id="qr_type" class="form-control wd-150 text-secondary"  style="font-family: 'FontAwesome', sans-serif;">
                                <option value="text">&#xf15c Text</option>
                                <option value="wifi">&#xf1eb Wifi</option>
                                <option value="email">&#xf0e0 Email</option>
                                <option value="url">&#xf0c1 URL</option>
                            </select>
                            <div hidden id="qr_text_container" class="mt-3">
                                <textarea maxlength="300" rows="5" name="qr_text" id="qr_text" class="form-control text-secondary fw-bolder" placeholder="Enter your text"></textarea>
                            </div>
                            <div id="qr_wifi_container" class="mt-3">
                                <label for="qr_ssid" class="mb-2">Network Name</label>
                                <div class="d-flex w-100">
                                    <input type="text" class="form-control wd-500" placeholder="SSID"> 
                                    <input class="ms-4" type="checkbox" value="" id="flexCheckDefault">
                                    <label style="margin-top: 6px !important; margin-left: 5px;" for="flexCheckDefault">Hidden</label>
                                </div>
                                <label for="qr_password" class="mb-2 mt-2">Password</label>
                                <input type="text" class="form-control"> 
                                <label for="qr_encryption" class="mb-2 mt-2">Encryption</label>
                                <select name="qr_encryption" id="qr_encryption" class="form-control wd-150 text-secondary"  style="font-family: 'FontAwesome', sans-serif;">
                                    <option value="none">None</option>
                                    <option value="wpa/wpa2">WPA/WPA2</option>
                                    <option value="wep">WEP</option>
                                </select>
                            </div>
                            <button class="btn btn-success alert-success rounded-pill fw-bolder mt-5 mb-2"><span class="fa fa-refresh"></span> GENERATE QR CODE</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded-3 p-3">
                            <div id="qr_preview" class="w-100 text-center image-wrapper">
                                <img class="wd-180" src="../../assets/img/artisanry/qr-hello.png" alt="">
                            </div>
                        </div>
                        <div class="mt-2">
                            <label for="">QR Color</label>
                            <input type="color" class="btn btn-light p-1">
                        </div>
                        <button class="mt-5 ht-55 btn btn-primary w-100 d-flex justify-content-center fw-bolder"><span class="fa fa-download mt-2 f-20 me-2"></span><div>DOWNLOAD <br> <p class="f-13" style="margin-top: -4px;">PNG</p></div></button>
                    </div>
                </div>
                
        </div>
    </div>
</div>