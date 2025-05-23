<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
        <link rel="stylesheet" href="../assets/fontawesome/css/font-awesome.min.css">
    <title>Wifi Team Inventory</title>
    <link rel="shortcut icon" href="../assets/img/hero.png" type="image/x-icon">
</head>
  <body id="login">
    <div class="container">
      <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <div class="row justify-content-center align-items-center">
                <img src="../assets/img/fposi-logo.png" style="width: 250px;" alt="fposi-logo.png">
              </div>
              <h5 class="card-title text-center">Wifi Team Inventory</h5>
              <div id="login_alert" style="display: none !important;" class="alert alert-danger d-flex align-items-center" role="alert">
                <!--  -->
              </div>
                <div class="mb-3">
                  <label for="userid" class="form-label">User ID</label>
                  <input type="userid" class="form-control" id="userid" placeholder="Enter your user ID">
                </div>
                <label for="userid" class="form-label">Password</label>
                <div class="ps-field mb-3">
                    <input type="password" id="password" class="form-control" placeholder="Enter your password">
                    <span id="togglePassword" class="fa fa-eye-slash text-secondary"></span>
                </div>
                <button id="login_btn" type="submit" class="btn btn-danger w-100">Login</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <h6 class="copyright-1 f-10 text-secondary"><i>Copyright 2025 @ Wifi Team</i></h6>
  </body>
  
  <script src="../assets/js/bootstrap/bootstrap.min.js"></script>
  <script src="../assets/js/sole.js"></script>
  <script src="../assets/js/login.js"></script>
  <script src="../assets/js/script.js"></script>
  <script src="../assets/js/modal_alert.js"></script>
</html>