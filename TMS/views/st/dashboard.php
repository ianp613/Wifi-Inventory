<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/tms.css">
        <link rel="stylesheet" href="../../assets/fontawesome/css/font-awesome.min.css">
    <title>Task Management System</title>
    <link rel="shortcut icon" href="" type="image/x-icon">
</head>
  <body class="dashboard" id="dashboard">
    <div class="container d-flex justify-content-center align-items-center">
        <div class="pt-3" style="max-width: 400px; width: 100%;">
            <h4 class="text-left mb-4 fw-bold text-primary">DASHBOARD</h4>
            <div class="row">
                <div class="col">
                    <div class="bg-primary text-white fw-bold pt-4 ps-3" style="width: 100%; height: 130px; border-radius: 15px;">
                        <h3>16</h3>
                        <h6 style="font-size: 13px;">2nd FLOOR ANNEX TECHNICIANS</h6>
                    </div>
                </div>
                <div class="col">
                    <div class="bg-dark text-white fw-bold pt-4 ps-3" style="width: 100%; height: 130px; border-radius: 15px;">
                        <h3>6</h3>
                        <h6 style="font-size: 13px;">TECHNICIANS ON DUTY</h6>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <div class="bg-primary text-white fw-bold pt-4 ps-3" style="width: 100%; height: 130px; border-radius: 15px;">
                        <h3>54</h3>
                        <h6 style="font-size: 13px;">TOTAL PENDING TASKS</h6>
                    </div>
                </div>
                <div class="col">
                    <div class="bg-primary text-white fw-bold pt-4 ps-3" style="width: 100%; height: 130px; border-radius: 15px;">
                        <h3>2</h3>
                        <h6 style="font-size: 13px;">TOTAL ONGOING TASKS</h6>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <div class="text-white fw-bold pt-4 ps-3" style="width: 100%; height: 130px; border-radius: 15px;background-color: #006e25ff;">
                        <h3>2</h3>
                        <h6 style="font-size: 13px;">TIME OUT REQUESTS</h6>
                    </div>
                </div>
                <div class="col">
                    <button id="tms_time_in" class="btn btn-primary w-100 fw-bold">TIME IN</button>
                    <button class="btn btn-primary w-100 fw-bold mt-2">DAILY TASK</button>
                    <button disabled class="btn btn-primary w-100 fw-bold mt-2">TIME OUT</button>
                </div>
            </div>
            <h5 class="text-primary mt-4">Daily User Information</h5>
        </div>
        <div id="tms_menu" class="tms-menu w-100 bg-primary position-fixed bottom-0 pt-2 pe-2"  style="max-width: 400px; width: 100%; height: 60px;">
            <div class="row text-center text-white">
                <div id="tms_home" class="col">
                    <span class="fa fa-home"></span>
                    <h6 style="font-size: 13px;">HOME</h6>
                </div>
                <div id="tms_tasks" class="col">
                    <span class="fa fa-edit"></span>
                    <h6 style="font-size: 13px;">TASKS</h6>
                </div>
                <div id="tms_notifications" class="col">
                    <span class="fa fa-info"></span>
                    <h6 style="font-size: 13px;">NOTIFICATIONS</h6>
                </div>
                <div id="tms_settings" class="col">
                    <span class="fa fa-gears"></span>
                    <h6 style="font-size: 13px;">SETTINGS</h6>
                </div>
            </div>
        </div>
    </div>
  </body>
  
  <script src="../../assets/js/bootstrap/bootstrap.min.js"></script>
  <script src="../../assets/js/sole.js"></script>
  <script src="../../assets/js/modal_alert.js"></script>
  <script src="../../assets/js/tms.js"></script>
  <script src="../../assets/js/tms_dashboard.js"></script>
</html>