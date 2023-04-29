<?php 
  require_once("tp-username.php");
  require_once("tp-position.php");
  
	if ($_SESSION['newPass'] == 1) {
		header('location: ../new-password.php');
	  exit();
	}

  $username =	$_SESSION['login_name'];  
  $id_department =	$_SESSION['id_department'];
  require_once("../admin/db.php");
  $sql = "SELECT * FROM Tbl_User where login_name = '$username'";
  // $sql = "SELECT * FROM Tbl_User where login_name = '$username' and id_department= '$id_department'";

  $result = $conn->query($sql);
  while($row = $result->fetch_assoc()){
    $_SESSION['id_positon'] = $row['id_position'];
    $_SESSION['number_department'] =  $row['number_department'];
  }
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

  <?php require_once("tp-header.php") ?>
  
  <table class="table table-hover table-pointer">
    <thead>
    <tr>  
				<td><button onclick="window.location = '../new-task.php'" class="btn-detail">THÊM TASK</button></td>
			</tr>
      <tr>
       <td><strong>Nhân viên</strong></td>
       <td><strong>Tiêu đề</strong></td>
       <td><strong>Trạng thái</strong></td>
       <td><strong>File đính kèm</strong></td>
       <td><strong>Hạn</strong></td>
       <td><strong>Chi tiết</strong></td>
      </tr>
    </thead>
    <tbody>
      <?php

       $select = "SELECT * FROM Tbl_Task where id_department = $id_department"; 
       $resultl = $conn->query($select);
       while($roww = $resultl->fetch_assoc()){
         $title = $roww['title'];
         $discription = $roww['task_discription'];
         $dueto = $roww['due_to'];
         $file = $roww['file_attach'];
         $id_employee = $roww['id_employee'];
         $id_status = $roww['id_status_task'];
         $id_task = $roww['id_task'];
         $select_id ="SELECT * FROM Tbl_task_status where id_status_task = $id_status";
         if ($result = $conn -> query($select_id)) {
            while($row = $result->fetch_assoc()){
              $status = $row['status_'];
            }
        } else {
            printf("Query failed: %s\n", $conn -> error);
        }

        // $select_id_employee ="SELECT * FROM Tbl_User";
        $select_id_employee ="SELECT * FROM Tbl_User where id_employee = '$id_employee'";
	     $deadline = date('Y-m-d, h:i:s', strtotime($dueto));
        
         if ($result = $conn -> query($select_id_employee)) {
            while($row = $result->fetch_assoc()){
              $name_employee = $row['fullname_user'];
              echo '<tr> 
              <td>'.$name_employee.'</td>
              <td>'.$title.'</td>
              <td>'.$status.'</td>
              <td>'.$file.'</td>
              <td>'.$deadline.'</td>
              <td><a href = "/truong-phong/tp-task-detail.php?id='.$id_task.'">Chi tiết</a></td>
            </tr>';
            }
        } else {
            printf("Query failed: %s\n", $conn -> error);
        }
        
      }
          ?>

      <!-- <tr>  
				<td colspan="6"><button onclick="window.location = '../new-task.php'" class="btn-detail">THÊM TASK</button></td>
			</tr> -->

          <!-- <tr onclick="window.location = '/truong-phong/tp-task-detail.php'"> -->
       
         
        
    </tbody>
  </table>
	
  <?php require_once("tp-footer.php") ?>

	<script src="/main.js"></script>
</body>
</html>