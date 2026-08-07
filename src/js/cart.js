const CART_ITEMS_KEY = "wh_cart_items";

function readCart() {
  try {
    const raw = localStorage.getItem(CART_ITEMS_KEY);
    const items = raw ? JSON.parse(raw) : [];
    return Array.isArray(items) ? items : [];
  } catch {
    return [];
  }
}

function writeCart(items) {
  // localStorage.setItem бросает в приватном режиме Safari и при
  // переполнении квоты. Без try/catch исключение вылетало бы прямо из
  // обработчика клика — addToCart/updateCartItemQuantity/removeFromCart
  // все вызывают writeCart синхронно, и клик по "+", "−" или иконке
  // корзины падал бы молча, без единого следа в интерфейсе
  try {
    localStorage.setItem(CART_ITEMS_KEY, JSON.stringify(items));
    return true;
  } catch (err) {
    console.warn("WH: couldn't save the cart", err);
    return false;
  }
}

export function getCartItems() {
  return readCart();
}

export function getCartCount() {
  return readCart().reduce((sum, item) => sum + item.quantity, 0);
}

export function addToCart(product) {
  const items = readCart();
  const existing = items.find((item) => item.id === product.id);
  if (existing) {
    existing.quantity += product.quantity;
  } else {
    items.push(product);
  }
  writeCart(items);
  renderCartCount();
}

export function updateCartItemQuantity(id, quantity) {
  const items = readCart();
  const item = items.find((i) => i.id === id);
  if (!item) return;
  item.quantity = Math.max(1, quantity);
  writeCart(items);
  renderCartCount();
}

export function removeFromCart(id) {
  writeCart(readCart().filter((item) => item.id !== id));
  renderCartCount();
}

export function renderCartCount() {
  const count = getCartCount();
  document.querySelectorAll("[data-cart-count]").forEach((el) => {
    el.textContent = count > 0 ? ` (${count})` : "";
  });
}
