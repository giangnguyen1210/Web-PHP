<?php require_once("gd-username.php") ?>
<?php require_once("gd-position.php") ?>
<?php
	if(!isset($_SESSION)) { 
    session_start();
  } 
	if(isset($_SESSION['id_position'])) { 
		// echo $_SESSION['id_position'];
		// echo $_SESSION['login_name'];
		if($_SESSION['id_position'] != 1){
			header("Location: ../nhan-vien/nv-task.php");
			exit();
		}
	}
	require_once("../admin/db.php");
	$sql = "SELECT * FROM Tbl_User";
	$result = $conn->query($sql);
	// while($row=$result->fetch_assoc())	{
	// 	// $_SESSION['id_employee'] = $row['id_employee'];
	// 	// $_SESSION['fullname_user'] = $row['fullname_user'];
	// 	// $_SESSION['id_position'] = $row['id_position'];
	// }
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
	<title>NHÂN VIÊN</title>
</head>
<body class="giam-doc">
  <header>
    <?php require_once("../site/navbar.php") ?>
  </header>
	<div class="danh-sach">
		<?php
			include("../site/card-user.php");
		?>
		<div class="the giam-doc__new">
			<div> <a href = "/new-user.php">+</a></div>
		</div>
	</div>

	<div class="modal fade" id="rsPass" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Đặt lại mật khẩu</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="rs">Yes</button>
				</div>
			</div>
		</div>
	</div>

	<footer class="bg-dark text-center text-white">
    <?php require_once("../nhan-vien/nv-footer.php") ?>
	</footer>
	<script src="/main.js"></script>
</body>
</html>