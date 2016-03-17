<?php
    require_once("LIB_project1.php");
    session_unset();
    session_destroy();
    header("Location: login.php");
