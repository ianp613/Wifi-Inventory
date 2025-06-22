<?php
    class Chain{
        public static function index(){
            echo("\e[1;32;40m------------------------------------------------------------------------------------------------\e[0m\n");
            echo("\e[1;32;40mHello\e[0m\n");
            echo("\e[1;32;40m------------------------------------------------------------------------------------------------\e[0m\n");
            Chain::standby();
        }
        public static function standby(){
            $input = Chain::readinput();
            if($input == "recall" || $input == "run" || $input == "start"){
                echo("\e[1;32;40m");
                Disc::index();
                echo("\e[0m\n");
                Chain::standby();
            }elseif($input == "reset" || $input == "clear"){
                $temp = 
"<?php
?>";
                file_put_contents("unite/chain/disc",$temp);
                Chain::index();
            }elseif($input == "exit"){
                echo("\e[1;32;40m------------------------------------------------------------------------------------------------\e[0m\n");
                echo("\e[1;32;40mGoodbye\e[0m\n");
                echo("\e[1;32;40m------------------------------------------------------------------------------------------------\e[0m\n");
            }elseif($input == "help"){
                echo("\e[1;32;40mInput PHP Code to Chain: \e[0m\e[1;33;40m  [any \$code]\e[0m\n");
                echo("\e[1;32;40mRun or Rerun Chain: \e[0m\e[1;33;40m       [run][start][recall]\e[0m\n");
                echo("\e[1;32;40mReset Chain: \e[0m\e[1;33;40m              [clear][reset]\e[0m\n");
                echo("\e[1;32;40mExit Chain: \e[0m\e[1;33;40m               [exit]\e[0m\n");
                echo("\e[1;32;40mChain Help: \e[0m\e[1;33;40m               [help]\e[0m\n");
                echo("\e[1;32;40mPress any key to continue...\e[0m\e[1;33;40m\e[0m\n");
                exec("pause");
                Chain::index();
            }elseif($input && $input != "exit"){
                $disc = file_get_contents("unite/chain/disc");
                $disc = explode(
"
",$disc);
                array_pop($disc);
                array_push($disc,$input);
                array_push($disc,"?>");
                $temp = "";
                for ($i=0; $i < count($disc); $i++) { 
                    if($i == count($disc)-1){
                        $temp .= $disc[$i];
                    }else{
                        $temp .= $disc[$i].
"
";
                    }
                }
                file_put_contents("unite/chain/disc",$temp);
                echo("\e[1;34;40mChain: \e[0m\e[1;35;40m <- $input\e[0m\n");
                Chain::standby();
            }else{
                Chain::standby();
            }
        }
        public static function readinput(){
            echo("\e[1;34;40mChain: \e[0m\e[1;33;40m");
            $input = readline();
            echo("\e[0m");
            return $input;
        }
    }
?>