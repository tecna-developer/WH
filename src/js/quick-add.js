import { addToCart } from "./cart";

export function initQuickAdd() {
  document.querySelectorAll("[data-quick-add]").forEach((btn) => {
    btn.addEventListener("click", () => {
      addToCart({
        id: btn.dataset.id,
        name: btn.dataset.name,
        variant: btn.dataset.variant,
        price: Number(btn.dataset.price),
        image: btn.dataset.image,
        quantity: 1,
      });
    });
  });
}
