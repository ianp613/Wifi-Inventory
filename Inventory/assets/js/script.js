
if(document.getElementById("sidebar")){
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

    document.getElementById("logout").addEventListener("click",e=>{
        var btn_yes = document.createElement("button");
        var btn_no = document.createElement("button");
        var message = document.createElement("div");
        var wrapper = document.createElement("div");

        btn_yes.setAttribute("class","btn btn-sm btn-danger rounded-pill")
        btn_yes.setAttribute("id","confirm_logout")
        btn_yes.setAttribute("style","width: 50px; margin-left: 4px;")
        btn_yes.innerText = "YES"
        btn_no.setAttribute("class","btn btn-sm btn-secondary rounded-pill")
        btn_no.setAttribute("data-bs-dismiss","modal")
        btn_no.setAttribute("id","alert_button")
        btn_no.setAttribute("style","width: 50px; margin-right: 4px;")
        btn_no.innerHTML = "NO"
        message.setAttribute("class","mb-3 mt-1")
        message.innerText = "Do you wish to end the current session?"
        wrapper.setAttribute("class","w-100")

        wrapper.appendChild(message)
        wrapper.appendChild(btn_no)
        wrapper.appendChild(btn_yes)
        
        bs5.toast("info",wrapper.outerHTML,null,false,false)

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
document.addEventListener('contextmenu', event => {
    event.preventDefault();
});

const elements = document.querySelectorAll("input, textarea");
elements.forEach((element) => {
  element.addEventListener("input", function() {
    this.value = this.value.replace(/[']/g, "");
  });
});