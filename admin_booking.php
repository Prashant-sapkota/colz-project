<?php
session_start();
if (!isset($_SESSION['adminloginid'])) {
    header("Location: admin_login.php");
    exit;
}

include_once 'admin_connection.php';

if(isset($_POST['logout'])) {
    session_destroy();
    header("Location: admin_login.php");
    exit;
}

// Update booking status
if(isset($_POST['update_status'])) {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status'];
    
    $sql = "UPDATE bookings SET status='$status' WHERE BId='$booking_id'";
    if ($conn->query($sql) === TRUE) {
        // Booking status updated successfully
    } else {
        // Error updating booking status
    }
}

// Delete booking
if(isset($_POST['delete_booking'])) {
    $booking_id = $_POST['delete_booking'];
    
    $sql = "DELETE FROM bookings WHERE BId='$booking_id'";
    if ($conn->query($sql) === TRUE) {
        // Booking deleted successfully
    } else {
        // Error deleting booking
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Bookings</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <form method="POST">
                        <button class="btn btn-danger" name="logout">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Bookings</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>User ID</th>
                    <th>Event ID</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display bookings
                $sql = "SELECT * FROM bookings";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['BId']}</td>";
                        echo "<td>{$row['user']}</td>";
                        echo "<td>{$row['event']}</td>";
                        echo "<td>{$row['status']}</td>";
                        echo "<td>";
                        echo "<form method='post'>";
                        echo "<input type='hidden' name='booking_id' value='{$row['Bid']}'>";
                        echo "<select name='status' class='form-control mb-2'>";
                        echo "<option value='processing'>Processing</option>";
                        echo "<option value='done'>Done</option>";
                        echo "</select>";
                        echo "<button type='submit' class='btn btn-primary btn-sm' name='update_status'>Update Status</button>";
                        echo "<button type='submit' class='btn btn-danger btn-sm ml-1' name='delete_booking'>Delete</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No bookings found</td></tr>";
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
