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
  <body class="tms-time-in" id="tms-time-in">
    <div class="container d-flex justify-content-center align-items-center">
        <div class="pt-3" style="max-width: 400px; width: 100%;">
            <h4 class="text-left mb-4 fw-bold text-primary">TMS TIME IN</h4>
            <video hidden id="video" style="width: 100%; height: 500px;" autoplay></video>
            <textarea hidden name="" id="output" rows="10" cols="50"></textarea>

            <canvas id="canvas" class="tms-canvas rounded-3" style="width: 100%; height: 500px;">

            </canvas>
            <h6 id="tms_datetime" class="text-primary mt-1 mb-0">Thursday Dec 18, 2025 | 8:29 AM</h6>
            <h6 id="latitude" class="text-primary mb-0" ll="">Latitude: N/A</h6>
            <h6 id="longitude" class="text-primary mb-0" ll="">Longitude: N/A</h6>
            <h6 class="text-primary mb-0">Time in Location: <span id="loc_disp">Not Applicable</span></h6>
        </div>
        <div class="tms-capture w-100 text-center position-fixed bottom-0 pt-2 pe-2"  style="max-width: 400px; width: 100%; height: 60px; margin-bottom: 70px;">
            <button id="capture" class="btn text-white fw-bold" style="background-color: #E97132; width: 150px;">CAPTURE</button>
            <button id="retake" class="btn text-white fw-bold" style="background-color: #E97132; width: 150px;">RETAKE</button>
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
  <script src="../../assets/js/tms_time_in.js"></script>
  
</html>