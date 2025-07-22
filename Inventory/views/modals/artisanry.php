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
                                <option value="0">&#xf15c Text</option>
                                <option value="1">&#xf1eb Wifi</option>
                                <option disabled value="2">&#xf0e0 Email</option>
                                <option disabled value="3">&#xf0c1 URL</option>
                            </select>
                            <div id="qr_text_container" class="mt-3">
                                <textarea maxlength="300" rows="5" name="qr_text" id="qr_text" class="form-control text-secondary fw-bolder" placeholder="Enter your text"></textarea>
                                <p id="qr_text_counter" class="w-100 text-end text-secondary">0/1000</p>
                            </div>
                            <div hidden id="qr_wifi_container" class="mt-3">
                                <label for="qr_ssid" class="mb-2">Network Name</label>
                                <div class="d-flex w-100">
                                    <input type="text" class="form-control wd-500" placeholder="SSID"> 
                                    <input class="ms-4" type="checkbox" value="" id="flexCheckDefault">
                                    <label style="margin-top: 6px !important; margin-left: 5px;" for="flexCheckDefault">Hidden</label>
                                </div>
                                <div class="row d-flex w-100">
                                    <div class="wd-180">
                                        <label for="qr_encryption" class="mb-2 mt-2">Encryption</label>
                                        <select name="qr_encryption" id="qr_encryption" class="form-control wd-150 text-secondary"  style="font-family: 'FontAwesome', sans-serif;">
                                            <option value="none">None</option>
                                            <option value="wpa/wpa2">WPA/WPA2</option>
                                            <option value="wep">WEP</option>
                                        </select>        
                                    </div>
                                    <div hidden id="qr_password_container" class="wd-500">
                                        <label for="qr_password" class="mb-2 mt-2">Password</label>
                                        <input id="qr_password" type="text" class="form-control">     
                                    </div>
                                </div>
                            </div>

                            <div class="accordion mt-3" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            <span class="fa fa-paint-brush me-2"></span> <b>Colors</b>
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="bgColor" class="mb-2">Background Color</label>
                                                    <input class="colorpicker colorpicker-light" id="bgColor" type="text">
                                                    <div class="d-flex mt-2 mb-1">
                                                        <input type="checkbox" name="" id="bgTransparent">
                                                        <label for="bgTransparent" class="f-15 ms-2 text-secondary">Transparent Background</label>
                                                    </div>
                                                    <div class="d-flex">
                                                        <input type="checkbox" name="" id="bgImg">
                                                        <label for="bgImg" class="f-15 ms-2 text-secondary">Image Background</label>
                                                    </div>
                                                    <input hidden type="file" accept="image/*" name="" id="bgImgFile" class="form-control mt-2">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="fgColor" class="mb-2">Foreground Color</label>
                                                    <input class="colorpicker colorpicker-dark" id="fgColor" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <span class="fa fa-qrcode me-2"></span> <b>Design</b>
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <strong>This is the second item’s accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It’s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            <span class="fa fa-certificate me-2"></span> <b>Logo</b>
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <strong>This is the third item’s accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It’s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            <span class="fa fa-th-list me-2"></span> <b>Frame</b>
                                        </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <strong>This is the third item’s accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It’s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                            <span class="fa fa-toggle-on me-2"></span> <b>Options</b>
                                        </button>
                                    </h2>
                                    <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <strong>This is the third item’s accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It’s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <button id="qr_generate_btn" class="btn btn-success alert-success rounded-pill fw-bolder mt-4 mb-2"><span class="fa fa-refresh"></span> GENERATE QR CODE</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="rounded-3 p-1">
                            <div id="qr_preview" class="w-100 text-center image-wrapper pb-3">
                                <canvas class="shadow" id="qrPreviewCanvas"></canvas>
                            </div>
                        </div>
                        <button class="mt-4 ht-55 btn btn-primary w-100 d-flex justify-content-center fw-bolder"><span class="fa fa-download mt-2 f-20 me-2"></span><div>DOWNLOAD <br> <p class="f-13" style="margin-top: -4px; font-weight: 400;">PNG</p></div></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>