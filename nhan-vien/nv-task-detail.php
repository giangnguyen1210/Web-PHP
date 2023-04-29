<?php 
	require_once("nv-username.php");
	require_once("nv-position.php");
	
	if ($_SESSION['newPass'] == 1) {
		header('location: ../new-password.php');
	  exit();
	}

	date_default_timezone_set("Asia/Ho_Chi_Minh");
if(!isset($_SESSION)) { 
	session_start(); 
  } 
  $error = "";
  $username =	$_SESSION['login_name'];
  require_once("../admin/db.php");
  $sql = "SELECT * FROM Tbl_User where login_name = '$username'";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc()){
	$_SESSION['id_positon'] = $row['id_position'];
	$_SESSION['number_department'] =  $row['number_department'];
  }
  if(isset($_GET['id'])){
	$id_task=$_GET['id'];
	$sqll = "SELECT * FROM Tbl_Task where id_task = '$id_task'";
	$resultt = $conn->query($sqll);
	if($row = $resultt->fetch_assoc()){
		$id_employee = $row['id_employee'];
		if($_SESSION['id_employee'] != $id_employee){
			header("Location: nv-task.php");
			exit();
		}
		$title = $row['title'];
		$id_employee = $row['id_employee'];
		$discription = $row['task_discription'];
		$dueto = $row['due_to'];
		$level = $row['level_complete'];
		$id_status = $row['id_status_task'];
		$select = "SELECT * FROM Tbl_task_status where id_status_task = '$id_status'";
		$result2 = $conn->query($select);
		while($row2 = $result2->fetch_assoc()){
			$status = $row2['status_'];
		}
		
		$select_id_employee ="SELECT * FROM Tbl_User where id_employee = '$id_employee'";
		
		if ($result = $conn -> query($select_id_employee)) {
            while($row = $result->fetch_assoc()){
              $name_employee = $row['fullname_user'];
            }
		}
	}else{
		header("Location: nv-task.php");
		exit();
	}

	if(isset($_POST['submit'])){
		// $update = "UPDATE `tbl_task` SET `task_discription`='[value-3]',`file_attach`='[value-5]',`id_status_task`=2 where id_task = '$id_task'";
		$update = "UPDATE `tbl_task` SET `id_status_task`=2 where id_task = '$id_task'";
		$result = $conn->query($update);
		header("Location: nv-task-detail.php?id=$id_task");
		exit();
	}
	if(isset($_POST['submit1'])){
		$select_id = "SELECT * FROM `tbl_task` WHERE id_task=$id_task";
		$query = $conn->query($select_id);
		if($row= $query->fetch_assoc()){
			$dueto = $row['due_to'];
			$now =  date('Y-m-d h:i');
			if($dueto>$now){
				$deadline = 0;
			}else{
				$deadline = 1;
			}
		}
		$discript = $_POST['newTask-description'];
		$filename = $_FILES["newTask-file"]["name"];
		$tempname = $_FILES["newTask-file"]["tmp_name"];    
		$folder = "../uploads/".$filename;
		$fileType = pathinfo($folder, PATHINFO_EXTENSION);
		$valid_extensions = array("zip", "rar","doc","docx","pdf","pptx","xlsx","jpg", "jpeg", "png");
		if($_FILES["newTask-file"]["size"]>42000000){
			$error = "Kích thước file quá lớn";
		}elseif(empty($discript)){
			$error = "Nhập mô tả";
		}
		elseif(in_array(strtolower($fileType), $valid_extensions)) {
			move_uploaded_file($_FILES["newTask-file"]["tmp_name"], $folder);
			$update = "UPDATE `tbl_task` SET `task_discription`='$discript',`file_attach`='$filename',`deadline` = $deadline,`id_status_task`=4 where id_task = '$id_task'";
			$result = $conn->query($update);
			header("Location: nv-task-detail.php?id=$id_task");
			exit();
		}else{
			$error = "Chọn lại file";
		}
	}

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
	<title>TASK DETAIL</title>
</head>
<body>
  <?php require_once("nv-header.php") ?>
	<div class="mail">
		<div>
			<!-- <?php $deadline = date('Y-m-d, h:i:s', strtotime($dueto));?> -->
			
			<h1>Title: <?=$title?></h1>
			<p>Người nhận: <?=$name_employee?></p>
			<p>Hạn: <?=$deadline?></p>
			<p>Trạng thái: <?=$status?></p>
			<p>Mức độ hoàn thành: <?=$level?></p>
			<div>
				Mô tả: <?= $discription?>
			</div>
			<hr>
			<form action = ""  id="ns-submit" method="POST" enctype="multipart/form-data">
				<?php
					$sql = "SELECT file_attach FROM Tbl_task where id_task= '$id_task'";
					$result = $conn->query($sql);
					echo '<p>File đính kèm: </p>';
					while($row = mysqli_fetch_array($result)) { 
						echo '<a href="/uploads/'.$row['file_attach'].' " target="_blank">'.$row['file_attach'].'</a>';
					}
				
				?>
			<hr>

				<?php 
				$select_history = "SELECT * FROM `tbl_history_task` WHERE id_employee = '$id_employee' and id_task= '$id_task'";
				$result3 = $conn->query($select_history);
				while($row3 = $result3->fetch_assoc()){
					$history = $row3['history'];
					$file = $row3['file'];
					echo '<p>
					Lịch sử: '.$history.'
					</p>
					<p>
					File đính kèm: <a href="/uploads/'.$file.' " target="_blank">'.$file.'</a>
					</p>';
				}
			?>
				
			
				<div>
					<button type="button" name="abc" onclick="setTimeout(() => {setFooter(true); window.scrollTo(0,document.body.scrollHeight)}, 300)" class="btn a-btn f-r <?php echo ($id_status == 1)? ("none"): ("") ?>" data-toggle="collapse" data-target="#submit" <?php echo ($id_status == 2 || $id_status == 5)? (""): ("disabled") ?>>SUBMIT</button>
					<button name="submit" class="btn a-btn f-r <?php echo ($id_status == 1)? (""): ("none")?>">START</button>
				</div>
			</form>
		</div>
	</div>
	
	<div class="collapse c-b" id="submit">
		<div class="my-form">
			<form action = ""  id="ns-submit" method="POST" enctype="multipart/form-data">
				<p>Mô tả:</p>
				<textarea name="newTask-description" value="" id="newTask-description"  rows="3" cols="48"></textarea>
				<p>File đính kèm:</p>
				<input type="file" name="newTask-file" id="newTask-file" class="inputfile">
				<label for="newTask-file" class="input input-file"><span>Chọn file</span></label>
				<!-- <p class="err" id="newTask-err"> -->
				<?php
                  if (!empty($error)) {
                      echo "<div class='alert alert-danger'>$error</div>";
                  }
                  if (!empty($success)) {
                      echo "<div class='alert alert-success'>$success</div>";
                  }
              ?>	
				<!-- </p> -->

				<button name="submit1" type="submit">TURN IN</button>
			</form>
		</div>
	</div>
	
	
  <?php require_once("nv-footer.php") ?>

	<script src="/main.js"></script>
</body>
</html>