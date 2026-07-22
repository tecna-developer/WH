export function initCatalogView() {
  const wrapper = document.querySelector(".catalog__wrapper");
  const gridBtn = document.querySelector('.filters__view-btn[aria-label="Grid view"]');
  const listBtn = document.querySelector('.filters__view-btn[aria-label="List view"]');
  if (!wrapper || !gridBtn || !listBtn) return;

  function setView(isList) {
    wrapper.classList.toggle("is-list", isList);

    gridBtn.classList.toggle("is-active", !isList);
    gridBtn.setAttribute("aria-pressed", String(!isList));

    listBtn.classList.toggle("is-active", isList);
    listBtn.setAttribute("aria-pressed", String(isList));
  }

  gridBtn.addEventListener("click", () => setView(false));
  listBtn.addEventListener("click", () => setView(true));
}
