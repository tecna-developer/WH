// Корзину рендерит сервер (woocommerce/cart/cart.php), поэтому здесь только
// поведение степпера количества: видимый span для вида, скрытый number-инпут
// — то, что реально уходит в форму. Смена количества сабмитит форму целиком,
// как и клик по "Update cart" в обычном WooCommerce
export function initCartPage() {
  const form = document.querySelector(".cart-page__wrapper");
  if (!form) return;

  form.querySelectorAll(".cart-item").forEach((item) => {
    const value = item.querySelector("[data-counter-value]");
    const input = item.querySelector("[data-counter-input]");
    const decreaseBtn = item.querySelector("[data-decrease]");
    const increaseBtn = item.querySelector("[data-increase]");
    if (!input) return;

    let quantity = Number(input.value) || 1;

    const commit = () => {
      input.value = String(quantity);
      if (value) value.textContent = String(quantity);
      form.requestSubmit();
    };

    decreaseBtn?.addEventListener("click", () => {
      if (quantity <= 1) return;
      quantity -= 1;
      commit();
    });

    increaseBtn?.addEventListener("click", () => {
      quantity += 1;
      commit();
    });
  });
}
