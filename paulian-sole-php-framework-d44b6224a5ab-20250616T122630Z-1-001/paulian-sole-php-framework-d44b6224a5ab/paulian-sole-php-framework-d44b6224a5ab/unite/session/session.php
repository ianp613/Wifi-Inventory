<?php
    class Session{
        public $svr = [];
    }
    function session($name){
        $DateTime = new DateTime;
        $date = ((string) $DateTime->format('Y-m-d'));
        $location = basedir."session/sessions/";
        $file = $location.md5($date);

        if(file_exists($file)){
            $session = json_decode(file_get_contents($file));
            if(session_has($name)){
                return $session->$name;
            }else{
                return false;  
            }
        }else{
            session_clear();
            $session = new Session;
            file_put_contents($file,json_encode($session));
            session($name);
        }
    }
    function session_put($name,$data){
        $DateTime = new DateTime;
        $date = ((string) $DateTime->format('Y-m-d'));
        $location = basedir."session/sessions/";
        $file = $location.md5($date);

        if(file_exists($file)){
            $session = json_decode(file_get_contents($file));
            if(session_has($name)){
                $session->$name = $data;
                file_put_contents($file,json_encode($session));
                return true;
            }else{
                array_push($session->svr,$name);
                $session->$name = $data;
                file_put_contents($file,json_encode($session));
                return true;    
            }
        }else{
            session_clear();
            $session = new Session;
            file_put_contents($file,json_encode($session));
            session_put($name,$data);
        }
    }
    function session_has($name){
        $DateTime = new DateTime;
        $date = ((string) $DateTime->format('Y-m-d'));
        $location = basedir."session/sessions/";
        $file = $location.md5($date);

        if(file_exists($file)){
            $session = json_decode(file_get_contents($file));
            if(in_array($name,$session->svr)){
                return true;
            }else{
                return false;
            }
        }else{
            session_clear();
            $session = new Session;
            file_put_contents($file,json_encode($session));
            session_has($name);
        }
    }
    function session_forget($name){
        $DateTime = new DateTime;
        $date = ((string) $DateTime->format('Y-m-d'));
        $location = basedir."session/sessions/";
        $file = $location.md5($date);

        if(file_exists($file)){
            $session = json_decode(file_get_contents($file));
            if(session_has($name)){
                $offset = 0;
                for ($i=0; $i < count($session->svr); $i++) { 
                    if($session->svr[$i] == $name){
                        $offset = $i;
                    }
                }
                array_splice($session->svr,$offset,1);
                $session->$name = null;
                file_put_contents($file,json_encode($session));
                return true;
            }else{
                return false;  
            }
        }else{
            session_clear();
            $session = new Session;
            file_put_contents($file,json_encode($session));
            session_forget($name);
        }
    }
    function session_clear(){
        $location = basedir."session/sessions/";
        foreach(glob($location."*") as $session){
            unlink($session);
        }
        return true;
    }
?>