<?php 
    session_start();
    require_once("gd-username.php");
    require_once("gd-position.php");
    require_once("../admin/db.php");
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $update_user = "UPDATE `tbl_user` SET `id_position`=3 where id_employee = '$id'";
        $result = $conn->query($update_user);
        $update_dayoff = "UPDATE `tbl_day_offs` SET `id_position`=3, `sum_day_off`=12 where id_employee = '$id'";
        $result1 = $conn->query($update_dayoff);

        header("Location: chi-tiet-phong.php?number_department=".$_SESSION['number_department']);
        exit();
    }

?>