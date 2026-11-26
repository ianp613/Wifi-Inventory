<?php
declare(strict_types=1);
// Usage:  php bin/reset_password.php [username] <new-password>
//   php bin/reset_password.php MyNewPass123          -> resets the first admin account
//   php bin/reset_password.php admin MyNewPass123    -> resets (or creates) "admin"
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
require __DIR__ . '/../app/lib.php';

$args = array_slice($argv, 1);
if (count($args) === 1) {
    $pass = $args[0];
    $user = (string)(val('SELECT username FROM admins ORDER BY id LIMIT 1') ?: 'admin');
} elseif (count($args) === 2) {
    [$user, $pass] = $args;
} else {
    fwrite(STDERR, "Usage: php bin/reset_password.php [username] <new-password>\n");
    exit(1);
}
if (strlen($pass) < 8) { fwrite(STDERR, "Password must be at least 8 characters.\n"); exit(1); }

$hash = password_hash($pass, PASSWORD_DEFAULT);
if (val('SELECT 1 FROM admins WHERE username=?', [$user])) {
    q('UPDATE admins SET password_hash=? WHERE username=?', [$hash, $user]);
    echo "Password updated for \"$user\".\n";
} else {
    q('INSERT INTO admins(username,password_hash) VALUES(?,?)', [$user, $hash]);
    echo "Admin \"$user\" created.\n";
}