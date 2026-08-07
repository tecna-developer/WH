import "@a1rth/css-normalize";
import Swiper from "swiper";
import { Pagination } from "swiper/modules";
// import Swiper and modules styles
import "swiper/css";
import "swiper/css/pagination";
import "./scss/style.scss";

import Slider from "./js/slider";
import { renderCartCount } from "./js/cart";
import { initProductDetail } from "./js/product-detail";
import { initCartPage } from "./js/cart-page";
import { initCatalogView } from "./js/catalog-view";
import { initQuickAdd } from "./js/quick-add";

//счетчик для корзины
document.addEventListener("DOMContentLoaded", renderCartCount);
document.addEventListener("DOMContentLoaded", initProductDetail);
document.addEventListener("DOMContentLoaded", initCartPage);
document.addEventListener("DOMContentLoaded", initCatalogView);
document.addEventListener("DOMContentLoaded", initQuickAdd);

// Cлайдер через Swiper.js
const heroSliderElement = document.querySelector(".hero__slider");

if (heroSliderElement) {
  new Swiper(heroSliderElement, {
    modules: [Pagination],
    direction: "horizontal",
    loop: true,
    pagination: {
      el: ".hero__slider_pagination",
      clickable: true,
      type: "bullets",
    },
    breakpoints: {
      768: {
        direction: "vertical",
      },
    },
  });
}

//Slider popular products
const sliderElementForPopular = document.querySelector(".popular__slider");

window.addEventListener("DOMContentLoaded", () => {
  if (!sliderElementForPopular) return;

  new Slider(sliderElementForPopular, {
    track: "[data-slider-track]",
    prevBtn: "[data-btn-prev]",
    nextBtn: "[data-btn-next]",
    slidesToShow: 1,
    paginationContainer: ".slider__pagination",
  });
});

//Footer details collaps

// Держим в синхроне с $media-lg из helpers/variables.scss
const footerDesktopQuery = window.matchMedia("(min-width: 768px)");

// До брейкпоинта секции футера работают аккордеоном: name сводит их в группу,
// и браузер сам держит открытой только одну. С брейкпоинта раскрываем все и
// снимаем name, чтобы они были независимы
function syncFooterAccordion() {
  const isDesktop = footerDesktopQuery.matches;

  // Только футерные: голый `details` забирал бы и чужие блоки — сейчас других
  // на страницах нет, но под WordPress их принесёт любой плагин
  document.querySelectorAll(".footer__details").forEach((detail) => {
    if (isDesktop) {
      // name снимаем до открытия: пока элемент в группе, браузер закрывает
      // все остальные, и раскрыть удалось бы лишь последний
      detail.removeAttribute("name");
      detail.open = true;
    } else {
      detail.setAttribute("name", "footer");
      detail.open = false;
    }
  });
}

// change, а не resize: resize на мобильных прилетает и при сворачивании
// адресной строки во время скролла — открытая секция захлопывалась прямо
// под пальцем. change срабатывает только на пересечении брейкпоинта
footerDesktopQuery.addEventListener("change", syncFooterAccordion);

// Запускаем один раз при загрузке страницы
document.addEventListener("DOMContentLoaded", syncFooterAccordion);
