<?php 
  require_once("username.php");
	if ($_SESSION['newPass'] == 1) {
		header('location: new-password.php');
	  exit();
	}

	$id_position = $_SESSION['id_position'];

  $number_department = $_SESSION['id_department'];
  require_once("admin/db.php");

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
	<title>DUYỆT NGHỈ PHÉP</title>
</head>
<body>
  <?php 
    if($id_position==1){
      require_once("site/navbar.php");
    }elseif($id_position==2){
      require_once("truong-phong/tp-header.php");
    }
    
    // $sql = "SELECT * FROM `tbl_day_offs`";
  ?>

   

  <table class="table table-hover table-pointer" id="day_off">
    <thead>
      <tr>
        <td>Nhân viên</td>
        <td>Ngày bắt đầu nghỉ</td>
        <td>Ngày kết thúc nghỉ</td>
        <td>Lý do</td>
        <td>Chi tiết</td>
      </tr>
    </thead>
    <tbody>
      <?php 
      if($id_position==2){
        $sql = "SELECT * FROM `tbl_day_offs` where reason IS NOT NULL and id_position=3";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
          $id_day_off = $row['id_day_off'];
          $reason = $row['reason'];
          $id_employee = $row['id_employee'];
          $start = $row['start'];
          $end = $row['end'];
          $reason = $row['reason'];
          $file = $row['file_attach'];
          $select_f_tbluser = "SELECT * FROM Tbl_User where id_employee = '$id_employee' and number_department = $number_department";
          $result1 = $conn->query($select_f_tbluser);
          while($row1 = $result1->fetch_assoc()){
            $id_posi = $row1['id_position'];
            $id_department = $row1['number_department'];
            $fullname = $row1['fullname_user'];
            echo '<tr>
            <td>'.$fullname.'</td>
            <td>'.$start.'</td>
            <td>'.$end.'</td>
            <td>'.$reason.'</td>
            <td><a href="/nghiphep-detail.php?id_day_off='.$id_day_off.'">Chi tiết</a></td>
          </tr>';
          }
        }
      }elseif($id_position==1){
        $sql = "SELECT * FROM `tbl_day_offs` where reason IS NOT NULL and id_position=2";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
          $id_day_off = $row['id_day_off'];
          $reason = $row['reason'];
          $id_employee = $row['id_employee'];
          $start = $row['start'];
          $end = $row['end'];
          $reason = $row['reason'];
          $file = $row['file_attach'];
          $select_f_tbluser = "SELECT * FROM Tbl_User where id_employee = '$id_employee'";
          $result1 = $conn->query($select_f_tbluser);
          while($row1 = $result1->fetch_assoc()){
            $id_posi = $row1['id_position'];
            $id_department = $row1['number_department'];
            $fullname = $row1['fullname_user'];
            echo '<tr>
            <td>'.$fullname.'</td>
            <td>'.$start.'</td>
            <td>'.$end.'</td>
            <td>'.$reason.'</td>
            <td><a href="/nghiphep-detail.php?id_day_off='.$id_day_off.'">Chi tiết</a></td>
          </tr>';
          }
        }
      }
        // $update = "UPDATE `tbl_day_offs` SET `start`= NULL,`end`=NULL,`reason`= NULL,`file_attach`= NULL,`id_status_day_off`='[value-9]'";
      ?>
      
    </tbody>
  </table>

    <footer class="bg-dark text-center text-white">
    <?php require_once("site/footer.php") ?>
	</footer>
	<script src="/main.js"></script>
</body>
</html>