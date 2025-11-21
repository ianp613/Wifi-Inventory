<?php
    $currentPath = $_SERVER['PHP_SELF'];
    $depth = substr_count(dirname($currentPath), '/');
    $pathToRoot = str_repeat('../', $depth);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Captive Portal</title>
        <link rel="shortcut icon" href="<?php echo $pathToRoot; ?>assets/img/logo-ico.png" type="image/x-icon">
        <link rel="stylesheet" href="<?php echo $pathToRoot; ?>assets/fontawesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo $pathToRoot; ?>assets/css/datatables/datatables.min.css">
        <link rel="stylesheet" href="<?php echo $pathToRoot; ?>assets/css/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $pathToRoot; ?>assets/css/sole.splash/splash.css">
        <link rel="stylesheet" href="<?php echo $pathToRoot; ?>assets/css/colorpicker.css">
        <link rel="stylesheet" href="<?php echo $pathToRoot; ?>assets/css/style.css">
    </head>
    <body>
        <div class="d-flex w-100 justify-content-center">
            <div class="captive-card">
                <img class="captive-img" src="<?php echo $pathToRoot; ?>assets/img/ddc.png" alt="ddc-logo">
                <h3 class="captive-title mt-3" id="captive_title">UniFi Guest Wifi</h3>
                <h6 id="captive_subtitle" class="captive-subtitle mt-2">Welcome to UniFi Guest Wifi Hotspot</h6>
                <div id="authentication" hidden>
                    <h6 class="mt-3 mb-3"><strong>Enter Access Code</strong></h6>
                    <div id="captive_codes" class=" w-100 captive-code">
                        <div class="col-md-2 ps-1 pe-1">
                            <input maxlength="1" type="text" name="" id="1" class="inp1 captive-inp form-control">
                        </div>
                        <div class="col-md-2 ps-1 pe-1">
                            <input maxlength="1" type="text" name="" id="2" class="inp2 captive-inp form-control">
                        </div>
                        <div class="col-md-2 ps-1 pe-1">
                            <input maxlength="1" type="text" name="" id="3" class="inp3 captive-inp form-control">
                        </div>
                        <div class="col-md-2 ps-1 pe-1">
                            <input maxlength="1" type="text" name="" id="4" class="inp4 captive-inp form-control">
                        </div>
                        <div class="col-md-2 ps-1 pe-1">
                            <input maxlength="1" type="text" name="" id="5" class="inp5 captive-inp form-control">
                        </div>
                        <div class="col-md-2 ps-1 pe-1">
                            <input maxlength="1" type="text" name="" id="6" class="inp6 captive-inp form-control">
                        </div>
                </div>
                </div>
                <code id="captive_alert" hidden>You can now access the internet. <br> Please refresh the page if nothing happens.
                    <br> You can also view this page anytime at <a href="//192.168.15.221" target="_blank">192.168.15.221</a>
                </code>
                <h3 id="captive_timer" class="captive-timer"></h3>
                <div id="captive_submit" class="captive-submit">Login</div>
                <h6 style="margin-top: 95px" class="text-dark blink"><strong>Powered By: DDC Wifi Team</strong></h6>
            </div>
        </div>
        <script>
            
            class Sole{
                get(url) {
                    var request = fetch(url)
                    return request.then(response => response.json())
                }
                post(url,value){
                    var request = fetch(url,{
                        method: 'POST', // Use POST method
                        headers: {
                            'Content-Type': 'application/json' // Inform the server about the JSON format
                        },
                        body: JSON.stringify(value)
                    })
                    return request.then(response => response.json())
                }
            }
            var sole = new Sole;
            try {
                var captive_submit = document.getElementById("captive_submit")
                var captive_timer = document.getElementById("captive_timer")
                var captive_alert = document.getElementById("captive_alert")
                var captive_title = document.getElementById("captive_title")
                var captive_subtitle = document.getElementById("captive_subtitle")
                var captive_codes = document.getElementById("captive_codes")
                var authentication = document.getElementById("authentication")
                var urlOrigin = window.location.origin
                var targetTime_cooldown = 0
                var voucher = false;
                
                
                // GET CONF.JSON

                function hexToRgba(hex, opacity) {
                    // Remove # if present
                    hex = hex.replace(/^#/, '');

                    // Parse r, g, b
                    let r = parseInt(hex.substring(0, 2), 16);
                    let g = parseInt(hex.substring(2, 4), 16);
                    let b = parseInt(hex.substring(4, 6), 16);

                    // Return rgba string
                    return `rgba(${r}, ${g}, ${b}, ${opacity / 100})`;
                }


                sole.get(urlOrigin + "/controllers/get_conf.php").then(res => {
                    let bgColor = hexToRgba(res.Landing_Page.Background.Box_Color, res.Landing_Page.Background.Box_Opacity); 
                    var captiveCard = document.getElementsByClassName("captive-card")[0]
                    captiveCard.style.backgroundColor = bgColor
                    captive_title.style.color = res.Landing_Page.Background.Header_Color
                    captive_subtitle.style.color = res.Landing_Page.Background.Text_Color
                    captive_title.innerText = res.Landing_Page.Title
                    captive_subtitle.innerText = res.Landing_Page.Welcome_Text
                    captive_submit.innerText = res.Landing_Page.Button_Text
                    captive_submit.style.backgroundColor = res.Landing_Page.Background.Button_Color
                    captive_submit.style.color = res.Landing_Page.Background.Button_Text_Color

                    res.Unifi.Authentication ? authentication.hidden = false : authentication.hidden = true
                    res.Unifi.Authentication ? captiveCard.style.height = "500px" : ""

                    voucher = res.Unifi.Authentication
                })

                // GET CLIENT MAC ADDRESS
                const urlParams = new URLSearchParams(window.location.search);        
                var mac = urlParams.get('id'); 
                sole.get(urlOrigin + "/controllers/captive_portal/get_mac.php").then(res => {
                    if(!mac){
                        mac = res
                    }
                })

                // GET SITE ID, MANUAL ASSIGNMENT
                var siteID = null;
                sole.get(urlOrigin + "/controllers/captive_portal/get_siteID.php").then(res => {
                    siteID = res
                })

                // CHECK IF CLIENT IS CONNECTED TO NETWORK THROUGH AP OR NOT
                var netAP = false;
                var hostname = "Guest User";
                sole.get(urlOrigin + "/controllers/captive_portal/get_clients.php").then(res => {
                    res.data.forEach(clients => {
                        if(clients.mac == mac){
                            netAP = true
                            if(clients.hostname !== undefined){
                                hostname = clients.hostname
                            }
                        }
                    });
                })

                setTimeout(() => {
                    if(netAP){
                        getClient()
                    }    
                }, 1000);
                
                function getClient() {
                    sole.post(urlOrigin + "/controllers/captive_portal/get_client.php",{
                        mac : mac
                    }).then(res => {
                        if(res.status){
                            captive_timer.removeAttribute("hidden")
                            captive_submit.setAttribute("hidden","true")
                            captive_subtitle.setAttribute("hidden","true")
                            authentication.setAttribute("hidden","true")
                            // captive_submit.classList.add("bg-primary")

                            // Replace this with your actual start time
                            // Example: targetMinutes = 1440 (1 day), or 5 * 1440 for 5 days
                            const targetMinutes = res.authentication.target; // you can set this dynamically
                            const startTime = new Date(res.client[0].time);

                            // Target time is start + targetMinutes
                            const targetTime = new Date(startTime.getTime() + targetMinutes * 60 * 1000);
                            targetTime_cooldown = new Date(startTime.getTime() + (targetMinutes * 60 * 1000) + (1 * 60 * 1000));
                            var now = new Date();
                            var cooldownInterval = null

                            // function cooldownCounter(){
                            //     var now = new Date();
                            //     var diff = targetTimes - now
                            //     cooldown_time = diff
                            //     console.log("Cool Down Start")
                            //     if(diff <= 0){
                            //         console.log("You can now reconnect to internet.")
                            //         clearInterval(cooldownInterval)
                            //         cooldown = false
                            //         return;
                            //     }

                            // }

                            // if(now >= targetTime && now < targetTimes){
                            //     cooldownInterval = setInterval(cooldownCounter, 1000);
                            // }

                            function updateTimer() {
                                const now = new Date();
                                const diffMs = targetTime - now;

                                if (diffMs <= 0) {
                                    captive_timer.textContent = "Your time is up, please sign in again.";
                                    sole.post(urlOrigin + "/controllers/captive_portal/unauthorize.php", {
                                        mac: mac,
                                        site_id: siteID
                                    }).then(res => console.log("UNAUTHORIZED"));

                                    // cooldownInterval = setInterval(cooldownCounter, 1000);
                                    // cooldown = true;

                                    setTimeout(() => {
                                        captive_timer.setAttribute("hidden", "true");
                                        captive_submit.removeAttribute("hidden");
                                        captive_subtitle.removeAttribute("hidden");
                                        if(voucher){
                                            authentication.removeAttribute("hidden");    
                                        }
                                    }, 3000);

                                    clearInterval(timerInterval);
                                    return;
                                }

                                const totalSeconds = Math.floor(diffMs / 1000);
                                const days = Math.floor(totalSeconds / 86400); // 86400 seconds in a day
                                const hours = Math.floor((totalSeconds % 86400) / 3600);
                                const minutes = Math.floor((totalSeconds % 3600) / 60);
                                const seconds = totalSeconds % 60;

                                // Build display string
                                let display = "Time Remaining: ";
                                if (days > 0) {
                                    display += `${days} Day${days > 1 ? "s" : ""}, `;
                                }
                                display +=
                                    `${hours.toString().padStart(2, "0")}:` +
                                    `${minutes.toString().padStart(2, "0")}:` +
                                    `${seconds.toString().padStart(2, "0")}`;

                                captive_timer.textContent = display;
                            }

                            const timerInterval = setInterval(updateTimer, 1000);
                            updateTimer(); // Initial call
                        }else{
                            captive_timer.setAttribute("hidden",true)
                            captive_submit.removeAttribute("hidden")
                        }
                    })    
                }

                function submitAuthentication(cooldown,time,code){
                    if(!cooldown){
                        sole.post(urlOrigin + "/controllers/captive_portal/authorize.php",{
                            mac : mac,
                            code : code
                        }).then(res => {
                            try {
                                const parsed = typeof res === 'string' ? JSON.parse(res) : res;
                                if (parsed && parsed.authorized && parsed.authorized.includes('"rc":"ok"')) {
                                    var target = res.target
                                    var type = res.type
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
                                        hostname : hostname,
                                        date_time : date_time
                                    }).then(res => {
                                        alert("You can now access the internet!")
                                        
                                        captive_subtitle.setAttribute("hidden","true")
                                        authentication.setAttribute("hidden","true")
                                        sole.post(urlOrigin + "/controllers/captive_portal/save_authentication.php", {
                                            mac : mac,
                                            code : code,
                                            target : target,
                                            type : type,
                                        }).then(res => {
                                            getClient()
                                        })
                                    })
                                    
                                } else {
                                    alert('Authorization failed.');
                                }
                            } catch (e) {
                                console.log(e)
                                // alert('Invalid response format.');
                            }
                        })    
                    }else{
                        alert("Please try again after " + time)
                    }
                }
                
                captive_submit.addEventListener("click",function(e){
                    var captiveInp = document.getElementsByClassName("captive-inp")
                    var code = "";
                    for (let i = 0; i < captiveInp.length; i++) {
                        code += captiveInp[i].value
                    }

                    var diff_col = 0;
                    var now = new Date();
                    sole.post(urlOrigin + "/controllers/captive_portal/get_client.php",{
                        mac : mac
                    }).then(res => {
                        diff_col = new Date(new Date(res.client[0].time).getTime() + (3 * 60 * 1000)) - now
                        if(diff_col > 0){
                            submitAuthentication(true,diff_col,code)
                        }else{
                            submitAuthentication(false,diff_col,code)
                        }
                    })

                    setTimeout(() => {
                        console.log(diff_col)
                    }, 200);
                })

                authentication.addEventListener("keyup", function(e){
                    var el = e.srcElement
                    if(e.key == "Backspace"){
                        var ids = parseInt(el.id)
                        if(ids > 1){
                            document.getElementsByClassName("inp" + (ids - 1))[0].focus()
                        }
                    }
                    if(el.value){
                        var ids = parseInt(el.id)
                        if(ids < 6){
                            document.getElementsByClassName("inp" + (ids + 1))[0].focus()
                        }
                    }
                })
            } catch (error) {
                alert(error)
            }
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
            splash(null, 200)
        </script>
        <script src="<?php echo $pathToRoot; ?>assets/js/jquery/jquery-3.7.1.js"></script>
        <script src="<?php echo $pathToRoot; ?>assets/js/popper/popper.min.js"></script>
        <script src="<?php echo $pathToRoot; ?>assets/js/datatables/datatables.min.js"></script>
        <script src="<?php echo $pathToRoot; ?>assets/js/bootstrap/bootstrap.min.js"></script>
        <script src="<?php echo $pathToRoot; ?>assets/js/sole.splash/splash.js"></script>
        <!-- <script src="<?php //echo $pathToRoot; ?>assets/js/sole.js"></script> -->
        <!-- <script src="<?php //echo $pathToRoot; ?>assets/js/script.js"></script> -->
        <!-- <script src="<?php //echo $pathToRoot; ?>assets/js/captive.js"></script> -->
    </body>
</html>
