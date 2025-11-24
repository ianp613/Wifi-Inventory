let clientTable = new DataTable('#tb_client',{
    rowCallback: function(row) {
        $(row).addClass("trow");
    },
    scrollX: true,
    autoWidth: true,
    columnDefs: [
        {
            target: 0,
            visible: false,
            searchable: false
        },
        { 
            className: 'dt-left', 
            targets: '_all' 
        }
    ],
    autoWidth: false,
    language: {
        sLengthMenu: "Show _MENU_entries",
    //    search: "Search: "
        search: "<button hidden id=\"for_status_btn\" data-bs-toggle=\"modal\" data-bs-target=\"#for_status\" style=\"margin-right: 20px; padding-left: 10px;\" class=\"btn btn-sm btn-secondary rounded-pill position-relative\"><span id=\"for_status_count\" class=\"position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger\"></span><span class=\" fa fa-file-pdf-o\"></span> For Status</button>   Search: "
    }
});

let voucherTable = new DataTable('#tb_voucher',{
    rowCallback: function(row) {
        $(row).addClass("trow");
    },
    autoWidth: true,
    columnDefs: [
        {
            target: 0,
            visible: false,
            searchable: false
        },
        { 
            className: 'dt-left', 
            targets: '_all' 
        }
    ],
    autoWidth: false,
    language: {
        sLengthMenu: "Show _MENU_entries",
    //    search: "Search: "
        search: "<button hidden id=\"for_status_btn\" data-bs-toggle=\"modal\" data-bs-target=\"#for_status\" style=\"margin-right: 20px; padding-left: 10px;\" class=\"btn btn-sm btn-secondary rounded-pill position-relative\"><span id=\"for_status_count\" class=\"position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger\"></span><span class=\" fa fa-file-pdf-o\"></span> For Status</button>   Search: "
    }
});

let usergroupTable = new DataTable('#tb_usergroup',{
    rowCallback: function(row) {
        $(row).addClass("trow");
    },
    autoWidth: true,
    columnDefs: [
        {
            target: 0,
            visible: false,
            searchable: false
        },
        { 
            className: 'dt-left', 
            targets: '_all' 
        }
    ],
    autoWidth: false,
    language: {
        sLengthMenu: "Show _MENU_entries",
    //    search: "Search: "
          search: "<button hidden id=\"for_status_btn\" data-bs-toggle=\"modal\" data-bs-target=\"#for_status\" style=\"margin-right: 20px; padding-left: 10px;\" class=\"btn btn-sm btn-secondary rounded-pill position-relative\"><span id=\"for_status_count\" class=\"position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger\"></span><span class=\" fa fa-file-pdf-o\"></span> For Status</button>   Search: "
    }
});


let unclose = {
    backdrop: 'static',
    keyboard: false
}
const authentication_modal = new bootstrap.Modal(document.getElementById('authentication'),unclose);
const voucher_modal = new bootstrap.Modal(document.getElementById('voucher_m'),unclose);
const usergroup_modal = new bootstrap.Modal(document.getElementById('usergroups'), unclose);

var authentication_save = document.getElementById("authentication_save")
var authentication = false;

var voucher = document.getElementById("voucher")
var default_ = document.getElementById("default_")
var voucher_ = document.getElementById("voucher_")
var voucher_btn_ = document.getElementById("voucher_btn_")

var ugcreate = document.getElementById("ugcreate")
var ugdialog = document.getElementById("ugdialog")
var ugtb_cont = document.getElementById("ugtb_cont")
var ugform_cont = document.getElementById("ugform_cont")
var ugcancel = document.getElementById("ugcancel")
var ugsave = document.getElementById("ugsave")
var ugname = document.getElementById("ugname")
var ugdownload_limit = document.getElementById("ugdownload_limit")
var ugupload_limit = document.getElementById("ugupload_limit")

var ugfields = [ugname, ugdownload_limit, ugupload_limit]

var expiration = document.getElementById("expiration")
var expiration_type = document.getElementById("expiration_type")

var fields = [expiration, expiration_type]

var voucher_name = document.getElementById("voucher_name")
var voucher_amount = document.getElementById("voucher_amount")
var voucher_expiration = document.getElementById("voucher_expiration")
var voucher_expiration_type = document.getElementById("voucher_expiration_type")
var voucher_use_per_voucher = document.getElementById("voucher_use_per_voucher")

var voucher_fields = [voucher_name, voucher_amount, voucher_expiration, voucher_expiration_type];

var use_ = "single"
var conf = null


loadConf()
loadVouchers()
loadUsergroups()
loadClients()

function loadClients(){
  sole.get("../controllers/admin/get_clients.php").then(res => {
    console.log(conf)
    clientTable.clear().draw();
    res.data.forEach(r => {
      if(conf.Unifi.SSID.includes(r.essid)){
        console.log(r)
        clientTable.row.add([
            "",
            r.hostname ? r.hostname : "Guest User",
            r.mac ? r.mac : "",
            r.essid,
            getSimplifiedClientExperienceRating(r),
            r.ip,
            formatUptime(r.uptime),
            "Unauthorize",
        ]).draw(false)
      }
    });
  })
}

function getSimplifiedClientExperienceRating(clientData) {
    const score = clientData.satisfaction_real;
    const anomalies = clientData.anomalies;
    const retryPercentage = clientData.wifi_tx_retries_percentage;

    // A hard failure indicator will immediately override the score
    if (anomalies > 0) {
        return "<span style=\"color: red\">Poor</span>";
    }

    // High retry rates often indicate underlying physical layer issues, even if the score is high
    if (retryPercentage >= 40.0) {
        // If the score is high despite this, it's still functionally 'good',
        // but if the score is already trending down, force it to 'Poor'
        if (score < 80) {
           return "<span style=\"color: red\">Poor</span>"; 
        }
    }
    
    // Determine the rating based on the UniFi satisfaction score thresholds:
    if (score >= 90) {
        return "<span style=\"color: green\">Excellent</span>";
    } else if (score >= 70 && score < 90) {
        return "<span style=\"color: #9bd303\">Good</span>";
    } else {
        // Includes scores 0-69
        return "<span style=\"color: red\">Poor</span>";
    }
}

function formatUptime(seconds) {
  if (seconds < 0) seconds = 0;

  const days = Math.floor(seconds / (24 * 3600));
  seconds %= 24 * 3600;

  const hours = Math.floor(seconds / 3600);
  seconds %= 3600;

  const minutes = Math.floor(seconds / 60);
  const secs = seconds % 60;

  const parts = [];
  if (days > 0) parts.push(`${days}d`);
  if (hours > 0) parts.push(`${hours}h`);
  if (minutes > 0) parts.push(`${minutes}m`);
  if (secs > 0 || parts.length === 0) parts.push(`${secs}s`);

  return parts.join(" ");
}


function loadUsergroups(){
  sole.get("../controllers/admin/get_usergroup.php").then(res => {
    usergroupTable.clear().draw();
    res.user_groups.data.forEach(e => {
      if(e.name.includes("captive_")){
        usergroupTable.row.add([
            "",
            e.name.replace("captive_",""),
            (e.qos_rate_max_down / 1024) + " Mbps",
            (e.qos_rate_max_up / 1024) + " Mbps",
            "<button id=\"revoke_voucher_"+ e["id"] +"\" v-id=\""+ e["id"] +"\" class=\"revoke_voucher_row btn btn-sm btn-danger mb-1\">Revoke</button>"
        ]).draw(false)
      }
    });
  })
}

function loadConf(){
  sole.get("../controllers/get_conf.php")
  .then(res => {
    conf = res
    expiration.value = res.Unifi.Open.Time
    expiration_type.value = res.Unifi.Open.Type
    voucher.checked = res.Unifi.Authentication
    checkVoucher(res.Unifi.Authentication)
  })  
}

function loadVouchers(){
  sole.get("../controllers/admin/get_vouchers.php").then(res => {
    voucherTable.clear().draw();
    res.forEach(e => {
        var exp = e["exp_type"] == "Hour" ? e["expiration"] / 60 : (e["exp_type"] == "Day" ? e["expiration"] / 1440 : e["expiration"])
        var exp_typ = (e["exp_type"]) + (exp > 1 ? "s" : "")
        voucherTable.row.add([
            e["id"],
            e["name"],
            e["code"],
            exp == 0 ? "Unlimited" : exp + " " + exp_typ,
            e["upv"]  == 0 ? "Unlimited" : e["upv"],
            "<button id=\"revoke_voucher_"+ e["id"] +"\" v-id=\""+ e["id"] +"\" class=\"revoke_voucher_row btn btn-sm btn-danger mb-1\">Revoke</button>"
        ]).draw(false)
    });
  })
}

ugcreate.addEventListener("click",function(){
  this.hidden = true
  ugdialog.classList.remove("modal-lg")
  ugdialog.classList.add("modal-md")

  ugtb_cont.hidden = true
  ugform_cont.hidden = false
})

ugcancel.addEventListener("click",function(){
  ugcreate.hidden = false
  ugdialog.classList.add("modal-lg")
  ugdialog.classList.remove("modal-md")

  ugtb_cont.hidden = false
  ugform_cont.hidden = true

  ugname.value = ""
  ugdownload_limit.value = ""
  ugupload_limit.value = ""
})

ugsave.addEventListener("click",function(){
  if (ugfields.every(field => field && field.value.trim() !== "")) {
    sole.post("../controllers/admin/create_usergroup.php",{
      ugname : ugname.value,
      ugupload_limit : ugupload_limit.value,
      ugdownload_limit : ugdownload_limit.value
    }).then(res => console.log(res))
  }else{
    alert("Please fill up all fields.")
  }
})

document.querySelector('#tb_voucher').addEventListener("click", e=>{
    if (e.target.classList.contains('revoke_voucher_row')) {
        if(confirm("Warning: All clients connected through this voucher will be unauthorized and will need to re-authenticate using a different voucher code to continue using the internet. Are you sure you want to proceed?")){
          sole.post("../controllers/admin/delete_voucher.php",{
            id : e.target.getAttribute("v-id")
          }).then(res => {
            alert(res)
            loadVouchers()
          })
        }
    }
})

document.getElementById("voucher_use_").addEventListener("click",function(){
  if(document.getElementById("multiple").checked){
    document.getElementById("upv_").classList.add("d-flex")
    document.getElementById("upv_").hidden  = false
  }else{
    document.getElementById("upv_").classList.remove("d-flex")
    document.getElementById("upv_").hidden  = true
  }
})

voucher.addEventListener("change",function(){
  if(!this.checked){
    alert("Warning: All vouchers will be revoked. Clients connected through a voucher will be unauthorized and will need to re-authenticate to continue using the internet. Once saved, this action cannot be undone.")
  }
  checkVoucher(this.checked)
})

document.getElementById('authentication').addEventListener('hidden.bs.modal', function () {
  loadConf();
});

authentication_save.addEventListener("click",function(){
  var submit = true
  if(authentication){
    if (voucher_fields.every(field => field && field.value.trim() !== "")) {
      use_ = document.getElementById("single").checked ? "single" : use_
      use_ = document.getElementById("multiple").checked ? "multiple" : use_
      use_ = document.getElementById("unlimited").checked ? "unlimited" : use_
      var temp_use = 1
      if(use_ == "multiple"){
        if(voucher_use_per_voucher.value != ""){
          temp_use = voucher_use_per_voucher.value  
        }else{
          alert("Please fill up all fields.")
          return
        }
      }
      if(use_ == "unlimited"){
        temp_use = 0
      }
      
      sole.post("../controllers/admin/save_voucher.php",{
        authentication : authentication,
        voucher_name : voucher_name.value,
        voucher_amount : voucher_amount.value,
        upv : temp_use,
        voucher_expiration : voucher_expiration.value,
        voucher_expiration_type : voucher_expiration_type.value,
      }).then(res => {
        alert(res)
        document.getElementById("upv_").classList.remove("d-flex")
        document.getElementById("upv_").hidden  = true
        document.getElementById("single").checked = true
        voucher_name.value = ""
        voucher_amount.value = "10"
        voucher_use_per_voucher.value = "2"
        voucher_expiration.value = ""
        voucher_expiration_type.value = "1"
        voucher_expiration_type.value = ""
        authentication_modal.hide()
        loadVouchers()
      })


    }else{
      alert("Please fill up all fields.")
    }
  }else{
    if (fields.every(field => field && field.value.trim() !== "")) {
      sole.post("../controllers/admin/save_authentication.php",{
        authentication : authentication,
        expiration : expiration.value,
        expiration_type : expiration_type.value
      }).then(res => {
        authentication_modal.hide()
        alert("Authentication has been updated.")
      })
    }else{
      alert("Please fill up all fields.")
    }
  }
})

function checkVoucher(data){
  if(data){
    default_.hidden = true
    voucher_.hidden = false
    voucher_btn_.hidden = false
    authentication = true
  }else{
    default_.hidden = false
    voucher_.hidden = true
    voucher_btn_.hidden = true
    authentication = false
  }
}









// GET ALL ONLINE USER FOR DDC Open Wifi















































function splash(message, seconds) {
  // Create splash element
  const splashScreen = document.createElement("div");
  const bs5_spinner = "<div class=\"spinner-border text-success ht-70 wd-70 me-5\" role=\"status\"></div>"
  splashScreen.innerHTML = bs5_spinner
  splashScreen.id = "splash";
  splashScreen.style.position = "fixed";
  splashScreen.style.top = "0";
  splashScreen.style.left = "0";
  splashScreen.style.width = "100%";
  splashScreen.style.height = "100%";
  splashScreen.style.background = "white";
  splashScreen.style.display = "flex";
  splashScreen.style.alignItems = "center";
  splashScreen.style.justifyContent = "center";
  splashScreen.style.fontSize = "24px";
  splashScreen.style.opacity = "1";
  splashScreen.style.transition = "opacity 0.5s ease-out";
  splashScreen.style.zIndex = "9999";

  if (message) {
    splashScreen.innerHTML = message;
  }

  document.body.appendChild(splashScreen);

  // Remove after fade
  setTimeout(() => {
    splashScreen.style.opacity = "0";
    setTimeout(() => {
      splashScreen.remove();
    }, 500); // Matches fade transition duration
  }, seconds);
}
splash(null, 500)