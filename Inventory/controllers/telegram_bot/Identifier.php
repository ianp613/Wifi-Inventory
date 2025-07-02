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
        $input = strtolower(trim($input));

        $input_temp = $input;
        $in = explode("in",$input);
        count($in) == 2 ? $input = $in[1] : null;

        foreach ($models as $field => $model) {
            $words = preg_split('/\s+/', strtolower($input));

            foreach ($words as $word) {
                // Skip words shorter than 3 characters
                if (strlen($word) < 2) continue;

                // Match if the word is a substring of the model key
                if (stripos($field, $word) !== false) {
                    return Identifier::generateFromModel($model, $input);
                }
            }
        }

        // return ($matches);

        return "No matching data found.";
    }

    public static function generateFromModel($model, $input) {
        return $table = $model->table;

        // Check if there are two possible column in the input
        $and = preg_match('/\band\b/i', $input) ? true : false;

        $column = [];

foreach ($model->fillable as $field) {
    // Check if input contains any part of the field name
    if (preg_match('/' . preg_quote(substr($field, 0, 4), '/') . '/i', $input)) {
        $column[] = $field;
    }
}
        return $column;


        $fillable = $model->fillable;

        // Match commands like "show all users", "get user", "list all user", etc.
        $pattern = "/(give|get|show|list)\s+(me\s+)?(all\s+)?(" . preg_quote($table, '/') . "s?)\b/";

        if (preg_match($pattern, $input)) {
            return "SELECT " . implode(", ", $fillable) . " FROM {$table};";
        }

        return "⚠️ Unable to generate SQL from input.";
    }
}
?>