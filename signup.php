<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = mysqli_real_escape_string($link, $_POST['fullname']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $password = mysqli_real_escape_string($link, $_POST['password']);

    // Validation
    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: register.html");
        exit();
    }

    // Check if email already exists
    $checkQuery = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $checkResult = mysqli_query($link, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION['error'] = "Email already registered.";
        header("Location: register.html");
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into database
    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
    $result = mysqli_query($link, $query);

    if ($result) {
        $user_id = mysqli_insert_id($link);
        $_SESSION['user'] = $email;
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user_id;

        header("Location: home.php");
        exit();
    } else {
        $_SESSION['error'] = "Something went wrong. Please try again.";
        header("Location: register.html");
        exit();
    }
} else {
    header("Location: register.html");
    exit();
}
?>
