<?php
session_start();
unset($_SESSION['mmnLogin']);
header("Location: login.php");
exit;