<?php
session_start();
date_default_timezone_set('America/Los_Angeles');

$dbname = "interview_test"; // Make sure this DB exists!
$servername = "localhost"; 
$Username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $Username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERROR J3DJS7SGHSJS"); // Standards Error for Connection
}

function clean_string($string_val) {
    return strip_tags(filter_var($string_val, FILTER_SANITIZE_SPECIAL_CHARS));
}

function strip_non_alphanumeric($string_val) {
    return preg_replace("/[^A-Za-z0-9]/", '', $string_val);
}