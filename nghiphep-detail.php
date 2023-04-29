<?php 
	require_once("username.php");
	if ($_SESSION['newPass'] == 1) {
		header('location: new-password.php');
	  exit();
	}

	require_once("admin/db.php");
	$id_position = $_SESSION['id_position'];
	$id_day_off = $_GET['id_day_off'];
	if(isset($id_day_off)){
		$select = "SELECT * FROM `tbl_day_offs` WHERE id_day_off = '$id_day_off'";
		$result = $conn->query($select) or die($conn->error);
		if($row = $result->fetch_assoc()){
			// if($result->
			$start = $row['start'];
			$end = $row['end'];
			$number_day_off = $row['number_day_off'];
			$num_left = $row['numbers_day_left'];
			$id_employee = $row['id_employee'];
			$reason = $row['reason'];
			$file = $row['file_attach'];
			$refined_date_start = intval(implode("", explode("-", $start)));
			$refined_date_end = intval(implode("", explode("-", $end)));
			$range = $refined_date_end - $refined_date_start;
		}
		else{
			header("Location: duyet-nghiphep.php");
			exit();
		}
		if(isset($_POST['approved'])){
			$status = "Approved";
			$num_left= $num_left-$range;
			$history = "Ngày bắt đầu nghỉ: ".$start.", Ngày kết thúc nghỉ: ".$end.", Số ngày còn lại: ".$num_left.", Lý do: ".$reason.", Trạng thái: ".$status;
			$insert_history = "INSERT INTO `day_off_history`(`id_employee`,`id_day_off`,`history`,`file_attach`) VALUES ('$id_employee','$id_day_off','$history','$file')";
			$result4 = $conn->query($insert_history);
			$update = "UPDATE
					`tbl_day_offs`
				SET
					`start` = NULL,
					`end` = NULL,
					`numbers_day_left` = $num_left,
					`number_day_off` = NULL,
					`reason` = NULL,
					`file_attach` = NULL,
					`id_status_day_off` = NULL where id_employee ='$id_employee' ";
			$result = $conn->query($update);
			header("Location: duyet-nghiphep.php");
			exit();
		}
		elseif(isset($_POST['refused'])){
			$status = "Refused";
			$history = "Ngày bắt đầu nghỉ: ".$start.", Ngày kết thúc nghỉ: ".$end.", Số ngày còn lại: ".$num_left.", Lý do: ".$reason.", Trạng thái: ".$status;
			$insert_history = "INSERT INTO `day_off_history`(`id_employee`,`id_day_off`,`history`,`file_attach`) VALUES ('$id_employee','$id_day_off','$history','$file')";
			$result4 = $conn->query($insert_history);
			$update = "UPDATE
					`tbl_day_offs`
				SET
					`start` = NULL,
					`end` = NULL,
					`number_day_off` = NULL,
					`numbers_day_left` = $num_left,
					`reason` = NULL,
					`file_attach` = NULL,
					`id_status_day_off` = NULL where id_employee ='$id_employee' ";
			$result = $conn->query($update);
			$status = "Refused";
			header("Location: duyet-nghiphep.php");
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
	<title>CHI TIẾT NGHỈ PHÉP</title>
</head>
<body>
  <?php 
		if($id_position==3){
			require_once("/nhan-vien/nv-header.php");
		}elseif($id_position==2){
			require_once("truong-phong/tp-header.php");
		}elseif($id_position==1){
			require_once("site/navbar.php");
		}
		if(isset($id_day_off)){
			$select = "SELECT * FROM `tbl_day_offs` WHERE id_day_off = '$id_day_off' ";
			$result = $conn->query($select);
			while($row = $result->fetch_assoc()){
				$start = $row['start'];
				$id_employee = $row['id_employee'];
				$select_id_employee ="SELECT * FROM Tbl_User where id_employee = '$id_employee'";
				if ($result = $conn -> query($select_id_employee)) {
					while($row1 = $result->fetch_assoc()){
						$name_employee = $row1['fullname_user'];
					}
				}
				$end = $row['end'];
				$numdayoff = $row['number_day_off'];
				$reason = $row['reason'];
				$file = $row['file_attach'];
				$id_status = $row['id_status_day_off'];
				if($id_status==1){
					$status = "Waiting";
				}elseif($id_status==2){
					$status = "Refused";
				}elseif($id_status==3){
					$status = "Approved";
				}
			}
			echo '	<div class="mail">
			<h1>Nghỉ phép</h1>
			<p>Người gửi: '.$name_employee.'</p>
			<p>Ngày bắt đầu nghỉ: '.$start.' </p>
			<p>Ngày kết thúc nghỉ: '.$end.'</p>
			<p>Số ngày nghỉ: '.$numdayoff.'</p>
			<p>Lý do: '.$reason.' </p>
			<p>Trạng thái: '.$status.' </p>
			<hr>';
			echo '<p>file đính kèm: </p>';
			while($row = mysqli_fetch_array($result)) { 
				echo '<a href="../uploads/'.$file.' " target="_blank">'.$file.'</a>';
			}
		}
  ?>

	<form action = "" method="POST">
    <div>
			<button name="refused" class="btn a-btn f-r">REFUSED</button>
			<button name="approved" class="btn a-btn f-r">APPROVED</button>
	</div>
	</form>
    <footer class="bg-dark text-center text-white">
    <?php require_once("site/footer.php") ?>
	</footer>
	<script src="/main.js"></script>
</body>
</html>