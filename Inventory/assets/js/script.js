let unclose = {
    backdrop: 'static',
    keyboard: false
}
const audio = new Audio("../assets/sound/ph.mp3");
const click = new Audio("../assets/sound/click.wav");
var switch_sound = document.getElementById("switch_sound")
var switch_sound_check = document.getElementById("switch_sound_check")

var sound = null;
var theme = null;

if(document.getElementById("sidebar")){
    let inactivityTime = 60000 * 5; // 5 minutes
    let timeout;

    function inactive_logout() {
        localStorage.setItem("inactivity",true)
        window.location.replace("../index.php");
    }

    function resetTimer() {
        clearTimeout(timeout);
        timeout = setTimeout(inactive_logout, inactivityTime);
    }

    document.addEventListener('mousemove', resetTimer);
    document.addEventListener('keypress', resetTimer);
    document.addEventListener('mousedown', resetTimer);
    document.addEventListener('touchstart', resetTimer);

    // Start the timer initially
    resetTimer();




    sole.get("../../controllers/settings.php").then(res => settings(res))

    const logout_modal = new bootstrap.Modal(document.getElementById('logout_modal'),unclose);
    const settings_modal = new bootstrap.Modal(document.getElementById('settings_modal'),unclose);
    const confirm_export_modal = new bootstrap.Modal(document.getElementById('confirm_export_modal'),unclose);
    sole.get("../controllers/validate_auth.php").then(res => {
        validateAuth(res);
    })

    function validateAuth(res){
        if(res.status){
            localStorage.setItem("user_id",res.user[0]["username"])
            document.getElementById("userDropdown").innerHTML = "<span class=\"fa fa-user-circle-o\"></span> " + res.user[0]["name"]
        }else{
            window.location.replace("../index.php");
        }
    }
    

    document.getElementById("settings").addEventListener("click",function(){
        settings_modal.show()
    })

    document.getElementById("switch").addEventListener("click",function(){
        console.log("switch")
    })

    document.getElementById("logout").addEventListener("click",function(){
        sound ? audio.play() : null
        logout_modal.show()
        document.getElementById("confirm_logout").addEventListener("click",function(){
            window.location.replace("../index.php");
        })
    })

    var export_password = document.getElementById("export_password");

    document.getElementById("export_db").addEventListener("click",function(){
        settings_modal.hide()
        confirm_export_modal.show()
    })

    //  // CONFIRM PASSWORD FOCUS
    // document.getElementById('confirm_export_modal').addEventListener('shown.bs.modal', function () {
    //     export_password.focus()
    // })

    document.getElementById("cancel_export").addEventListener("click",function(){
        settings_modal.show()
        confirm_export_modal.hide()
        export_password.value = ""
    })

    document.getElementById("confirm_export").addEventListener("click",function(){
        if(localStorage.getItem("user_id")){
            if(export_password.value){
                sole.post("../controllers/pass_check.php",{
                    userid: localStorage.getItem("user_id"),
                    password: export_password.value
                })
                .then(res => exportAssist(res))
            }else{
                alert("PLEASE INPUT ACCOUNT PASSWORD")
            }
        }else{
            bs5.toast("warning","Something went wrong, try again.")
        }
    })

    function exportAssist(res){
        if(res.status){
            sole.get("../controllers/db_export.php")
            .then(res => exportAssistDownload(res))
        }else{
            alert(res.message)
        }
    }

    function exportAssistDownload(res){
        if(res){
            const filePath = res;
            const filename = filePath.split('/').pop();

            fetch(res)
            .then(response => response.blob()) // Convert response to a Blob
            .then(blob => {
                const link = document.createElement("a");
                link.href = URL.createObjectURL(blob);
                link.download = filename; // Set the filename
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            })
            .catch(error => bs5.toast("error", "Export Failed: " + error));

            settings_modal.show()
            confirm_export_modal.hide()
            export_password.value = ""

            setTimeout(() => {
                sole.post("../../controllers/clear_temp.php").then(res => console.log(res));
            }, 5000);
        }else{
            alert("EXPORT ERROR")
        }
    }

    const sidebar = document.getElementById('sidebar');
    let collapsed = false;

    function toggleSidebar() {
        sidebar.classList.toggle('collapsed');
        collapsed = !collapsed;
    }

    // Add a toggle button (optional)
    const toggleButton = document.createElement('button');
    toggleButton.innerHTML = '<i class="fa fa-bars"></i>';
    toggleButton.classList.add('btn', 'btn-outline-light', 'mb-3');
    toggleButton.style = "width: 50px;"
    toggleButton.addEventListener('click', toggleSidebar);

    // Insert the toggle button at the top of the sidebar
    //sidebar.insertBefore(toggleButton, sidebar.firstChild);
    const toggleButtonContainer = document.createElement('div');
    toggleButtonContainer.id = 'toggleButton';
    toggleButtonContainer.style.marginBottom = '10px';
    toggleButtonContainer.style.textAlign = 'center';
    toggleButtonContainer.style.width = '100%';
    toggleButtonContainer.style.borderRadius = '0';
    toggleButtonContainer.style.marginTop = 'auto';

    toggleButtonContainer.appendChild(toggleButton);
    sidebar.appendChild(toggleButtonContainer);

    // Initial check for screen size
    function checkScreenSize() {
        if (window.innerWidth <= 768 && !collapsed) {
            toggleSidebar();
        } else if (window.innerWidth > 768 && collapsed) {
            toggleSidebar();
        }
    }

    // Call checkScreenSize on load and resize
    window.addEventListener('load', checkScreenSize);
    window.addEventListener('resize', checkScreenSize);
}

if(document.getElementsByClassName("ps-field")[0]){
    document.getElementsByClassName("ps-field")[0].addEventListener("click",function(e){
        if(e.target.tagName == "SPAN"){
            if(e.target.classList.contains("fa-eye-slash")){
                document.getElementById("password").type = "text"
                e.target.classList.remove("fa-eye-slash")
                e.target.classList.add("fa-eye")
            }else{
                document.getElementById("password").type = "password"
                e.target.classList.remove("fa-eye")
                e.target.classList.add("fa-eye-slash")
            }
        }
    })    
}



// PUBLIC
document.addEventListener('contextmenu', event => {
    event.preventDefault();
});

const elements = document.querySelectorAll("input[type='text'], input[type='password'], textarea");
elements.forEach((element) => {
  element.addEventListener("input", function() {
    this.value = this.value.replace(/[']/g, "");
  });
});

const originalAddEventListener = EventTarget.prototype.addEventListener;

// Override the method to include the click sound
EventTarget.prototype.addEventListener = function(type, listener, options) {
    if (type === "click") {
        // Wrap the original listener to also play the sound
        const newListener = function(event) {
            sound ? click.play() : null;
            listener.call(this, event);
        };
        originalAddEventListener.call(this, type, newListener, options);
    } else {
        originalAddEventListener.call(this, type, listener, options);
    }
};


if(document.getElementById("sidebar")){
    document.getElementById("settings_modal").addEventListener('shown.bs.modal', function () {
        sole.get("../../controllers/settings.php").then(res => settings(res))
    })

    function settings(res){
        sound = res["sound"] == "1" ? true : false
        theme = res["theme"] == "1" ? true : false

        if(sound){
            switch_sound_check.setAttribute("checked","true")
        }else{
            switch_sound_check.getAttribute("checked") ? switch_sound_check.removeAttribute("checked") : null
        }
    }
    let isRunning = false;
    switch_sound.addEventListener("click",function (e){
        if (isRunning) return;
        isRunning = true;
        sole.post("../../controllers/settings_set.php", {
            type: "sound"
        }).then(res => {
            settings(res);
            isRunning = false;
        });
    })
}


function splash(message, seconds) {
  // Create splash element
  const splashScreen = document.createElement("div");
  const bs5_spinner = "<div class=\"spinner-border text-danger ht-70 wd-70 me-5\" role=\"status\"></div>"
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
