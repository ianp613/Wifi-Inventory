var captive_submit = document.getElementById("captive_submit")
var captive_timer = document.getElementById("captive_timer")
var urlOrigin = window.location.origin
var cooldown = false
const pathSegments = window.location.pathname.split("/");
const siteID = pathSegments[3];
const urlParams = new URLSearchParams(window.location.search);
const mac = urlParams.get('id'); 
const ap = urlParams.get('ap');
const t = urlParams.get('t');

getClient()

function getClient() {
    sole.post(urlOrigin + "/controllers/captive_portal/get_client.php",{
        mac : mac
    }).then(res => {
        if(res){
            captive_timer.removeAttribute("hidden")
            captive_submit.setAttribute("hidden","true")
            // Replace this with your actual start time
            const startTime = new Date(res.time);

            // Target time is 2 hours after start
            // const targetTime = new Date(startTime.getTime() + 2 * 60 * 60 * 1000);
            // Target time is 1 minute after start
            const targetTime = new Date(startTime.getTime() + 1 * 60 * 1000);

            function updateTimer() {
                const now = new Date();
                const diffMs = targetTime - now;

                if (diffMs <= 0) {
                    captive_timer.textContent = "Your time is up, please sign in again.";
                    sole.post(urlOrigin + "/controllers/captive_portal/unauthorize.php",{
                        mac : mac,
                        ap : ap,
                        t : t,
                        site_id : siteID
                    }).then(res => alert(res.unauthorized))
                    captive_submit.removeAttribute("hidden")
                    clearInterval(timerInterval);
                    return;
                }

                const totalSeconds = Math.floor(diffMs / 1000);
                const hours = Math.floor(totalSeconds / 3600);
                const minutes = Math.floor((totalSeconds % 3600) / 60);
                const seconds = totalSeconds % 60;

                captive_timer.textContent = `Time Remaining: ` + 
                `${hours.toString().padStart(2, '0')}:` +
                `${minutes.toString().padStart(2, '0')}:` +
                `${seconds.toString().padStart(2, '0')}`;
            }

            const timerInterval = setInterval(updateTimer, 1000);
            updateTimer(); // Initial call
        }else{
            captive_timer.setAttribute("hidden",true)
            captive_submit.removeAttribute("hidden")
        }
    })    
}



captive_submit.addEventListener("click",e=>{
    if(!cooldown){
        sole.post(urlOrigin + "/controllers/captive_portal/authorize.php",{
            mac : mac,
            ap : ap,
            t : t,
            site_id : siteID
        }).then(res => {
            try {
                const parsed = typeof res === 'string' ? JSON.parse(res) : res;
                if (parsed && parsed.authorized && parsed.authorized.includes('"rc":"ok"')) {
                    const now = new Date();
                    const year = now.getFullYear();
                    const month = String(now.getMonth() + 1).padStart(2, '0');
                    const day = String(now.getDate()).padStart(2, '0');
                    const hours = String(now.getHours()).padStart(2, '0');
                    const minutes = String(now.getMinutes()).padStart(2, '0');
                    const seconds = String(now.getSeconds()).padStart(2, '0');
                    const date_time = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;

                    sole.post(urlOrigin + "/controllers/captive_portal/save_client.php",{
                        mac : mac,
                        date_time : date_time
                    }).then(res => {
                        sole.speak("You can now access the internet.")
                        getClient()
                    })
                } else {
                    alert('❌ Authorization failed.');
                }
            } catch (e) {
                alert('❌ Invalid response format.');
            }
        })    
    }else{
        alert("Please wait for the cooldown to finish.")
    }
    
})

