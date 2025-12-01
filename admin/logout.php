<?php
    session_start();
    session_unset();
    session_destroy();
    include("../config/index.php");
    header("Location: ".$SITE_URL."/admin/login.php");
    exit();
?>