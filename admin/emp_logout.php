<?php
session_start();
unset($_SESSION['employee']);
session_destroy();
header('Location:index.php');
?>