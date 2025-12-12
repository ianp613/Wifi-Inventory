<?php
class MAC_FIX{
    public static function index($mac) {
        // Remove any non-hex characters (like colons, dashes)
        $clean = preg_replace('/[^a-fA-F0-9]/', '', $mac);

        // Check if it's exactly 12 hex characters
        if (preg_match('/^[a-fA-F0-9]{12}$/', $clean)) {
            // Convert to colon-separated format
            $normalized = strtolower(implode(':', str_split($clean, 2)));
            return $normalized;
        }

        // Check if it's already in valid colon-separated format
        if (preg_match('/^([0-9a-fA-F]{2}:){5}[0-9a-fA-F]{2}$/', $mac)) {
            return strtolower($mac); // normalize case
        }

        // If not valid, return false
        return false;
    }
}

?>