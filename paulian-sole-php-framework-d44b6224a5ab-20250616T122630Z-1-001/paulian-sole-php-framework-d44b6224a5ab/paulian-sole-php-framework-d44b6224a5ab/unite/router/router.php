
<?php
    class Route{
        public static function load($name){
            session_put("log",0);
            session_put("view",false);
            header('location: app/controllers/'.$name);
        }
        public static function view($name, $dd = null){
            $arr = explode('.',$name);
            $location = "";
            for ($i=0; $i <= count($arr)-1; $i++) { 
                $location .= '/'.$arr[$i];
            }
            require_once("../../resources/views".$location.".sole.php");
            session_put("view",true);
            Auto::index();
        }
        public static function index($name){
            session_put("view",false);
            header('location: ../controllers/'.$name);
        }
        public static function redirect($url){
            header("location: ".$url);  
        }
        public static function return($name){
            session_put("view",false);
            $_SESSION['Route_Location'] = $name;
            header('location: ../controllers/'.$name);
        }
        public static function view_extend($name){
            $arr = explode('.',$name);
            $location = "";
            for ($i=0; $i <= count($arr)-1; $i++) { 
                $location .= '/'.$arr[$i];
            }
            require_once("../../resources/views".$location.".sole.php");
        }
        public static function error($name){
            $arr = explode('.',$name);
            $location = "";
            for ($i=0; $i <= count($arr)-1; $i++) { 
                $location .= '/'.$arr[$i];
            }
            if(file_exists("../../resources/temp/error".$location.".sole.php")){
                require_once("../../resources/temp/error".$location.".sole.php");    
            }else{
                echo "<h6><b>File doesn't exist in: </b> resources/temp/error$location.sole.php</h6>";
                echo "<b>Error: </b>";
            }
            session_put("view",false);
            Auto::index();
        }
    }
    class RouteExtend{
        public static function index(){
            try {
                session_put("view",false);
                $func = array("store","show","update","destroy","handler");
                $Controller = $_SERVER["PHP_SELF"];
                $arr = explode('/',$Controller);
                $arr = explode('.',end($arr));
                $Controller = $arr[0];
                if(count($_GET)){
                    $request_data = new Request;
                    $request_keys = array_keys($_GET);

                    for ($i=0; $i < count($request_keys); $i++) { 
                        $temp = $request_keys[$i];
                        $request_data->$temp = $_GET[$temp];
                    }
                    $request_keys = array_keys($_POST);
                    
                    for ($i=0; $i < count($request_keys); $i++) { 
                        $temp = $request_keys[$i];
                        $request_data->$temp = $_POST[$temp];
                    }
                    if(in_array(array_keys($_GET)[0],$func)){
                        $method = array_keys($_GET)[0];
                        $Controller::$method($request_data);
                    }else{
                        $method = array_keys($_GET)[0];
                        $Controller::$method($request_data);
                    }
                }else{
                    $Controller::index();
                }
            } catch (Throwable | SoleException $e) {
                $_SESSION["soleexceptionerror"] = $e;
                exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
                echo $e->getMessage();
            }
        }
    }
    class Request{}
    RouteExtend::index();
?>