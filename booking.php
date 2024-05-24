<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.html"); // Redirect to login page if user is not logged in
    exit;
}

include_once 'config.php';

if(isset($_POST['Logout'])) {
    session_destroy(); // Destroy all sessions
    header("Location: index.html"); // Redirect to index.html after logout
    exit;
}

// Check if form is submitted for booking
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmRegister'])) {
    // Check if the event is selected
    $event = $_POST['confirmRegister'];
    $user_id = $_SESSION['user']['BId'];
    
    // Insert booking details into the database
    $sql = "INSERT INTO bookings (BId, event) VALUES ('$user_id', '$event')";
    if ($conn->query($sql) === TRUE) {
        // Display popup with user details and booked ticket information
        $amount = ($event == 'bca_cup') ? 10000 : ($event == 'challenge' ? 1000 : 0);
        echo "<script>alert('Thank you for booking!\\nName: {$_SESSION['user']['first_name']} {$_SESSION['user']['last_name']}\\nAddress: {$_SESSION['user']['address']}\\nEmail: {$_SESSION['user']['email']}\\nAmount to be paid: RS {$amount}');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS */
        body {
            background-color: #f8f9fa; /* Light gray background */
        }

        .logo {
            margin-top: 20px;
        }

        .navbar {
            background-color: #343a40; /* Dark gray navbar */
            border: none;
        }

        .navbar-brand img {
            height: 60px;
        }

        .nav-link {
            color: white;
        }

        .content {
            background-color: rgba(255, 255, 255, 0.8); /* Transparent white background */
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        .card {
            cursor: pointer;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .modal-dialog {
            max-width: 90%;
            margin: 1.75rem auto;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <img src="./proimg/iconwhite.png" alt="Khel-Kud Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="users.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="events.php">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="booking.php">Booking</a>
                </li>
                <li class="nav-item">
                    <form method="POST">
                        <button class="btn btn-danger" name="Logout">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Booking</h1>
        <!-- Button to trigger the booking process -->
        <button type="button" class="btn btn-primary" id="bookTicketBtn">Booked Ticket</button>
    </div>

    <!-- Booking Confirmation Card (Initially Hidden) -->
    <div class="container mt-5" id="bookingConfirmation" style="display: none;">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Thank You for Booking</h5>
                <!-- User details and booking information will be displayed here -->
                <p class="card-text">Name: <?php echo $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name']; ?></p>
                <p class="card-text">Address: <?php echo $_SESSION['user']['address']; ?></p>
                <p class="card-text">Email: <?php echo $_SESSION['user']['email']; ?></p>
                <!-- Amount to be paid based on the event -->
                <?php
                $event = isset($_POST['event']) ? $_POST['event'] : '';
                $amount = ($event == 'bca_cup') ? 10000 : 1000;
                ?>
                <p class="card-text">Amount to be paid: RS <?php echo $amount; ?></p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Function to display the booking confirmation card when the button is clicked
        document.getElementById('bookTicketBtn').addEventListener('click', function() {
            document.getElementById('bookingConfirmation').style.display = 'block';
        });
    </script>
</body>
</html>
