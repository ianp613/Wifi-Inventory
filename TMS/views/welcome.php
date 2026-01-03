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
  <body class="welcome" id="welcome">
    <div class="container d-flex justify-content-center align-items-center vh-100">
      <div class="p-4" style="max-width: 400px; width: 100%;">
        <h5 class="text-center mb-4 fw-bold text-primary">HELLO PAUL IAN, KINDLY PLEASE SET A NEW ACCOUNT PASSWORD FOR YOUR SECURITY</h5>
        <div class="mb-3">
            <input type="email" class="form-control" id="npassword" placeholder="NEW PASSWORD">
        </div> <!-- Password -->
        <div class="mb-3">
          <input type="password" class="form-control" id="rnpassword" placeholder="RE-ENTER PASSWORD">
        </div>
        <div class="w-100 text-center mt-4">
          <div class="row">
            <div class="col">
              <div style="width: 100%; height: 8px; background-color: #145B5D; border-radius: 5px;"></div>
            </div>
            <div class="col">
              <div style="width: 100%; height: 8px; background-color: #145B5D; border-radius: 5px;"></div>
            </div>
            <div class="col">
              <div style="width: 100%; height: 8px; background-color: #145B5D; border-radius: 5px;"></div>
            </div>
          </div>
        </div>
        <h6 class="w-100 text-left mb-5 mt-2 text-primary fw-bold">STRONG</h6>
        <button type="submit" class="btn btn-primary w-100 fw-bold">SUBMIT</button>
      </div>
    </div>
  </body>
  
  <script src="../assets/js/bootstrap/bootstrap.min.js"></script>
  <script src="../assets/js/sole.js"></script>
  <script src="../assets/js/modal_alert.js"></script>
  <script src="../assets/js/tms.js"></script>
</html>