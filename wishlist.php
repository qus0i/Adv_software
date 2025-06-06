<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}

include("connection.php");

$email = $_SESSION['user'];
$username = '';
$user_id = 0;

// Get username & user_id
$sql = "SELECT id, username FROM users WHERE email = '$email' LIMIT 1";
$result = mysqli_query($link, $sql);
if ($row = mysqli_fetch_assoc($result)) {
    $user_id = $row['id'];
    $username = $row['username'];
}

// Fetch wishlist items
$wishlist = [];
$query = "SELECT * FROM wishlist WHERE id = '$user_id'";
$result = mysqli_query($link, $query);
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $wishlist[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>My Wishlist</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <header>
    <h2><?php echo $username; ?>'s Wishlist</h2>
    <nav>
      <a href="home.php">Home</a> |
      <a href="favorites.php">My Favorite</a> |
      <a href="wishlist.php">Wishlist</a> |
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <main>
    <?php if (empty($wishlist)): ?>
      <p>No books in your wishlist yet.</p>
    <?php else: ?>
      <div class="book-list">
        <?php foreach ($wishlist as $book): ?>
          <div class="book-card">
            <?php if (!empty($book['thumbnail'])): ?>
              <img src="<?php echo $book['thumbnail']; ?>" alt="Book Cover">
            <?php endif; ?>
            <h4><?php echo htmlspecialchars($book['title']); ?></h4>
            <p>By: <?php echo htmlspecialchars($book['author']); ?></p>

            <!-- 🗑 Remove from Wishlist -->
            <form action="remove_wishlist.php" method="POST" style="margin-top: 10px;">
              <input type="hidden" name="title" value="<?php echo htmlspecialchars($book['title']); ?>">
              <button type="submit" style="background:none; border:none; color:red; font-size:18px; cursor:pointer;" title="Remove">🗑 Remove</button>
            </form>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>
</body>
</html>
