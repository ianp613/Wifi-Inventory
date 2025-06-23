function initialize_snake(){
    document.body.insertAdjacentHTML("beforeend",
    "<div id=\"gameboard\">"+
        "<canvas id=\"snakeboard\" width=\"100\" height=\"100\"></canvas>"+
        "<div class=\"controller-container\">"+
            "<div>"+
                "<div id=\"score\">Scrore: 0</div>"+
                "<div id=\"speed\">Speed: Slow</div>"+
            "</div>"+
            "<div>"+
                "<div id=\"start\">Start</div>"+
                "<div id=\"pause\">Pause</div>"+
                "<div id=\"close\">Close</div>"+
            "</div>"+
        "</div>"+
        "<div class=\"onscreen_controller\">"+
            "<div id=\"up\">U</div>"+
            "<div id=\"left\">L</div>"+
            "<div id=\"right\">R</div>"+
            "<div id=\"down\">D</div>"+
            "<div id=\"hide\">x</div>"+
        "</div>"+
    "</div>")
    document.body.onresize = resize_board
    document.getElementById("start").onclick = start_snake_game
    document.getElementById("pause").onclick = pause_snake_game
    document.getElementById("close").onclick = close_snake_game
    document.getElementById("hide").onclick = change_direction_onscreen;
    resize_board()
}
function resize_board(){
    var clientHeight = parseInt(document.body.clientHeight)
    var finalHeight = (Math.round((clientHeight / 100)) * 100) - 160
    var clientWidth = parseInt(document.body.clientWidth)
    var finalWidth = (Math.round((clientWidth / 100)) * 100) - 100
    var snakeBoard = document.getElementById("snakeboard")
    if(snakeBoard){
      snakeBoard.setAttribute("height",finalHeight)
      snakeBoard.setAttribute("width",finalWidth)  
    }
}
const board_border = 'black';
const board_background = "white";
const snake_col = '#ff44008e';
const snake_border = 'orangered';
const food_color = ["green","yellow","red","blue","orange","brown","gray","indigo","orangered","deeppink","green"];
var food_index = 0;
var snake_speed = 200;
var temp_score = 100;
var message_popup = true;
let score = 0;
let changing_direction = false;
let food_x;
let food_y;
let dx = 20;
let dy = 0;
let snake = [
  {x: 200, y: 200},
  {x: 190, y: 200},
  {x: 180, y: 200},
  {x: 170, y: 200},
  {x: 160, y: 200}
]
let snakeboard = null;
let snakeboard_ctx = null;
function start_snake_game(){
    document.addEventListener("keydown", change_direction);
    if(document.getElementsByClassName("onscreen_controller")[0]){
      document.getElementById("up").onclick = change_direction_onscreen;
      document.getElementById("left").onclick = change_direction_onscreen;
      document.getElementById("right").onclick = change_direction_onscreen;
      document.getElementById("down").onclick = change_direction_onscreen;  
    }
    snakeboard = document.getElementById("snakeboard");
    snakeboard_ctx = snakeboard.getContext("2d")
    snake = [
      {x: 200, y: 200},
      {x: 190, y: 200},
      {x: 180, y: 200},
      {x: 170, y: 200},
      {x: 160, y: 200}
    ]
    dx = 20;
    dy = 0;
    snake_speed = 200
    score = 0
    document.getElementById("speed").innerHTML = "Speed: Slow";
    document.getElementById('score').innerHTML = "Score: " + score;
    document.getElementById('start').style = "display: none";
    document.getElementById('pause').style = "display: block";
    main();
    gen_food();
}
function pause_snake_game(){
    alert("CLICK OK OR SPACEBAR TO RESUME.")
}
function close_snake_game(){
    document.getElementById('start').style = "display: none";
    document.getElementById('pause').style = "display: none";
    document.getElementById('close').style = "display: none";
    document.getElementById("gameboard").style = "animation: removesnakegameboard 1s linear; height: 0%;";
    setTimeout(close_snake_game_support, 1000)
}
function close_snake_game_support(){
  document.getElementById("gameboard").remove()
  window.location.href = "";
}
function main() {
  if(document.getElementById("gameboard")){
      if(score >= temp_score){
          temp_score += 100
          if(snake_speed > 50){
              snake_speed -= 10
          }
          if(snake_speed == 200){
              message_popup = true
          }else if(snake_speed == 150){
              message_popup = true
          }else if(snake_speed == 100){
              message_popup = true
          }else if(snake_speed == 50){
              message_popup = true
          }else if(snake_speed < 50){
            message_popup = true
        }
      }else{
          if(snake_speed <= 200 && snake_speed > 150){
              document.getElementById("speed").innerHTML = "Speed: Slow";
              if(message_popup){
                  sole.info("Target Score: 500","bottom-left")
                  sole.info("Speed: Slow","bottom-left")
                  message_popup = false
              }
          }else if(snake_speed <= 150 && snake_speed > 100){
              document.getElementById("speed").innerHTML = "Speed: Normal";
              if(message_popup){
                  sole.success("Target Score: 1000","bottom-left")
                  sole.success("Speed: Normal","bottom-left")
                  message_popup = false
              }
          }else if(snake_speed <= 100 && snake_speed > 50){
              document.getElementById("speed").innerHTML = "Speed: Fast";
              if(message_popup){
                  sole.warning("Target Score: 1500","bottom-left")
                  sole.warning("Speed: Fast","bottom-left")
                  message_popup = false
              }
          }else if(snake_speed <= 50){
              document.getElementById("speed").innerHTML = "Speed: Very Fast";
              if(message_popup){
                  sole.error("Target Score: Infinite","bottom-left")
                  sole.error("Speed: Very Fast","bottom-left")
                  message_popup = false
              }
          }else{
              document.getElementById("speed").innerHTML = "Speed: Can't Measure";
              if(message_popup){
                  sole.danger("Target Score: Can't Measure","bottom-left")
                  sole.danger("Speed: Can't Measure","bottom-left")
                  message_popup = false
              }
          }
      }
      if (has_game_ended()){
          alert("GAME OVER.")
          document.getElementById('start').style = "display: block";
          document.getElementById('pause').style = "display: none";
          message_popup = true
          return;
      }
      changing_direction = false;
      setTimeout(function onTick() {
        clear_board();
        drawFood();
        move_snake();
        drawSnake();
        main();
      }, snake_speed)
    }
  
}
function clear_board() {
  snakeboard_ctx.fillStyle = board_background;
  snakeboard_ctx.strokeStyle = board_border;
  snakeboard_ctx.fillRect(0, 0, snakeboard.width, snakeboard.height);
  snakeboard_ctx.strokeRect(0, 0, snakeboard.width, snakeboard.height);
}
function drawSnake() {
  snake.forEach(drawSnakePart)
}
function drawFood() {
  snakeboard_ctx.fillStyle = food_color[food_index];
  snakeboard_ctx.strokeStyle = 'orangered';
  snakeboard_ctx.fillRect(food_x, food_y, 20, 20);
  snakeboard_ctx.strokeRect(food_x, food_y, 20, 20);
}
function drawSnakePart(snakePart) {
  snakeboard_ctx.fillStyle = snake_col;
  snakeboard_ctx.strokeStyle = snake_border;
  snakeboard_ctx.fillRect(snakePart.x, snakePart.y, 20, 20);
  snakeboard_ctx.strokeRect(snakePart.x, snakePart.y, 20, 20);
}
function has_game_ended() {
  for (let i = 4; i < snake.length; i++) {
    if (snake[i].x === snake[0].x && snake[i].y === snake[0].y) return true
  }
  const hitLeftWall = snake[0].x < 0;
  const hitRightWall = snake[0].x > snakeboard.width - 20;
  const hitToptWall = snake[0].y < 0;
  const hitBottomWall = snake[0].y > snakeboard.height - 20;
  return hitLeftWall || hitRightWall || hitToptWall || hitBottomWall
}
function random_food(min, max) {
  return Math.round((Math.random() * (max-min) + min) / 20) * 20;
}
function gen_food() {
  food_index = parseInt(Math.random() * 10);
  food_x = random_food(0, snakeboard.width - 20);
  food_y = random_food(0, snakeboard.height - 20);
  snake.forEach(function has_snake_eaten_food(part) {
    const has_eaten = part.x == food_x && part.y == food_y;
    if (has_eaten) gen_food();
  });
}
function change_direction(event) {
  if(event.keyCode == 32){
    pause_snake_game()
  }
  const LEFT_KEY = 37;
  const RIGHT_KEY = 39;
  const UP_KEY = 38;
  const DOWN_KEY = 40;
  if (changing_direction) return;
  changing_direction = true;
  const keyPressed = event.keyCode;
  const goingUp = dy === -20;
  const goingDown = dy === 20;
  const goingRight = dx === 20;
  const goingLeft = dx === -20;
  if (keyPressed === LEFT_KEY && !goingRight) {
    dx = -20;
    dy = 0;
  }
  if (keyPressed === UP_KEY && !goingDown) {
    dx = 0;
    dy = -20;
  }
  if (keyPressed === RIGHT_KEY && !goingLeft) {
    dx = 20;
    dy = 0;
  }
  if (keyPressed === DOWN_KEY && !goingUp) {
    dx = 0;
    dy = 20;
  }
}
function change_direction_onscreen(event) {
  if(event.path[0].id == "hide"){
      document.getElementsByClassName("onscreen_controller")[0].remove()
  }
  const LEFT_KEY = "left";
  const RIGHT_KEY = "right";
  const UP_KEY = "up";
  const DOWN_KEY = "down";
  if (changing_direction) return;
  changing_direction = true;
  const keyPressed = event.path[0].id;
  const goingUp = dy === -20;
  const goingDown = dy === 20;
  const goingRight = dx === 20;
  const goingLeft = dx === -20;
  if (keyPressed === LEFT_KEY && !goingRight) {
    dx = -20;
    dy = 0;
  }
  if (keyPressed === UP_KEY && !goingDown) {
    dx = 0;
    dy = -20;
  }
  if (keyPressed === RIGHT_KEY && !goingLeft) {
    dx = 20;
    dy = 0;
  }
  if (keyPressed === DOWN_KEY && !goingUp) {
    dx = 0;
    dy = 20;
  }
}
function move_snake() {
  const head = {x: snake[0].x + dx, y: snake[0].y + dy};
  snake.unshift(head);
  const has_eaten_food = snake[0].x === food_x && snake[0].y === food_y;
  if (has_eaten_food) {
    score += 20;
    document.getElementById('score').innerHTML = "Score: " + score;
    gen_food();
  } else {
    snake.pop();
  }
}