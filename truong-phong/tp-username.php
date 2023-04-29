<?php
  if(!isset($_SESSION)) { 
    session_start();
  } 
  if (!isset($_SESSION['login_name'])) {
    header('location: ../index.php');
    exit();
  }
?>