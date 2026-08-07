import { getCartItems, updateCartItemQuantity, removeFromCart } from "./cart";

function formatPrice(value) {
  return `€${value}`;
}

// Статичная разметка иконки — без подстановок, поэтому единственный
// безопасный innerHTML во всём файле
const REMOVE_ICON_MARKUP = `<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <path d="M1 1L13 13M13 1L1 13" stroke="#2C2C2C" stroke-width="1.5" stroke-linecap="round" />
  </svg>`;

// Строки товара сейчас приходят из data-* на карточках, но под WordPress
// это будет название из БД — а значит потенциально чужой ввод. Раньше он
// подставлялся прямо в HTML-шаблон, и кавычка в названии выходила за
// пределы атрибута и выполняла произвольный JS (проверено на кавычке в
// alt). Строим узлы через DOM API: textContent и .src/.alt как свойства
// никогда не парсятся как разметка, так что вставить туда тег или
// обработчик события через данные невозможно
function createCartItemElement(item) {
  const li = document.createElement("li");
  li.className = "cart-item";
  li.dataset.itemId = item.id;

  const product = document.createElement("div");
  product.className = "cart-item__product";

  const thumb = document.createElement("div");
  thumb.className = "cart-item__thumb";
  const img = document.createElement("img");
  img.src = item.image;
  img.alt = item.name;
  thumb.append(img);

  const meta = document.createElement("div");
  meta.className = "cart-item__meta";
  const name = document.createElement("p");
  name.className = "cart-item__name";
  name.textContent = item.name;
  const variant = document.createElement("p");
  variant.className = "cart-item__variant";
  variant.textContent = item.variant;
  meta.append(name, variant);

  product.append(thumb, meta);

  const counter = document.createElement("div");
  counter.className = "cart-item__counter";

  const decreaseBtn = document.createElement("button");
  decreaseBtn.type = "button";
  decreaseBtn.className = "cart-item__counter_btn";
  decreaseBtn.dataset.decrease = "";
  decreaseBtn.setAttribute("aria-label", "Decrease quantity");
  decreaseBtn.textContent = "−";

  const value = document.createElement("span");
  value.className = "cart-item__counter_value";
  value.textContent = String(item.quantity);

  const increaseBtn = document.createElement("button");
  increaseBtn.type = "button";
  increaseBtn.className = "cart-item__counter_btn";
  increaseBtn.dataset.increase = "";
  increaseBtn.setAttribute("aria-label", "Increase quantity");
  increaseBtn.textContent = "+";

  counter.append(decreaseBtn, value, increaseBtn);

  const price = document.createElement("p");
  price.className = "cart-item__price";
  price.textContent = formatPrice(item.price * item.quantity);

  const removeBtn = document.createElement("button");
  removeBtn.type = "button";
  removeBtn.className = "cart-item__remove";
  removeBtn.dataset.remove = "";
  removeBtn.setAttribute("aria-label", `Remove ${item.name} from cart`);
  removeBtn.innerHTML = REMOVE_ICON_MARKUP;

  li.append(product, counter, price, removeBtn);
  return li;
}

function renderCartPage() {
  const list = document.querySelector("[data-cart-list]");
  if (!list) return;

  const emptyMsg = document.querySelector("[data-cart-empty]");
  const summary = document.querySelector("[data-cart-summary]");
  const items = getCartItems();

  if (items.length === 0) {
    list.replaceChildren();
    if (emptyMsg) emptyMsg.hidden = false;
    if (summary) summary.hidden = true;
    return;
  }

  if (emptyMsg) emptyMsg.hidden = true;
  if (summary) summary.hidden = false;

  list.replaceChildren(...items.map(createCartItemElement));

  const subtotal = items.reduce((sum, item) => sum + item.price * item.quantity, 0);
  const subtotalEl = document.querySelector("[data-cart-subtotal]");
  const totalEl = document.querySelector("[data-cart-total]");
  if (subtotalEl) subtotalEl.textContent = formatPrice(subtotal);
  if (totalEl) totalEl.textContent = formatPrice(subtotal);

  list.querySelectorAll("[data-increase]").forEach((btn) => {
    btn.addEventListener("click", () => {
      const id = btn.closest("[data-item-id]").dataset.itemId;
      const item = items.find((i) => i.id === id);
      updateCartItemQuantity(id, item.quantity + 1);
      renderCartPage();
    });
  });

  list.querySelectorAll("[data-decrease]").forEach((btn) => {
    btn.addEventListener("click", () => {
      const id = btn.closest("[data-item-id]").dataset.itemId;
      const item = items.find((i) => i.id === id);
      if (item.quantity <= 1) return;
      updateCartItemQuantity(id, item.quantity - 1);
      renderCartPage();
    });
  });

  list.querySelectorAll("[data-remove]").forEach((btn) => {
    btn.addEventListener("click", () => {
      const id = btn.closest("[data-item-id]").dataset.itemId;
      removeFromCart(id);
      renderCartPage();
    });
  });
}

export function initCartPage() {
  renderCartPage();
}
