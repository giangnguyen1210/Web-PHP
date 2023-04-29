<?php
  if(!isset($_SESSION)) { 
    session_start(); 
  } 
  require_once("../admin/db.php");
  $sql = "SELECT * FROM Tbl_User";
  $result = $conn->query($sql);
  $fullname = '';

  while($data = $result->fetch_assoc()){
      $fullname = $data['fullname_user'];
      $id_employee = $data['id_employee'];
      $birth_year = $data['birth_year'];
      $gender = $data['gender_user'];
      $phone_number = $data['phone_number'];
      $email = $data['email'];
      $salary = $data['salary'];
      $type_employee = $data['id_position'];
      $avatar = $data['avatar'] ?? '/user-default.png';
      $number_department = $data['number_department'];
      $sql1 = "SELECT * FROM Tbl_Department where number_department = '$number_department'";
      $resultt = $conn->query($sql1);
      while($row = $resultt->fetch_assoc()){
        $name_department = $row['name_department'];
      }
      $_SESSION['fullname_user'] = $data['fullname_user'];
      if(isset($_POST['detail'])){
        header("Location: profile_detail.php");
        exit();
      }

    ?>
     <?php echo '<div class="the" onclick="theSwitch(this)">
      <div class="the__front">
        <img class="avatar" 
		   	data-src="/uploads/'.$avatar.'" src="/uploads/user-default.png" alt="Card image cap" />
        <p>'.$fullname.'</p>
      </div>
      <div class="the__back none">
        <p onclick="window.location=\'/profile_detail.php?id='.$id_employee.'\'">Chi tiết</a></p>
        <p data-toggle="modal" data-target="#rsPass" data-whatever="'.$fullname.'" data-id="'.$data['login_name'].'">Đặt lại mật khẩu</p>
      </div>
    </div>';
  }

?>
           