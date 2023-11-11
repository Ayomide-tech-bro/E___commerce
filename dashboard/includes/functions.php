<?php
require_once('conn.php');
/**
 * This function sanitizes user inputs with
 * - mysqli_real_escape_string
 * - strip_tags
 * - trim
 *
 * @param mysqli $conn The MySQLi connection object.
 * @param string $var The variable to be sanitized.
 *
 * @return string The sanitized variable.
 */
function sanitize_var($conn, $var) {
    $var = mysqli_real_escape_string($conn, strip_tags(trim($var)));
    return $var;
}
?>