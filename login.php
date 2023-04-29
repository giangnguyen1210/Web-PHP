<?php
	if(!isset($_SESSION)) { 
		session_start();
	} 
	if (isset($_SESSION['login_name'])) {
		header('location: ../index.php');
		exit();
	}
?>
<?php
	if(!isset($_SESSION)) { 
		session_start();
	} 
	$error = '';
	$success = '';
    $username = '';
    $password = '';
	$fullname = '';

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
		require_once("admin/db.php");

		if(empty($username)){
			$error = 'Chưa nhập tài khoản';
		}elseif(empty($password)){
			$error = 'Chưa nhập mật khẩu';
		}
		$sql = "SELECT * FROM `Tbl_User` where login_name = ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param("s",$username);
		if(!$stm->execute()){
			die("cant execute ".$stm->error);
		}
		$result = $stm->get_result();
		if($result->num_rows == 0){
			$error = 'Tên tài khoản không tồn tại';	
		}
		while($row = $result->fetch_assoc()){
			$name = $row['login_name'];
			$id_position = $row['id_position'];
			$id_department = $row['number_department'];
			$id_employee = $row['id_employee'];
			if ($password==$name && password_verify($password,$row['user_password'])) {
				$_SESSION['newPass'] = 1;
				$_SESSION['login_name'] = $username;
				$_SESSION['id_employee'] = $id_employee;
				$_SESSION['id_position'] = $id_position;
				$_SESSION['id_department'] = $id_department;
				header("Location: new-password.php");
				exit();
			}elseif(password_verify($password,$row['user_password'])){
				$_SESSION['newPass'] = 0;
				$_SESSION['login_name'] = $username;
				$_SESSION['id_employee'] = $id_employee;
				$_SESSION['id_position'] = $id_position;
				$_SESSION['id_department'] = $id_department;
				header("Location: index.php");
				exit();
			}
			else{
				$error= "Sai mật khẩu";
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
	<title>ĐĂNG NHẬP</title>
</head>
<body class="login">
  <img src="/images/logo.png" alt="logo" class="my-logo">
	<div class="my-form">
	<form id="login-form" action="" method = "post">
      <p>Tài khoản:</p>
			<input type="text" value = "<?=$username?>" name="username" id="login-username">
      <p>Mật khẩu:</p>
			<input type="password"  value = "<?=$password?>" name="password" id="login-password">
      <p class="err fade" id="login-err">$error</p>
	 		 <?php
			   if (!empty($error)) {
				echo "<div class='alert alert-danger'>$error</div>";
			}
				if (!empty($success)) {
					echo "<div class='alert alert-success'>$success</div>";
				}
              ?>	
			<button type="submit">ĐĂNG NHẬP</button>
		</form>
	</div>
	<script src="/main.js"></script>
</body>
</html>