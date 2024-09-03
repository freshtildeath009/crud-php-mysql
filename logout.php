<?php
session_start();

unset($_SESSION['UserLogin']);
unset($_SESSION['Access']);
header("location: index.php");