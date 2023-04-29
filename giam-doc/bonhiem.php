<?php 
    session_start();
    require_once("gd-username.php");
    require_once("gd-position.php");
    require_once("../admin/db.php");
    $number_department = $_SESSION['number_department'];
    $sql = "SELECT * FROM `tbl_user` WHERE `id_position`=2 and number_department = '$number_department'";
    $result2 = $conn->query($sql);
    if(isset($_GET['id'])){
        if($row = $result2->fetch_assoc()){
            $id_employee = $row['id_employee'];
            $update_user = "UPDATE `tbl_user` SET `id_position`=3 where id_employee = '$id_employee'";
            $result = $conn->query($update_user);
            $update_dayoff = "UPDATE `tbl_day_offs` SET `id_position`=3, `sum_day_off`=12 where id_employee = '$id_employee'";
            $result1 = $conn->query($update_dayoff);
        }

        $id = $_GET['id'];
        $update_user = "UPDATE `tbl_user` SET `id_position`=2 where id_employee = '$id'";
        $result = $conn->query($update_user);
        $update_dayoff = "UPDATE `tbl_day_offs` SET `id_position`=2, `sum_day_off`=15 where id_employee = '$id'";
        $result1 = $conn->query($update_dayoff);
        header("Location: chi-tiet-phong.php?number_department=".$_SESSION['number_department']);
        exit();
    }
 

?>