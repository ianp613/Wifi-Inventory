if(document.getElementById("dashboard")){


    var inuse = document.getElementById("inuse");
    var standby = document.getElementById("standby");
    var forstatus = document.getElementById("forstatus");
    var pending = document.getElementById("pending");

    sole.get("../../controllers/dashboard/get_entry.php")
    .then(res => load_unit_counts(res))

    function load_unit_counts(res){
        var wmi_ip = document.getElementById("wmi_ip")
        var wmi_isp = document.getElementById("wmi_isp")
        var wmi_asn = document.getElementById("wmi_asn")
        var wmi_city = document.getElementById("wmi_city")
        var wmi_region = document.getElementById("wmi_region")
        var wmi_country = document.getElementById("wmi_country")
        
        wmi_ip.innerHTML = wmi_ip.innerHTML + " " + res.ip
        wmi_isp.innerHTML = wmi_isp.innerHTML + " " + res.isp
        wmi_asn.innerHTML = wmi_asn.innerHTML + " " + res.asn
        wmi_city.innerHTML = wmi_city.innerHTML + " " + res.city
        wmi_region.innerHTML = wmi_region.innerHTML + " " + res.region
        wmi_country.innerHTML = wmi_country.innerHTML + " " + res.country

        console.log(res)
        var count = [0,0,0,0];
        for (let i = 0; i < res.entry.length; i++) {
            if(res.entry[i]["status"] == "Standby"){
                count[1]++
            }
            if(res.entry[i]["status"] == "In Use"){
                count[0]++
            }
            if(res.entry[i]["status"] == "For Status"){
                count[2]++
            }
            if(res.entry[i]["status"] == "Pending"){
                count[3]++
            }
        }

        count[0] != 0 ? count[0] == 1 ? inuse.innerText = count[0] + " unit" : inuse.innerText = count[0] + " units" : inuse.innerText = "No record"
        count[1] != 0 ? count[1] == 1 ? standby.innerText = count[1] + " unit" : standby.innerText = count[1] + " units" : standby.innerText = "No record"
        count[2] != 0 ? count[2] == 1 ? forstatus.innerText = count[2] + " unit" : forstatus.innerText = count[2] + " units" : forstatus.innerText = "No record"
        count[3] != 0 ? count[3] == 1 ? pending.innerText = count[3] + " unit" : pending.innerText = count[3] + " units" : pending.innerText = "No record"
    }
}