if(document.getElementById("dashboard")){
    var inuse = document.getElementById("inuse");
    var standby = document.getElementById("standby");
    var forstatus = document.getElementById("forstatus");
    var pending = document.getElementById("pending");
    var active_isp = document.getElementById("active_isp");
    var routers = document.getElementById("active_routers");

    var months_sdot = document.getElementById("months_sdot")
    var years_sdot = document.getElementById("years_sdot")

    var consumables = [];
    var consumables_log = [];

    setConsumables()
    function setConsumables(){
        sole.get("../../controllers/dashboard/get_consumables_log.php")
        .then(res => {
            consumables_log = res.consumables_log
        })
        sole.get("../../controllers/dashboard/get_consumables.php")
        .then(res => {
            consumables = res.consumables
        })    
    }
    

    sole.get("../../controllers/dashboard/get_entry.php")
    .then(res => load_unit_counts(res))


    sole.get("../../controllers/dashboard/current_configurations.php")
    .then(res => {
        res.active_isp.length ? active_isp.innerHTML = "" : null
        res.active_isp.forEach(ai => {
            var p = document.createElement("p");
            p.setAttribute("class","f-14 mb-1")
            p.innerHTML = ai
            active_isp.appendChild(p)
        });

        res.routers.length ? routers.innerHTML = "" : null
        res.routers.forEach(ai => {
            var p = document.createElement("p");
            p.setAttribute("class","f-14 mb-1")
            p.innerHTML = ai
            routers.appendChild(p)
        });
    })

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



    // CHARTS ======================================================
    // Stock Deduction Over Time

    // Predefined pastel colors
    const pastelColors = [
    '#AEC6CF', // pastel blue
    '#FFB347', // pastel orange
    '#77DD77', // pastel green
    '#F49AC2', // pastel pink
    '#CFCFC4', // pastel gray
    '#B39EB5', // pastel purple
    '#FFD1DC', // baby pink
    '#CB99C9', // pastel lavender
    // '#FDFD96', // pastel yellow
    '#B5EAD7', // mint pastel
    '#C7CEEA'  // sky pastel
    ];

    // Track used colors
    let usedColors = [];

    // Function to get a unique pastel color
    function getUniquePastelColor() {
    // Find unused color
    const available = pastelColors.filter(c => !usedColors.includes(c));

    if (available.length > 0) {
        const color = available[Math.floor(Math.random() * available.length)];
        usedColors.push(color);
        return color;
    }

    // If all colors are used, generate a random pastel
    const r = Math.floor((Math.random() * 127) + 127); // 127–255 for light tones
    const g = Math.floor((Math.random() * 127) + 127);
    const b = Math.floor((Math.random() * 127) + 127);
    const color = `rgb(${r}, ${g}, ${b})`;
    usedColors.push(color);
        return color;
    }



    const ctx = document.getElementById('sdot');

    // Start with empty labels and datasets
    const sdot = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],        // no labels yet
            datasets: []       // no datasets yet
        },
        options: {
            scales: {
                y: {
                beginAtZero: true
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutQuad'
            }
        }
    });

    // Add a new dataset dynamically
    function addDataset(itemName) {
        const newDataset = {
        label: itemName,
        data: [], // start empty
        borderColor: getUniquePastelColor(),
        borderWidth: 2,
        tension: 0.4
        };
        sdot.data.datasets.push(newDataset);
        sdot.update();
    }

    // Add a new label and values for each dataset
    function addRecord(dateLabel, values) {
        sdot.data.labels.push(dateLabel);

        sdot.data.datasets.forEach((dataset, i) => {
        dataset.data.push(values[i]); // values is an array matching datasets
        });

        sdot.update();
    }

    // ADD DATASET AND TOP LABELS
    setTimeout(() => {
        consumables.forEach(cons => {
            addDataset(cons.description)
        });
        insertDaily(2026,1)
    }, 1000);

    function insertDaily(year, month){
        clearAllData(sdot)
        var daily = getDates(year, month);
        var data = [];

        // loop first the date and add all date to data
        daily.forEach(dail => {
            data.push([dail,[]]);
        })

        for (let daily_id = 0; daily_id < daily.length; daily_id++) {
            // loop all consumables
            consumables.forEach(cons => {
                // get all consumable_log with the same id and if date exist
                var total_value = 0;
                
                consumables_log.forEach(cons_log => {
                    if(cons_log.date == daily[daily_id] && cons_log.cid == cons.id){
                        total_value = parseInt(cons_log.quantity_deduction) + total_value
                    }
                })

                const entry = data.find(([date]) => date === daily[daily_id]);

                if (entry) {
                    entry[1].push(total_value);
                }
            })
        }
        data.forEach(dat => {
            addRecord(formatDateToMonthDay(dat[0]),dat[1])
        })
    }

    months_sdot.addEventListener("change",e => {
        insertDaily(years_sdot.value,months_sdot.value)
    })
    years_sdot.addEventListener("change",e => {
        insertDaily(years_sdot.value,months_sdot.value)
    })

    








    function clearAllData(chart_) {
        chart_.data.labels = [];
        chart_.data.datasets.forEach(dataset => {
            dataset.data = [];
        });
        chart_.update();
    }

}
