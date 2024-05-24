<?php
session_start();
if (!isset($_SESSION['adminloginid'])) {
    header("Location: admin_login.php"); // Redirect to admin login page if admin is not logged in
    exit;
}

// Include database connection
include_once 'admin_connection.php';

// Check if logout button is clicked
if(isset($_POST['logout'])) {
    session_destroy(); // Destroy all sessions
    header("Location: admin_login.php"); // Redirect to admin login page after logout
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        
        body {
            background-color: #f8f9fa; /* Light gray background */
        }
        .navbar li {
            display: list-item;
        }
        
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li><button><a href="admin panel.php">Home</a></li>
                <li><button><a href="admin_users.php">Users</a></button></li>
                <li><button><a href="admin_events.php">Events</a></button></li>
                <li><button><a href="admin_booking.php">Booking</a></button></li>
                <li class="nav-item">
                    <form method="POST">
                        <button class="btn btn-danger" name="logout">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Registered Users</h2>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Gender</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Retrieve user data from the database
                $sql = "SELECT * FROM users";
                $result = $conn->query($sql);

                // Check if the query was executed successfully
                if ($result === false) {
                    die("Error: " . $conn->error); // Display error message if query fails
                }

                // Check if any users were found
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row['Uid']; ?></td>
                            <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['age']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone_number']; ?></td>
                            <td><?php echo $row['gender'] ?></td>
                            <td>
                                <form method="POST" action="admin_action.php">
                                    <input type="hidden" name="user_id" value="<?php echo $row['Uid']; ?>">
                                    <button type="submit" class="btn btn-danger" name="delete_user">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='8'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
