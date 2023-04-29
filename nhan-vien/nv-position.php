<?php
  if(!isset($_SESSION)) { 
    session_start();
  } 
  if ($_SESSION["id_position"] != 3) {
    header('location: ../index.php');
    exit();
  }
?>