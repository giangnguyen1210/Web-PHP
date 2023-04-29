<?php require_once("gd-username.php") ?>
<?php require_once("gd-position.php") ?>
<?php
    if(!isset($_SESSION)) { 
		session_start(); 
	} 
	$error = '';
	$success = '';
	require_once("../admin/db.php");
	$number_department = $_GET['number_department'];
	$sql = "SELECT * FROM Tbl_Department,Tbl_User where Tbl_Department.number_department = Tbl_User.number_department and Tbl_Department.number_department = '$number_department'";
	$result = $conn->query($sql);	
	
	$sql1 = "SELECT * FROM Tbl_Department,Tbl_User where Tbl_Department.number_department = Tbl_User.number_department and Tbl_Department.number_department = '$number_department'";
	$result1 = $conn->query($sql1);	
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
	<title>CHI TIẾT PHÒNG BAN</title>
</head>
<body class="profile">
  <header>
    <?php require_once("../site/navbar.php") ?>
  </header>
	<div>
		<!-- <img id="profile-avatar" class="rounded-circle" src="/uploads/user-default.png" alt="avatar"> -->
		<div class="profile__info col-12 col-sm-8 info">
			<?php 
			while($row=$result->fetch_assoc())	{
				$fullname_employee = $row['fullname_user'];
				$name_department = $row['name_department'];
				$discription = $row['discription_department'];
				$id_position = $row['id_position'];
				$select = "SELECT * FROM Tbl_User where number_department = '$number_department and id_position = $id_position";
				if($id_position==2){
					$id_manager = $row['id_employee'];
					$name_manager = $row['fullname_user'];
				}elseif($id_position==3){
					$id_employee= $row['id_employee'];
					$name_employee = $row['fullname_user'];
				
				}
			}
			?>
				</br><h2>Thông tin</h2></br>
					<p>
						<strong>Tên phòng ban: </strong>
						<span id="profile-hoTen"><?=$name_department?><span>
					</p>
					<p>
						<strong>Phòng ban số: </strong>
						<span id="profile-namSinh"><?=$number_department?><span>
					</p>
					<p>
						<strong>Mô tả: </strong>	
						<span id="profile-chucVu"><?=$discription?></span>
					</p>
					<p>
						<strong>Trưởng phòng: </strong>
						<span><?=$name_manager?> <strong>Mã nhân viên:</strong><?=$id_manager?></span>
					</p>
					
					<strong>Nhân viên: </strong>

				<?php 
				while($row1=$result1->fetch_assoc())	{
					$id_position = $row1['id_position'];
					$select = "SELECT * FROM Tbl_User where number_department = '$number_department and id_position = $id_position";
					if($id_position==3){
						$id_employee= $row1['id_employee'];
						$name_employee = $row1['fullname_user'];
						echo '<p>
						<span><strong>Họ và tên: </strong>'.$name_employee.'<strong>_Mã nhân viên: </strong>'.$id_employee.'</span>
						</p>';
					}
				}
			?>		
			
					
					
					
		</div>
	</div>
	<footer class="bg-dark text-center text-white">
    <?php require_once("../site/footer.php") ?>
	</footer>
	<script src="/main.js"></script>
</body>
</html>