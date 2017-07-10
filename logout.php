<?php
session_start();
session_destroy(); //clear all session
header("Location: index.php");
exit();