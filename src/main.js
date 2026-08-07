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

function handleFooterResize() {
  const isDesktop = window.matchMedia("(min-width: 768px)").matches;
  const detailsElements = document.querySelectorAll("details");
  const accordionGroupName = "footer";

  detailsElements.forEach((detail) => {
    if (isDesktop) {
      detail.removeAttribute("name");

      // Принудительно открываем
      detail.setAttribute("open", "");
    } else {
      detail.setAttribute("name", accordionGroupName);

      detail.removeAttribute("open");
    }
  });
}

// Слушаем изменение размера экрана
window.addEventListener("resize", handleFooterResize);

// Запускаем один раз при загрузке страницы
document.addEventListener("DOMContentLoaded", handleFooterResize);
