<?php require_once("gd-username.php") ?>
<?php require_once("gd-position.php") ?>
<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
	$error = '';
    
   
    if(isset($_POST['submit']))
    {
        $name_depart = $_POST['name_depart'];
        $discription = $_POST['discription'];
        $number_of_depart = $_POST['number_of_depart'];
        if (empty($name_depart)) {
            $error = 'Chưa nhập tên phòng ban';
		}else if(empty($discription)){
            $error = 'Chưa nhập mô tả';
		}elseif(empty($number_of_depart)){
            $error = 'Chưa nhập số phòng của phòng ban';
		}
        require_once("../admin/db.php");
        $select = "SELECT * FROM `Tbl_Department` where number_department = '$number_of_depart' or name_department = '$name_depart'";
        $result = $conn->query($select);
		if ($result->num_rows > 0) {
			$error = 'Tên phòng ban hoặc số hiệu phòng ban đã tồn tại';	
		 }
		 elseif (empty($name_depart)) {
            $error = 'Chưa nhập tên phòng ban';
		}else if(empty($discription)){
            $error = 'Chưa nhập mô tả phòng ban';
		}elseif(empty($number_of_depart)){
            $error = 'Chưa phòng nhập phòng số';
		}
        $sql = "INSERT INTO `Tbl_Department` (name_department,number_department,discription_department) VALUES (?,?,?)";
        $stm = $conn->prepare($sql);
        $stm->bind_param("sss",$name_depart,$number_of_depart,$discription);
		if($error==''){
			echo '<script language="javascript">alert("Thêm phòng ban thành công");</script>';
			if($stm->execute()){
				$success = "Thêm phòng ban thành công";
				header("refresh:1;url=phong-ban.php");
				exit();
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
	<title>Thêm phòng ban</title>
</head>
<body class="new-user">
<<<<<<< HEAD
  <!-- <img src="/images/logo.png" alt="logo" class="my-logo"> -->
  <header>
    <?php require_once("../site/navbar.php") ?>
  </header>
    <h3 class="text-center mt-4 mb-4"> THÊM MỘT PHÒNG BAN MỚI </h3>
=======
  <header>
    <?php require_once("../site/navbar.php") ?>
  </header>
    <h3 class="text-center mb-4"> THÊM MỘT PHÒNG BAN MỚI </h3>
>>>>>>> 649f9af9e2b637fdf21dc52b7c0175533828f363
	<div class="my-form">
		
        <form id="newUser-form" method = "post" action = "">
			<p>Tên phòng ban: </p>
			<input type="text" name="name_depart" id="name_depart">
			<p>Mô tả: </p>
			<textarea name="discription" id="discription" rows="3" cols="48"></textarea>
      		<p>Phòng số:</p>
			<input  type="text" name="number_of_depart" id="number_of_depart">
            <?php
                  if (!empty($error)) {
                      echo "<div class='alert alert-danger'>$error</div>";
                  }
                  if (!empty($success)) {
                      echo "<div class='alert alert-success'>$success</div>";
                  }
              ?>	
			<button name="submit" type="submit">Tạo</button>
		</form>
	</div>
	<footer class="bg-dark text-center text-white">
<<<<<<< HEAD
    <?php require_once("../nhan-vien/nv-footer.php") ?>
=======
    <?php require_once("../site/footer.php") ?>
>>>>>>> 649f9af9e2b637fdf21dc52b7c0175533828f363
	</footer>
	<script src="/main.js"></script>
</body>
</html>