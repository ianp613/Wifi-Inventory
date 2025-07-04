<?php
class Identifier {
    public static function main($input) {
        $input = str_replace(",","",$input);
        $models = [
            "ip" => new IP_Address(),
            "equipment" => new Equipment(),
            "entry" => new Equipment_Entry(),
            "network" => new IP_Network(),
            "router" => new Routers(),
            "isp" => new ISP(),
            "map" => new CCTV_Location(),
            "cctv" => new CCTV_Camera()
        ];

        $ignore = ["en", "ent","me"];  // Add any more short tokens here

        // $input_temp = strtolower(trim($input));
        // $in = explode("in", $input);
        // $input = count($in) == 2 ? $in[1] : $input;

        foreach ($models as $field => $model) {
            $words = preg_split('/\s+/', strtolower($input));

            foreach ($words as $word) {
                if (strlen($word) < 2) continue;
                if (in_array($word, $ignore)) continue;  // Skip ignored words

                if (stripos($field, $word) !== false) {
                    return Identifier::generateFromModel($model, $input);
                }
            }
        }
        return "No matching data found.";
    }

    public static function generateFromModel($model, $input) {
        $table = $model->table;
        $fillable = $model->fillable;
        $ignore = $model->ignore;
        $column = [];
        $filteredWords = [];


        // Extract all the data in the database
        $data = DB::all($model);
        $values = [];
        foreach ($data as $record) {
            foreach ($record as $key => $value) {
                // Skip nulls or unnecessary fields if needed
                if (!is_null($value) && $value != "-" && !in_array($key, ['created_at', 'updated_at'])) {
                    $values[] = strtolower(trim($value)); // Normalize for matching
                }
            }
        }
        // return $values;


        // Get all matching data from database that are in the $input
        $input = strtolower(trim($input));
        $words = preg_split('/\s+/', $input);
        $ignored = ["table","column","someone","some","something","everyone","everything","every","log","can","provide","their","you","please","find","of","is","me","and","equal","value", "give","also", "all", "in", "on","=","than","less","greater","at", "to", "the", "show", "list", "data","who","have","has","been", "using", "with", "for","map","that"];
        $results = [];
        foreach ($words as $word) {
            if (strlen($word) < 2 || in_array($word, $ignored)) continue;

            foreach ($values as $value) {
                if (stripos($value, $word) !== false) {
                    $results[] = $value;
                }
            }
        }
        $results = array_unique($results); // Removes duplicates

        // get columns to be used
        $words = preg_split('/\s+/', strtolower($input));
        foreach ($words as $word) {
            if (strlen($word) < 2) continue;
            if (in_array($word, $ignore)) continue;

            $isColumnMatch = false;

            foreach ($fillable as $fill) {
                if (stripos($fill, $word) !== false) {
                    $column[] = $fill;
                    $isColumnMatch = true;
                    break;
                }
            }
            // Keep word only if it's not matched to any column
            if (!$isColumnMatch) {
                $filteredWords[] = $word;
            }
        }
        $cleanedInput = implode(' ', $filteredWords);
        $column = array_unique($column); // Removes duplicates

        // Get row in database where value is in $results
        $data = DB::all($model);
        $row = [];
        foreach ($data as $d) {
            foreach ($column as $c) {
                in_array(strtolower($d[$c]),array_map('strtolower',$results)) ? $row[] = $d : null;
            }
            in_array(strtolower($d[$model->main]),array_map('strtolower',$results)) ? $row[] = $d : null;
        }


        // Removes duplicates for multidimensional array
        $id = [];
        $temp_row = [];
        foreach ($row as $r) {
            if(!in_array($r["id"],$id)){
                array_push($id,$r["id"]);
                array_push($temp_row,$r);
            }
        }
        $row = $temp_row;

        in_array("ip",$column) ? $column = array_diff($column,["ip"]): null;
        if(count($column)){
            count($row) ? $reply = "" : $reply = "No matching data found. 0";
            for ($i = 0; $i < count($row); $i++) {
                if($model->table == "logs"){ // Add name of user if model is log
                    // $user = new User;
                    // if(count(DB::find($user,$row[$i]["uid"]))){
                    //     $reply .= "<b>".DB::find($user,$row[$i]["uid"])[0]["name"]."</b>br|";
                    // }else{
                    //     $reply .= "<b>Deleted Account</b>br|";
                    // }
                }else{
                    $reply .= "<b>--- ".$row[$i][$model->main]." ---</b>br|";
                }
                foreach ($column as $c) {
                    for ($j = 0; $j < count($row); $j++) {
                        if($row[$j][$model->main] == $row[$i][$model->main]){
                            $reply .= "<b>".$c.": </b><i>".($row[$j][$c] != "-" ? $row[$j][$c] : "")."</i>br|";
                        }
                    }
                }
                $reply .= "br|";
            }
            if(!count($row) && count($column)){
                $data = DB::all($model);
                count($data) ? $reply = "" : $reply = "No matching data found. 00";
                foreach ($data as $d) {
                    $reply .= "<b>--- ".$d[$model->main]." ---</b>br|";
                    foreach ($column as $c) {
                        $reply .= "<b>".$c.": </b><i>".$d[$c]."</i>br|";
                    }
                    $reply .= "br|";
                }
            }
            return $reply;
        }else{
            count($row) ? $reply = "" : $reply = "No matching data found. 1";
            for ($i = 0; $i < count($row); $i++) {
                if($model->table == "logs"){ // Add name of user if model is log
                    // $user = new User;
                    // if(count(DB::find($user,$row[$i]["uid"]))){
                    //     $reply .= "<b>".DB::find($user,$row[$i]["uid"])[0]["name"]."</b>br|";
                    // }else{
                    //     $reply .= "<b>Deleted Account</b>br|";
                    // }
                }else{
                    $reply .= "<b>--- ".$row[$i][$model->main]." ---</b>br|";
                }
                count($column) ? $reply .= "br|" : null;
            }
            if(!count($row) && count($results)){
                $data = DB::all($model);
                $row = [];
                $fillable = [];

                foreach ($data as $d) {
                    foreach ($model->fillable as $fill) {
                        if(in_array(strtolower($d[$fill]),array_map('strtolower',$results))){
                            array_push($row,$d);
                            !in_array($fill,$fillable) ? array_push($fillable,$fill) : null;
                        }
                    }
                }

                // Removes duplicates for multidimensional array
                $id = [];
                $temp_row = [];
                foreach ($row as $r) {
                    if(!in_array($r["id"],$id)){
                        array_push($id,$r["id"]);
                        array_push($temp_row,$r);
                    }
                }
                $row = $temp_row;
                count($row) ? $reply = "" : $reply = "No matching data found. 11";
                foreach ($row as $r) {
                    $reply .= "<b>--- ".$r[$model->main]." ---</b>br|";
                    foreach ($fillable as $f) {
                        $reply .= "<b>".$f.": </b><i>".$d[$f]."</i>br|";
                    }
                    $reply .= "br|";
                }
            }

            if(!count($row) && !count($results)){
                $data = DB::all($model);
                count($data) ? $reply = "" : $reply = "No matching data found. 00";
                foreach ($data as $d) {
                    $reply .= "<b>--- ".$d[$model->main]." ---</b>br|";
                    $reply .= "<b>ID: </b><i>".$d["id"]."</i>br|";
                    $reply .= "<b>".$model->main.": </b><i>".$d[$model->main]."</i>br|";
                    $reply .= "br|";
                }
            }

            return $reply;
        }

        // return ["table to be used","columns or fillable to be used","matching value in database using the query","row of from database which match the value of model->main"]
        return [$table,$column,$results,$row];


        


        // return "⚠️ Unable to generate SQL from input.";
    }
}
?>