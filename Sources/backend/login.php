<?php
session_start();
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../mycss/styles.min.css">
</head>
<body>
	<?php
	include("connection.php");
	// Kiểm tra nếu người dùng đã ân nút đăng nhập thì mới xử lý
	if (isset($_POST["btn_submit"])) {
		// lấy thông tin người dùng
		$username = $_POST["username"];
		$password = $_POST["password"];
		//làm sạch thông tin, xóa bỏ các tag html, ký tự đặc biệt 
		//mà người dùng cố tình thêm vào để tấn công theo phương thức sql injection
		$username = strip_tags($username);
        $username = addslashes($username);
        $password = strip_tags($password);
        $password = addslashes($password);
		if ($username == "" || $password =="") {
            echo "<script>alert('bạn vui lòng nhập đầy đủ thông tin!')</script>";
        }else{
            $sql = "SELECT * FROM users where username='$username' and password='$password'";
            $query = mysqli_query($conn,$sql);
            $num_rows = mysqli_num_rows($query);
            if ($num_rows==0) {
                echo "<script>alert('Bạn đã nhập sai tài khoản hoặc mật khẩu!')</script>";
            }else{
                $data= mysqli_fetch_array($query); //Lấy ra kết quả truy vấn
                
                $_SESSION['phanquyen']=$data["phanquyen"];
                if($_SESSION['phanquyen']==1){
                    
                    header('Location:admin.php');
                    
                    
                    
                }
                else{
    
                    $_SESSION["username"] = $data["username"];
                    header('Location: ../index.php');
                    
                }
            }
            }
        }   
	?>
    <div class="login-dark">
        <form method="post" action="login.php">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
            <div class="form-group"><input class="form-control" type="text" name="username" placeholder="Username"></div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Mật khẩu" size="30"></div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit" name="btn_submit">Đăng nhập</button>
            </div><a href="register.php" class="forgot">Bạn chưa có tài khoản? <strong>Đăng ký</strong> tại đây</a>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>