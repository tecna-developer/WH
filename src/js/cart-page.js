import { getCartItems, updateCartItemQuantity, removeFromCart } from "./cart";

function formatPrice(value) {
  return `€${value}`;
}

function renderCartPage() {
  const list = document.querySelector("[data-cart-list]");
  if (!list) return;

  const emptyMsg = document.querySelector("[data-cart-empty]");
  const summary = document.querySelector("[data-cart-summary]");
  const items = getCartItems();

  if (items.length === 0) {
    list.innerHTML = "";
    if (emptyMsg) emptyMsg.hidden = false;
    if (summary) summary.hidden = true;
    return;
  }

  if (emptyMsg) emptyMsg.hidden = true;
  if (summary) summary.hidden = false;

  list.innerHTML = items
    .map(
      (item) => `
      <li class="cart-item" data-item-id="${item.id}">
        <div class="cart-item__product">
          <div class="cart-item__thumb"><img src="${item.image}" alt="${item.name}"></div>
          <div class="cart-item__meta">
            <p class="cart-item__name">${item.name}</p>
            <p class="cart-item__variant">${item.variant}</p>
          </div>
        </div>
        <div class="cart-item__counter">
          <button type="button" class="cart-item__counter_btn" data-decrease aria-label="Decrease quantity">−</button>
          <span class="cart-item__counter_value">${item.quantity}</span>
          <button type="button" class="cart-item__counter_btn" data-increase aria-label="Increase quantity">+</button>
        </div>
        <p class="cart-item__price">${formatPrice(item.price * item.quantity)}</p>
        <button type="button" class="cart-item__remove" data-remove aria-label="Remove ${item.name} from cart">
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M1 1L13 13M13 1L1 13" stroke="#2C2C2C" stroke-width="1.5" stroke-linecap="round" />
          </svg>
        </button>
      </li>`,
    )
    .join("");

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
