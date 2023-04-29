<?php require_once("gd-username.php") ?>
<?php require_once("gd-position.php") ?>
<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
	$error = '';
    require_once("../admin/db.php");
    
    if(isset($_GET['number_department'])){
        $numb_depart = $_GET['number_department'];
        $select_name = "SELECT * FROM `Tbl_Department` where number_department = '$numb_depart'";
        $query = $conn->query($select_name);
        if ($row =$query->fetch_assoc()) {
            $current_name = $row['name_department'];
            $descript = $row['discription_department'];
                
        }
        if(isset($_POST['submit']))
        {
            $name_depart = $_POST['name_depart'];
            // $current_depart = 
            $discription = $_POST['discription'];
            $select = "SELECT * FROM `Tbl_Department` where name_department = '$name_depart'";
            $result = $conn->query($select);
            if ($row =$result->fetch_assoc()) {
                if($row['number_department'] != $numb_depart){
                    $error = 'Tên phòng ban đã tồn tại';
                }
                	
            }
            elseif (empty($name_depart)) {
                $error = 'Chưa nhập tên phòng ban';
            }else if(empty($discription)){
                $error = 'Chưa nhập mô tả phòng ban';
            }
            
            $sql = "UPDATE `Tbl_Department` SET name_department = ?,discription_department = ? where number_department = '$numb_depart' ";
            $stm = $conn->prepare($sql);
            $stm->bind_param("ss",$name_depart,$discription);
            if($error==''){
                if($stm->execute()){
                    header("refresh:1;url=phong-ban.php");
                    exit();
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
	<title>UPDATE DEPARTMENT</title>
</head>
<body class="new-user">
  <img src="/images/logo.png" alt="logo" class="my-logo">
  <h3 class="text-center mb-4"> CHỈNH SỬA PHÒNG BAN SỐ <?=$numb_depart?></h3>
	<div class="my-form">
		
        <form id="updateDepartment-form" method = "post" action = "">
			<p>Tên phòng ban: </p>
			<input type="text" name="name_depart" id="name_depart" value="<?=$current_name?>">
			<p>Mô tả: </p>
			<textarea name="discription" id="discription" rows="3" cols="48"><?=$descript?></textarea>
            <p class="err fade" id="updateDepartment-err"></p>
            <?php
                  if (!empty($error)) {
                      echo "<div class='alert alert-danger'>$error</div>";
                  }
                  if (!empty($success)) {
                      echo "<div class='alert alert-success'>$success</div>";
                  }
              ?>	
			<button name="submit" type="submit">UPDATE</button>
		</form>
	</div>
	<script src="/main.js"></script>
</body>
</html>