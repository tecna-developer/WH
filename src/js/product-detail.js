import { addToCart } from "./cart";

export function initProductDetail() {
  const root = document.querySelector(".product-detail");
  if (!root) return;

  const tabs = root.querySelectorAll(".product-detail__tab");
  const panels = root.querySelectorAll(".product-detail__tabpanel");

  tabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      tabs.forEach((t) => {
        t.classList.remove("is-active");
        t.setAttribute("aria-selected", "false");
      });
      panels.forEach((panel) => {
        panel.hidden = true;
      });

      tab.classList.add("is-active");
      tab.setAttribute("aria-selected", "true");
      const panel = root.querySelector(`#${tab.getAttribute("aria-controls")}`);
      if (panel) panel.hidden = false;
    });
  });

  const mainPhoto = root.querySelector("[data-main-photo]");
  const thumbs = root.querySelectorAll(".product-detail__thumb");

  thumbs.forEach((thumb) => {
    thumb.addEventListener("click", () => {
      thumbs.forEach((t) => t.classList.remove("is-active"));
      thumb.classList.add("is-active");
      const src = thumb.getAttribute("data-photo");
      if (mainPhoto && src) mainPhoto.src = src;
    });
  });

  const counterValue = root.querySelector("[data-counter-value]");
  const decreaseBtn = root.querySelector("[data-counter-decrease]");
  const increaseBtn = root.querySelector("[data-counter-increase]");
  let quantity = 1;

  const renderQuantity = () => {
    if (counterValue) counterValue.textContent = String(quantity);
  };

  decreaseBtn?.addEventListener("click", () => {
    quantity = Math.max(1, quantity - 1);
    renderQuantity();
  });

  increaseBtn?.addEventListener("click", () => {
    quantity += 1;
    renderQuantity();
  });

  const addToCartBtn = root.querySelector("[data-add-to-cart]");
  addToCartBtn?.addEventListener("click", () => {
    addToCart({
      id: "helgun",
      name: "Helgun",
      variant: "150x200 cm, beige",
      price: 135,
      image: "/src/image/products/product(1).webp",
      quantity,
    });
  });
}
