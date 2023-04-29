<?php require_once("username.php") ?>
<?php
    if(!isset($_SESSION)) { 
		session_start();
	}
    
    $error = '';
    $success = '';
    $newPassword = '';
    $confirmPass = '';
    if(isset($_POST['newPassword-password']) && isset($_POST['newPassword-rePassword']))
    {
        $newPassword = $_POST['newPassword-password'];
        $confirmPass = $_POST['newPassword-rePassword'];
       
        require_once("admin/db.php");
        $login_name = $_SESSION['login_name'];
        $sql = "SELECT * FROM `Tbl_User` where login_name = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param("s",$login_name);
        if(!$stm->execute()){
            die("cant execute ".$stm->error);
        }
        $result = $stm->get_result();

        
        while($row = $result->fetch_assoc()){
            $sql1 = "UPDATE `Tbl_User` SET user_password = ? where login_name = ?";
            $stm1 = $conn->prepare($sql1);
            $old_pass = $row['user_password'];
          
            $password_hash = password_hash($newPassword,PASSWORD_BCRYPT);
            $stm1->bind_param("ss",$password_hash,$login_name);
            if($newPassword != $confirmPass){
                echo "<script>alert('Nhập lại khẩu không trùng khớp')</script>";
            }elseif(password_verify($newPassword,$old_pass)){
                $error = "Bạn đang nhập lại mật khẩu mặc định";
            }
            else{
                if($stm1->execute()){
                    $success = "Change password success";
                    $_SESSION['fullname_user'] = $row['fullname_user'];
                    $_SESSION['birth_year'] = $row['birth_year'];
                    $_SESSION['id_position'] = $row['id_position'];
                    $_SESSION['number_department'] = $row['number_department'];
                    $_SESSION['newPass'] = 0;
                    if($row['id_position']==1){
                        header("refresh:1;url=giam-doc/nhan-vien.php");
                        exit();
                    }elseif($row['id_position']==2){
                        header("refresh:1;url=truong-phong/tp-task.php");
                        exit();
                    }else{
                        header("refresh:1;url=nhan-vien/nv-task.php");
                        exit();
                    }
                   
                }
                else{
                    die("cant execute ".$stm1->error);
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
	<link rel="stylesheet" href="style.css">
	<title>MẬT KHẨU MỚI</title>
</head>
<body>
  <!-- <img src="/images/logo.png" alt="logo" class="my-logo"> -->
  <img src="/images/logo.png" alt="logo" class="my-logo">
	<div class="my-form">
        <form id="newPassword-form" method="post" action="">
            <p>Mật khẩu mới:</p>
                <input value="<?= $newPassword?>" type="password" name="newPassword-password" id="newPassword-password">
            <p>Nhập lại mật khẩu mới:</p>
                <input value= "<?= $confirmPass?>" type="password" name="newPassword-rePassword" id="newPassword-rePassword">
            <p class="err" id="newPassword-err">
                <?php
                    if (!empty($error)) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                    if (!empty($success)) {
                        echo "<div class='alert alert-success'>$success</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Đổi mật khẩu trước khi sử dụng tài khoản</div>";
                    }
                ?>	
            </p>
                <button type="submit">ĐỔI MẬT KHẨU</button>
                <div class="new-password__dang-xuat">
                <button style="margin-top:3px;"> <a href="/logout.php">ĐĂNG XUẤT</a></button>
                </div>
        </form>
        
    </div>
	<script src="/main.js"></script>
</body>
</html>