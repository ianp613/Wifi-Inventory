if(document.getElementById("dashboard")){
sole.splash()

    var inuse = document.getElementById("inuse");
    var standby = document.getElementById("standby");
    var forstatus = document.getElementById("forstatus");
    var pending = document.getElementById("pending");

    sole.get("../../controllers/dashboard/get_entry.php")
    .then(res => load_unit_counts(res))

    function load_unit_counts(res){
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