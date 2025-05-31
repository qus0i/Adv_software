<?php/*
session_start();
  if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
  }
  include("connection.php");
  $email = $_SESSION['user'];
  $username = '';
  $sql = "SELECT username FROM users WHERE email = '$email' LIMIT 1";
  $result = mysqli_query($link, $sql);
  if ($row = mysqli_fetch_assoc($result)) {
    $username = $row['username'];
  }
  $loginMessage = '';
    if (isset($_SESSION['login_message'])) {
    $loginMessage = $_SESSION['login_message'];
    unset($_SESSION['login_message']);
  }
// ✅ FETCH AND FILTER BOOKS
$books = [];
$uniqueBooks = [];
$seenTitles = [];
  $apiUrl = "https://www.googleapis.com/books/v1/volumes?q=fiction&maxResults=12";  
  $response = file_get_contents($apiUrl);
  if ($response !== false) {
    $data = json_decode($response, true);
    if (isset($data['items'])) {
        foreach ($data['items'] as $book) {
            $title = $book['volumeInfo']['title'] ?? '';
            if (!in_array($title, $seenTitles)) {
                $seenTitles[] = $title;
                $uniqueBooks[] = $book;
            }
        }
        // Limit to 6 unique books
        $uniqueBooks = array_slice($uniqueBooks, 0, 6);
    }
  } else {
  }*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookNest</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./main.css" rel="stylesheet">
  <style>

  </style>
</head>
<body>
  <!-- Navbar -->
<div id="navbar-placeholder"></div>
  <script>
  fetch('nav.html')
    .then(response => response.text())
    .then(data => document.getElementById('navbar-placeholder').innerHTML = data);
  </script>
<!-- Hero Section -->
<div class="hero">
  <video
    id="hero-video"
    autoplay
    muted             
    loop
    playsinline
    preload="auto"
  >
    <source src="./hero.mp4" type="video/mp4">
    Your browser doesn’t support HTML5 video.
  </video>
</div>


  <div class="hero-text-overlay">
    <h1 class="hero-title">
      <span class="typewriter-text">Welcome to NextMovie</span>
    </h1>  
    <p class="hero-subtitle">Discover your next literary adventure</p>
  </div>
</div>
<!-- Navbar Placeholder (if using separate nav.html) -->
<div id="navbar-placeholder"></div>
  <!-- Popular Picks Section -->
  


  <!-- Explore by Genre Section -->
  <div class="container-fluid py-5">
    <div class="row">
      <div class="col-12">
        <div class="genre-iframe-container">
         <iframe
      src="genraSec.html"
       class="genre-iframe"
      loading="lazy"
        allowfullscreen
       scrolling="no"
       style="overflow:hidden;">
            </iframe>
        </div>
      </div>
    </div>
  </div>

<!-- Best Books This Month Section -->
 <div id="includedContent"></div>
 <!-- From Our Readers Section -->
<div class="reviews-iframe-container">
  <iframe src="randomreviews.html" 
    loading="lazy"
    frameborder="0"
    allow="fullscreen"
    class="reviews-iframe"
  ></iframe>
</div>
<script>

  // Receive height updates and adjust iframe
  window.addEventListener('message', (event) => {
    // Security check - verify message origin if deployed
    // if (event.origin !== "https://your-domain.com") return;
    
    if (event.data.type === 'reviewsHeight') {
      const iframe = document.querySelector('.reviews-iframe');
      iframe.style.height = `${event.data.height}px`;
      
      // Optional: Add smooth transition
      iframe.style.transition = 'height 0.3s ease';
    }
  });
  // Fallback: Set initial min-height
  document.querySelector('.reviews-iframe').style.minHeight = '600px';
  </script>
  <!-- Bootstrap JS -->
   
  <script>
    // Function to load the HTML content into a div
   function loadHTML() {
      fetch('./MonthlyRecomnd.html')
        .then(response => response.text())
        .then(data => {
          document.getElementById('includedContent').innerHTML = data;
        })
        .catch(error => {
          console.error('Error loading HTML:', error);
        });

    }
    // Load HTML content when the page is loaded
    window.onload = loadHTML;
      // Add this new fetch call for the reviews section
  </script>
    <div id="footer-placeholder"></div>
    
  <script>
    fetch('footer.html')
      .then(response => response.text())
      .then(html => {
        const temp = document.createElement('div');
        temp.innerHTML = html;
        const footerEl = temp.querySelector('footer');
        document.getElementById('footer-placeholder').appendChild(footerEl);
      })
      .catch(err => console.error('Error loading footer:', err));
  </script>
  <script src="./MonthlyRecomnd.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
 </body>
</html>
