<?php
    class Auto{
        public static $br = "
";
        public static $file = basedir."/auto/link.php";
        public static function index(){
            $ENV = json_decode(file_get_contents(basedir."../.env.json"));
            $document = file_get_contents(Auto::$file);
            $document = "";

            # create links for css
            for ($i=0; $i < count($ENV->PUBLIC->css); $i++) { 
                $document .= '<link rel="stylesheet" href="../../public/'.$ENV->PUBLIC->css[$i].'">'.Auto::$br;
            }
            $css = glob("../../public/assets/css/sole.*");
            foreach($css as $ca){
                if(is_dir($ca)){
                    foreach(glob($ca."/*") as $cb){
                        if(is_file($cb)){
                            $document .= '<link rel="stylesheet" href="'.$cb.'">'.Auto::$br;
                        }
                    }
                }else{
                    $document .= '<link rel="stylesheet" href="'.$ca.'">'.Auto::$br;
                }
            }
            $document .= '<link rel="stylesheet" href="../../public/app/app.css">'.Auto::$br;

            # create links for js
            for ($i=0; $i < count($ENV->PUBLIC->js); $i++) { 
                $document .= '<script src="../../public/'.$ENV->PUBLIC->js[$i].'"></script>'.Auto::$br;
            }
            $js = glob("../../public/assets/js/sole.*");
            foreach($js as $ca){
                if(is_dir($ca)){
                    foreach(glob($ca."/*") as $cb){
                        if(is_file($cb)){
                            $document .= '<script src="'.$cb.'"></script>'.Auto::$br;
                        }
                    }
                }else{
                    $document .= '<script src="'.$ca.'"></script>'.Auto::$br;
                }
            }
            $document .= '<script src="../../public/app/app.js"></script>'.Auto::$br;
            file_put_contents(Auto::$file,$document);

            # check if the controller is an api
            $requesturi = explode("/",$_SERVER["REDIRECT_URL"]);
            if(!in_array(end($requesturi),$ENV->API_CONTROLLER_CLASS)){
                include(Auto::$file);
            }
        }
    }
    # undo comment for the code below if built-in modal doesn't work
    # Auto::index();
?>
<?php
    # check if the controller is an api
    # note: this portion might cause an error, i suggest to use script_filename array key of the server
    $ENV = json_decode(file_get_contents(basedir."../.env.json"));
    $requesturi = explode("/",$_SERVER["REDIRECT_URL"]);
    if(!in_array(end($requesturi),$ENV->API_CONTROLLER_CLASS)){
?>
<?php $ENV = json_decode(file_get_contents(basedir."../.env.json"));?>
<?php if($ENV->SETTINGS->app_name){?>
    <title><?php echo $ENV->PROJECT->name;?></title>
<?php }?>
<?php if($ENV->SETTINGS->app_icon){?>
    <link rel="shortcut icon" href="../../public/assets/icons/favicon.ico" type="image/x-icon">
<?php }?>
<?php if($ENV->SETTINGS->app_watermark && session("view")){?>
<div class="sole-wm">
    <img src="../../public/assets/icons/favicon.ico" alt="">
    <div>
        <h5>Sole PHP Framework</h5>
        <h6><i>Learn & Create</i></h6>    
    </div>
</div>
<?php 
    }
    }
?>