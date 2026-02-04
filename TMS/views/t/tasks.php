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
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="../../assets/fontawesome/css/font-awesome.min.css">

    <title>Task Management System</title>
    <link rel="shortcut icon" href="" type="image/x-icon">
</head>
  <body class="notifications" id="tasks">
    <div class="container d-flex justify-content-center align-items-center">
        <div class="pt-3" style="max-width: 400px; width: 100%;" id="notification_field">
            <div class="mb-3 d-flex justify-content-between" style="height: 40px;">
                <h4 class="text-left fw-bold text-primary">TASKS</h4>
                <div id="tms_dropdown" class="dropdown">
                    <div class="dropdown-label">-- Select Location --</div>
                </div>
            </div>
            <div hidden id="tms_user_list" class="w-100 justify-content-between">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">User : </span>
                    <select class="form-control" name="" id="task_user_list">
                        <option selected disabled value="">-- Select User --</option>
                    </select>
                    <button id="add_task_btn" class="btn btn-primary">Add Task</button>
                </div>
            </div>

            <div id="task_pane" class="w-100 notification-pane">
                <div hidden id="task_empty" class="create-task-image w-100 text-center">
                    <img class="" style="width: 80%" src="../../assets/img/tms/create_task.png" alt="" srcset="">
                    <h6 class="text-primary">Start Your Productive Day</h6>
                </div>
                <h6 hidden id="pending_task_title" style="padding-left: 10px;" class="mb-2">Pending Tasks <span class="fa fa-sort"></span></h6>
                <div hidden id="pending_task" class="mb-3">
                    <!-- PENDING TASK HERE -->
                </div>
                <h6 hidden id="ongoing_task_title" style="padding-left: 10px;" class="mb-2">Ongoing Tasks <span class="fa fa-sort"></span></h6>
                <div hidden id="ongoing_task" class="mb-3">
                    <!-- ONGOING TASK HERE -->
                </div>
                <div hidden id="view_accomplished_task" class="w-100 text-center mt-3 mb-3">
                    <button  class="btn btn-sm btn-primary rounded-pill">View Accomplished Task</button>
                </div>
                <h6 hidden id="accomplished_task_title" style="padding-left: 10px;" class="mb-2">Accomplished Tasks <span class="fa fa-sort"></span></h6>
                <div hidden id="accomplished_task">
                    <!-- ACCOMPLISHED TASK HERE -->
                    <!-- <div class="d-flex justify-content-between tms-message-field tmf tmf-con">
                        <p class="tms-message tmf tmf-message">Hello Lorim epsum dolor sit amet .sdfj sdjfh sdfohis krwe oisdhf ewroijzf iojdf sdofisdf euoifhfbn</p>
                        <p style="width: 90px; padding-right: 10px;" class="text-end tmf tmf-time">08:55 AM</p>
                    </div> -->
                </div>
                
            </div>
            
        </div>
        <div class="settings-pane position-fixed bottom-0 d-flex justify-content-end tms_" style="max-width: 400px; width: 100%; height: 205px;">
            <div id="setting_selection" class="settings-selection wd-160 p-3 border border-secondary rounded-3 tms_">
                <div class="d-flex settings-object tms_">
                    <span class="fa fa-user me-2 wd-15" style="margin-top: 2px;"></span>
                    <h6> Account</h6>
                </div>
                <div class="d-flex settings-object tms_">
                    <span class="fa fa-list me-2 wd-15" style="margin-top: 2px;"></span>
                    <h6> Activity Logs</h6>
                </div>
                <div class="d-flex settings-object tms_">
                    <span class="fa fa-flag me-2 wd-15" style="margin-top: 2px;"></span>
                    <h6> Task Owner</h6>
                </div>
                <hr class="mt-1 mb-2">
                <div class="d-flex settings-object tms_">
                    <span class="fa fa-sign-out me-2 wd-15" style="margin-top: 2px;"></span>
                    <h6> Logout</h6>
                </div>
            </div>
        </div>
        <div id="tms_menu" class="tms-menu w-100 bg-primary position-fixed bottom-0 pt-2 pe-2"  style="max-width: 400px; width: 100%; height: 60px;">
            <div class="row text-center text-white tms_">
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
                <div id="tms_settings" class="col tms_">
                    <span class="fa fa-gears"></span>
                    <h6 style="font-size: 13px;">SETTINGS</h6>
                </div>
            </div>
        </div>
    </div>
    <?php include("../modals/modals.php"); ?>
  </body>
  <script src="../../assets/js/flatpickr/flatpickr.min.js"></script>
  <script src="../../assets/js/bootstrap/bootstrap.min.js"></script>
  <script src="../../assets/js/sole.js"></script>
  <script src="../../assets/js/modal_alert.js"></script>
  <script src="../../assets/js/tms-notifications.js"></script>
  <script src="../../assets/js/tms-tasks.js"></script>
  <script src="../../assets/js/tms.js"></script>
</html>