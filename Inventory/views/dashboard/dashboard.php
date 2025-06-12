<div id="dashboard">
    <h6 style="margin-bottom: -2px;">Equipments</h6>
    <div class="row">
        <div class="col-md-3 p-2">
            <div class="border border-secondary border-1 rounded">
                <div class="w-100 ht-60 p-2 d-flex flex-row justify-content-between">
                    <div class="ps-2 overflow-hidden">
                        <h5 id="inuse" class="text-success p-0 m-0">0 unit</h5>
                        <h6 class="f-14">Total In Use</h6>  
                    </div>
                    <div class="pt-2 pe-3">
                        <h1 class="f-30 fa fa-check text-secondary"></h1>
                    </div>
                </div>
                <div class="w-100 ht-5 bg-secondary rounded-bottom"></div>    
            </div>
        </div>
        <div class="col-md-3 p-2">
            <div class="border border-secondary border-1 rounded">
                <div class="w-100 ht-60 p-2 d-flex flex-row justify-content-between">
                    <div class="ps-2 overflow-hidden">
                        <h5 id="standby" class="text-primary p-0 m-0">0 unit</h5>
                        <h6 class="f-14">Total Standby</h6>  
                    </div>
                    <div class="pt-2 pe-3">
                        <h1 class="f-30 fa fa-tasks text-secondary"></h1>
                    </div>
                </div>
                <div class="w-100 ht-5 bg-secondary rounded-bottom"></div>    
            </div>
        </div>
        <div class="col-md-3 p-2">
            <div class="border border-secondary border-1 rounded">
                <div class="w-100 ht-60 p-2 d-flex flex-row justify-content-between">
                    <div class="ps-2 overflow-hidden">
                        <h5 id="forstatus" class="text-danger p-0 m-0">0 unit</h5>
                        <h6 class="f-14">Total For Status</h6>  
                    </div>
                    <div class="pt-2 pe-3">
                        <h1 class="f-30 fa fa-exclamation-triangle text-secondary"></h1>
                    </div>
                </div>
                <div class="w-100 ht-5 bg-secondary rounded-bottom"></div>    
            </div>
        </div>
        <div class="col-md-3 p-2">
            <div class="border border-secondary border-1 rounded">
                <div class="w-100 ht-60 p-2 d-flex flex-row justify-content-between">
                    <div class="ps-2 overflow-hidden">
                        <h5 id="pending" class="text-warning p-0 m-0">0 unit</h5>
                        <h6 class="f-14">Total Pending</h6>  
                    </div>
                    <div class="pt-2 pe-3">
                        <h1 class="f-30 fa fa-clock-o text-secondary"></h1>
                    </div>
                </div>
                <div class="w-100 ht-5 bg-secondary rounded-bottom"></div>    
            </div>
        </div>
    </div>
    <h6 class="mt-4" style="margin-bottom: -2px;">Current Configurations</h6>
    <div class="p-3">
        <div class="row">
            <div class="col-md-6">
                <h6 class="f-14"><span class="fa fa-wifi"></span> Assigned ISP</h6>
                <div id="active_isp" class="ps-3 scroll-y">
                    <p class="f-14 mb-1">No data available</p>
                </div>
            </div>
            <div class="col-md-6">
                <h6 class="f-14"><span class="fa fa-gears"></span> Connected Routers</h6>
                    <div id="active_routers" class="ps-3 scroll-y">
                    <p class="f-14 mb-1">No data available</p>
                    
                </div>
            </div>
        </div>
    </div>
    <h6 class="mt-4" style="margin-bottom: -2px;"><span class="fa fa-info-circle"></span> What is my IP?</h6>
    <div class="row p-3">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <p id="wmi_ip" class="f-13 mb-1 text-primary fw-bold"><span class="fwt-5 text-dark">IP:</span></p>
                    <p id="wmi_isp" class="f-13 mb-1 text-primary fw-bold"><span class="fwt-5 text-dark">ISP:</span></p>
                    <p id="wmi_asn" class="f-13 mb-1 text-primary fw-bold"><span class="fwt-5 text-dark">ASN:</span></p>    
                </div>
                <div class="col-md-6">
                    <p id="wmi_city" class="f-13 mb-1 text-primary fw-bold"><span class="fwt-5 text-dark">City:</span></p>
                    <p id="wmi_region" class="f-13 mb-1 text-primary fw-bold"><span class="fwt-5 text-dark">Region:</span></p>
                    <p id="wmi_country" class="f-13 mb-1 text-primary fw-bold"><span class="fwt-5 text-dark">Country:</span></p>
                </div>
            </div>
        </div>    
    </div>
    
</div>