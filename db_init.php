<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$db_name = "reviews";           /** Enter your data base name. Example "reviews" */
$db_host = "localhost";         /** Enter your host. Example "mysql.zzz.com.ua"; */
$db_user = "root";              /** Enter your user name. Example "root"; */
$db_pass = "ivan54321";         /** Enter your password for data base. Example "root"; */
$db_charset = "utf8";           /** Database encoding, default utf8 */


$db_dsn = "mysql:host=$db_host;dbname=$db_name;charset=$db_charset";

$db_opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

$db = new PDO($db_dsn, $db_user, $db_pass, $db_opt);