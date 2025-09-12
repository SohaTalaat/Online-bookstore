<?php
include __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../models/book.php';

$bookModel = new Book();
$stmt = $bookModel->getAllBooks();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mass Store</title>
  <link rel="stylesheet" href="css/shop.css" />
  <link rel="stylesheet" href="css/responsive.css" />
  <link rel="stylesheet" href="css/all.min.css" />
</head>

<body>
  <!-- start page -->
  <div class="container">
    <!-- start filter -->
    <div id="filter">
      <h3>Filter</h3>
      <input type="checkbox" name="bestseller" id="bestseller" /><label
        for="bestseller">Bestseller</label><br />
      <input type="checkbox" name="newreleases" id="newreleases" /><label
        for="newreleases">New Releases</label><br />
      <input type="checkbox" name="awaiting" id="awaiting" /><label
        for="awaiting">Awaiting</label><br />
      <input type="checkbox" name="discounted" id="discounted" /><label
        for="discounted">Discounted</label><br />

      <h3>Genre</h3>
      <input type="checkbox" name="horror" id="horror" /><label for="horror">Horror</label><br />
      <input type="checkbox" name="thrillers" id="thrillers" /><label
        for="thrillers">Thrillers</label><br />
      <input type="checkbox" name="prose" id="prose" /><label for="prose">Prose</label><br />
      <input type="checkbox" name="science" id="science" /><label
        for="science">Science Fiction</label><br />
      <input type="checkbox" name="romance" id="romance" /><label
        for="romance">Romance Novels</label><br />
      <input type="checkbox" name="detectives" id="detectives" /><label
        for="detectives">Detectives</label><br />
      <input type="checkbox" name="fiction" id="fiction" /><label
        for="fiction">Fiction</label><br />
      <input type="checkbox" name="psychology" id="psychology" /><label
        for="psychology">Psychology</label><br />
      <input type="checkbox" name="business" id="business" /><label
        for="business">Business and Motivation</label><br />
      <input type="checkbox" name="children" id="children" /><label
        for="children">Children's Books </label><br />

      <h3>Language</h3>
      <input type="checkbox" name="english" id="english" /><label
        for="english">English</label><br />
      <input type="checkbox" name="arabic" id="arabic" /><label for="arabic">Arabic</label><br />

      <h3>Book Type</h3>
      <input type="checkbox" name="paper" id="paper" /><label for="paper">Paper</label><br />
      <input type="checkbox" name="ebook" id="ebook" /><label for="ebook">E-book</label><br />

      <h3>Publisher</h3>
      <input type="search" placeholder="Publisher Search" /><br />

      <h3>Price</h3>
      <input type="search" placeholder="From" />
      <input type="search" placeholder="To" /><br />

      <br />
      <input type="button" value="Search" id="search" /><br />
    </div>
    <!-- end filter -->

    <!-- start books grids -->
    <!-- start New Releases -->
    <div class="divofsections">
      <section class="books-section" id="discover">
        <div class="sub-container">
          <div class="section-header">
            <h2>New Releases</h2>
            <div class="view-options">
              <button class="view-btn active" data-view="grid">
                <i class="fas fa-th"></i>
              </button>
              <button class="view-btn" data-view="list">
                <i class="fas fa-list"></i>
              </button>
            </div>
          </div>
          <div class="books-grid" id="booksGrid"></div>
        </div>
      </section>
      <!-- End New Releases -->

      <!-- Start BestSellers -->
      <section class="books-section" id="discover">
        <div class="sub-container">
          <div class="section-header">
            <h2>BestSellers</h2>
            <div class="view-options">
              <button class="view-btn active" data-view="grid">
                <i class="fas fa-th"></i>
              </button>
              <button class="view-btn" data-view="list">
                <i class="fas fa-list"></i>
              </button>
            </div>
          </div>
          <div class="books-grid">
            <?php if (!empty($books)): ?>
              <?php foreach ($books as $row): ?>
                <div class="book-card">
                  <!-- صورة الغلاف -->
                  <img class="book-cover"
                    src="<?php echo htmlspecialchars($row['cover_url'] ?? 'images/placeholder.jpg'); ?>"
                    alt="<?php echo htmlspecialchars($row['title']); ?>">

                  <!-- معلومات الكتاب -->
                  <div class="book-info">
                    <!-- العنوان (مغلف برابط لصفحة الكتاب الفردية) -->
                    <h3 class="book-title">
                      <a href="singleBookPage.php?id=<?php echo (int)$row['book_id']; ?>">
                        <?php echo htmlspecialchars($row['title']); ?>
                      </a>
                    </h3>

                    <!-- اسم المؤلف (مسبقاً بـ "By ") -->
                    <p class="book-author">By <?php echo htmlspecialchars($row['author']); ?></p>

                    <div class="spacer"></div>

                    <!-- زر الإضافة للسلة: نضع data-book-id ليتعامل معه JS -->
                    <button class="add-cart" data-book-id="<?php echo (int)$row['book_id']; ?>">
                      Add To Cart
                    </button>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <p>No books found.</p>
            <?php endif; ?>
          </div>
        </div>
      </section>
    </div>
    <!-- End BestSellers -->
    <script src="js/shop.js"></script>
  </div>
  <!-- Start Footer -->
  <footer>
    <div class="footer-content">
      <div class="footer-section">
        <h3>BookStore</h3>
        <p>
          Your Trusted Partner for Finding The Perfect Book. Discover, Read,
          and Grow With Us.
        </p>
        <div class="social">
          <a href="#"><i class="fab fa-facebook"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-linkedin"></i></a>
        </div>
      </div>
      <div class="footer-section">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="#">Home</a></li>
          <li><a href="#">Categories</a></li>
          <li><a href="#">Bestsellers</a></li>
          <li><a href="#">New Arrivals</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h4>Customer Service</h4>
        <ul>
          <li><a href="#">Contact Us</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Shipping Info</a></li>
          <li><a href="#">Returns</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h4>Stay In The Loop</h4>
        <p>
          Subscribe to Our Newsletter and be The First To Know About New
          Arrivals. Enter Your E-mail Below.
        </p>
        <div class="email-input">
          <input
            type="email"
            name="mail"
            id="mail"
            placeholder="Your Email Address" />
          <button class="subscribe">Send</button>
        </div>
      </div>
    </div>
    <div class="bottom">
      <p>&copy; 2025 BookStore. All Rights Reserved.</p>
    </div>
  </footer>
  <!-- End Footer -->
</body>

</html>