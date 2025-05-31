if(document.getElementById("login")){
    if(localStorage.getItem("inactivity")){
        bs5.toast("info","You've been logged out of your account due to inactivity. <br> Please log in again to resume your work.","lg")
        localStorage.removeItem("inactivity")
    }
    let userid = document.getElementById("userid")
    let password = document.getElementById("password")
    let login_btn = document.getElementById("login_btn")
    let login_alert = document.getElementById("login_alert")
    let login_sound = false

    sole.post("../../controllers/settings.php")
    .then(res => {
        res["sound"] == "1" ? login_sound = true : login_sound = false;
    });
    login_alert.addEventListener("click", e => {
        login_alert.style = "display: none !important;";
        userid.value = ""
        password.value = ""
        userid.focus()
    })
    userid.focus()

    document.addEventListener("keypress", e=>{
        if(e.key == "Enter"){
            login()
        }
    })

    login_btn.addEventListener("click", e => {
        login()
    })

    function login(){
        sole.post("../controllers/login.php",{
            "userid" : userid.value,
            "password" : password.value
        }).then(res => {
            validateLogin(res)
        })
    }

    function validateLogin(res){
        if(res.status){
            bs5.toast(res.type,res.message + " " + res.user[0]["name"],res.size, true, false)
            login_sound ? audio.play() : null;
            setTimeout(() => {
                window.location.replace("inventory.php?loc=dashboard");
            }, 3000);
        }else{
            login_alert.style = "display: flex !important; height: 30px;"
            login_alert.innerText = res.message

            setTimeout(() => {
                login_alert.style = "display: none !important; height: 30px;"
            }, 2000);
        }
    }
}