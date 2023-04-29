<?php
  if(!isset($_SESSION)) { 
    session_start(); 
  } 
  require_once("../admin/db.php");
  $sql = "SELECT * FROM Tbl_Department";
  $result = $conn->query($sql);
  $_SESSION['name_department'] = '';
  while($data = $result->fetch_assoc()){
    $name_department = $data['name_department'];
    $number_of_department = $data['number_department'];
    $discript = $data['discription_department'];
    $_SESSION['name_department'] = $data['name_department'];
    ?>
     <?php echo '<div>
      <tr>
         <td>'.$name_department.'</td>
         <td>'.$number_of_department.'</td>
         <td><a href = "/giam-doc/update_department.php?number_department='.$number_of_department.'">Chỉnh sửa</a></td>
         <td><a href = "/giam-doc/chi-tiet-phong.php?number_department='.$number_of_department.'">Chi tiết</a></td>
      <tr>
      </div>';
  }

?>

