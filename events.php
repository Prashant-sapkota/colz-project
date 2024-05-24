<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.html"); // Redirect to login page if user is not logged in
    exit;
}
// Check if logout button is clicked
if(isset($_POST['Logout'])) {
    session_destroy(); // Destroy all sessions
    header("Location: index.html"); // Redirect to index.html after logout
    exit;
}

// Include database connection
include_once 'admin_connection.php';

// Fetch events from the database
$sql = "SELECT * FROM events";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
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
        /* Custom CSS for adjusting card size */
        .card {
            height: 300px; /* Adjust height as needed */
        }
        .card {
            height: 300px; /* Adjust height as needed */
            background-image: url(./proimg/bca.jpeg);
            border: none;
            background-size: cover;
            background-position: center;
            color: white;
            margin: 10px;
        }

        .page-background {
            background-size: cover;
            background: url()
            background-position: center;
            color: white;
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
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="haha.php">Profile</a>
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
        <div class="row">
            <?php
            // Check if events are found
            if ($result->num_rows > 0) {
                // Output each event as a card
                while($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['event_name']; ?></h5>
                                <!-- Add more event details here as needed -->
                                <button type="button" class="btn btn-primary register-btn" data-toggle="modal" data-target="#confirmationModal">Register</button>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                // No events found
                echo "<div class='col-md-12'><p>No events found</p></div>";
            }
            ?>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to register for this event?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmRegister">Confirm</button>
                </div>
            </div>
        </div>
    </div>  

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Handle registration confirmation and redirection
        document.getElementById('confirmRegister').addEventListener('click', function() {
            // Redirect to booking.php page
            window.location.href = 'booking.php';
        });
    </script>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmRegister'])) {
    // Check if the event is selected
    $event = $_POST['confirmRegister'];
    $user_id = $_SESSION['user']['BId'];

    // Redirect to booking.php with necessary data
    header("Location: booking.php?event=$event&user_id=$user_id");
    exit;
} 
?>
