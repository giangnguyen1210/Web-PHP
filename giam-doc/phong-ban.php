<?php require_once("gd-username.php") ?>
<?php require_once("gd-position.php") ?>
<?php
		if(isset($_SESSION['id_position'])) { 
		if($_SESSION['id_position'] != 1){
			header("Location: ../nhan-vien/nv-task.php");
			exit();
		}
	}
	require_once("../admin/db.php");
	$sql = "SELECT * FROM Tbl_Department";
	$result = $conn->query($sql);
	while($row=$result->fetch_assoc())	{
		$_SESSION['name_department'] = $row['name_department'];
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
	<title>PHÒNG BAN</title>
</head>
<body class="giam-doc">
  <header>
    <?php require_once("../site/navbar.php") ?>
  </header><br>
	<table class="table table-striped">
		<thead>
			<tr>
				<td>Tên</td>
				<td>Phòng số</td>
				<td>Chỉnh sửa</td>
				<td>Chi tiết</td>
			</tr>
		</thead>
		<tbody>
		<?php
				include("../site/card_department.php");

			?>
			<tr>
				<td colspan="5"><button onclick="window.location = 'new-department.php'" class="btn-detail">THÊM PHÒNG BAN MỚI</button></td>
			</tr>
		</tbody>
	</table>
	<footer class="bg-dark text-center text-white">
    <?php require_once("../site/footer.php") ?>
	</footer>
	<script src="/main.js"></script>
</body>
</html>