if(document.getElementById("login")){
    let userid = document.getElementById("userid")
    let password = document.getElementById("password")
    let login_btn = document.getElementById("login_btn")
    let login_alert = document.getElementById("login_alert")
    login_alert.addEventListener("click", e => {
        login_alert.style = "display: none !important;";
        userid.value = ""
        password.value = ""
        userid.focus()
    })
    userid.focus()

    document.addEventListener("keypress", e=>{
        if(e.key == "Enter"){
            audio.play();
            login()
        }
    })

    login_btn.addEventListener("click", e => {
        audio.play();
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
            bs5.toast(res.type,res.message + " " + res.user[0]["name"],res.size)
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