<?php 
	require_once("username.php");
	if ($_SESSION['newPass'] == 1) {
		header('location: new-password.php');
	  exit();
	}

	$error = '';
	$success = '';
	require_once("admin/db.php");
	$login_name = $_SESSION['login_name'];
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
	if($id_position == 1){
		$type_employee = "Giám đốc";
	}elseif($id_position== 2){
		$type_employee = "Trưởng phòng";
	}elseif($id_position==3){
		$type_employee = "Nhân viên";
	}
	
	if(isset($_POST['submit'])){
		$filename = $_FILES["avatar"]["name"];
		$tempname = $_FILES["avatar"]["tmp_name"];    
		$folder = "uploads/".$filename;
		$imgFileType = pathinfo($folder, PATHINFO_EXTENSION);
		$valid_extensions = array("jpg", "jpeg", "png");

		if (in_array(strtolower($imgFileType), $valid_extensions)) {
			move_uploaded_file($tempname, $folder);
		}

		$sqlo = "UPDATE `Tbl_User` SET `avatar`='$filename' where id_employee = '$id_employee'" ;
		if (mysqli_query($conn, $sqlo)) {
			header("Location: profile.php");
			exit();
		} 
		else {
			echo '<script language="javascript">alert("Thay ảnh lỗi!");</script>';
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
	<link rel="stylesheet" href="style.css">
	<title>PROFILE</title>
</head>
<body class="profile">
  <header>
    <?php 
		if($id_position==3){
			require_once("nhan-vien/nv-header.php");
		}elseif($id_position==2){
			require_once("truong-phong/tp-header.php");
		}elseif($id_position==1){
			require_once("site/navbar.php");
		}
	 ?>
  </header>
	<div class="container-full">
		<div class="row  ">
		   <div class="col-sm-4 col-4 d-flex justify-content-center align-items-center">
			<img class="avatar rounded-circle"
				data-src="/uploads/<?= $avatar?>" style="height:295px; width:295px" src="/uploads/user-default.png" alt="Card image cap" />
			</div>
			<div class="profile__info col-8 col-sm-8 info">
				<?php 
					if($id_position==1){
						echo '</br><h2>Thông tin</h2></br>
						<p>
							<strong>Họ và tên: </strong>
							<span id="profile-hoTen">'.$fullname.'<span>
						</p>
						<p>
							<strong>Mã nhân viên: </strong>
							<span id="profile-hoTen">'.$id_employee.'<span>
						</p>
						<p>
							<strong>Năm sinh: </strong>
							<span id="profile-namSinh">'.$birth_year.'<span>
						</p>
						<p>
							<strong>Chức vụ: </strong>
							<span id="profile-chucVu">'.$type_employee.'</span>
						</p>
						<div class="mg-a">
						<button id="profile-password-change" name="change_password" class="profile__btn"><a href="change-password.php">ĐỔI MẬT KHẨU</a></button>
						<form action ="" method ="post" enctype="multipart/form-data">
							<input type="file" name="avatar" id="avatar" class="inputfile input-img">
							<label for="avatar" class="input input-file input-choose"><span>ĐỔI ẢNH</span></label>
							<input type="submit" value="XÁC NHẬN" name="submit" class="input input-img none" id="change-img">
						</form>
					</div>';
					}else{
						echo '</br><h2>Thông tin</h2></br>
						<p>
							<strong>Họ và tên: </strong>
							<span id="profile-hoTen">'.$fullname.'<span>
						</p>

						<p>
							<strong>Mã nhân viên: </strong>
							<span id="profile-hoTen">'.$id_employee.'<span>
						</p>
						<p>
							<strong>Năm sinh: </strong>
							<span id="profile-namSinh">'.$birth_year.'<span>
						</p>
						<p>
							<strong>Chức vụ: </strong>
							<span id="profile-chucVu">'.$type_employee.'</span>
						</p>
						<strong>Phòng ban: </strong>
						<span id="profile-phongBan">'.$name_department.'</span>
					</p>
					<div class="mg-a">
						<button id="profile-password-change" name="change_password" class="profile__btn"><a href="change-password.php">ĐỔI MẬT KHẨU</a></button>
						<form action ="" method ="post" enctype="multipart/form-data">
							<input type="file" name="avatar" id="avatar" class="inputfile input-img">
							<label for="avatar" class="input input-file input-choose"><span>ĐỔI ẢNH</span></label>
							<input type="submit" value="XÁC NHẬN" name="submit" class="input input-img none" id="change-img">
						</form>
					</div>';
					}

				?>
					
			</div>
			
		</div>
	</div>
	<footer class="bg-dark text-center text-white">
    <?php require_once("site/footer.php") ?>
	</footer>
	<script src="/main.js"></script>
</body>
</html>