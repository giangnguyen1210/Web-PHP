<?php
	require_once("username.php");
  if(!isset($_SESSION)) { 
    session_start();
  } 
	if ($_SESSION['newPass'] == 1) {
		header('location: new-password.php');
	  exit();
	}
  if ($_SESSION["id_position"] != 2) {
    header('location: ../index.php');
    exit();
  }
	date_default_timezone_set("Asia/Ho_Chi_Minh");
	require_once("admin/db.php");
	$error = '';
	if(isset($_POST['submit']))
    {
		$filename = $_FILES["newTask-file"]["name"];
		$tempname = $_FILES["newTask-file"]["tmp_name"];    
		$folder = "uploads/".$filename;
		$fullname = $_POST['newTask-phongBan'];
		$fileType = pathinfo($folder, PATHINFO_EXTENSION);
		$valid_extensions = array("zip", "rar","doc","docx","pdf","pptx","xlsx","jpg", "jpeg", "png");

		if (in_array(strtolower($fileType), $valid_extensions)) {
			move_uploaded_file($_FILES["newTask-file"]["tmp_name"], $folder);
			$title = $_POST['newTask-title'];
			$discript = $_POST['newTask-description'];
			// $file = $_POST['newTask-file'];
			$dueto = $_POST['newTask-time'];
			$dueto = date('Y-m-d h:i', strtotime($dueto));
			if(empty($title)){
				$error = 'Nhập tiêu đề task';
			}elseif(empty($discript)){
				$error = 'Nhập mô tả task';
			}elseif(empty($dueto)){
				$error = 'Nhập thời hạn task';
			}elseif(empty($fullname)){
				$error = 'Nhập người được giao task';
			}
			if($error==''){
				$sql = "SELECT * FROM Tbl_User where fullname_user = '$fullname'";
				$result = $conn->query($sql);
				$row = $result->fetch_assoc();
				$id_employee = $row['id_employee'];
				$id_department = $_SESSION['id_department'];
				$sqll = "INSERT INTO `tbl_task`(`title`, `task_discription`, `id_employee`,`file_attach`,`due_to`,`id_status_task`,`id_department`) VALUES ('$title','$discript','$id_employee', '$filename','$dueto',1,'$id_department')";
				if ($conn->query($sqll) === TRUE) {
					header("refresh:1;url=truong-phong/tp-task.php");
					exit();
				} else {
					$error = "$conn->error";
					// echo "Error: " . $sqll . "<br>" . $conn->error;
				}
			}
		}else{
			$error = "Chọn lại file";
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
	<title>NEW TASK</title>
</head>
<body>
  <!-- <img src="/images/logo.png" alt="logo" class="my-logo"> -->
  <?php require_once("truong-phong/tp-header.php") ?>
	<div class="my-form">
		<form id="newTask-form" method="post" action="" enctype="multipart/form-data">
      <p>Tiêu đề:</p>
			<input type="text" name="newTask-title" id="newTask-title">
      <p>Mô tả:</p>
			<textarea name="newTask-description" value="<?=$discript?>" id="newTask-description"  rows="3" cols=""></textarea>
      <p>File đính kèm:</p>
      <input type="file" value="<?=$filename?>" name="newTask-file" id="newTask-file" class="inputfile">
      <label for="newTask-file" class="input input-file"><span>Chọn file</span></label>
      <p>Người nhận:</p>
	  <?php
	  		$number_department = $_SESSION['number_department'];
			$sql1 = "SELECT  * FROM `Tbl_User` where number_department = $number_department and id_position = 3";
			$result = $conn->query($sql1);
			$number = $result->num_rows;

			if($result->num_rows==0){
				die("connect but no data");
			}
			echo '<select name="newTask-phongBan" class="input" id="newTask-receiver">';
			while ($row = mysqli_fetch_assoc($result)) {
				$username =$row['fullname_user'];
				echo'<option value="'.$username.'">'.$username.'</option>';
			}
			echo'</select>';
		?>
		 <p>Thời hạn:</p>
			<input value="<?=$dueto?>" type="datetime-local" name="newTask-time" id="newTask-time">
      <p class="err fade" id="newTask-err">
		<?php
			if (!empty($error)) {
				echo "<div class='alert alert-danger'>$error</div>";
			}
		?>	
		</p>
			<button name="submit" type="submit">TẠO</button>
		</form>
	</div>
	<?php require_once("truong-phong/tp-footer.php") ?>
	<script src="/main.js"></script>
</body>
</html>