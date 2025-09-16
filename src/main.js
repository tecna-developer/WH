import "@a1rth/css-normalize";
import "./scss/style.scss";

//счетчик для корзины
// --- Cart state and helpers -------------------------------------------------

// Retrieve cart from localStorage or start with an empty array
const cart = JSON.parse(localStorage.getItem("cart")) || [];

// Reference to the counter element in the header
const basketCounter = document.querySelector(".cart span:last-child");

// Persist cart and update counter in the DOM
function updateCartCounter() {
  if (basketCounter) {
    basketCounter.textContent = `(${cart.length})`;
  }
  localStorage.setItem("cart", JSON.stringify(cart));
}

// Add item to cart
function addItem(item) {
  cart.push(item);
  updateCartCounter();
}

// Remove item from cart by index
function removeItem(index) {
  if (index >= 0 && index < cart.length) {
    cart.splice(index, 1);
    updateCartCounter();
  }
}

// Initialize counter on page load
updateCartCounter();

// Expose cart API globally (optional for other modules)
window.cart = {
  addItem,
  removeItem,
  items: cart,
};
