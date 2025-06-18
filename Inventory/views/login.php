<?php
  session_start();
  !array_key_exists("auth",$_SESSION) ? $_SESSION["auth"] = null : null;
  !array_key_exists("userid",$_SESSION) ? header("location: ../index.php") : null; 
  $_SESSION["auth"] ? header("location: inventory.php?loc=dashboard") : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
        <link rel="stylesheet" href="../assets/fontawesome/css/font-awesome.min.css">
    <title>Wifi Team Inventory</title>
    <link rel="shortcut icon" href="../assets/img/logo-ico.png" type="image/x-icon">
</head>
  <body class="login" id="login">
    <div class="card-cover"></div>
    <div class="container">
      <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-4">
          <div class="card">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="card-body">
              <div class="row justify-content-center align-items-center">
                <img src="../assets/img/fposi-logo.png" style="width: 250px;" alt="fposi-logo.png">
              </div>
              <div id="login_alert" style="display: none !important;" class="alert alert-danger d-flex align-items-center" role="alert">
                <!--  -->
              </div>
                <div class="mb-3">
                  <label for="userid" class="form-label">User ID</label>
                  <input type="userid" class="form-control" id="userid" placeholder="Enter User ID">
                </div>
                <label for="userid" class="form-label">Password</label>
                <div class="ps-field mb-3">
                    <input type="password" id="password" class="form-control" placeholder="Enter Password">
                    <span id="togglePassword" class="fa fa-eye-slash text-secondary"></span>
                </div>
                <button id="login_btn" type="submit" class="btn btn-danger w-100"><span class="fa fa-sign-in"></span> Login</button>
                <div class="w-100 text-center mt-3"><a class="text-light" style="text-decoration: none;" href="forgot_password.php">Forgot password?</a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <h6 class="copyright-1 f-10 text-secondary"></h6>
  </body>
  
  <script src="../assets/js/bootstrap/bootstrap.min.js"></script>
  <script src="../assets/js/sole.js"></script>
  <script src="../assets/js/modal_alert.js"></script>
  <script src="../assets/js/login.js"></script>
  <script src="../assets/js/script.js"></script>
</html>