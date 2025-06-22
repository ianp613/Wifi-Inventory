let card_array = [
    "search",
    "envelope",
    "heart",
    "star",
    "remove",
    "github",
    "home",
    "download",
    "refresh",
    "lock",
    "flag",
    "music",
    "qrcode",
    "tags",
    "book",
    "print",
    "camera",
    "user",
    "group",
    "usb",
    "bitbucket",
    "bluetooth",
    "comments",
    "facebook",
    "css3",
]
let card_index = 0;
let card_temp = [];
let card_set = [];
let mp_score = 0
let mp_incorrect = 0
let mp_timer = 300
let mp_size = false;
let mp_message = "Game Over";
let mp_board_animation = "none"
let card_board = null
let card_name_temp = null;
let card_id_temp = null;
let mp_score_temp = 0;
function initialize_matchpuzzle(){
    document.body.insertAdjacentHTML("beforeend",
        "<div id=\"matchpuzzle_gameboard\">"+
            "<div id=\"mp_board\">"+
                "<div id=\"mp_cards\" class=\"row\">"+
                "</div>"+
            "</div>"+
            "<div id=\"mp_board_cover\">"+
            "</div>"+
            "<div id=\"mp_board_controller\">"+
                "<div class=\"row\">"+
                    "<div class=\"col-md-8 mp_statistic\">"+
                        "<span id=\"mp_score\">Scrore: 0</span>"+
                        "<span id=\"mp_incorrect\">Incorrect Guess: 0</span>"+
                        "<span id=\"mp_level\">Level: Normal</span>"+
                        "<span id=\"mp_timer\">Timer: 0</span>"+
                    "</div>"+
                    "<div class=\"col-md-4 mp_buttons\">"+
                        "<select id=\"mp_level_picker\" class=\"form-control\">"+
                            "<option value=\"Normal\">Normal</option>"+
                            "<option value=\"Hard\">Hard</option>"+
                        "</select>"+
                        "<button id=\"mp_start\">Start</button>"+
                        "<button id=\"mp_reset\">Reset</button>"+
                        "<button id=\"mp_pause\">Pause</button>"+
                        "<button id=\"mp_close\">Close</button>"+
                    "</div>"+
                "</div>"+
            "</div>"+
            "<div id=\"mp_board_message_cover\">"+
                "<span>Match Puzzle</span>"+
            "</div>"+
        "</div>"
    )
    document.body.style = "scrollbar-width: 0px;"
    document.body.onresize = resize_mp_board
    document.onkeydown = pause_mp_game_keyboard
    document.getElementById("mp_start").onclick = start_mp_game
    document.getElementById("mp_reset").onclick = reset_mp_game_all
    document.getElementById("mp_pause").onclick = pause_mp_game
    document.getElementById("mp_close").onclick = close_mp_game
    resize_mp_board()
}
function resize_mp_board(){
    var clientHeight = parseInt(document.body.clientHeight)
    var finalHeight = (Math.round((clientHeight / 100)) * 100) - 110
    var clientWidth = parseInt(document.body.clientWidth)
    var finalWidth = (Math.round((clientWidth / 100)) * 100) - 100
    var mp_board = document.getElementById("mp_board")
    if(mp_size){
        finalWidth = finalWidth / 2
    }
    if(mp_board){
        mp_board.style = "height: " + finalHeight + "; width:" + finalWidth + "; animation: " +  mp_board_animation + " 2s linear infinite";
    }
}
function start_mp_game(){
    if(document.getElementById("mp_level_picker").value == "Normal"){
        mp_size = true;    
    }else{
        mp_size = false;
    }
    document.getElementById("mp_start").style = "display: none";
    document.getElementById("mp_reset").style = "display: block";
    document.getElementById("mp_pause").style = "display: block";
    document.getElementById("mp_level_picker").style = "display: none";
    document.getElementById("mp_cards").innerHTML = ""
    reset_mp_game()
    card_temp = card_array.splice(card_index)
    get_card_set(card_temp)
}
function get_card_set(cards){
    sole.post("../../resources/temp/api/sole.matchpuzzle.php",{
        cards : cards
    }).then(res => set_card_set(res))
}
function set_card_set(cards){
    var mp_cards = document.getElementById("mp_cards");
    if(mp_size){
        for (let index = 0; index < cards.length; index++) {
            if(index == 12){
                mp_cards.insertAdjacentHTML("beforeend",
                    "<div class=\"card\" style=\"background: #343a40; color: white;\" id=\"free\" name=\"free\"><span>FREE</span></div>"
                )
                mp_cards.insertAdjacentHTML("beforeend",
                    "<div class=\"card\" style=\"background: #343a40;\" onclick=\"remove_card_cover(this.attributes)\" id=\""+cards[index]+parseInt(Math.random() * 1000)+"\" name=\""+cards[index]+"\"><span class=\"fa fa-"+cards[index]+"\"></span></div>"
                )
            }else{
                mp_cards.insertAdjacentHTML("beforeend",
                    "<div class=\"card\" style=\"background: #343a40;\" onclick=\"remove_card_cover(this.attributes)\" id=\""+cards[index]+parseInt(Math.random() * 1000)+"\" name=\""+cards[index]+"\"><span class=\"fa fa-"+cards[index]+"\"></span></div>"
                )    
            }
        }
    }else{
        for (let index = 0; index < cards.length; index++) {
            mp_cards.insertAdjacentHTML("beforeend",
                "<div class=\"card\" style=\"background: #343a40;\" onclick=\"remove_card_cover(this.attributes)\" id=\""+cards[index]+parseInt(Math.random() * 1000)+"\" name=\""+cards[index]+"\"><span class=\"fa fa-"+cards[index]+"\"></span></div>"
            )
        }
    }
    mp_message = "Memorize Cards"
    show_mp_cover_message()
    decrement_mp_timer();
}
function decrement_mp_timer(){
    mp_timer--;
    check_mp_timer()
}
function check_mp_timer(){
    setTimeout(function onTick() {
        document.getElementById("mp_timer").innerText = "Timer: " + mp_timer
        if(mp_timer != 0){
            if(mp_timer <= 10){
                mp_board_animation = "alertmpbackground"
                resize_mp_board()
            }
            if(mp_size){
                if(mp_score == mp_score_temp){
                    mp_score_temp += 12
                    mp_timer += 300
                    reload_cards()
                }
            }else{
                if(mp_score == mp_score_temp){
                    mp_score_temp += 25
                    mp_timer += 600
                    reload_cards()
                }
            }
            decrement_mp_timer()
        }else{
            if(mp_message == "Game Over"){
                reset_mp_game_all()
                mp_message = "Game Over"
                show_mp_cover_message()
            }else{
                show_mp_cover_message()
            }
        }
    }, 1000)
}
function remove_card_cover(attrib){
    document.getElementById(attrib.id.value).style = "background: white;"
    if(card_name_temp){
        document.getElementById("mp_board_cover").style = "display: block";
        compare_cards(attrib.name.value,attrib.id.value)
    }else{
        card_name_temp = attrib.name.value
        card_id_temp = attrib.id.value
    }
}
function restore_card_cover(id){
    document.getElementById(card_id_temp).style = "background: #343a40;"
    document.getElementById(id).style = "background: #343a40;"
    document.getElementById("mp_board_cover").style = "display: none";
    card_name_temp = null
    card_id_temp = null
}
function compare_cards(card,id){
    if(card_name_temp == card && card_id_temp != id){
        mp_score += 1;
        document.getElementById("mp_score").innerText = "Score: " + mp_score
        document.getElementById("mp_board_cover").style = "display: none";
        document.getElementById(card_id_temp).removeAttribute("onclick")
        document.getElementById(id).removeAttribute("onclick")
        card_name_temp = null
        card_id_temp = null
    }else{
        mp_incorrect += 1;
        document.getElementById("mp_incorrect").innerText = "Incorrect Guess: " + mp_incorrect
        setTimeout(function onTick() {
            restore_card_cover(id)
        }, 350)
    }
}
function reset_mp_game(){
    restore_cards()
    if(document.getElementById("mp_level_picker").value == "Normal"){
        document.getElementById("mp_level").innerText = "Level: Normal"
        mp_timer = 300
        card_index = 13;
        mp_score_temp = 12;
        mp_size = true;
        resize_mp_board()    
    }else{
        document.getElementById("mp_level").innerText = "Level: Hard"
        mp_timer = 600
        card_index = 0;
        mp_score_temp = 25;
        mp_size = false;
        resize_mp_board()
    }
    card_temp = [];
    card_set = [];
    mp_score = 0
    mp_incorrect = 0
    mp_message = "Game Over";
    mp_board_animation = "none"
    card_board = null
    card_name_temp = null;
    card_id_temp = null;
}
function reset_mp_game_all(){
    reset_mp_game()
    mp_size = false;
    mp_timer = 0
    mp_message = "Game Reset";
    resize_mp_board()
    document.getElementById("mp_start").style = "display: block";
    document.getElementById("mp_reset").style = "display: none";
    document.getElementById("mp_pause").style = "display: none";
    document.getElementById("mp_level_picker").style = "display: block";
    document.getElementById("mp_cards").innerHTML = ""
    document.getElementById("mp_score").innerText = "Score: 0"
    document.getElementById("mp_level").innerText = "Level: Normal"
    document.getElementById("mp_incorrect").innerText = "Incorrect Guess: 0"
    document.getElementById("mp_timer").innerText = "Timer: 0"
}
function restore_cards(){
    card_array = [
        "search",
        "envelope",
        "heart",
        "star",
        "remove",
        "github",
        "home",
        "download",
        "refresh",
        "lock",
        "flag",
        "music",
        "qrcode",
        "tags",
        "book",
        "print",
        "camera",
        "user",
        "group",
        "usb",
        "bitbucket",
        "bluetooth",
        "comments",
        "facebook",
        "css3",
    ]
}
function reload_cards(){
    restore_cards()
    document.getElementById("mp_cards").innerHTML = ""
    card_temp = card_array.splice(card_index)
    get_card_set(card_temp)
}
function show_mp_cover_message(){
    document.getElementById("mp_board_message_cover").style = "display: block"
    document.getElementById("mp_board_message_cover").innerHTML = "<span>"+mp_message+"</span>"
    setTimeout(remove_mp_cover_message, 3000)
}
function remove_mp_cover_message(){
    document.getElementById("mp_board_message_cover").style = "display: none"
    mp_message = "Game Over"
}
function pause_mp_game(){
    alert("CLICK OK OR SPACEBAR TO RESUME.")
}
function pause_mp_game_keyboard(evt){
    if(evt.keyCode == 32){
        alert("CLICK OK OR SPACEBAR TO RESUME.")
    }
}
function close_mp_game(){
    document.getElementById("matchpuzzle_gameboard").style = "animation: removempgameboard 1s linear;"
    setTimeout(remove_mp_board, 1000)
}
function remove_mp_board(){
    document.getElementById("matchpuzzle_gameboard").remove()
    window.location.href = ""
}