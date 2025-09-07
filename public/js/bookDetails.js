function req() {
  var jsonData;
  var book;
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      book = xhr.responseText;
      display_recom_books(book);
    }
  };

  var url = "https://openlibrary.org/search.json?q=new+releases&limit=50";
  xhr.open("get", url, true);
  xhr.send();
}

function display_recom_books(p) {
  jsonData = JSON.parse(p);
  var bookimage;
  var coverId;
  var author_name;
  var title;
  for (let i = 0; i < 3; i++) {
    bookimage = document.getElementById("image" + i);
    coverId = jsonData.docs[i].cover_i;
    bookimage.src = `https://covers.openlibrary.org/b/id/${coverId}-L.jpg`;
    author_name = document.getElementById("auth" + i);
    author_name.innerText = jsonData.docs[i].author_name;
    title = document.getElementById("tit" + i);
    title.innerText = jsonData.docs[i].title;
  }
}
req();
function recom_book_det(event) {
  //  req();
  var bookimg;
  var booktit;
  var bookauth;
  var coverId;
  var label;
  let class_name = event.target.id;

  for (let i = 0; i < 3; i++) {
    if (class_name == "image" + i) {
      bookimg = document.getElementById("mainimg");
      coverId = jsonData.docs[i].cover_i;
      bookimg.src = `https://covers.openlibrary.org/b/id/${coverId}-L.jpg`;
      booktit = document.getElementById("bookname");
      label = document.getElementById("label");
      booktit.innerText = jsonData.docs[i].title;
      label.innerText = jsonData.docs[i].title;
      bookauth = document.getElementById("authorname");
      bookauth.innerText = jsonData.docs[i].author_name;
    }
  }
}

document.addEventListener("DOMContentLoaded", () => {
  var label;
  var data_book;
  var book;
  const storedData = localStorage.getItem("selectedBook");
  var bookimg;
  var title;
  if (storedData) {
    data_book = JSON.parse(storedData);
    console.log(data_book);
    bookimg = document.getElementById("mainimg");
    bookimg.src = data_book.image;
    title = document.getElementById("bookname");
    title.innerText = data_book.title;
    label = document.getElementById("label");
    label.innerText = data_book.title;
  }
});
