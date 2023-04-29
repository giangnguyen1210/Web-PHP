<?php 
	require_once("username.php");
  if(!isset($_SESSION)) { 
    session_start();
  } 
	if ($_SESSION['newPass'] == 1) {
		header('location: new-password.php');
	  exit();
	}
  if ($_SESSION["id_position"] != 1) {
    header('location: ../index.php');
    exit();
  }
?>
<?php
	ob_start();
	require_once("admin/db.php");
	$account = '';
    $id_employee = '';
    $name = '';
    $date = '';
    $gender = '';
	$phone_number = '';
	$email = '';
	$salary = '';
	$department = '';
	$success = '';
	$avatar = '';
    if(isset($_POST['submit']))
    {
		$account = $_POST['newUser-username'];
		$id_employee = $_POST['newUser-id'];
		$name = $_POST['newUser-name'];
		$date = $_POST['newUser-birthYear'];
		$gender = $_POST['gender'];
		$phone_number = $_POST['newUser-phone'];
		$email = $_POST['newUser-email'];
		$salary = $_POST['newUser-salary'];
		$department = $_POST['newUser-phongBan'];
		$id_position = 3;
		$sqll = "SELECT * FROM Tbl_User where login_name = '$account' or id_employee='$id_employee'";
		$resultt = $conn->query($sqll);
		if ($resultt->num_rows > 0) {
		   $error = 'Tên tài khoản hoặc mã nhân viên đã tồn tại';	
		}elseif (empty($account)) {
            $error = 'Chưa nhập tên tài khoản nhân viên';
		}else if(empty($id_employee)){
            $error = 'Chưa nhập id nhân viên';
		}elseif(empty($name)){
            $error = 'Chưa nhập tên nhân viên';
		}elseif(empty($date)){
            $error = 'Chưa nhập năm sinh nhân viên';
		}elseif(empty($phone_number)){
            $error = 'Chưa nhập số điện thoại nhân viên';
		}elseif(!is_numeric($phone_number)){
            $error = 'Nhập số điện thoại nhân viên không đúng kiểu';
		}
		elseif(empty($email)){
            $error = 'Chưa nhập email nhân viên';
		}elseif(empty($gender)){
            $error = 'Chọn giới tính nhân viên';
		}elseif(empty($salary)){
            $error = 'Chưa nhập lương nhân viên';
		}elseif($salary<10){
            $error = 'Lương nhân viên phải lớn hơn 100000';
		}elseif(empty($department)){
            $error = 'Chưa nhập phòng ban nhân viên';
		}
		else {
			$sql = "INSERT INTO `Tbl_User`(`login_name`, `user_password`, `fullname_user`,`id_employee`,`gender_user`, `birth_year`, `phone_number`,`id_position`, `email`, `salary`, `number_department`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
			$stm = $conn->prepare($sql);
			$passw_hash = password_hash($account,PASSWORD_BCRYPT);
            $stm->bind_param("sssssisisii",$account,$passw_hash,$name,$id_employee,$gender,$date,$phone_number,$id_position,$email,$salary,$department);
			
			$sql3 = "INSERT INTO `tbl_day_offs`(`id_employee`, `sum_day_off`, `numbers_day_left`,`id_position`) VALUES ('$id_employee',12,12,3)";
            $result3 = $conn->query($sql3);
            // if ($result3 === TRUE) {
			// 	echo "oke";
			// } else {
			// 	echo "Error: " . $sqll . "<br>" . $conn->error;
			// }

			if($stm->execute()){
				// echo '<script language="javascript">alert("Thêm nhân viên thành công!");</script>';

				$success = "Thêm nhân viên thành công";
				header("refresh:1;url=giam-doc/nhan-vien.php");
				exit();
			}
			else{
				die("cant execute ".$stm->error);
			}
			$sql3 = "INSERT INTO `tbl_day_offs`(`id_employee`, `sum_day_off`, `numbers_day_left`) VALUES ('$id_employee','$sum_day_off','$sum_day_off')";
            $result3 = $conn->query($sql3);
            if ($result3 === TRUE) {
				// echo '<script language="javascript">alert("Thêm nhiệm vụ thành công!");</script>';
			} else {
				echo "Error: " . $sqll . "<br>" . $conn->error;
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
	<title>Tạo tài khoản</title>
</head>
<body class="new-user">
  <header>
    <?php require_once("site/navbar.php") ?>
  </header>
	<div class="my-form">
		<form id="newUser-form" method="post" action="">
			<p>Tài khoản: </p>
			<input value = "<?= $account?>" type="text" name="newUser-username" id="newUser-username">
			<p>ID nhân viên: </p>
			<input  value = "<?= $id_employee?>" type="text" name="newUser-id" id="newUser-id">
      		<p>Họ và tên:</p>
			<input  value = "<?= $name?>"  type="text" name="newUser-name" id="newUser-name">
      		<p>Năm sinh:</p>
			<input  value = "<?= $date?>" type="number" name="newUser-birthYear" id="newUser-date">
			<p>Giới tính:</p>	
			<div class="radio d-flex">	
				<div class="radio-item d-flex">
					<input value="Nam"  type="radio" name="gender" value="male" id="male" class="mr-2" checked>
					<label for="male">Nam</label>
				</div>
				<div class="radio-item d-flex">
					<input value = "Nữ" type="radio" name="gender" value="female" id="female" class = "mr-2">
					<label for="female">Nữ</label>
				</div>	
			</div>
			<p>Số điện thoại:</p>
				<input  value = "<?= $phone_number?>" type="text" name="newUser-phone" id="newUser-phone">
			<p>email:</p>
				<input  value = "<?= $email?>" type="email" name="newUser-email" id="newUser-email">
			<p>Mức lương:</p>
				<input  value = "<?= $salary?>" type="number" name="newUser-salary" id="newUser-salary">
			<p>Phòng ban: </p>
			
				 <?php
					$sql1 = "SELECT  * FROM `Tbl_Department`";
					$result = $conn->query($sql1);
					$number = $result->num_rows;
		
					if($result->num_rows==0){
						echo "hi";
						die("connect but no data");
					}
				 	$num_depart = '';
					 echo '<select name="newUser-phongBan" class="input" id="newUser-receiver">';
					while ($row = mysqli_fetch_assoc($result)) {
						$num_depart = $row['number_department'];
						$name_depart =$row['name_department'];
						echo'<option value="'.$num_depart.','.$name_depart.'">'.$num_depart.'_'.$name_depart.'</option>';
								
						
					}
				   echo'</select>';
					
					
					
				?>
			<p class="err" id="newUser-err">
				<?php
					if (!empty($error)) {
						echo "<div class='alert alert-danger'>$error</div>";
					}
					if (!empty($success)) {
						echo "<div class='alert alert-success'>$success</div>";
					}
				?>	
			</p>
		
			<button name="submit" type="submit">Tạo</button>
		</form>
	</div>
	<footer class="bg-dark text-center text-white">
    <?php require_once("nhan-vien/nv-footer.php") ?>
	</footer>
	<script src="/main.js"></script>
</body>
</html>