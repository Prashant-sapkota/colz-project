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

if(isset($_POST['create_event'])) {
    $event_name = $_POST['event_name'];
    // You can add more event details here as needed

    // Insert the new event into the database
    $sql = "INSERT INTO events (event_name) VALUES ('$event_name')";
    if ($conn->query($sql) === TRUE) {
        // Event added successfully
        $message = "Event created successfully!";
    } else {
        // Error adding event
        $error = "Error creating event: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Create Event</title>
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
        <h2>Create Event</h2>
        <?php
        if(isset($message)) {
            echo "<div class='alert alert-success'>$message</div>";
        }
        if(isset($error)) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        ?>
        <form method="POST">
            <div class="form-group">
                <label for="event_name">Event Name:</label>
                <input type="text" class="form-control" id="event_name" name="event_name" required>
            </div>
            <!-- Add more fields for event details here as needed -->
            <button type="submit" class="btn btn-primary" name="create_event">Create Event</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
