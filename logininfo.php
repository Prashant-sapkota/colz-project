<?php
// Initialize the session
session_start();

// Include the database connection file
require_once 'config.php';

// Check if the form is submitted
if (isset($_POST['save'])) {

    // Get the login values
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the email and password are not empty
    if (!empty($email) && !empty($password)) {

        // Validate the email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            // Check if the email exists in the database
            $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

            if (mysqli_num_rows($query) > 0) {

                // Fetch the user data
                $user = mysqli_fetch_assoc($query);

                // Verify the password
                if (password_verify($password, $user['password'])) {

                    // Password is correct
                    // Set the session variables
                    $_SESSION['user'] = $user;

                    // Redirect to the dashboard
                    header('Location: home.php');

                } else {

                    // Password is incorrect
                    $error = 'Incorrect password.';

                }

            } else {

                // Email not found
                $error = 'Email not found.';

            }

        } else {

            // Invalid email format
            $error = 'Invalid email format.';

        }

    } else {

        // Email and password are empty
        $error = 'Email and password cannot be empty.';

    }

}

// Close the database connection
mysqli_close($conn);

?>
