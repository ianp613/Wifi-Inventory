<?php
    session_start();
    $dashboard = $_GET["loc"] == "dashboard" ? true : false;
    $equipments = $_GET["loc"] == "equipments" ? true : false;
    $isp = $_GET["loc"] == "isp" ? true : false;
    $routers = $_GET["loc"] == "routers" ? true : false;
    $ipaddress = $_GET["loc"] == "ipaddress" ? true : false;
    $_SESSION["auth"] ? null : header("location: login.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Wifi Team Inventory</title>
        <link rel="shortcut icon" href="../assets/img/logo-ico.png" type="image/x-icon">
        <link rel="stylesheet" href="../assets/fontawesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="../assets/css/datatables/datatables.min.css">
        <link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/sole.splash/splash.css">
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
        <div class="d-flex sticky-top">
            <nav class="text-white sidebar p-3" id="sidebar">
                <div class="d-flex justify-content-center align-items-center bg-light p-2 rounded">
                    <img id="sidebar_logo" src="../../assets/img/fposi-logo.png" style="width: 150px;">
                </div>
                
                <ul class="nav flex-column">
                    <li class="nav-item mt-3">
                        <a href="?loc=dashboard" class="nav-link f-15 text-light">
                            <i class="fa fa-tachometer red-1 <?php $dashboard ?  printf("text-light rounded") :  null;?>" style="width: 13px;"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    <hr style="margin-top: 6px;">
                    <div class="d-flex justify-content-start align-items-center">
                        <h5 class="ms-3 red-1 f-14 fwt-5">MENU</h5>    
                    </div>
                    <li class="nav-item mb-2">
                        <a href="?loc=equipments" class="nav-link f-15 text-light <?php $equipments ?  printf("bg-light text-dark rounded") :  null;?>">
                            <i class="fa fa-wrench red-1  <?php $equipments ?  printf("text-dark rounded") :  null;?>" style="width: 13px;"></i> <span>Equipments</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="?loc=isp" class="nav-link f-15 text-light <?php $isp ?  printf("bg-light text-dark rounded") :  null;?>">
                            <i class="fa fa-wifi red-1  <?php $isp ?  printf("text-dark rounded") :  null;?>" style="width: 13px;"></i> <span>ISP</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="?loc=routers" class="nav-link f-15 text-light <?php $routers ?  printf("bg-light text-dark rounded") :  null;?>">
                            <i class="fa fa-gears red-1 <?php $routers ?  printf("text-dark rounded") :  null;?>" style="width: 13px;"></i> <span>Routers</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="?loc=ipaddress" class="nav-link f-15 text-light <?php $ipaddress ?  printf("bg-light text-dark rounded") :  null;?>">
                            <i class="fa fa-map-marker red-1 <?php $ipaddress ?  printf("text-dark rounded") :  null;?>" style="width: 13px;"></i> <span>IP Address</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link f-15 text-light" data-bs-toggle="modal" data-bs-target="#general_search">
                            <i class="fa fa-search red-1" style="width: 13px;"></i> <span>Search</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="http://192.168.15.221:9000/views/ping.php?loc=ping" target="_blank" class="nav-link f-15 text-light">
                            <i class="fa fa-search red-1" style="width: 13px;"></i> <span>Ping</span>
                        </a>
                    </li>
                    <hr style="margin-top: 2px;">
                </ul>
            </nav>
            <div class="main-content">
                <div class="d-flex justify-content-between align-items-center shadow-sm p-3 pb-2 pt-2 ">
                    <h5 class="mt-1 text-secondary">
                        <?php 
                            if(isset($_GET["loc"])){
                                if($_GET["loc"] == "dashboard"){
                                    echo "<span class=\"fa fa-tachometer\"></span> Dashboard";
                                }elseif($_GET["loc"] == "equipments"){
                                    echo "<span class=\"fa fa-wrench\"></span> Equipments";
                                }elseif($_GET["loc"] == "isp"){
                                    echo "<span class=\"fa fa-wifi\"></span> Internet Service Provider";
                                }elseif($_GET["loc"] == "routers"){
                                    echo "<span class=\"fa fa-gears\"></span> Routers";
                                }elseif($_GET["loc"] == "ipaddress"){
                                    echo "<span class=\"fa fa-map-marker\"></span> IP Address";
                                }else{
                                    header("location: ../index.php");
                                }
                            }else{
                                header("location: ../index.php");
                            }
                        ?>
                    </h5>
                    <div class="dropdown text-dark f-14 fwt-5">
                        <div type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- User Name -->
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li id="account"><a class="dropdown-item f-13" href="#"><span class="fa fa-user me-2 text-secondary" style="width: 12px;"></span> Account</a></li>
                            <li id="settings"><a class="dropdown-item f-13" href="#"><span class="fa fa-gears me-2 text-secondary" style="width: 12px;"></span> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li id="logout"><a class="dropdown-item f-13"><span class="fa fa-sign-out me-2 text-secondary" style="width: 12px;"></span> Log Out</a></li>
                        </ul>
                    </div>
                </div>
                <div class="main-content m-3 p-2">
                    <?php 
                        if($_GET["loc"] == "dashboard"){
                            include("dashboard/dashboard.php");
                        }elseif($_GET["loc"] == "equipments"){
                            include("equipments/equipments.php");
                        }elseif($_GET["loc"] == "ipaddress"){
                            include("ipaddress/ipaddress.php");
                        }elseif($_GET["loc"] == "isp"){
                            include("isp/isp.php");
                        }elseif($_GET["loc"] == "routers"){
                            include("routers/routers.php");
                        }
                    ?>
                </div>
            </div>
        </div>
        <h6 class="copyright f-10 text-secondary"><i>Copyright 2025 @ Wifi Team</i></h6>
        <?php include("modals/equipments.php"); ?>
        <?php include("modals/ipaddress.php"); ?>
        <?php include("modals/isp.php"); ?>
        <?php include("modals/routers.php"); ?>
        <?php include("modals/logout.php"); ?>
        <?php include("modals/settings.php"); ?>
        <?php include("modals/general_search.php"); ?>
        <script src="../assets/js/jquery/jquery-3.7.1.js"></script>
        <script src="../assets/js/popper/popper.min.js"></script>
        <script src="../assets/js/datatables/datatables.min.js"></script>
        <script src="../assets/js/bootstrap/bootstrap.min.js"></script>
        <script src="../assets/js/sole.splash/splash.js"></script>
        <script src="../assets/js/sole.js"></script>
        <script src="../assets/js/script.js"></script>
        <script src="../assets/js/dashboard.js"></script>
        <script src="../assets/js/equipments.js"></script>
        <script src="../assets/js/ipaddress.js"></script>
        <script src="../assets/js/routers.js"></script>
        <script src="../assets/js/isp.js"></script>
        <script src="../assets/js/general_search.js"></script>
        <script src="../assets/js/modal_alert.js"></script>
        
    </body>
</html>
