// DOM Elements
let booksGrid = document.getElementById("booksGrid");   // قسم New Releases
let booksGrid2 = document.getElementById("booksGrid2"); // قسم Best Sellers

// Event Listeners
document.addEventListener("DOMContentLoaded", loadBooks);
document.addEventListener("click", addToLocalStorage);

// ===== Load Books from DB =====
function loadBooks() {
  fetch("/fetch_books.php") // PHP بترجع JSON من DB
    .then((res) => res.json())
    .then((data) => {
      displayBooks(data, booksGrid);   // New Releases
      displayBooks(data, booksGrid2);  // Best Sellers (نفس الكتب مؤقتاً)
    })
    .catch((err) => console.error("Error fetching books:", err));
}

// ===== Display Books =====
function displayBooks(books, container) {
  if (!container) return;
  container.innerHTML = ""; // clear before append

  const cart = JSON.parse(localStorage.getItem("cart")) || [];

  books.forEach((book) => {
    // book card
    const bookCard = document.createElement("div");
    bookCard.className = "book-card";

    // book image
    const bookImage = document.createElement("img");
    bookImage.className = "book-cover";
    bookImage.src = book.cover_url || "images/placeholder.png";
    bookCard.appendChild(bookImage);

    // info div
    const bookInfo = document.createElement("div");
    bookInfo.className = "book-info";

    // title
    const bookTitle = document.createElement("h3");
    bookTitle.className = "book-title";
    bookTitle.innerText = book.title;

    // author
    const bookAuthor = document.createElement("p");
    bookAuthor.className = "book-author";
    bookAuthor.innerText = `By ${book.author}`;

    // spacer
    const spacer = document.createElement("div");
    spacer.className = "spacer";

    // Add To Cart button
    const addToCart = document.createElement("button");
    addToCart.className = "add-cart";
    addToCart.innerText = "Add To Cart";
    addToCart.dataset.bookId = book.book_id; // مهم للتعامل مع localStorage

    // check if already in cart
    if (cart.some((item) => String(item.id) === String(book.book_id))) {
      addToCart.innerText = "Added to Cart";
      addToCart.disabled = true;
      addToCart.classList.add("disabled");
    }

    // append all
    bookInfo.appendChild(bookTitle);
    bookInfo.appendChild(bookAuthor);
    bookInfo.appendChild(spacer);
    bookInfo.appendChild(addToCart);

    bookCard.appendChild(bookInfo);
    container.appendChild(bookCard);
  });
}

// ===== Add To Cart (LocalStorage) =====
function addToLocalStorage(e) {
  if (!e.target.classList.contains("add-cart")) return;

  const btn = e.target;
  const card = btn.closest(".book-card");
  if (!card) return;

  const id = btn.dataset.bookId;
  const title = card.querySelector(".book-title").innerText.trim();
  const author = card.querySelector(".book-author").innerText.replace(/^By\s*/i, "").trim();
  const cover = card.querySelector(".book-cover").getAttribute("src");

  let cart = JSON.parse(localStorage.getItem("cart") || "[]");

  let existing = cart.find((item) => String(item.id) === String(id));
  if (existing) {
    existing.qty = (existing.qty || 1) + 1;
  } else {
    cart.push({ id: id, title: title, author: author, cover: cover, qty: 1 });
  }

  localStorage.setItem("cart", JSON.stringify(cart));

  btn.innerText = "Added ✓";
  btn.disabled = true;
  btn.classList.add("disabled");
}
