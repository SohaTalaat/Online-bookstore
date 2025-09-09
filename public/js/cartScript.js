window.onload = function () {
  var cartItem = JSON.parse(localStorage.getItem("cart")) || []; // extract data
  var cartPage = document.querySelector(".cart-page");
  var cartSummary = document.querySelector(".cart-summary");

  if (cartItem.length === 0) {
    cartPage.innerHTML = "<h2 class='empty'> Your cart is empty </h2>";
    cartSummary.innerHTML = "";
    return;
  }

  var subtotal = 0;

  for (let i = 0; i < cartItem.length; i++) {
    var item = cartItem[i];
    var title = item.title;
    var cover = item.image;
    var price = Math.floor(Math.random() * 40) + 10;

    cartPage.innerHTML += `
      <div class="cart-item">
    <img src="${cover}" alt="${title}" />
      <div class="cart-info">
      <h2>${title}</h2>
      <p>Price: $${price}</p>
      <p>Quantity: 1</p>
    </div>
    <div class="quantity-selector">
      <button class="qtyminus-btn">-</button>
      <span class="qty-number">1</span>
      <button class="qtyadd-btn">+</button>
    </div>
    <button class="remove-btn">Remove</button>
  </div>
`;
    subtotal += price;
  }

  cartSummary.innerHTML = `
    <p>Subtotal: $${subtotal}</p>
    <p>Total: $${subtotal}</p>
    <button class="checkout-btn">Checkout</button>
  `;
  removeButton(cartItem);
  plusMinus();

  var checkoutBtn = document.querySelector(".checkout-btn");  // to checkout and display that the shopping is done and storage being free
  if (checkoutBtn) {
    checkoutBtn.addEventListener("click", function () {
      localStorage.removeItem("cart");

      cartPage.innerHTML = `
        <div class="confirmation-message">
          <h2>✅ Your order is confirmed!</h2>
          <p>Thank you for shopping with us.</p>
        </div>
      `;
    });
  }
};

var rmvbutton = document.querySelectorAll(".remove-btn");
console.log(rmvbutton);

function removeButton(cartItem) {
  // remove from DOM Content
  var rmvbutton = document.querySelectorAll(".remove-btn");
  for (let i = 0; i < rmvbutton.length; i++) {
    rmvbutton[i].addEventListener("click", function () {
      var itemDiv = this.closest(".cart-item");
      const itemIndex = Array.from(document.querySelectorAll(".cart-item")).indexOf(itemDiv);

      if (itemIndex !== -1) {
        cartItem.splice(itemIndex, 1);
        localStorage.setItem("cart", JSON.stringify(cartItem));
      }

      if (cartItem.length === 0) {
        location.reload();
      }
      itemDiv.remove();

    });
  }
}

// decrement and increment product "book"
function plusMinus() {
  var item = document.querySelectorAll(".cart-item");
  item.forEach(element => {
    var qtyplus = element.querySelector(".qtyadd-btn");
    var minus = element.querySelector(".qtyminus-btn");
    var quantity = element.querySelector(".qty-number");
    var quantityText = element.querySelector(".cart-info p:nth-child(3)"); // in display <p>Quantity: 1</p>

    qtyplus.addEventListener("click", function () { // increment + 
      let qty = parseInt(quantity.textContent);
      qty = qty + 1;
      quantity.textContent = qty;
      quantityText.textContent = `Quantity: ${qty}`;
    });

    minus.addEventListener("click", function () {  // decrement - 
      let qty = parseInt(quantity.textContent);
      if (qty > 1) {
        qty = qty - 1;
        quantity.textContent = qty;
        quantityText.textContent = `Quantity: ${qty}`;
      }
    });
  });
}
