<?php
require 'php/ping_test.php';
session_start();
include 'constants/session_config.php';
if ($is_logged_in){
    header("Location: homepage_seller.php");
    exit;
} else {
    header("Location: login.php");
    exit;
}
?>