<?php 
  require_once("username.php");
	if ($_SESSION['newPass'] == 1) {
		header('location: new-password.php');
	  exit();
	}

  if ($_SESSION['id_position'] != 1) {
    header("index.php");
  }
  if(!isset($_SESSION)) { 
    session_start();
  } 
  if ($_SESSION["id_position"] != 1) {
    header('location: ../index.php');
    exit();
  }

  if (isset($_GET['name'])) {
    require_once("admin/db.php");
    $login_name = $_GET['name'];
    $password_reset = $_GET['name'];
    if(isset($login_name)){
        $sql = "SELECT * FROM Tbl_User where login_name = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param("s",$login_name);
        if(!$stm->execute()){
      die("cant execute ".$stm->error);
    }
    
    $result = $stm->get_result();
    while($row = $result->fetch_assoc()){
            $sql1 = "UPDATE `Tbl_User` SET user_password = ? where login_name = ?";
            
            $stm1 = $conn->prepare($sql1);
            $password_reset = password_hash($password_reset,PASSWORD_BCRYPT);
            $stm1->bind_param("ss",$password_reset,$login_name);
            
      if(!$stm1->execute()){
                die();
            }else{
              header("refresh:1;url=../giam-doc/nhan-vien.php");
              exit();
            }
        }
    }
  }
?>