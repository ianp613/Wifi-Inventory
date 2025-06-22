<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <body>
        <!--Sidebar Menu-->
        <div class="sole-menu-sidebar">
            <div class="sole-menu-head">
                <img src="../../public/assets/icons/favicon.ico" alt="sole-icon" class="sole-menu-item-img">
                <div class="sole-menu-item-title">
                    <p>Sole | Template</p>
                </div>
            </div>
            <div class="sole-menu-body">
                <a href="#" link-label="Dashboard | Active" class="sole-menu-item-link menu-link-active"><span class="fa fa-tachometer"></span></a>
                <a href="#" link-label="Accessories" class="sole-menu-item-link" data-target="accessories"><span class="fa fa-wrench"></span></a>
                <div class="sole-menu-item-wrapper" id="accessories">
                    <a href="#" link-label="Paint Ball" class="sole-menu-item-link" onclick="sole.paintball()"><span class="fa fa-paint-brush"></span></a>
                    <a href="#" link-label="Crowd" class="sole-menu-item-link" onclick="sole.crowd()"><span class="fa fa-group"></span></a>
                    <a href="#" link-label="Rain" class="sole-menu-item-link" onclick="sole.rain()"><span class="fa fa-cloud"></span></a>
                </div>
                <a href="#" link-label="Games" class="sole-menu-item-link" data-target="games"><span class="fa fa-gamepad"></span></a>
                <div class="sole-menu-item-wrapper" id="games">
                    <a href="#" link-label="Snake" class="sole-menu-item-link" onclick="sole.snake()"><span class="fa fa-gamepad"></span></a>
                    <a href="#" link-label="Match Puzzle" class="sole-menu-item-link" onclick="sole.matchpuzzle()"><span class="fa fa-puzzle-piece"></span></a>
                </div>
                <a href="#" link-label="User Management" class="sole-menu-item-link" data-target="userManagement"><span class="fa fa-user"></span></a>
                <div class="sole-menu-item-wrapper" id="userManagement">
                    <a href="#" link-label="Create User" class="sole-menu-item-link"><span class="fa fa-plus"></span></a>
                    <a href="#" link-label="Update User | Active" class="sole-menu-item-link menu-link-active"><span class="fa fa-pencil"></span></a>
                    <a href="#" link-label="User Accounts" class="sole-menu-item-link"><span class="fa fa-binoculars"></span></a>
                </div>
                <a href="#" link-label="Account Settings" class="sole-menu-item-link" data-target="accountSettings"><span class="fa fa-gear"></span></a>
                <div class="sole-menu-item-wrapper" id="accountSettings">
                    <a href="#" link-label="Reports" class="sole-menu-item-link"><span class="fa fa-line-chart"></span></a>
                    <a href="#" link-label="Manage Credentials" class="sole-menu-item-link"><span class="fa fa-lock"></span></a>
                    <a href="#" link-label="Dark Mode" class="sole-menu-item-link"><span class="fa fa-moon-o"></span></a>
                </div>
            </div>
        </div>
        <!--Display-->
        <div class="sole-display response-sidebar">
            <h6><?php echo framework_name." v".framework_version;?> All Rights Reserved 2021 © <?php echo framework_developer;?></h6>
            <hr>
            <h6><i>Learn PHP, alter framework features and functions according to your needs and create your own masterpiece.</i></h6>
            <h6><i>Help other to build their own dreams and achieve their own goals.</i></h6>
        </div>
    </body>
</html>