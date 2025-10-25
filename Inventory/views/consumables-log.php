<?php
    session_start();
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
        <link rel="stylesheet" href="../assets/css/colorpicker.css">
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
        <div class="w-100 d-flex justify-content-center">
            <div class="wd-600 p-4">
                <h5 class="text-secondary mb-3 d-flex"><div id="g_name_display"></div><span class="fa fa-cubes"></span> Consumables</h5>
                <div class="w-100 btn-group">
                    <input type="text" name="" id="g_search" class="form-control" placeholder="Search code or description">
                    <button class="btn btn-sm alert-dark btn-dark wd-40"><span class="fa fa-search"></span></button>
                </div>
                
            </div>
        </div>
        <h6 class="copyright f-10 text-secondary"></h6>
        <script src="../assets/js/jquery/jquery-3.7.1.js"></script>
        <script src="../assets/js/popper/popper.min.js"></script>
        <script src="../assets/js/datatables/datatables.min.js"></script>
        <script src="../assets/js/bootstrap/bootstrap.min.js"></script>
        <script src="../assets/js/sole.splash/splash.js"></script>
        <script src="../assets/js/quagga/quagga.min.js"></script>
        <script src="../assets/js/sole.js"></script>
        <script src="../assets/js/script.js"></script>
        <script src="../assets/js/consumables_log.js"></script>
        <script src="../assets/js/modal_alert.js"></script>
    </body>
</html>
