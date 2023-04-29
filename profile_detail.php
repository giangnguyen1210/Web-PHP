<?php 
	require_once("username.php");
	if ($_SESSION['newPass'] == 1) {
		header('location: new-password.php');
	  exit();
	}

	$error = '';
	$success = '';
	require_once("admin/db.php");
	$birth_year = 0;
	$fullname ='';
	$id_position = '';
	$name_department = '';
	$id_employee = '';
	$gender = '';
	$phone_number ='';
	$email = '';
	$salary = '';
	$avatar ='';
	$type_employee = '';
	if(isset($_GET['id'])){
		$id_employee=$_GET['id'];

		$sql = "SELECT *from `Tbl_User` where `id_employee` = '$id_employee'";
		$result = $conn->query($sql);
		if($row = $result->fetch_assoc()){
			$birth_year = $row['birth_year'];
			$fullname = $row['fullname_user'];
			$id_position = $row['id_position'];
			$number_department = $row['number_department'];
			$id_employee = $row['id_employee'];
			$gender = $row['gender_user'];
			$phone_number = $row['phone_number'];
			$email = $row['email'];
			$salary = $row['salary'];
			$avatar = $row['avatar'] ?? '/user-default.png';
			$sql1 = "SELECT * FROM Tbl_Department where number_department = '$number_department'";
			$resultt = $conn->query($sql1);
			while($row = $resultt->fetch_assoc()){
				$name_department = $row['name_department'];
      		}
		}else{
			header("Location: giam-doc/nhan-vien.php");
			exit();
		}
		if($id_position == 1){
			$type_employee = "Giám đốc";
		}elseif($id_position== 2){
			$type_employee = "Trưởng phòng";
		}elseif($id_position==3){
			$type_employee = "Nhân viên";
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
	<title>PROFILE</title>
</head>
<body class="profile">
  <header>
    <?php require_once("site/navbar.php") ?>
  </header>
	<div class="container-full">
		<div class="row">
			<div class="col-4 d-flex justify-content-center align-items-center">
				<img class="avatar rounded-circle"
					data-src="/uploads/<?= $avatar?>" style="height:295px; width:295px" src="/uploads/user-default.png" alt="avatar" />
			</div>
			<div class="col-4 info">
		   <h2>Thông tin</h2></br>
		   <?php
				if($id_position == 1){
					echo '
					<p>
					<strong>Họ và tên: </strong>
					<span id="profile-hoTen">'.$fullname.'<span>
				</p>
				<p>
					<strong>Mã nhân viên: </strong>
					<span id="profile-phongBan">'.$id_employee.'</span>
				</p>
				<p>
					<strong>Năm sinh: </strong>
					<span id="profile-namSinh">'.$birth_year.'<span>
				</p>
				
				<p>
					<strong>Giới tính: </strong>
					<span id="profile-hoTen">'.$gender.'<span>
				</p>
				<p>
					<strong>Chức vụ: </strong>
					<span id="profile-chucVu">'.$type_employee.'</span>
				</p>
				<p>
					<strong>Số điện thoại: </strong>
					<span id="profile-namSinh">'.$phone_number.'<span>
				</p>
				<p>
					<strong>email: </strong>
					<span id="profile-chucVu">'.$email.'</span>
				</p>
				<p>
					<strong>Lương: </strong>
					<span id="profile-phongBan">'.$salary.'</span>
				</p>
					';
				}else{
					echo '
					<p>
					<strong>Họ và tên: </strong>
					<span id="profile-hoTen">'.$fullname.'<span>
				</p>
				<p>
					<strong>Mã nhân viên: </strong>
					<span id="profile-phongBan">'.$id_employee.'</span>
				</p>
				<p>
					<strong>Năm sinh: </strong>
					<span id="profile-namSinh">'.$birth_year.'<span>
				</p>
				
				<p>
					<strong>Giới tính: </strong>
					<span id="profile-hoTen">'.$gender.'<span>
				</p>
				<p>
					<strong>Chức vụ: </strong>
					<span id="profile-chucVu">'.$type_employee.'</span>
				</p>
				<p>
					<strong>Phòng ban: </strong>
					<span id="profile-chucVu">'.$name_department.'</span>
				</p>
				<p>
					<strong>Số điện thoại: </strong>
					<span id="profile-namSinh">'.$phone_number.'<span>
				</p>
				<p>
					<strong>email: </strong>
					<span id="profile-chucVu">'.$email.'</span>
				</p>
				<p>
					<strong>Lương: </strong>
					<span id="profile-phongBan">'.$salary.'</span>
				</p>
					';
				}
		   ?>
		
           
			<!-- <div class="mg-a">
				<button id="profile-password-change" style="width: 200px" name="change_password" class="profile__btn"><a href="reset_password.php">RESET MẬT KHẨU</a></button>
			</div> -->
		</div> 
		</div>
		
	</div>
	<footer class="bg-dark text-center text-white">
    <?php require_once("site/footer.php") ?>
	</footer>
	<script src="/main.js"></script>
</body>
</html>