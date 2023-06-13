<?php
$config = parse_ini_file('config.ini');

define('DB_HOST', $config['DB_HOST']);
define('DB_USERNAME', $config['DB_USERNAME']);
define('DB_PASSWORD', $config['DB_PASSWORD']);
define('DB_DATABASE_NAME', $config['DB_DATABASE_NAME']);
define('PASSWORD_LENGTH', $config['PASSWORD_LENGTH']);
define('DEFAULT_PROFILE_PICTURE', $config["DEFAULT_PROFILE_PICTURE"]);

$cookie_expiration_delay = $config['cookie_expiration_delay'];

?>