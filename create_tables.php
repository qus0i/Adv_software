<?php
include("connection.php");

// Drop both tables to clean up any mismatches
$link->query("DROP TABLE IF EXISTS user_genres");
$link->query("DROP TABLE IF EXISTS users");

// Create users table
$userTable = "CREATE TABLE users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(64) NOT NULL,
    profile_img LONGBLOB
) ENGINE=InnoDB";

// Create user_genres table
$genresTable = "CREATE TABLE user_genres (
    user_id INT UNSIGNED NOT NULL,
    genre1 VARCHAR(64),
    genre2 VARCHAR(64),
    genre3 VARCHAR(64),
    genre4 VARCHAR(64),
    genre5 VARCHAR(64),
    genre6 VARCHAR(64),
    PRIMARY KEY (user_id),
    FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB";

// Run queries
if (
    $link->query($userTable) === TRUE &&
    $link->query($genresTable) === TRUE 
) {
    echo "All tables created successfully.";
} else {
    echo "Error: " . $link->error;
}

$link->close();
?>
