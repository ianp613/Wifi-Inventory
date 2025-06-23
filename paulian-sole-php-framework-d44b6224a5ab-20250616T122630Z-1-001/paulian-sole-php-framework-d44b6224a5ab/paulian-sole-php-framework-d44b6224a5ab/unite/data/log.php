<?php
    class Logs{
        public static $file = basedir."/log/sole.log";
        public static function index(){
            if(is_file(Logs::$file) === false){
                file_put_contents(Logs::$file,"");
                Logs::log();
            }else{
                Logs::log();
            } 
        }
        public static function clear(){
            if(is_file(Logs::$file) === false){
                file_put_contents(Logs::$file,"");
            }else{
                file_put_contents(Logs::$file,"");  
                session_put("log",0);
            }
        }
        public static function show(){
            echo '<div class="sole-systemlog" style="height: 50%;" id="systemlog">';
            echo '<div class="sole-systemlogcontrol sticky-top modal-header">
                    <h5>Sole PHP Framework System Log</h5>
                        <div>
                            <button class="btn btn-dark btn-sm" onclick="minimize()">Half</button>
                            <button class="btn btn-dark btn-sm" onclick="maximize()">Full</button>
                            <button class="btn btn-dark btn-sm" onclick="showhide()">Show/Hide</button>
                        </div>
                  </div>';
            echo '<div class="sole-systemlogbody" id="systemlogbody">';
            if(is_file(Logs::$file) === false){
                file_put_contents(Logs::$file,"");
            }else{
                $document = file_get_contents(Logs::$file);
                $document = explode('
',$document);
                for ($i=0; $i < count($document); $i++) { 
                    echo '<h6>'.$document[$i].'</h6>';
                }
            }
            echo '</div>';
            echo '</div>';
        }
        public static function log(){
            $ENV = json_decode(file_get_contents(basedir."../.env.json"));
            if(!session_has("log")){
                session_put("log",0);
            }
            $index = session("log");
            $document = file_get_contents(Logs::$file);
            $sf = explode('/',$_SERVER["SCRIPT_FILENAME"]);
            $SCRIPT_FILENAME = "";
            for ($i=0; $i < count($sf) ; $i++) {
                if($i == 0){
                    $SCRIPT_FILENAME .= $sf[$i]; 
                }else{
                    $SCRIPT_FILENAME .= "//".$sf[$i];
                }
            }
            if($_SERVER["QUERY_STRING"]){
                $QUERY_STRING = "?".$_SERVER["QUERY_STRING"]."::".strtolower($_SERVER["REQUEST_METHOD"])."()"; 
            }else{
                $QUERY_STRING = $_SERVER["QUERY_STRING"]."::".strtolower($_SERVER["REQUEST_METHOD"])."()";    
            }
            $requesturi = explode("/",$_SERVER["REDIRECT_URL"]);
            $requesturi = end($requesturi);
            if(in_array($requesturi,$ENV->API_CONTROLLER_CLASS)){
                $QUERY_STRING .= "/api";
            }
            $DateTime = new DateTime;
            $date = date("M d, Y",strtotime((string) $DateTime->format('Y-m-d h:i:s'))).' at '.date("h:i A",strtotime((string) $DateTime->format('Y-m-d h:i:s')));
            if($index == 0){
                $document .= "--------------------------------------------------------------------------------------------------------
"."[".$date."]"." - System Start"."
"."Sole PHP Framework Version: ".$ENV->FRAMEWORK->version."
"."Project Name: ".$ENV->PROJECT->name."
"."Developer/s: ".$ENV->PROJECT->developer."
"."--------------------------------------------------------------------------------------------------------
"."#".$index." ".$SCRIPT_FILENAME.$QUERY_STRING."
";
            }else{
                $document .= "#".$index." ".$SCRIPT_FILENAME.$QUERY_STRING."
"; 
            }
            file_put_contents(Logs::$file,$document);   
            $index++;
            session_put("log",$index);
        }
    }
    if(log){
        Logs::index();
    }else{
        Logs::clear();
    }
    if(session("view")){
        if(log_show){
            Logs::show();
        }    
    }
?>