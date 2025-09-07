let booksGrid = document.getElementById("booksGrid");
let booksGrid2 = document.getElementById("booksGrid2");
let addToCart;
let bookInfo;
let book;
document.addEventListener("DOMContentLoaded", loadNew);
document.addEventListener("DOMContentLoaded", loadBest);
document.addEventListener("click", addToLocalStorage);
document.addEventListener("click", showBookInfo);

function loadNew() {
  // Extract API Data
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      var book = xhr.responseText;
      displayNew(book);
    }
  };
  var url = "https://openlibrary.org/search.json?q=new+releases&limit=8";
  xhr.open("get", url, true);
  xhr.send();
}
function displayNew(p) {
  var jsonData = JSON.parse(p);
  var bookData = jsonData.docs;
  for (let i = 0; i < bookData.length; i++) {
    // Create book Container
    var bookCard = document.createElement("div");
    bookCard.className = "book-card";
    var bookImage = document.createElement("img");
    bookImage.className = "book-cover";
    var coverId = jsonData.docs[i].cover_i;
    bookImage.src = `https://covers.openlibrary.org/b/id/${coverId}-L.jpg`;
    bookCard.appendChild(bookImage);
    // Create Info Card
    let bookInfo = document.createElement("div");
    bookInfo.className = "book-info";
    let bookTitle = document.createElement("h3");
    bookTitle.className = "book-title";
    bookTitle.innerText = jsonData.docs[i].title;
    let bookAuthor = document.createElement("p");
    bookAuthor.className = "book-author";
    bookAuthor.innerText = `By ${jsonData.docs[i].author_name}`;
    // Create Spacer
    let spacer = document.createElement("div");
    spacer.className = "spacer";
    //Add To Cart Button
    let addToCart = document.createElement("button");
    addToCart.className = "add-cart";
    addToCart.innerText = "Add To Cart";
    // check if book checked befor reload
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let coverIdStr = String(coverId);
    if (cart.some((book) => book.id === coverIdStr)) {
      addToCart.innerText = "Added to Cart";
      addToCart.disabled = true;
      addToCart.classList.add("disabled");
    }
    // Append Data
    bookInfo.appendChild(bookTitle);
    bookInfo.appendChild(bookAuthor);
    bookCard.appendChild(bookInfo);
    bookInfo.appendChild(spacer);
    bookInfo.appendChild(addToCart);
    booksGrid2.append(bookCard);
  }
}
// BestSellers Section
// Extract API Data
function loadBest() {
  var xhr2 = new XMLHttpRequest();
  xhr2.onreadystatechange = function () {
    if (xhr2.readyState == 4 && xhr2.status == 200) {
      var book = xhr2.responseText;
      displayBest(book);
    }
  };
  var url = "https://openlibrary.org/search.json?q=bestsellers&limit=20";
  xhr2.open("get", url, true);
  xhr2.send();
}
function displayBest(p) {
  var jsonData = JSON.parse(p);
  var bookData = jsonData.docs;
  for (let i = 0; i < bookData.length; i++) {
    // Create book Container
    var bookCard = document.createElement("div");
    bookCard.className = "book-card";
    var bookImage = document.createElement("img");
    bookImage.className = "book-cover";
    var coverId = jsonData.docs[i].cover_i;
    bookImage.src = `https://covers.openlibrary.org/b/id/${coverId}-L.jpg`;
    bookCard.appendChild(bookImage);
    // Create Info Card
    let bookInfo = document.createElement("div");
    bookInfo.className = "book-info";
    let bookTitle = document.createElement("h3");
    bookTitle.className = "book-title";
    bookTitle.innerText = jsonData.docs[i].title;
    let bookAuthor = document.createElement("p");
    bookAuthor.className = "book-author";
    bookAuthor.innerText = `By ${jsonData.docs[i].author_name}`;
    // Create Spacer
    let spacer = document.createElement("div");
    spacer.className = "spacer";
    //Add To Cart Button
    let addToCart = document.createElement("button");
    addToCart.className = "add-cart";
    addToCart.innerText = "Add To Cart";
    // check if book checked befor reload
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let coverIdStr = String(coverId);
    if (cart.some((book) => book.id === coverIdStr)) {
      addToCart.innerText = "Added to Cart";
      addToCart.disabled = true;
      addToCart.classList.add("disabled");
    }
    // Append Data
    bookInfo.appendChild(bookTitle);
    bookInfo.appendChild(bookAuthor);
    bookCard.appendChild(bookInfo);
    bookInfo.appendChild(spacer);
    bookInfo.appendChild(addToCart);
    booksGrid.append(bookCard);
  }
}
//Event functions
function addToLocalStorage(e) {
  if (e.target.classList.contains("add-cart")) {
    const bookCard = e.target.closest(".book-card");
    const title = bookCard.querySelector(".book-title").innerText;
    const imageSrc = bookCard.querySelector(".book-cover").src;
    const coverId = imageSrc.match(/\/b\/id\/(\d+)-L\.jpg/)[1];
    const newBook = {
      title: title,
      image: imageSrc,
      id: coverId,
    };

    // // Initialize Array
    let cart = [];
    if (localStorage.getItem("cart")) {
      cart = JSON.parse(localStorage.getItem("cart"));
    }
    const exists = cart.some((book) => book.id === newBook.id);
    if (!exists) {
      cart.push(newBook);
      localStorage.setItem("cart", JSON.stringify(cart));

      e.target.innerText = "Added To Cart";
      e.target.disabled = true;
      e.target.classList.add("disabled");

    }
  }
}

  function showBookInfo(e) {
  if (e.target.classList.contains("book-cover")) {
    const bookCard = e.target.closest(".book-card");
    const title = bookCard.querySelector(".book-title").innerText;
    const imageSrc = e.target.src;

    // set Data to local storage
    localStorage.setItem(
      "selectedBook",
      JSON.stringify({ title: title, image: imageSrc })
    );
    // Single book page
    window.location.href = "singleBookPage.html";
  }
}
  
