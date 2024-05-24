<?php
session_start();
include('config.php');  // include the database connection

if (isset($_POST['save'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];
    $gender = $_POST['gender'];

    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    $sql_query = "INSERT INTO users (first_name, last_name, address, age, email, password, phone_number, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_query);
    // $stmt->bind_param("ssssssss", '$frist_name', '$last_name', '$address', '$age', '$email', '$hash_password', '$phone_number', '$gender');
    $stmt->bind_param("sssissis", $first_name,$last_name, $address, $age, $email, $password, $phone_number, $gender);

    if ($stmt->execute()) {
        echo "Registered successfully";
    } else {
        echo "Error: " . $sql_query . "<br>" . $conn->error;
    }

    $stmt->close();

    $check_email_query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($check_email_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $check_email_result = $result->fetch_assoc();

    if ($check_email_result) {
        $_SESSION['status'] = "Email ID Already Exists";
        header("Location: index.html");
    }

    $stmt->close();
}

mysqli_close($conn);
?>