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
                            <input maxlength="1" type="number" name="" id="1" class="inp1 captive-inp form-control">
                        </div>
                        <div class="col-md-2 ps-1 pe-1">
                            <input maxlength="1" type="number" name="" id="2" class="inp2 captive-inp form-control">
                        </div>
                        <div class="col-md-2 ps-1 pe-1">
                            <input maxlength="1" type="number" name="" id="3" class="inp3 captive-inp form-control">
                        </div>
                        <div class="col-md-2 ps-1 pe-1">
                            <input maxlength="1" type="number" name="" id="4" class="inp4 captive-inp form-control">
                        </div>
                        <div class="col-md-2 ps-1 pe-1">
                            <input maxlength="1" type="number" name="" id="5" class="inp5 captive-inp form-control">
                        </div>
                        <div class="col-md-2 ps-1 pe-1">
                            <input maxlength="1" type="number" name="" id="6" class="inp6 captive-inp form-control">
                        </div>
                    </div>
                </div>
                <code id="captive_alert" hidden>You can now access the internet. <br> Please refresh the page if nothing happens.
                    <br> You can also view this page anytime at <a href="//192.168.15.221" target="_blank">192.168.15.221</a>
                </code>
                <h3 id="captive_timer" class="captive-timer"></h3>
                <div hidden class="lockout" id="lockout">
                    <h6>⚠️ You have reached the maximum number of login attempts. Please try again after <span id="lockout_time">30</span>.</h6>
                </div>
                <div id="captive_submit" class="captive-submit">Login</div>
                <h6 style="margin-top: 95px" class="text-dark blink"><strong>Powered By: DDC Wifi Team</strong></h6>
            </div>
        </div>
        <canvas id="weatherCanvas"></canvas>
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

                setTimeout(() => {
                    checkLockout("check")
                }, 500);

                function checkLockout(type){
                    sole.post(urlOrigin + "/controllers/captive_portal/check_lockout.php",{
                        mac : mac,
                        type : type
                    }).then(res => {
                        if(parseInt(res.client[0].attempt) == 3 && res.client[0].time != "-"){
                            const lockout_ = document.getElementById('lockout');
                            lockout_.hidden = false
                            // Start time
                            const startTime = new Date(res.client[0].time);

                            // Add 30 minutes
                            const endTime = new Date(startTime.getTime() + 30 * 60 * 1000);

                            const timerEl = document.getElementById('lockout_time');

                            function lockoutTimer() {
                                const now = new Date();
                                let diff = endTime - now;

                                if (diff <= 0) {
                                    clearInterval(interval_)
                                    setTimeout(() => {
                                        checkLockout("reset")
                                    }, 500);
                                    lockout_.hidden = true
                                    timerEl.innerText = '0 min and 0 sec';
                                    return;
                                }

                                const totalSeconds = Math.floor(diff / 1000);
                                const minutes = Math.floor(totalSeconds / 60);
                                const seconds = totalSeconds % 60;
                                var min_ = minutes > 1 ? "mins" : "min"
                                var sec_ = seconds > 1 ? "secs" : "sec"
                                timerEl.innerText = minutes ? `${minutes} ${min_} and ${seconds} ${sec_}` : ` ${seconds} ${sec_}`;
                            }

                            lockoutTimer();               // initial run
                            var interval_ = setInterval(lockoutTimer, 1000); // update every second
                        }
                    })
                }
                
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
                                        checkLockout("reset")
                                        
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
                                    checkLockout("post")
                                    alert('Authorization failed.');
                                }
                            } catch (e) {
                                console.log(e)
                                // alert('Invalid response format.');
                            }
                        })    
                    }else{
                        const totalSeconds = Math.floor(time / 1000);
                        const days = Math.floor(totalSeconds / 86400); // 86400 seconds in a day
                        const hours = Math.floor((totalSeconds % 86400) / 3600);
                        const minutes = Math.floor((totalSeconds % 3600) / 60);
                        const seconds = totalSeconds % 60;

                        // Build display string
                        let display = "";
                        display += (days > 0 ? days + "d " : "") + (hours > 0 ? hours + "h " : "") + (minutes > 0 ? minutes + "m " : "") + (seconds > 0 ? seconds + "s" : "")
                        alert("Please try again after " + display)
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
                        if(res.status){
                            const targetMinutes = res.authentication.target; // you can set this dynamically
                            const startTime = new Date(res.client[0].time);
                            const targetCooldown = 10 //Change to cooldown Minutes

                            // Target time is start + targetMinutes
                            const targetTime = new Date(startTime.getTime() + (targetMinutes * 60 * 1000) + (targetCooldown * 60 * 1000));


                            // var startTime = res.client.length ? new Date(res.client[0].time) : 0
                            // var targetTime = new Date(startTime.getTime() + res.authentication ? res.authentication.target * 60 * 1000 : 0)

                            // const targetTime = new Date(startTime.getTime() + targetMinutes * 60 * 1000);
                            diff_col = targetTime - now
                        }
                        if(diff_col > 0){
                            submitAuthentication(true,diff_col,code)
                        }else{
                            submitAuthentication(false,diff_col,code)
                        } 
                    })

                    setTimeout(() => {
                        // alert("sample")
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
                        var text = document.getElementsByClassName("inp" + ids)[0]
                        var text_split = text.value.split("")
                        if(text_split.length){
                            text.value = text_split[0]
                        }
                        if(ids < 6){
                            document.getElementsByClassName("inp" + (ids + 1))[0].focus()
                        }
                    }
                })
            } catch (error) {
                alert(error)
            }


            const MIN_SWIPE_DISTANCE = 50; // minimum pixels to count as swipe
            const TARGET_SWIPES = 10;
            const SWIPE_TIMEOUT = 2000; // reset counter if no swipe in 2 sec

            let swipeCount = 0;
            let startX = 0;
            let swipeTimeout;

            // const message = document.getElementById('message');

            function resetSwipeCounter() {
                swipeCount = 0;
                console.log(`Swipe ${TARGET_SWIPES} times horizontally`)
            }

            function startSwipe(x) {
                startX = x;
            }

            function endSwipe(x) {
                const deltaX = x - startX;

                if (Math.abs(deltaX) > MIN_SWIPE_DISTANCE) {
                    const direction = deltaX > 0 ? "Right" : "Left";
                    swipeCount++;
                    // message.textContent = `Swipe ${direction} detected! Count: ${swipeCount}`;
                    console.log(`Swipe ${direction} detected! Count: ${swipeCount}`)

                    clearTimeout(swipeTimeout);
                    swipeTimeout = setTimeout(resetSwipeCounter, SWIPE_TIMEOUT);

                    if (swipeCount >= TARGET_SWIPES) {
                    //   message.textContent = `✅ 3 ${direction} swipes completed!`;
                        console.log(`✅ ${TARGET_SWIPES} ${direction} swipes completed!`)
                        alert("Code SLR has been activated.")
                        window.location.reload()
                        checkLockout("reset")
                        swipeCount = 0; // reset counter
                    }
                }
            }

            const element = document.body;

            // Touch events
            element.addEventListener('touchstart', (e) => startSwipe(e.touches[0].clientX));
            element.addEventListener('touchend', (e) => endSwipe(e.changedTouches[0].clientX));

            // Mouse events
            element.addEventListener('mousedown', (e) => startSwipe(e.clientX));
            element.addEventListener('mouseup', (e) => endSwipe(e.clientX));


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

            /* ------------------------- VALENTINES START ------------------------------------------------------------------------- */

            const canvas = document.getElementById('weatherCanvas');
            const ctx = canvas.getContext('2d');

            let W = window.innerWidth;
            let H = window.innerHeight;
            canvas.width = W;
            canvas.height = H;

            const hearts = [];

            // Colors
            const heartColors = ['#ff4d6d', '#ff85a1', '#ff1e56', '#ff6f91'];

            // --- Heart Constructor ---
            function Heart(x, y) {
                this.x = x;
                this.y = y;
                this.size = Math.random() * 15 + 10;
                this.color = heartColors[Math.floor(Math.random() * heartColors.length)];
                this.alpha = 1;
                this.speed = Math.random() * 1.5 + 0.5;
                this.swing = Math.random() * Math.PI * 2;
            }

            // --- Draw Heart Shape ---
            function drawHeart(x, y, size, color, alpha) {
                ctx.save();
                ctx.translate(x, y);
                ctx.scale(size / 30, size / 30);
                ctx.globalAlpha = alpha;
                ctx.fillStyle = color;

                ctx.beginPath();
                ctx.moveTo(0, 10);
                ctx.bezierCurveTo(0, 0, -15, 0, -15, 10);
                ctx.bezierCurveTo(-15, 25, 0, 30, 0, 40);
                ctx.bezierCurveTo(0, 30, 15, 25, 15, 10);
                ctx.bezierCurveTo(15, 0, 0, 0, 0, 10);
                ctx.closePath();
                ctx.fill();

                ctx.restore();
            }

            // --- Create Heart ---
            function spawnHeart() {
                hearts.push(new Heart(Math.random() * W, H + 20));
            }

            // --- Animation Loop ---
            function draw() {
                // White background
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, W, H);

                for (let i = hearts.length - 1; i >= 0; i--) {
                    const h = hearts[i];

                    drawHeart(h.x, h.y, h.size, h.color, h.alpha);

                    h.y -= h.speed;
                    h.swing += 0.05;
                    h.x += Math.sin(h.swing) * 0.5;
                    h.alpha -= 0.003;

                    if (h.alpha <= 0 || h.y < -50) {
                        hearts.splice(i, 1);
                    }
                }
            }

            // Resize handler
            window.addEventListener('resize', () => {
                W = window.innerWidth;
                H = window.innerHeight;
                canvas.width = W;
                canvas.height = H;
            });

            // Start
            setInterval(spawnHeart, 300);
            setInterval(draw, 30);
            /* ------------------------- VALENTINES END ------------------------------------------------------------------------- */




            /* ------------------------- NEW YEAR START ------------------------------------------------------------------------- */

            // const canvas = document.getElementById('weatherCanvas');
            // const ctx = canvas.getContext('2d');
            // let W = window.innerWidth;
            // let H = window.innerHeight;
            // canvas.width = W;
            // canvas.height = H;

            // // Arrays
            // const fireworks = [];
            // const particles = [];
            // const stars = [];

            // // Colors
            // const colors = ['#ff0043', '#00ffd5', '#fffc00', '#ff7f00', '#00ff00', '#00aaff', '#ff00ff'];

            // // --- Create Stars ---
            // function initStars() {
            //     const MAX_STARS = 150;
            //     for (let i = 0; i < MAX_STARS; i++) {
            //         stars.push({
            //             x: Math.random() * W,
            //             y: Math.random() * H,
            //             r: Math.random() * 1.5 + 0.5,
            //             alpha: Math.random(),
            //             fade: Math.random() * 0.02 + 0.01 // twinkle speed
            //         });
            //     }
            // }

            // // --- Firework constructor ---
            // function Firework(x, y) {
            //     this.x = x;
            //     this.y = H;
            //     this.targetY = y;
            //     this.speed = 5;
            //     this.exploded = false;
            //     this.color = colors[Math.floor(Math.random() * colors.length)];
            // }

            // // --- Particle constructor ---
            // function Particle(x, y, color) {
            //     this.x = x;
            //     this.y = y;
            //     this.r = Math.random() * 3 + 2;
            //     this.color = color;
            //     this.alpha = 1;
            //     this.velX = (Math.random() - 0.5) * 8;
            //     this.velY = (Math.random() - 0.5) * 8;
            // }

            // // --- Launch Firework ---
            // function launchFirework() {
            //     const x = Math.random() * W;
            //     const y = Math.random() * (H / 2);
            //     fireworks.push(new Firework(x, y));
            // }

            // // --- Draw Stars ---
            // function drawStars() {
            //     for (let i = 0; i < stars.length; i++) {
            //         const s = stars[i];
            //         ctx.fillStyle = `rgba(255,255,255,${s.alpha})`;
            //         ctx.beginPath();
            //         ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
            //         ctx.fill();

            //         // Twinkle effect
            //         s.alpha += s.fade;
            //         if (s.alpha <= 0 || s.alpha >= 1) {
            //             s.fade = -s.fade;
            //         }
            //     }
            // }

            // // --- Draw Fireworks ---
            // function draw() {
            //     ctx.fillStyle = 'rgba(0, 0, 0, 0.2)'; 
            //     ctx.fillRect(0, 0, W, H);

            //     drawStars();

            //     // Fireworks
            //     for (let i = fireworks.length - 1; i >= 0; i--) {
            //         const f = fireworks[i];
            //         if (!f.exploded) {
            //             ctx.fillStyle = f.color;
            //             ctx.beginPath();
            //             ctx.arc(f.x, f.y, 3, 0, Math.PI * 2);
            //             ctx.fill();

            //             f.y -= f.speed;
            //             if (f.y <= f.targetY) {
            //                 f.exploded = true;
            //                 for (let j = 0; j < 50; j++) {
            //                     particles.push(new Particle(f.x, f.y, f.color));
            //                 }
            //                 fireworks.splice(i, 1);
            //             }
            //         }
            //     }

            //     // Particles
            //     for (let i = particles.length - 1; i >= 0; i--) {
            //         const p = particles[i];
            //         ctx.fillStyle = `rgba(${hexToRgb(p.color)}, ${p.alpha})`;
            //         ctx.beginPath();
            //         ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            //         ctx.fill();

            //         p.x += p.velX;
            //         p.y += p.velY;
            //         p.alpha -= 0.02;

            //         if (p.alpha <= 0) {
            //             particles.splice(i, 1);
            //         }
            //     }
            // }

            // function hexToRgb(hex) {
            //     const bigint = parseInt(hex.slice(1), 16);
            //     const r = (bigint >> 16) & 255;
            //     const g = (bigint >> 8) & 255;
            //     const b = bigint & 255;
            //     return `${r},${g},${b}`;
            // }

            // window.addEventListener('resize', () => {
            //     W = window.innerWidth;
            //     H = window.innerHeight;
            //     canvas.width = W;
            //     canvas.height = H;
            //     stars.length = 0;
            //     initStars();
            // });

            // // Initialize
            // initStars();
            // setInterval(launchFirework, 800);
            // setInterval(draw, 30);

           /*  ------------------------- NEW YEAR END ------------------------------------------------------------------------- */








            /* ------------------------- CHRISTMAS START ------------------------------------------------------------------------- */

            // // JavaScript Code
            // const canvas = document.getElementById('weatherCanvas');
            // const ctx = canvas.getContext('2d');
            // let W = window.innerWidth;
            // let H = window.innerHeight;
            // canvas.width = W;
            // canvas.height = H;

            // // Configuration
            // const MAX_PARTICLES = 80;
            // const particles = [];
            
            // // --- Load a Snowflake Image (used for image particles) ---
            // const snowflakeImage = new Image();
            // // !! IMPORTANT: Replace the URL below with a link to your hosted snowflake PNG image !!
            // snowflakeImage.src = urlOrigin + '/assets/img/captive/snowflake.svg'; 

            // function init() {
            //     for (let i = 0; i < MAX_PARTICLES; i++) {
            //         const isImage = Math.random() > 0.5; // 50% chance of being an image
                    
            //         let size;
            //         if (isImage) {
            //             // BIGGER SIZE FOR IMAGES (20px to 40px)
            //             size = Math.random() * 20 + 20; 
            //         } else {
            //             // UNCHANGED SIZE FOR CIRCLES (4px to 12px)
            //             size = Math.random() * 8 + 4;
            //         }

            //         particles.push({
            //             x: Math.random() * W,
            //             y: Math.random() * H,
            //             r: size, // Apply the determined size
            //             d: Math.random() * MAX_PARTICLES, // Density/speed variation
            //             type: isImage ? 'image' : 'circle' // Define particle type
            //         });
            //     }
            // }

            // function draw() {
            //     ctx.clearRect(0, 0, W, H);
            //     for (let i = 0; i < MAX_PARTICLES; i++) {
            //         const p = particles[i];

            //         if (p.type === 'image' && snowflakeImage.complete) {
            //             // Draw the image if loaded
            //             ctx.drawImage(snowflakeImage, p.x, p.y, p.r, p.r);
            //         } else {
            //             // Draw a circle for rain or simple snow (CODE UNALTERED)
            //             ctx.fillStyle = 'rgba(255, 255, 255, 0.8)';
            //             ctx.beginPath();
            //             ctx.moveTo(p.x, p.y);
            //             ctx.arc(p.x, p.y, p.r/2, 0, Math.PI * 2, true); 
            //             ctx.fill();
            //         }
            //     }
            //     update();
            // }

            // function update() {
            //     for (let i = 0; i < MAX_PARTICLES; i++) {
            //         const p = particles[i];

            //         // Snow movement (slower fall, slight sway)
            //         p.y += Math.cos(p.d) + 1 + p.r / 10; 
            //         p.x += Math.sin(p.d) * 0.4;
                    
            //         // If the particle is off-screen, reset its position
            //         if (p.y > H || p.x > W || p.x < 0) {
            //             p.x = Math.random() * W;
            //             p.y = -50; // Start higher above the top
            //             // When resetting, we also need to maintain the original size/type properties:
            //             // Note: The size defined in 'init' is maintained when it loops back to the top
            //         }
            //     }
            // }

            // window.addEventListener('resize', () => {
            //     W = window.innerWidth;
            //     H = window.innerHeight;
            //     canvas.width = W;
            //     canvas.height = H;
            // });

            // // Wait for the image to load before starting the animation loop
            // snowflakeImage.onload = () => {
            //     init();
            //     setInterval(draw, 30);
            // };
            
            // // If the image is already loaded (cached), initialize immediately
            // if (snowflakeImage.complete) {
            //     init();
            //     setInterval(draw, 30);
            // }

            /* ------------------------- CHRISTMAS END ------------------------------------------------------------------------- */
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
