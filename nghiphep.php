<?php
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    require_once("username.php");
		if ($_SESSION['newPass'] == 1) {
			header('location: new-password.php');
			exit();
		}

	$error = '';
	$success = '';
    require_once("admin/db.php");
	$login_name = $_SESSION['login_name'];
	$year = date("Y");
	$select = "SELECT * FROM `tbl_day_offs` LIMIT 1";
	$solve = $conn->query($select);
	if($row1 = $solve->fetch_assoc()){
		$year_ = $row1['year'];
		if($year != $year_){
			$update = "UPDATE `tbl_day_offs` SET `sum_day_off`=15,`numbers_day_left`=15, `year`='$year' where `id_position`=2";
			$query = $conn->query($update);
			$update2 = "UPDATE `tbl_day_offs` SET `sum_day_off`=12,`numbers_day_left`=12, `year`='$year' where `id_position`=3";
			$query2 = $conn->query($update2);
		}
	}



	$sql = "SELECT *from `Tbl_user` where login_name = '".$_SESSION['login_name']."'";
	$result = $conn->query($sql);
	if($result->num_rows==0){
		die("connect but no data");
	}
	
	while($row = $result->fetch_assoc()){
		$fullname = $row['fullname_user'];
		$birth_year = $row['birth_year'];
		$id_position = $row['id_position'];
		$number_department = $row['number_department'];
		$id_employee = $row['id_employee'];
		$avatar = $row['avatar'] ?? '/user-default.png';

		$_SESSION['fullname'] = $fullname;
		$_SESSION['id_employee'] = $id_employee;
		$sql1 = "SELECT * FROM Tbl_Department where number_department = '$number_department'";
		$resultt = $conn->query($sql1);
		while($row1 = $resultt->fetch_assoc()){
			$name_department = $row1['name_department'];
		}
		
	}

	$id_employee = $_SESSION['id_employee'];
	if($id_position== 2){
		$type_employee = "Trưởng phòng";
        $sum_day_off = 15;
	}elseif($id_position==3){
		$type_employee = "Nhân viên";
        $sum_day_off = 12;
	}
	$now = date('Y-m-d');

    if(isset($_POST['submit']))
    {
        $filename = $_FILES["file_nghiphep"]["name"];
		$tempname = $_FILES["file_nghiphep"]["tmp_name"];    
		$folder = "uploads/".$filename;
		$imgFileType = pathinfo($folder, PATHINFO_EXTENSION);
		$valid_extensions = array("docx","doc","pdf","docx","jpg", "jpeg", "png");
		if($filename){
			// $error = ""
			if($_FILES["file_nghiphep"]["size"]>42000000){
				$error = "Kích thước file quá lớn";
			}
			elseif(in_array(strtolower($imgFileType), $valid_extensions)) {
				move_uploaded_file($_FILES["file_nghiphep"]["tmp_name"], $folder);
			}else{
				$error = "Nộp sai dữ liệu";
			}
		}
	
		$reason = $_POST['reason'];
		$start_day = $_POST['start_day'];
		$end_day = $_POST['end_day'];
		$refined_date_start = intval(implode("", explode("-", $start_day)));
		$refined_date_end = intval(implode("", explode("-", $end_day)));
		$refined_date_now = intval(implode("", explode("-", $now)));
		$range = $refined_date_end - $refined_date_start;
		$range_now = $refined_date_start - $refined_date_now;
		if(empty($reason)){
			$error = "Cần phải nhập lý do";
		}
		elseif($range <= 0){
			$error = "Ngày bắt đầu phải bé hơn ngày kết thúc";
		}elseif( $range_now <=0){
			$error = "Bạn phải điền vào đơn trước ít nhất 1 ngày";
		}
		if(empty($start_day)){
			$error = "Cần phải nhập ngày bắt đầu";
		}elseif(empty($end_day)){
			$error = "Cần phải nhập ngày kết thúc";
		}
		$sql4 = "SELECT * FROM `tbl_day_offs` where id_employee = '$id_employee'";
		$result4 = $conn->query($sql4);
		while($row2 = $result4->fetch_assoc()){
			$numbers_day_left = $row2['numbers_day_left'];
			$now_time = $row2['now'];
			$refined_date_now_time = intval(implode("", explode("-", $now_time)));
		}
		$numbers_dayleft = $numbers_day_left - $range;
		if($numbers_dayleft<0){
			$error = "Số ngày bạn chọn đã quá so với ngày nghỉ còn lại của bạn, mời bạn chọn lại";
		}
		if($refined_date_now-$refined_date_now_time>=7){
			if($error==''){
				$sql3 = "UPDATE `tbl_day_offs` SET `start` = '$start_day',`end` = '$end_day',`now`= '$now',`number_day_off` = '$range',`reason`='$reason',`file_attach`='$filename',`id_status_day_off`=1 WHERE id_employee = '$id_employee'";
				$result3 = $conn->query($sql3);
				$success = "Tạo đơn thành công";
			}
		}else{
			$error = "Chưa đủ thời gian tạo form mới!";
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
	<title>NGHỈ PHÉP</title>
</head>
<body>
	<?php 
		if($id_position==3){
			require_once("nhan-vien/nv-header.php");
		}elseif($id_position==2){
			require_once("truong-phong/tp-header.php");
		}
	 ?>
	<div class=”container”>
		<div class="row">
			<div class="my-form col-sm-6">
			<form id="nghiPhep-form" method="post" action="" enctype="multipart/form-data">
				<p>Lý do:</p>
						<textarea name="reason" value="" id="reason"  class="input"></textarea>
				<p>File đính kèm:</p>
				<input type="file" name="file_nghiphep" id="file_nghiphep" class="inputfile">
				<label for="file_nghiphep" class="input input-file"><span>Chọn file</span></label>
				
					<p>Ngày bắt đầu nghỉ phép:</p>
						<input type="date" name="start_day" id="start_day">
					<p>Ngày kết thúc nghỉ phép:</p>
					<input type="date" name="end_day" id="end_day">
				<p class="err" id="nghiPhep-err">
					<?php
						if (!empty($error)) {
							echo "<div class='alert alert-danger'>$error</div>";
						}if (!empty($success)) {
							echo "<div class='alert alert-success'>$success</div>";
						}
					?>	
					</p>
					<button name="submit" type="submit">TẠO</button>
				</form>
			</div>
			<div class="col-sm-6">
				<div>
					<h2 style="margin-top: 10px;">Chi tiết nghỉ phép</h2>
					<?php 
						$select1 = "SELECT * FROM `tbl_day_offs` WHERE id_employee = '$id_employee'";
						$resulttt = $conn->query($select1);
						while($row4 = $resulttt->fetch_assoc()){
							$sum_day_off = $row4['sum_day_off'];
							$numbers_dayleft = $row4['numbers_day_left'];
							$num_used = $sum_day_off - $numbers_dayleft;
							
						}
						echo '<p style = "margin-right: 12px">
							Tổng số ngày nghỉ phép: '.$sum_day_off.'
							</p>
							<p style = "margin-right: 12px">
							Số ngày đã nghỉ : '.$num_used.'
							</p>
							<p style = "margin-right: 12px">
							Số ngày nghỉ phép còn lại: '.$numbers_dayleft.'
							</p>';
					?>
					<hr>
					<h2 style="margin-top: 10px;">Lịch sử nghỉ phép</h2>
					<?php 
						$select_history = "SELECT * FROM `day_off_history` WHERE id_employee = '$id_employee'";
						$result3 = $conn->query($select_history);
						while($row3 = $result3->fetch_assoc()){
							$history = $row3['history'];
							$file = $row3['file_attach'];
							echo '<p style = "margin-right: 12px">
							Lịch sử: '.$history.'
							</p>';
							echo '<p>File đính kèm <a href="../uploads/'.$file.' " target="_blank">'.$file.'</a></p>';
						}
					?>
				</div>
			</div>
		</div>
	</div>
  <footer class="bg-dark text-center text-white">
    <?php require_once("site/footer.php") ?>
	</footer>
	<script src="/main.js"></script>
</body>
</html>