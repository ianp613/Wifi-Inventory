let unclose = {
    backdrop: 'static',
    keyboard: false
}
const audio = new Audio("../assets/sound/ph.mp3");
const click = new Audio("../assets/sound/click.wav");
if(document.getElementById("sidebar")){
    
    const logout_modal = new bootstrap.Modal(document.getElementById('logout_modal'),unclose);
    const settings_modal = new bootstrap.Modal(document.getElementById('settings_modal'),unclose);
    sole.get("../controllers/validate_auth.php").then(res => {
        validateAuth(res);
    })

    function validateAuth(res){
        if(res.status){
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
        audio.play()
        logout_modal.show()
        document.getElementById("confirm_logout").addEventListener("click",function(){
            window.location.replace("../index.php");
        })
    })

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

// PUBLIC
document.addEventListener('contextmenu', event => {
    event.preventDefault();
});

const elements = document.querySelectorAll("input[type='text'], textarea");
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
            click.play();
            listener.call(this, event);
        };
        originalAddEventListener.call(this, type, newListener, options);
    } else {
        originalAddEventListener.call(this, type, listener, options);
    }
};