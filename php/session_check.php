<?php
    if ($_SESSION["status"] !== "active"){
        header("Location: ../login.php");
        exit;
    }
?>