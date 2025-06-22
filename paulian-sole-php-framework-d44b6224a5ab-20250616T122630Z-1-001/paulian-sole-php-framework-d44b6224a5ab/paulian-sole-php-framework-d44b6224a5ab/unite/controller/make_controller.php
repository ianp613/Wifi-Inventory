<?php
    class MakeController{
        public static function index($class){
            if(!is_file(controllers.$class.".php")){
                $controller = $class.".php";
                $content = "<?php
    include(\"../../sole\");
    class ".$class."{
        public static function index(){
            //code here...
        }
        public static function store(){
            //code here...
        }
        public static function show(){
            //code here...
        }
        public static function update(){
            //code here...
        }
        public static function destroy(){
            //code here...
        }
        public static function handler(Request \$request){
            //code here...
        }
    }
?>";
                file_put_contents(controllers.$controller,$content);
                echo("\e[1;32;40mController ".$class." created successfully."."\e[0m");
            }else{
                echo("\e[1;33;40mController ".$class." already exist."."\e[0m");
            }
        }
    }
?>