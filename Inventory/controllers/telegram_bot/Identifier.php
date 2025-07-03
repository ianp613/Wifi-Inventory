<?php
class Identifier {
    public static function main($input) {
        $models = [
            "ip" => new IP_Address(),
            "equipment" => new Equipment(),
            "entry" => new Equipment_Entry(),
            "network" => new IP_Network(),
            "router" => new Routers(),
            "isp" => new ISP(),
            "map" => new CCTV_Location(),
            "cctv" => new CCTV_Camera(),
            "log" => new Logs(),
        ];

        $ignore = ["en", "ent","me"];  // Add any more short tokens here

        $input_temp = strtolower(trim($input));
        $in = explode("in", $input);
        $input = count($in) == 2 ? $in[1] : $input;

        foreach ($models as $field => $model) {
            $words = preg_split('/\s+/', strtolower($input));

            foreach ($words as $word) {
                if (strlen($word) < 2) continue;
                if (in_array($word, $ignore)) continue;  // 🔥 Skip ignored words

                if (stripos($field, $word) !== false) {
                    return Identifier::generateFromModel($model, $input_temp);
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


        $input = strtolower(trim($input));
        $words = preg_split('/\s+/', $input);
        $ignored = ["is","me", "give", "all", "in", "on", "at", "to", "the", "show", "list", "data", "using", "with", "for","map"];
        $results = [];
        foreach ($words as $word) {
            if (strlen($word) < 2 || in_array($word, $ignored)) continue;

            foreach ($values as $value) {
                if (stripos($value, $word) !== false) {
                    $results[] = $value;
                    break;
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
            in_array(strtolower($d[$model->main]),array_map('strtolower',$results)) ? $row[] = $d : null;
        }

        if(count($column)){
            return true;
            // $final = [];
            // for
        }else{
            return false;
        }

        // return ["table to be used","columns or fillable to be used","matching value in database using the query","row of from database which match the value of model->main"]
        return [$table,$column,$results,$row];


        


        // return "⚠️ Unable to generate SQL from input.";
    }
}
?>