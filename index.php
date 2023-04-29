<?php
	if(!isset($_SESSION)) { 
    session_start();
  } 
	if (!isset($_SESSION["login_name"])) {
    header('location: login.php');
    exit();
  }
	if ($_SESSION['newPass'] == 1) {
		header('location: new-password.php');
	  exit();
	}
	if ($_SESSION["id_position"] == 1) {
	  header('location: giam-doc/nhan-vien.php');
	  exit();
	}
	if ($_SESSION["id_position"] == 2) {
	  header('location: truong-phong/tp-task.php');
	  exit();
	}
	if ($_SESSION["id_position"] == 3) {
	  header('location: nhan-vien/nv-task.php');
	  exit();
	}
	echo $_SESSION["login_name"] . " - " . $_SESSION["id_position"];
?>