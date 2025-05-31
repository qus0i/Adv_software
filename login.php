<?php
session_start();
require_once "connection.php";

// Error messages
$missingEmail = '<p><strong>Please enter your email address!</strong></p>';
$missingPassword = '<p><strong>Please enter your password!</strong></p>';
$errors = '';

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate Email
    if (empty($_POST["loginemail"])) {
        $errors .= $missingEmail;
    } else {
        $email = filter_var($_POST["loginemail"], FILTER_SANITIZE_EMAIL);
    }

    // Validate Password
    if (empty($_POST["loginpassword"])) {
        $errors .= $missingPassword;
    } else {
        $password = $_POST["loginpassword"]; // Leave raw for password_verify()
    }

    // Output validation errors
    if ($errors) {
        echo '<div class="alert alert-danger">' . $errors . '</div>';
        exit;
    }

    // Escape email for query
    $email = mysqli_real_escape_string($link, $email);

    // 🔐 Fetch user by email
    $stmt = $link->prepare("SELECT id, username, password FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // ✅ Verify password (hashed)
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $email;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Optional login message
            // $_SESSION['login_message'] = "Successfully logged in!";
            header("Location: home.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Invalid email or password!</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid email or password!</div>";
    }
} else {
    // 🚫 No direct GET access
    header("Location: first.html");
    exit();
}
?>
