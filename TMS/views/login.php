<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/tms.css">
        <!-- <link rel="stylesheet" href="../assets/fontawesome/css/font-awesome.min.css"> -->
    <title>Task Management System</title>
    <link rel="shortcut icon" href="" type="image/x-icon">
</head>
  <body class="login" id="login">
    <div class="container d-flex justify-content-center align-items-center vh-100">
      <div class="p-4" style="max-width: 400px; width: 100%;">
        <div class="w-100 d-flex justify-content-center pt-3 pb-3">
          <img src="../assets/img/login_icon.svg" style="width: 250px;" alt="tms-ico-image">
        </div>
        <h2 class="text-center mb-2 mt-4 fw-bold text-primary">DDC IT TMS</h2>
        <h6 class="text-left mt-4 fw-bold text-primary">LOGIN TO YOUR ACCOUNT</h6>
        <div class="mb-3">
            <input type="email" class="form-control" id="userid" placeholder="USER ID">
        </div> <!-- Password -->
        <div class="mb-3">
          <input type="password" class="form-control" id="password" placeholder="PASSWORD">
        </div>
        <div class="w-100 text-center mb-4 mt-4">
          <a href="" class="text-decoration-none fw-bold">FORGOT PASSWORD?</a>
        </div>
        <button id="login_btn" type="submit" class="btn btn-primary w-100 fw-bold">LOGIN</button>
      </div>
    </div>
  </body>
  
  <script src="../assets/js/bootstrap/bootstrap.min.js"></script>
  <script src="../assets/js/sole.js"></script>
  <script src="../assets/js/modal_alert.js"></script>
  <script src="../assets/js/tms.js"></script>
  <script src="../assets/js/tms_login.js"></script>
</html>