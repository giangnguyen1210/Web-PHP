<?php 
  require_once("nv-username.php");
  require_once("nv-position.php");
  if(!isset($_SESSION)) { 
    session_start(); 
  } 
  if ($_SESSION['newPass'] == 1) {
    header('location: ../index.php');
	  exit();
	}

  $username =	$_SESSION['login_name'];
  require_once("../admin/db.php");
  $sql = "SELECT * FROM Tbl_User where login_name = '$username'";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc()){
    $_SESSION['id_positon'] = $row['id_position'];
    $_SESSION['number_department'] =  $row['number_department'];
    $id_employee = $row['id_employee'];
  }
  $sql = "SELECT * FROM Tbl_task where id_employee = '$id_employee'";
  $resultt = $conn->query($sql);
  

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="/style.css">
	<title>TASK</title>
</head>
<body>

  <?php require_once("nv-header.php") ?>

  <table class="table table-hover table-pointer">
    <thead>
      <tr>
        <td>Tiêu đề</td>
        <td>Trạng thái</td>
        <td>Hạn</td>
        <td>Chi tiết</td>
      </tr>
    </thead>
    <tbody>
      <?php

        while($row1 = $resultt->fetch_assoc()){

          $title = $row1['title'];
          $id_status = $row1['id_status_task'];
          $dueto = $row1['due_to'];
          $id_task = $row1['id_task'];
          $select = "SELECT * FROM Tbl_task_status where id_status_task = '$id_status'";
          $result2 = $conn->query($select);
          // $dueto = date("h:i d-m-Y",$dueto);
          $deadline = date('Y-m-d, h:i:s', strtotime($dueto));
          while($row2 = $result2->fetch_assoc()){
            $status = $row2['status_'];
     
            echo ' <tr> <td>'.$title.'</td>
            <td>'.$status.'</td>
            <td>'.$deadline.'</td>
            <td><a href = "/nhan-vien/nv-task-detail.php?id='.$id_task.'">CHI TIẾT</a></td>  </tr>';
          }
         
        }
      
      ?>
    </tbody>
  </table>
	
  <?php require_once("nv-footer.php") ?>

	<script src="/main.js"></script>
</body>
</html>