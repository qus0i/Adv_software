<?php 
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

///Graduation-project/All_IMAGES/Profil.png    
    

?> 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Profile</title>
<link
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
  rel="stylesheet"
/>
<link
  href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
  rel="stylesheet"
/>

     <link rel="stylesheet" href="./ main.css">

</head>
<body>
  <!-- Navbar Include (if you have one) -->
  <div id="navbar-placeholder"></div>
  <script>
  fetch('nav.html')
    .then(response => response.text())
    .then(data => document.getElementById('navbar-placeholder').innerHTML = data);
  </script>
  <!-- Profile & Counters Section -->
  <section class="profile py-5">
    <div class="container">
  <div class="row mb-4">
    <div class="col">
      <h2 class="profiletxt" id="username"><?php echo $username; ?></h2>
    </div>
    
        <div class="col-md-8">
          <div class="row text-center">
            <!-- Five counters -->
           <script>
  // 1. Define a mapping from list-keys to SVG markup
  const icons = {
    Favorites: `
 <svg xmlns="http://www.w3.org/2000/svg" class="icons-counter" viewBox="0 0 24 24" width="50" height="50" >
      <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
               2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09
               C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5
               c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
    </svg>
      `,
    WishList: `
      <svg xmlns="http://www.w3.org/2000/svg" class="icons-counter" version="1.1" viewBox="0 0 100 100">
<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" fill="#c"
	 viewBox="0 0 420.012 420.012" style="enable-background:new 0 0 420.012 420.012;" xml:space="preserve">
<g id="XMLID_40_">
	<path id="XMLID_85_" d="M0,40v340.012h420.012V40H0z M100.006,165.006v30h-40v-30H100.006z M60.006,135.006v-30h40v30H60.006z
		 M100.006,225.006v30h-40v-30H100.006z M100.006,285.006v30h-40v-30H100.006z M260.83,284.979l-50.824-26.72l-50.824,26.72
		l9.707-56.593l-41.119-40.08l56.824-8.256l25.412-51.491l25.412,51.491l56.824,8.256l-41.119,40.08L260.83,284.979z
		 M360.006,165.006v30h-40v-30H360.006z M320.006,135.006v-30h40v30H320.006z M360.006,225.006v30h-40v-30H360.006z
		 M360.006,285.006v30h-40v-30H360.006z"/>
</g>
</svg>`,
   
  };

  const lists = ['Favorites','WishList'];
  lists.forEach(key => {
    const iconSvg = icons[key] || icons.library; // fallback icon
    document.write(`
      <div class="col-6 col-lg-4 mb-4">
        <div class="counter__item">
          <div class="counter__item__text profiletxt2">
            ${iconSvg}
            <h2 class="counter_num profiletxt" id="count-${key}">0</h2>
            <p>${key.charAt(0).toUpperCase() + key.slice(1)}</p>
          </div>
        </div>
      </div>
    `);
  });
</script>

          </div>
        </div>
      </div>  
    </div>
  </section>

  <!-- Book Carousels -->
  <div class="container mt-5"  style=" max-width:1500px;">
    <script>
      lists.forEach(key => {
        document.write(`
          <section class="mb-5">
            <div class="row" style="min-height: 460px;">
              <div class="col-md-2 d-flex flex-column justify-content-center align-items-center">
                <h3 class="fw-bold text-center lh-base mb-5 align-items-center">${key.charAt(0).toUpperCase() + key.slice(1)}</h3>
              </div>
              <div class="col-md-10">
                <div id="carousel-${key}" class="carousel slide" data-bs-ride="carousel">
                  <div class="carousel-inner" id="inner-${key}"></div>

                  <button class="carousel-control-prev" type="button" data-bs-target="#carousel-${key}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#carousel-${key}" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
                </div>
              </div>
            </div>
          </section>
        `);
      });
    </script>
    <script>
      document.addEventListener('DOMContentLoaded', () => {
  // Example slider names — you must define this array somewhere
  // e.g. const lists = ['myfavorites', 'mylibrary', 'myopencover', 'myclosedcover', 'mydustyshelves'];
  lists.forEach(slider => {
    fetch(`get_slider_books.php?slider=${slider}`)
      .then(res => res.json())
      .then(books => {
        document.getElementById(`count-${slider}`).textContent = books.length;
        const inner = document.getElementById(`inner-${slider}`);
        const perSlide = window.innerWidth < 576 ? 1 : window.innerWidth < 768 ? 2 : 4;
        let html = '';
        let cardIndex = 0;

        // Process each book
        books.forEach((book, i) => {
          const bookId = book.book_Id || book.book_id; // تأكد من الحقل الصحيح حسب PHP
          if (!bookId) return;

          fetch(`https://www.googleapis.com/books/v1/volumes/${bookId}`)
            .then(res => res.json())
            .then(data => {
              const volumeInfo = data.volumeInfo || {};
              const title = volumeInfo.title
                ? (volumeInfo.title.length > 30 ? volumeInfo.title.slice(0, 30) + '…' : volumeInfo.title)
                : (book.title || 'No Title');
              const author = volumeInfo.authors
                ? volumeInfo.authors.join(', ')
                : (book.author || 'Unknown Author');
              const thumbnail = volumeInfo.imageLinks?.thumbnail
                ? volumeInfo.imageLinks.thumbnail.replace('http://', 'https://')
                : 'default-book.png';
              const rating = book.averageRating || 0;
              let starRating = '';
for (let i = 1; i <= 5; i++) {
  starRating += `<span
    class="star ${i <= rating ? 'filled' : ''}"
    data-rating="${rating.toFixed(1)}"
  >★</span>`;
}

              // بناء HTML بعد استلام كل كتاب
              if (cardIndex % perSlide === 0) {
                html += `<div class="carousel-item ${cardIndex === 0 ? 'active' : ''}"><div class="row gx-2">`;
              }
              html += `
                <div class="col-md-3 col-sm-6 px-1" style="min-height: 400px;">
                  <a href="book-detail.html?bookId=${bookId}" class="card-link">
                    <div class="card">
                      <img src="${thumbnail}" class="card-img-top" alt="${title}" loading="lazy" onerror="this.onerror=null;this.src='default-book.png';">
                      <div class="card-body">
                        <h5 class="card-title card-link">${title}</h5>
                        <p class="card-text card-link author">${author}</p>
                        <div class="stars" data-rating="${rating}">${starRating}</div>               
                      </div>
                    </div>
                  </a>
                </div>
              `;

              cardIndex++;

              if (cardIndex % perSlide === 0 || cardIndex === books.length) {
                html += `</div></div>`;
              }

              // فقط بعد آخر عنصر يتم رسم المخرجات
              if (cardIndex === books.length) {
                inner.innerHTML = html;
              }
            })
            .catch(err => {
              console.error(`Failed to fetch book info for bookId: ${bookId}`, err);
            });
        });
      })
      .catch(err => console.error(`Failed to load slider: ${slider}`, err));
  });
});

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
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>

</body>
</html>
