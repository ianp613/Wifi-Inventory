<?php 
    session_start();
    $scriptfile = explode("/",$_SESSION["soleexceptionserver"]["SCRIPT_FILENAME"]);
    if(end($scriptfile) == "index.php"){
        $_SESSION["soleexceptionserver"]["REDIRECT_URL"] = "/";
    }
    $ENV = json_decode(file_get_contents("../../.env.json"));
    $link = $_SESSION["soleexceptionserver"]["REQUEST_SCHEME"]."://".$_SESSION["soleexceptionserver"]["SERVER_NAME"].":".$_SESSION["soleexceptionserver"]["SERVER_PORT"].$_SESSION["soleexceptionserver"]["REDIRECT_URL"];
    if($_SESSION["soleexceptionstatus"]){
        $_SESSION["soleexceptionstatus"] = false;
?>
<title><?php echo $ENV->PROJECT->name;?></title>
<link rel="shortcut icon" href="../../public/assets/icons/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="../../public/assets/css/sole.css">
<div class="sole-main_card">
    <div class="sole-card_head">
        <img src="../../public/assets/icons/error.ico" alt="">
        <h5><?php echo($_SESSION["soleexceptionserver"]["SCRIPT_FILENAME"]);?></h5>    
    </div>
    <hr>
    <div class="sole-message_card">
        <h2><?php echo($_SESSION["soleexceptionerror"][1]);?></h2>
        <a target="_blank" href="<?php echo($link);?>"><?php echo($link);?></a>
    </div>
</div>
<div class="sole-main_card">
    <div class="sole-bottom_card">
        <h4>Stack Trace</h4>
        <hr>
        <div class="sole-stack_trace">
            <table>
                <th>
                    <tr>
                        <td class="sole-ltd">Message</td>
                        <td class="sole-rtd"><?php echo $_SESSION["soleexceptionerror"][1];?></td>
                    </tr>
                    <tr>
                        <td class="sole-ltd">File</td>
                        <td class="sole-rtd"><?php echo $_SESSION["soleexceptionerror"][2];?></td>
                    </tr>
                    <tr>
                        <td class="sole-ltd">Line</td>
                        <td class="sole-rtd"><?php echo $_SESSION["soleexceptionerror"][3];?></td>
                    </tr>
                </th>
            </table>
        </div>
        <h4>Server</h4>
        <hr>
        <div class="sole-stack_trace">
            <table>
                <th>
                    <tr>
                        <td class="sole-ltd">SERVER_NAME</td>
                        <td class="sole-rtd"><?php echo $_SESSION["soleexceptionserver"]["SERVER_NAME"];?></td>
                    </tr>
                    <tr>
                        <td class="sole-ltd">SERVER_PORT</td>
                        <td class="sole-rtd"><?php echo $_SESSION["soleexceptionserver"]["SERVER_PORT"];?></td>
                    </tr>
                    <tr>
                        <td class="sole-ltd">HTTP_CONNECTION</td>
                        <td class="sole-rtd"><?php echo $_SESSION["soleexceptionserver"]["HTTP_CONNECTION"];?></td>
                    </tr>
                    <tr>
                        <td class="sole-ltd">HTTP_USER_AGENT</td>
                        <td class="sole-rtd"><?php echo $_SESSION["soleexceptionserver"]["HTTP_USER_AGENT"];?></td>
                    </tr>
                    <tr>
                        <td class="sole-ltd">REDIRECT_URL</td>
                        <td class="sole-rtd"><?php echo $_SESSION["soleexceptionserver"]["REDIRECT_URL"];?></td>
                    </tr>
                    <tr>
                        <td class="sole-ltd">REQUEST_METHOD</td>
                        <td class="sole-rtd"><?php echo $_SESSION["soleexceptionserver"]["REQUEST_METHOD"];?></td>
                    </tr>
                </th>
            </table>
        </div>
    </div>
</div>
<style>
    body{
        font-family: arial;
        background: #dadada;
        color: #3d3d3d;
    }
</style>
<?php
    }else{
        header("location: $link");
    }
?>