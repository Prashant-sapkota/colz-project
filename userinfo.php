<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Information</title>
</head>

<body>

    <?php
    if ($_SESSION['email']) {

        $conn = mysqli_connect('localhost', 'root', '', 'database');

        $sql = "SELECT * FROM loginingo WHERE email = '" . $_SESSION['email'] . "';";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {

            $userdata = mysqli_fetch_assoc($result);

            echo "<h1>Welcome, " . $userdata['firstname'] . " " . $userdata['lastname'] . "!</h1>";

            echo "<p>Email: " . $userdata['email'] . "</p>";

            echo "<p>Phone Number: " . $userdata['phone'] . "</p>";

            echo "<p>Address: " . $userdata['address'] . "</p>";

            echo "<p>Gender: " . $userdata['gender'] . "</p>";

            echo "<p>Birth Date: " . date('F j, Y', strtotime($userdata['birth_date'])) . "</p>";

            echo "<p><a href='logout.php'>Logout</a></p>";

        }

        mysqli_close($conn);

    } else {

        header('location: login.php');

    }
    ?>

</body>

</html>