<?php
session_start();
require_once 'connection.php';

header("Content-Type: application/json");

// 🛡️ Verify login
if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

// 🎯 Get user email and resolve user ID and username
$email = $_SESSION['user'];
$stmt = $link->prepare("SELECT id, username FROM users WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if (!$row = $res->fetch_assoc()) {
    http_response_code(401);
    echo json_encode(["error" => "User not found"]);
    exit;
}

$user_id = $row['id'];
$username = $row['username'];

// 📦 Get POST data
$title = $_POST['title'] ?? '';
$author = $_POST['author'] ?? '';
$thumbnail = $_POST['thumbnail'] ?? '';
$type = $_POST['type'] ?? '';

// 🔍 Validate required fields
if (!$title || !$author || !$thumbnail || !in_array($type, ['favorite', 'wishlist'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing or invalid data"]);
    exit;
}

// 🎯 Determine table based on type
$table = ($type === 'favorite') ? 'myfavorites' : 'mywishlist';

// 🔁 Check if already exists
$check = $link->prepare("SELECT id FROM $table WHERE user_id = ? AND title = ? AND author = ?");
$check->bind_param("iss", $user_id, $title, $author);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    // 🔥 Remove
    $del = $link->prepare("DELETE FROM $table WHERE user_id = ? AND title = ? AND author = ?");
    $del->bind_param("iss", $user_id, $title, $author);
    $del->execute();
    echo json_encode(["status" => "removed", "type" => $type]);
} else {
    // ➕ Insert
    $ins = $link->prepare("INSERT INTO $table (user_id, title, author, thumbnail) VALUES (?, ?, ?, ?)");
    $ins->bind_param("isss", $user_id, $title, $author, $thumbnail);
    $ins->execute();
    echo json_encode(["status" => "added", "type" => $type]);
}
?>
