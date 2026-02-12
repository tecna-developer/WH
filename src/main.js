import "@a1rth/css-normalize";
import "./scss/style.scss";

import Slider from "./js/slider";
// Открытие меню

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

//Slider popular products
const sliderElementForPopular = document.querySelector(".popular__slider");
window.addEventListener("DOMContentLoaded", () => {
  const sliderPopular = new Slider(sliderElementForPopular, {
    track: "[data-slider-track]",
    prevBtn: "[data-btn-prev]",
    nextBtn: "[data-btn-next]",
    slidesToShow: 1,
  });
  sliderPopular.initSlider();
});

//Footer details collaps

function handleFooterResize() {
  const isDesktop = window.matchMedia("(min-width: 768px)").matches;
  const detailsElements = document.querySelectorAll("details");
  const accordionGroupName = "footer";

  detailsElements.forEach((detail) => {
    if (isDesktop) {
      detail.removeAttribute("name");

      // Принудительно открываем
      detail.setAttribute("open", "");
    } else {
      detail.setAttribute("name", accordionGroupName);

      detail.removeAttribute("open");
    }
  });
}

// Слушаем изменение размера экрана
window.addEventListener("resize", handleFooterResize);

// Запускаем один раз при загрузке страницы
document.addEventListener("DOMContentLoaded", handleFooterResize);
