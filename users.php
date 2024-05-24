<?php
session_start();


// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: index.html"); // Redirect to login page if user is not logged in
    exit;
}
if(isset($_POST['Logout'])) {
    session_destroy(); // Destroy all sessions
    header("Location: index.html"); // Redirect to index.html after logout
    exit;
}

// Get user details from session
$user = $_SESSION['user'];

// Database connection
include 'config.php';

// Check if form is submitted for updating user details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['modify'])) {
        // Enable modification by removing readonly and disabled attributes from input fields
        $readonly = '';
        $disabled = '';
    } elseif(isset($_POST['save'])) {
        // Escape user inputs for security
        $first_name = $conn->real_escape_string($_POST['first_name']);
        $last_name = $conn->real_escape_string($_POST['last_name']);
        $address = $conn->real_escape_string($_POST['address']);
        $age = $conn->real_escape_string($_POST['age']);
        $phone_number = $conn->real_escape_string($_POST['phone_number']);
        $gender = isset($_POST['gender']) ? $conn->real_escape_string($_POST['gender']) : ''; // Check if gender is set
    
        // Update user details in database
        $sql = "UPDATE users SET first_name='$first_name', last_name='$last_name', address='$address', age='$age', phone_number='$phone_number', gender='$gender' WHERE Uid=" . $user['Uid'];
    
        if ($conn->query($sql) === TRUE) {
            // Update session with modified user details
            $_SESSION['user']['first_name'] = $first_name;
            $_SESSION['user']['last_name'] = $last_name;
            $_SESSION['user']['address'] = $address;
            $_SESSION['user']['age'] = $age;
            $_SESSION['user']['phone_number'] = $phone_number;
            $_SESSION['user']['gender'] = $gender;
        } else {
            echo "Error updating record: " . $conn->error;
        }

        // Redirect to home.php after updating database
        header("Location: home.php");
        exit;
    } elseif(isset($_POST['cancel'])) {
        // Redirect to home.php if cancel button is clicked
        header("Location: home.php");
        exit;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
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
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>User Profile</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="form-group">
                                <label for="first_name">First Name:</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>" <?php if(!isset($_POST['modify'])) echo "readonly"; ?>>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name:</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>" <?php if(!isset($_POST['modify'])) echo "readonly"; ?>>
                            </div>
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo $user['address']; ?>" <?php if(!isset($_POST['modify'])) echo "readonly"; ?>>
                            </div>
                            <div class="form-group">
                                <label for="age">Age:</label>
                                <input type="number" class="form-control" id="age" name="age" value="<?php echo $user['age']; ?>" <?php if(!isset($_POST['modify'])) echo "readonly"; ?>>
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Phone Number:</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $user['phone_number']; ?>" <?php if(!isset($_POST['modify'])) echo "readonly"; ?>>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender:</label>
                                <select class="form-control" id="gender" name="gender" <?php if(!isset($_POST['modify'])) echo "disabled"; ?>>
                                    <option value="Male" <?php if(isset($user['gender']) && $user['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                                    <option value="Female" <?php if(isset($user['gender']) && $user['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                                    <option value="Other" <?php if(isset($user['gender']) && $user['gender'] == 'Other') echo 'selected'; ?>>Other</option>
                                </select>
                            </div>
                            <?php if(!isset($_POST['modify'])): ?>
                                <button type="submit" class="btn btn-primary" name="modify">Modify</button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-primary" name="save">Save Changes</button>
                                <button type="submit" class="btn btn-secondary" name="cancel">Cancel</button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
