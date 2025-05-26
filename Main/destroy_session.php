<?php
session_start();
if(isset($_SESSION['ID']) || isset($_SESSION['Admin'])){
    session_destroy();
    header("Location: Home.php");
}else{
    header("Location: Home.php");
}
?>