
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
<section class="home">
        <header>
            <div class="logo">
                <a href="admin panel.php">
                    <img onclick=""  src="./proimg/iconwhite.png" alt="Khel-Kud Logo">
                </a>
            </div>
            <div class="navbar">
                <li><button><a href="home.php">Home</a></li>
                <li><button><a href="userinfo.php">profile</a></button></li>
                <li><button><a href="events.php">Events</a></button></li>
                <li><button><a href="booking.php">Booking</a></button></li>
                <li>
                    <form method="POST">
                        <button name="Logout">Logout</button>
                    </form>
                </li>
            </div>
        </header>
        <div class="content">
        </div>
    </section>
</body>
</html>
<?php 
  if(isset($_POST['Logout']))
  {
    session_destroy();
    header("Location:index.html");
  }
?>


