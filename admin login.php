<?php
    session_start();
    require "admin_connection.php";
    if(isset($_POST['signin'])){
        // echo"clicked";
        $query = "SELECT * FROM `admin_panel` WHERE `username`=? AND `password`=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $_POST['admin_name'], $_POST['admin_password']);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            // echo"correct";
            $_SESSION['adminloginid'] = $_POST['admin_name'];
            header("location:Admin panel.php");
            exit();
        } else {
            // echo"incorrect";
            echo "<script>alert('Invalid Username or password');</script>";
        }
    }
?>


<html>
<head>
<title>HTML_NEW</title>
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<link rel="stylesheet" type="text/css" href="admin login.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>

<div class="login-form">
    <h2>ADMIN LOGIN</h2>
    <form method = "POST">
        <div class="input-field">
            <i class="bi bi-person-circle"></i>
            <input type="text" placeholder="Username" name="admin_name">
        </div>
        <div class="input-field">
            <i class="bi bi-shield-lock"></i>
            <input type="password" placeholder="Password" name="admin_password">
        </div>

        <button type="submit" name ="signin">Sign In</button>

    </form>
</div>

</body>
</html>
