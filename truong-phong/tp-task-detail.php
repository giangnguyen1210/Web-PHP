<?php 
	require_once("tp-username.php");
	require_once("tp-position.php");
	date_default_timezone_set("Asia/Ho_Chi_Minh");
	if ($_SESSION['newPass'] == 1) {
		header('location: ../new-password.php');
	  exit();
	}

	$error = '';
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
			$id_department = $row['id_department'];
			if($_SESSION['number_department'] != $id_department){
				header("Location: tp-task.php");
				exit();
			}
			$title = $row['title'];
			$id_employee = $row['id_employee'];
			$discription = $row['task_discription'];
			$note = $row['task_note'];
			$dueto = $row['due_to'];
			$level = $row['level_complete'];
			$id_status = $row['id_status_task'];
			$deadline_status = $row['deadline'];
			
			$select = "SELECT * FROM Tbl_task_status where id_status_task = '$id_status'";
			$result2 = $conn->query($select);
			while($row2 = $result2->fetch_assoc()){
				$status = $row2['status_'];
			}
			$select_name = "SELECT * FROM Tbl_user where id_employee = '$id_employee'";
			$result_name = $conn->query($select_name);
			while($row3 = $result_name->fetch_assoc()){
				$fullname = $row3['fullname_user'];
			}
			$select_ = "SELECT * FROM tbl_task where id_task = $id_task";
			$result4 = $conn->query($select_);
			if($row4 = $result4->fetch_assoc()){
				$file_ = $row4['file_attach'];
			}
			if(isset($_POST['bad'])){
				$history = "Tiêu đề: ".$title.", Trạng thái: Completed, Mức độ hoàn thành: Bad, Mô tả: ".$discription." ";
				$update_history = "INSERT INTO `tbl_history_task`(`id_employee`, `history`, `id_task`,`file`) VALUES ('$id_employee','$history' ,'$id_task','$file_')";
				$result4 = $conn->query($update_history);
				$update = "UPDATE `tbl_task` SET `level_complete`='Bad', `id_status_task`= 6 WHERE id_task = $id_task";
				$result3 = $conn->query($update);
				header("Location: tp-task-detail.php?id=$id_task");
				exit();
			}elseif(isset($_POST['ok'])){
				$history = "Tiêu đề: ".$title.", Trạng thái: Completed, Mức độ hoàn thành: OK, Mô tả: ".$discription." ";
				$update_history = "INSERT INTO `tbl_history_task`(`id_employee`, `history`, `id_task`,`file`) VALUES ('$id_employee','$history' ,'$id_task','$file_')";
				$result4 = $conn->query($update_history);
				$update = "UPDATE `tbl_task` SET `level_complete`='Ok', `id_status_task`= 6 WHERE id_task = $id_task";
				$result3 = $conn->query($update);
				header("Location: tp-task-detail.php?id=$id_task");
				exit();
			}elseif(isset($_POST['good'])){
				$history = "Tiêu đề: ".$title.", Trạng thái: Completed, Mức độ hoàn thành: Good, Mô tả: ".$discription." ";
				$update_history = "INSERT INTO `tbl_history_task`(`id_employee`, `history`, `id_task`,`file`) VALUES ('$id_employee','$history' ,'$id_task','$file_')";
				$result4 = $conn->query($update_history);
				$update = "UPDATE `tbl_task` SET `level_complete`='Good', `id_status_task`= 6 WHERE id_task = $id_task";
				if($deadline_status == 1){
					$update = "UPDATE `tbl_task` SET `level_complete`='Ok', `id_status_task`= 6 WHERE id_task = $id_task";
				}
				$result3 = $conn->query($update);
				header("Location: tp-task-detail.php?id=$id_task");
				exit();
			}elseif(isset($_POST['rejected'])){
				$dueto_ = $_POST['deadline'];
				// echo $dueto_;
	   			$dueto_time = date('Y-m-d, h:i:s', strtotime($dueto_));
				$note = $_POST['note'];
				$filename = $_FILES["newTask-file"]["name"];
				$tempname = $_FILES["newTask-file"]["tmp_name"];    
				$folder = "../uploads/".$filename;
				$imgFileType = pathinfo($folder, PATHINFO_EXTENSION);
				$valid_extensions = array("zip","rar","doc","txt","pdf","xlsx","docx","jpg", "pptx","jpeg", "png");
				if(empty($note)){
					$error = 'Cần nhập ghi chú';
				}elseif(empty($dueto_)){
					$error = 'Cần gia hạn';
				}elseif($filename){
					if($_FILES["newTask-file"]["size"]>42000000){
						$error = "Kích thước file quá lớn";
					}
					elseif (in_array(strtolower($imgFileType), $valid_extensions)) {
						move_uploaded_file($_FILES["newTask-file"]["tmp_name"], $folder);
						$update = "UPDATE `tbl_task` SET `id_status_task`= 5,`due_to`='$dueto_',`file_attach`='$filename' ,`task_note`='$note' WHERE id_task = $id_task";
						$result3 = $conn->query($update);
						// $deadline = 
						$history = "Tiêu đề: ".$title.", Hạn: ".$dueto_time.", Mô tả: ".$discription.",  Lưu ý: ".$note;
						$update_history = "INSERT INTO `tbl_history_task`(`id_employee`, `history`, `file`, `id_task`) VALUES ('$id_employee','$history','$filename' ,'$id_task')";
						$result4 = $conn->query($update_history);
						header("Location: tp-task-detail.php?id=$id_task");
						exit();
					}else{
						$error = "Chọn lại file";
					}
					
				}
				
				
			}elseif(isset($_POST['canceled'])){
				$delete = "DELETE FROM `tbl_task` WHERE id_task = $id_task";
				$result3 = $conn->query($delete);
				header("Location: tp-task.php");
				exit();
			}
		}else{
			header("Location: tp-task.php");
			exit();
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

  <?php require_once("tp-header.php") ?>
	<div class="mail">
		<?php  $deadline_ = date('Y-m-d, h:i:s', strtotime($dueto));?>
		<h1>Title: <?=$title?></h1>
		<p><strong>Người nhận: </strong><?=$fullname?></p>
		<p><strong>Hạn: </strong><?=$deadline_?></p>
		<p><strong>Trạng thái:</strong> <?=$status?></p>
		<p><strong>Mức độ hoàn thành:</strong> <?=$level?></p>
		<p><strong>Mô tả:</strong> <?= $discription?></p>
		<hr>
		<?php
			$sql = "SELECT * FROM tbl_task where id_task= '$id_task'";
			$result = $conn->query($sql);
			echo '<p>File đính kèm: </p>';
			while($row = mysqli_fetch_array($result)) { 
				echo '<a href="../uploads/'.$row['file_attach'].' " target="_blank">'.$row['file_attach'].'</a>';
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
					Lịch sử: '.$history.', File đính kèm: <a href="/uploads/'.$file.' " target="_blank">'.$file.'</a>
					</p>';
				}
			?>
		<div>
			<button class="btn a-btn f-r" data-toggle="modal" data-target="#completed" <?php echo ($id_status == 4)? (""): ("disabled") ?>>COMPLETED</button>
			<form id="tp-submit" method="post" action="" enctype="multipart/form-data">
			<button type="button" onclick="setTimeout(() => window.scrollTo(0,document.body.scrollHeight), 300)" class="btn a-btn f-r" data-toggle="collapse" data-target="#rejected" <?php echo ($id_status == 4)? (""): ("disabled") ?>>REJECTED</button>
			<button name="canceled" class="a-btn btn f-r" <?php echo ($id_status == 1)? (""): ("disabled") ?>>CANCELED</button>
		</div>
	</div>
	
	<div class="collapse c-b" id="rejected">
		<div class="my-form">
				<p>Lưu ý:</p>
				<textarea name="note" value="" id="newTask-description"  rows="3" cols="48"></textarea>
				<p>File đính kèm:</p>
				<input type="file" name="newTask-file" id="newTask-file" class="inputfile">
     			<label for="newTask-file" class="input input-file"><span>Chọn file</span></label>
				<p class="err fade" id="newTask-err">
				</p>
				<p>Gia hạn:</p>
			<input value="<?=$deadline?>" type="datetime-local" name="deadline" id="newTask-time">
				<?php
				if (!empty($error)) {
					echo "<div class='alert alert-danger'>$error</div>";
				}
				?>
				<button name="rejected" type="submit">XÁC NHẬN</button>
		</div>
	</div>
	<div class="modal fade" id="completed" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Chọn mức độ hoàn thành: </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<button class="btn a-btn btn-lvl" name = "bad">Bad</button>
					<button class="btn a-btn btn-lvl" name = "ok">Ok</button>
					<button class="btn a-btn btn-lvl" name = "good" <?php echo ($deadline_status == 0)? (""): ("disabled") ?>>Good</button>
				</div>
			</div>
			<!-- <?php echo $deadline; ?> -->
		</div>
	</div>
	
	</form>
	
	<?php require_once("tp-footer.php") ?>

	<script src="/main.js"></script>
</body>
</html>