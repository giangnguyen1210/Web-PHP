<?php 
    require_once("username.php");
	if ($_SESSION['newPass'] == 1) {
		header('location: new-password.php');
	  exit();
	}

    $error = '';
    $success = '';
    $currentPass = '';
    $newPassword = '';
    $confirmPass = '';
    if(isset($_POST['currentPassword']) && isset($_POST['newPassword']) && isset($_POST['confirmPassword']))
    {
        $currentPass =$_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPass = $_POST['confirmPassword'];

        if (empty($currentPass)) {
            $error = 'Hãy nhập mật khẩu';
        }
        else if(strlen($currentPass)<6){
            $error = 'Mật khẩu phải nhiều hơn 6 ký tự';
        }
        else if (empty($newPassword)) {
            $error = 'Hãy nhập mật khẩu mới';
        }
        else if(strlen($newPassword)<6){
            $error = 'Mật khẩu mới phải nhiều hơn 6 ký tự';
        }
        elseif($newPassword == $currentPass){
            $error = 'Trùng mật khẩu cũ';
        }
        else if (empty($confirmPass)) {
            $error = 'Hãy nhập lại mật khẩu xác nhận';
        }else if($confirmPass != $newPassword){
            $error = 'Nhập mật khẩu xác nhận không trùng khớp';
        }
        else{
            require_once("admin/db.php");
            $full_name = $_SESSION['fullname'];
            if(isset($_SESSION['fullname'])){
                $sql = "SELECT * FROM `Tbl_User` where fullname_user = ?";
                $stm = $conn->prepare($sql);
                $stm->bind_param("s",$full_name);
                if(!$stm->execute()){
                    die("canot execute");
                }
                $result = $stm->get_result();
                while($row = $result->fetch_assoc()){
                    $default_pass = $row['login_name'];
                    $old_pass = $row['user_password'];//đây nè
                    $sql1 = "UPDATE `Tbl_User` SET user_password = ? where fullname_user = ?";
                    $stm1 = $conn->prepare($sql1);
                    $password_hash = password_hash($newPassword,PASSWORD_BCRYPT);
                    $stm1->bind_param("ss",$password_hash,$full_name);
                    // echo $default_pass;
                    if($newPassword==$default_pass){
                        $error = "Bạn đang nhập lại mật khẩu mặc định";
                    }
                    else if (password_verify($currentPass, $old_pass)/* && $error=''*/) {
                        if(!$stm1->execute()){
                            die("canot execute");
                        }
                        else{
                            header("refresh:1;url=profile.php");
                            exit();
                        }
                    }
                    else{
                        $error = "Mật khẩu sai";
                    }
                }
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
	<title>ĐỔi MẬT KHẨU</title>
</head>
<body class="new-password">
    <?php
        if ($_SESSION['id_position'] == 1) {
            echo "<header>";
            require_once("site/navbar.php");
            echo "</header>";
        } 
        else if ($_SESSION['id_position'] == 2) {
            require_once("truong-phong/tp-header.php");
        }
        else {
            require_once("nhan-vien/nv-header.php");
        }
    ?>
	<div class="my-form">
        <form id="changePassword-form" method="post" action="">
            <p>Mật khẩu cũ</p>
                <input value = "<?= $currentPass?>" type="password" name="currentPassword" id="changePassword-oldPassword">
            <p>Mật khẩu mới:</p>
                <input value = "<?= $newPassword?>" type="password" name="newPassword" id="changePassword-password">
            <p>Nhập lại mật khẩu mới:</p>
                <input value = "<?= $confirmPass?>" type="password" name="confirmPassword" id="changePassword-rePassword">
                <p class="err" id="changePassword-err"></p>
              	<?php
                  if (!empty($error)) {
                      echo "<div class='alert alert-danger'>$error</div>";
                  }
                  if (!empty($success)) {
                      echo "<div class='alert alert-success'>$success</div>";
                  }
              ?>	
                    <button type="submit">ĐỔI MẬT KHẨU</button>
		</form>
	</div>
    <?php require_once("nhan-vien/nv-footer.php") ?>
	<script src="/main.js"></script>
</body>
</html>