<div id="ipaddress">
    <div class="d-flex mb-3">
        <div class="col-md-6">
            <!-- <button data-bs-toggle="modal" data-bs-target="#add_entry" class="btn btn-sm btn-danger" style="margin-bottom: -5px;"><span class="fa fa-plus"></span> Add Entry</button> -->
        </div>
        <div class="col-md-6 d-flex justify-content-end align-items-end">
            <div class="dropdown">
                <div id="network_dropdown_toggle" tabindex="0" title="Right-Click Network to Edit" class="dropdown-toggle d-inline-block" type="button" data-bs-toggle="dropdown" aria-expanded="false">-- Select Network --</div>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" id="network_dropdown">
                <!-- DROP DOWN NETWORK -->
                </ul>
            </div>
            <button data-bs-target="#add_network" data-bs-toggle="modal" class="btn btn-sm btn-danger" style="margin-bottom: -5px; margin-left: 10px;"><span class="fa fa-plus"></span> Add Network</button>
        </div>
    </div>
    <table id="network_table" class="table border table-hover">
        <thead>
            <tr>
                <td class="text-start">ID</td>
                <td class="text-start">IP</td>
                <td class="text-start">Hostname</td>
                <td class="text-start">Site/Location</td>
                <td class="text-start">Server</td>
                <td class="text-start">Status</td>
                <td class="text-start">Web Mgmt. Port</td>
                <td class="text-start">Credentials</td>
                <td style="width: 100px; !important">Action</td>
            </tr>
        </thead>
        <tbody>
            <!-- Entry Here -->
        </tbody>
    </table>
</div>
