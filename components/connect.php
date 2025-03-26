<?php
// port=3307
// Database connection parameters
$db_name = 'mysql:host=localhost;dbname=home_db'; 
$db_user = 'root'; // Default XAMPP username
$db_user_pass = ''; // Default XAMPP password (empty)

try {
    $conn = new PDO($db_name, $db_user, $db_user_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Database connected successfully!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
/**
 * Function to create a unique 20-character alphanumeric ID
 *
 * This function generates a random string containing
 * numbers (0-9), lowercase letters (a-z), and uppercase letters (A-Z).
 *
 * @return string A unique 20-character alphanumeric string
 */
function create_unique_id(){
    $char =
    '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $char_len = strlen($char);
    $rand_str = '';
    for($i = 0; $i < 20; $i++){
        // Append a random character to $rand_str
        $rand_str .= $char[mt_rand(0, $char_len -1)];
    }
    return $rand_str;
}

?>