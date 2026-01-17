if(document.getElementById("login")){
    var userid = document.getElementById("userid")
    var password = document.getElementById("password")
    var login_btn = document.getElementById("login_btn")
    
    login_btn.addEventListener("click", () => {
        login()
    })

    document.addEventListener("keypress", (e) => {
        if(userid === document.activeElement || password === document.activeElement){
            if(e.key == "Enter"){
                login()
            }
        }
    })

    function login(){
        if(userid.value && password.value){
            sole.post("../../controllers/login.php",{
                userid : userid.value,
                password : password.value
            }).then(res => {
                alert(res.message)

                if(res.status){
                    res.user[0]["privileges"] == "Technician" ? window.location.replace("t/dashboard.php") : null
                    res.user[0]["privileges"] == "Senior Technician" ? window.location.replace("st/dashboard.php") : null
                    res.user[0]["privileges"] == "Administrator" ? window.location.replace("a/dashboard.php") : null
                }
            })
        }else{
            alert("Please input USER ID and PASSWORD.")
        }
    }
}