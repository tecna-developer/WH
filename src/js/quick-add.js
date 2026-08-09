// Настоящее добавление в корзину через AJAX-эндпоинт WooCommerce — тот же,
// что использует её собственный wc-add-to-cart.js. data-id на кнопке теперь
// настоящий ID товара (см. woocommerce/content-product.php), а не строковый
// слаг из статики
export function initQuickAdd() {
  const buttons = document.querySelectorAll("[data-quick-add]");
  if (!buttons.length || typeof wc_add_to_cart_params === "undefined") return;

  const endpoint = wc_add_to_cart_params.wc_ajax_url
    .toString()
    .replace("%%endpoint%%", "add_to_cart");

  buttons.forEach((btn) => {
    btn.addEventListener("click", async () => {
      btn.disabled = true;

      try {
        const response = await fetch(endpoint, {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: new URLSearchParams({
            product_id: btn.dataset.id,
            quantity: "1",
          }),
        });
        const data = await response.json();

        if (data.error) return;

        // Тот же формат, что отдаёт woocommerce_add_to_cart_fragments —
        // обновляем счётчик корзины без перезагрузки страницы
        Object.entries(data.fragments ?? {}).forEach(([selector, html]) => {
          document.querySelectorAll(selector).forEach((el) => {
            el.outerHTML = html;
          });
        });
      } catch {
        // Молча: неудачное быстрое добавление не должно ронять страницу —
        // покупатель всегда может добавить товар со страницы товара
      } finally {
        btn.disabled = false;
      }
    });
  });
}
