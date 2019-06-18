<?php
session_start();
unset($_SESSION["nim"]);
unset($_SESSION["password"]);
header("Location:index.php");