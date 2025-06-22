<?php
    define("FAKER_BASEDIR",dirname(__FILE__).DIRECTORY_SEPARATOR);
    class Faker{
        public function __construct(){
            $res = json_decode(file_get_contents(FAKER_BASEDIR."/json/faker.json"));
            $put = json_decode(file_get_contents(FAKER_BASEDIR."/json/data.json"));

            $sex = ["Male","Female"];
            $tempsex = $sex[rand(0,1)];
            $tempalphabet = strtolower(Data::generate(1,"alpha"));
            $tempfirstname = $res->$tempsex[0]->$tempalphabet[rand(0,count($res->$tempsex[0]->$tempalphabet)-1)];
            $tempmiddlename = $res->surname[rand(0,count($res->surname)-1)];
            $templastname = $res->surname[rand(0,count($res->surname)-1)];
            $tempmi = strtoupper($tempmiddlename[0]);
            $town = ["Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Carolina","North Dakota","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia"];
            $temptown = $town[rand(0,count($town)-1)];
            $tempcity = $res->town[0]->$temptown[rand(0,count($res->town[0]->$temptown)-1)];
            $tempaddress = $temptown.", ".$tempcity;

            $tempno = "+63-9".Data::generate(2,"numeric")."-".Data::generate(3,"numeric")."-".Data::generate(4,"numeric");

            $put->name = $tempfirstname." ".$tempmi.". ".$templastname;
            $put->firstname = $tempfirstname;
            $put->middlename = $tempmiddlename;
            $put->lastname = $templastname;
            $put->mi = $tempmi;
            $put->sex = $tempsex;
            $put->email = strtolower($tempfirstname).".".strtolower($templastname)."@gmail.com";
            $put->address = $tempaddress;
            $put->no = $tempno;
            
            file_put_contents(FAKER_BASEDIR."/json/data.json",json_encode($put));
        }
        public static function name(){
            $res = json_decode(file_get_contents(FAKER_BASEDIR."/json/data.json"));
            return $res->name;
        }
        public static function firstname(){
            $res = json_decode(file_get_contents(FAKER_BASEDIR."/json/data.json"));
            return $res->firstname;
        }
        public static function middlename(){
            $res = json_decode(file_get_contents(FAKER_BASEDIR."/json/data.json"));
            return $res->middlename;
        }
        public static function lastname(){
            $res = json_decode(file_get_contents(FAKER_BASEDIR."/json/data.json"));
            return $res->lastname;
        }
        public static function mi(){
            $res = json_decode(file_get_contents(FAKER_BASEDIR."/json/data.json"));
            return $res->mi;
        }
        public static function sex(){
            $res = json_decode(file_get_contents(FAKER_BASEDIR."/json/data.json"));
            return $res->sex;
        }
        public static function gender(){
            $res = json_decode(file_get_contents(FAKER_BASEDIR."/json/data.json"));
            return $res->sex;
        }
        public static function email(){
            $res = json_decode(file_get_contents(FAKER_BASEDIR."/json/data.json"));
            return $res->email;
        }
        public static function address(){
            $res = json_decode(file_get_contents(FAKER_BASEDIR."/json/data.json"));
            return $res->address;
        }
        public static function no(){
            $res = json_decode(file_get_contents(FAKER_BASEDIR."/json/data.json"));
            return $res->no;
        }
        public static function phone(){
            $res = json_decode(file_get_contents(FAKER_BASEDIR."/json/data.json"));
            return $res->no;
        }
    }
?>