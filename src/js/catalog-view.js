export function initCatalogView() {
  const wrapper = document.querySelector(".catalog__wrapper");
  // Кнопки ищем по data-view, а не по aria-label: под WordPress подпись
  // уходит в перевод, и селектор по ней молча перестал бы находить кнопки —
  // без ошибки в консоли, просто переключение вида перестало бы работать
  const buttons = document.querySelectorAll("[data-view]");
  if (!wrapper || !buttons.length) return;

  function setView(view) {
    wrapper.classList.toggle("is-list", view === "list");

    buttons.forEach((btn) => {
      const isActive = btn.dataset.view === view;
      btn.classList.toggle("is-active", isActive);
      btn.setAttribute("aria-pressed", String(isActive));
    });
  }

  buttons.forEach((btn) => {
    btn.addEventListener("click", () => setView(btn.dataset.view));
  });
}
