<?php
    class MakeSeeder{
        public static function index($s){
            $extend = false;
            $extension = ["r","e","d","e","e","S"];
            $temp = str_split($s,1);
            if(count($temp) >= count($extension)){
                $temp = array_reverse($temp);
                for ($i=0; $i < count($extension); $i++) { 
                    if($temp[$i] != $extension[$i]){
                        $extend = true;
                    }
                }
            }else{
                $extend = true;
            }
            if($extend){
                $s .= "Seeder";
            }
            $seeder = file_get_contents(seeders);
            $res = explode('
',$seeder);
            $a = explode(' = ',$res[1]);
            
            $b = str_replace(['["','"];','","','[','];'],['','','/','',''],$a);
            $c = explode("/",$b[1]);
            if($b[1]==""){
                $c = [];   
            }
            if(!in_array($s,$c)){
                array_push($c,$s);

                $stemp = '    Seed::$seeders = ["';
                for ($i=0; $i < count($c); $i++) { 
                    $stemp .= $c[$i];
                    if($i==count($c)-1){
                        $stemp .= '"';    
                    }else{
                        $stemp .= '","';    
                    }
                }
                $stemp .= '];'; 
                $res[1] = $stemp;
                array_pop($res);
                $restemp = '';

                for ($i=0; $i < count($res); $i++) { 
                    $restemp .= $res[$i];
                    $restemp .= '
';
                    if($i == count($res)-1){
                        $restemp .= '
    class '.$s.'
    {
        public static function index(){
            Seed::table("");
            Seed::insert([
            ]);
        }
    }';
                    }
                }
                $restemp .= '
?>';
                file_put_contents(seeders,$restemp);   
                echo("\e[1;32;40mSeeder ".$s." created successfully.\e[0m");
            }else{
                echo("\e[1;33;40mSeeder ".$s." already exist.\e[0m");
            }
        }
    }
?>