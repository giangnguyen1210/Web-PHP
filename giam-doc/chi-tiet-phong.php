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
	$_SESSION['number_department'] = $number_department;
	$sql = "SELECT * FROM Tbl_Department,Tbl_User where Tbl_Department.number_department = Tbl_User.number_department and Tbl_Department.number_department = '$number_department' and Tbl_User.id_position = 2";
	$result = $conn->query($sql);	
	
	$sql1 = "SELECT * FROM Tbl_Department,Tbl_User where Tbl_Department.number_department = Tbl_User.number_department and Tbl_Department.number_department = '$number_department' and Tbl_User.id_position = 3";
	$result1 = $conn->query($sql1);	

	$sql2 = "SELECT * FROM Tbl_Department where Tbl_Department.number_department = '$number_department'";
	$result2 = $conn->query($sql2);
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
	<title>CHI TIẾT PHÒNG BAN</title>
</head>
<body>
  <header>
    <?php require_once("../site/navbar.php") ?>
  </header>
	<table class="table table-striped">
		<thead>
			<tr>
				<td><strong>Chức vụ</strong></td>
				<td><strong>Họ tên</strong> </td>
				<td><strong>Mã nhân viên</strong></td>
				<td width="200px"><strong>CHI TIẾT</strong></td>
				<td width="200px"><strong>BỔ NHIỆM TP</strong></td>
			</tr>
		</thead>
		<?php 
			if($row=$result2->fetch_assoc())	{
				$name_department = $row['name_department'];
				$discription = $row['discription_department'];
			}else{
				header("Location: phong-ban.php");
				exit();
			}
		
			?>
		<tbody>
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
			<?php
				while($row=$result->fetch_assoc())	{
					$fullname_employee = $row['fullname_user'];
					$name_department = $row['name_department'];
					$discription = $row['discription_department'];
					$id_position = $row['id_position'];
					$id_manager = $row['id_employee'];
					$name_position = "Trưởng phòng";
					$name_manager = $row['fullname_user'];
					echo '<tr>
					<td>'.$name_position.'</td>
					<td>'.$name_manager.'</td>
					<td>'.$id_manager.'</td>
					<td>
						<button class="btn-detail"><a href = "../profile_detail.php?id='.$id_manager.'">CHI TIẾT</a></button>
					</td>
					<td>
					<button	 class="btn-detail" data-toggle="modal" data-target="#baiNhiem" data-whatever="'.$name_manager.'" data-id="'.$id_manager.'">BÃI NHIỆM</button>
					</td>
					</tr>';
					break;
				
				
							
				// }
				// else{
				// header("Location: phong-ban.php");
				// exit();
					if(isset($_POST['yes_bainhiem'])){
						$update = "UPDATE `tbl_user` SET `id_position`=2 where id_employee ='$id_manager'";
					}
				}
				while($row1=$result1->fetch_assoc())	{
					$id_position = $row1['id_position'];
					$id_employee= $row1['id_employee'];
					$name_employee = $row1['fullname_user'];
					$name_position = "Nhân viên";
					echo '<tr>
					<td>'.$name_position.'</td>
					<td>'.$name_employee.'</td>
					<td>'.$id_employee.'</td>
					<td>
						<button class="btn-detail"><a href = "../profile_detail.php?id='.$id_employee.'">CHI TIẾT</a></button>
					</td>
					<td>
						<button class="btn-detail" data-toggle="modal" data-target="#boNhiem" data-whatever="'.$name_employee.'" data-id="'.$id_employee.'">BỔ NHIỆM</button>
					</td>
					</tr>';
				}
			?>
		</tbody>
	</table>	

	<div class="modal fade" id="baiNhiem" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Bãi nhiệm </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" onclick="bainhiem()" class="btn btn-primary">Yes</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="boNhiem" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Bổ nhiệm</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" onclick="bonhiem()" class="btn btn-primary"  >Yes</button>
				</div>
			</div>
		</div>
	</div>

	<footer class="bg-dark text-center text-white">
    <?php require_once("../site/footer.php") ?>
	</footer>
	<script src="/main.js"></script>
</body>
</html>