<?php include __DIR__ . '/../includes/header.php'; ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/responsive.css" />
  <link rel="stylesheet" href="css/all.min.css" />
  <title>Book Store</title>
</head>

<body>
  <!-- Start Hero Section -->
  <section class="hero">
    <img src="assets/hero.jpg" alt="" class="bckgrnd" />
    <button class="discover"><a href="#discover">Discover More</a></button>
    <h3>Find New and Used Books!</h3>
  </section>
  <!-- End Hero Section -->
  <!-- Start New Releases -->
  <section class="books-section" id="discover">
    <div class="container">
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
      <div class="view-all" id="viewAll">
        <a href="shop.html">View All</a>
      </div>
    </div>
  </section>
  <!-- End New Releases -->
  <!-- Start BestSellers -->
  <section class="books-section" id="discover">
    <div class="container">
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
      <div class="books-grid" id="booksGrid2"></div>
      <div class="view-all" id="viewAll">
        <a href="shop.html">View All</a>
      </div>
    </div>
  </section>
  <!-- End BestSellers -->
  <!-- Start Blog & News -->
  <section class="news-section">
    <div class="container">
      <div class="section-header">
        <h2>Blog & News</h2>
        <div class="view-options">
          <button class="view-btn active" data-view="grid">
            <i class="fas fa-th"></i>
          </button>
          <button class="view-btn" data-view="list">
            <i class="fas fa-list"></i>
          </button>
        </div>
      </div>
      <div class="news-grid">
        <div class="news-card">
          <img src="assets/book1.jpg" alt="" />
          <div class="news-info">
            <button>Blog</button>
            <h3>Book Club</h3>
            <p>
              A Book Club Is A Place Where Books Bring People Together. We
              Read, Discuss And Get Inspired. Join US!
            </p>
          </div>
        </div>
        <div class="news-card">
          <img src="assets/book2.jpg" alt="" />
          <div class="news-info">
            <button>News</button>
            <h3>Book Club</h3>
            <p>
              A Book Club Is A Place Where Books Bring People Together. We
              Read, Discuss And Get Inspired. Join US!
            </p>
          </div>
        </div>
        <div class="news-card">
          <img src="assets/book3.jpg" alt="" />
          <div class="news-info">
            <button>Blog</button>
            <h3>Book Club</h3>
            <p>
              A Book Club Is A Place Where Books Bring People Together. We
              Read, Discuss And Get Inspired. Join US!
            </p>
          </div>
        </div>
      </div>
      <div class="view-all" id="viewAll">
        <a href="shop.html">View All</a>
      </div>
    </div>
  </section>
  <!-- End Blog & News -->
  <!-- Start Clients Section -->
  <section class="clients-section">
    <div class="container">
      <h2>What Our Clients Say</h2>
      <div class="posts-grid">
        <div class="post">
          <div class="post-head">
            <img src="assets/team-01.png" alt="" />
            <h3 class="user">Chance Mango</h3>
          </div>
          <div class="post-body">
            <p>
              User-Friendly site, responsive support, and lots of hidden
              literary treausres. Love ordering from here.
            </p>
          </div>
        </div>
        <div class="post">
          <div class="post-head">
            <img src="assets/team-02.png" alt="" />
            <h3 class="user">Lydia Rhiel Madsen</h3>
          </div>
          <div class="post-body">
            <p>
              A charming online bookstore with unique titles and fast service.
              Highly recommended!
            </p>
          </div>
        </div>
        <div class="post">
          <div class="post-head">
            <img src="assets/team-03.png" alt="" />
            <h3 class="user">Maren Herwitz</h3>
          </div>
          <div class="post-body">
            <p>
              Beautifully designed weebsite with a peacefully vibe. The
              perfect place to discover your next favourite book from home.
            </p>
          </div>
        </div>
        <div class="post">
          <div class="post-head">
            <img src="assets/team-04.png" alt="" />
            <h3 class="user">Ruben Calzoni</h3>
          </div>
          <div class="post-body">
            <p>
              Everything i order came just as described. Love the qulaity and
              care.
            </p>
          </div>
        </div>
        <div class="post">
          <div class="post-head">
            <img src="assets/team-05.png" alt="" />
            <h3 class="user">Marcus Aminoff</h3>
          </div>
          <div class="post-body">
            <p>
              A book lover's dream! So many categories and hidden gems to
              explore.
            </p>
          </div>
        </div>
        <div class="post">
          <div class="post-head">
            <img src="assets/team-01.png" alt="" />
            <h3 class="user">Lydia Rosser</h3>
          </div>
          <div class="post-body">
            <p>
              Fast, friendly, and great reads. Highly satisfied with every
              order.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Clients Section -->
  <?php require_once __DIR__ . '/../includes/footer.php'; ?>
  <!-- Script -->
  <script src="js/script.js"></script>
  <!-- Script -->
</body>

</html>