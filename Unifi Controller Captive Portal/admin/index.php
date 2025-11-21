<?php
    $currentPath = $_SERVER['PHP_SELF'];
    $depth = substr_count(dirname($currentPath), '/');
    $pathToRoot = str_repeat('../', $depth);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Captive Portal Admin</title>
        <link rel="shortcut icon" href="<?php echo $pathToRoot; ?>assets/img/logo-ico.png" type="image/x-icon">
        <link rel="stylesheet" href="<?php echo $pathToRoot; ?>assets/fontawesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo $pathToRoot; ?>assets/css/datatables/datatables.min.css">
        <link rel="stylesheet" href="<?php echo $pathToRoot; ?>assets/css/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $pathToRoot; ?>assets/css/sole.splash/splash.css">
        <link rel="stylesheet" href="<?php echo $pathToRoot; ?>assets/css/colorpicker.css">
        <link rel="stylesheet" href="<?php echo $pathToRoot; ?>assets/css/style_admin.css">
    </head>
    <body>
        <div class="admin_container mt-3">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#authentication"><span class="fa fa-lock"></span> Authentication</button>
                    <button hidden class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#usergroups"><span class="fa fa-tags"></span> User Groups</button>
                    <button hidden id="voucher_btn_" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#voucher_m"><span class="fa fa-ticket"></span> Vouchers</button>
                </div>
                <button class="btn btn-sm btn-dark"><span class="fa fa-home"></span> Landing Page</button>
            </div>
            <table id="tb_client" class="table table-hover">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Name</td>
                        <td>MAC</td>
                        <td>Connection</td>
                        <td>Experience</td>
                        <td>IP Address</td>    
                        <td>Action</td>    
                    </tr>
                </thead>
                <tbody>
                    <!-- DATA HERE -->
                </tbody>
            </table>    
        </div>
        <?php include("modals.php"); ?>
        <script src="<?php echo $pathToRoot; ?>assets/js/jquery/jquery-3.7.1.js"></script>
        <script src="<?php echo $pathToRoot; ?>assets/js/popper/popper.min.js"></script>
        <script src="<?php echo $pathToRoot; ?>assets/js/datatables/datatables.min.js"></script>
        <script src="<?php echo $pathToRoot; ?>assets/js/bootstrap/bootstrap.min.js"></script>
        <script src="<?php echo $pathToRoot; ?>assets/js/sole.splash/splash.js"></script>
        <script src="<?php echo $pathToRoot; ?>assets/js/sole.js"></script>
        <script src="<?php echo $pathToRoot; ?>assets/js/script_admin.js"></script>
    </body>
</html>