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

// Delete event
if(isset($_POST['delete_event'])) {
    $event_id = $_POST['delete_event'];
    
    // Delete event from admin_events.php database
    $sql = "DELETE FROM events WHERE EId='$event_id'";
    if ($conn->query($sql) === TRUE) {
        // Event deleted successfully from admin_events.php
    } else {
        // Error deleting event from admin_events.php
    }

    // Delete event from events.php database
    include_once 'admin_connection.php'; // Include connection to events.php database
    $sql_events = "DELETE FROM events WHERE EId='$event_id'";
    if ($conn->query($sql) === TRUE) {
        // Event deleted successfully from events.php
    } else {
        // Error deleting event from events.php
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Events</title>
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
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li><button><a href="admin panel.php">Home</a></li>
                <li><button><a href="admin_users.php">Users</a></button></li>
                <li><button><a href="admin_events.php">Events</a></button></li>
                <li><button><a href="admin_booking.php">Booking</a></button></li>
            </ul>
        </div>
                <li class="nav-item">
                    <form method="POST">
                        <button class="btn btn-danger" name="logout">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Events</h2>
        <div class="mb-3">
            <a href="admin_create_event.php" class="btn btn-primary">Add Event</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Event ID</th>
                    <th>Event Name</th>
                    <th>Action</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display events
                $sql = "SELECT * FROM events";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['EId']}</td>";
                        echo "<td>{$row['event_name']}</td>";
                        echo "<td><form method='post'><input type='hidden' name='delete_event' value='{$row['EId']}'><button type='submit' class='btn btn-danger'>Delete</button></form></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No events found</td></tr>";
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
