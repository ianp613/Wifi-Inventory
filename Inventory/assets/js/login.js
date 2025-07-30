if(document.getElementById("login")){
    localStorage.removeItem("email");
    localStorage.removeItem("userid");
    localStorage.removeItem("yourname");
    localStorage.removeItem("username");
    localStorage.removeItem("privileges");

    if(localStorage.getItem("inactivity")){
        bs5.toast("info","<div class=\"w-100 mb-2 text-primary\"><span class=\"fa fa-info\"></span></div>You've been logged out of your account due to inactivity. <br> Please log in again to resume your work.","lg", true, false)
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
        if(e.key == "Enter" && document.activeElement === userid){
            login()
        }
        if(e.key == "Enter" && document.activeElement === password){
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
            login_btn.setAttribute("disabled","")
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
    const chatbot_body = document.getElementById("chatbot_body")
    const chatbot_input = document.getElementById("chatbot_input")
    const chatbot_send = document.getElementById("chatbot_send")
    const speed = 5;
    var reply = []
    var reply_output = ""
    scrollToBottom()

    chatbot_input.addEventListener('focus', scrollToBottom);
    chatbot_input.addEventListener('click', scrollToBottom);

    chatbot_send.addEventListener("click",function(){
        var br = document.createElement("br")
        var wrapper = document.createElement("div")
        var chat_message_right = document.createElement("div")
        chat_message_right.setAttribute("class","chatbot-message-right")
        var chat_head = document.createElement("p")
        chat_head.innerText = "You"
        var chat_message = document.createElement("div")
        chat_message_right.appendChild(chat_head)
        chat_message_right.appendChild(chat_message)
        wrapper.appendChild(chat_message_right)
        chatbot_body.appendChild(wrapper)
        chatbot_body.appendChild(br)
        chat_message.innerText = chatbot_input.value

        sole.post("../../controllers/chatbot/main.php",{
            message : chatbot_input.value
        }).then(res => {
            if(res){
                reply = res
                if(res[0]){
                    var br = document.createElement("br")
                    var wrapper = document.createElement("div")
                    var chat_message_left = document.createElement("div")
                    chat_message_left.setAttribute("class","chatbot-message-left")
                    var chat_head = document.createElement("p")
                    chat_head.innerText = "Inventory Bot"
                    var chat_message = document.createElement("div")
                    chat_message.setAttribute("id",res[1])
                    chat_message_left.appendChild(chat_head)
                    chat_message_left.appendChild(chat_message)
                    wrapper.appendChild(chat_message_left)
                    chatbot_body.appendChild(wrapper)
                    chatbot_body.appendChild(br)
                    botReply()
                }
            }
        })
        chatbot_input.value = ""

        scrollToBottom()
    })


    function scrollToBottom() {
        chatbot_body.scrollTo({
            top: chatbot_body.scrollHeight,
            behavior: 'smooth'
        });
    }

    let i = 0;
    // let output = "";

    // typeWriter();
    
    function botReply(){
        var text = ""
        if (typeof reply[0] === 'string'){
            text = reply[0]
        }else{
            text = reply[0][1]
        }
        if (i < text.length) {
            reply_output += text.charAt(i);
            document.getElementById(reply[1]).innerHTML = reply_output;
            i++;
            setTimeout(botReply, speed);
        }else{
            reply_output = ""
            i = 0
        }
        scrollToBottom()
    }

    // function typeWriter() {
        
    // }
    


}