<?php
class SQLGenerator {
    public static function generate($input) {
        $models = [
            "user" => new User(),
            "equipment" => new Equipment(),
            "entry" => new Equipment_Entry(),
            "network" => new IP_Network(),
            "ip" => new IP_Address(),
            "router" => new Routers(),
            "isp" => new ISP(),
            "map" => new CCTV_Location(),
            "cctv" => new CCTV_Camera(),
            "log" => new Logs(),
        ];
        $input = strtolower(trim($input));

        // Identify table name
        foreach ($models as $key => $model) {
            if (strpos($input, $key) !== false) {
                return SQLGenerator::generateFromModel($model, $input);
            }
        }

        return "No matching data found.";
    }

    public static function generateFromModel($model, $input) {
        $table = $model->table;
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