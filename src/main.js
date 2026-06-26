import "@a1rth/css-normalize";
import Swiper from "swiper";
import { Navigation, Pagination } from "swiper/modules";
// import Swiper and modules styles
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import "./scss/style.scss";

import Slider from "./js/slider";

// // Открытие меню

// const burgerBtnElement = document.querySelector(".header__left_burger"),
//   menuElement = document.querySelector(".menu"),
//   closeBtnElement = document.querySelector(".menu__close");

// burgerBtnElement.addEventListener("click", () => {
//   menuElement.classList.add("active");
//   document.body.style.overflow = "hidden";
// });

// if (closeBtnElement) {
//   closeBtnElement.addEventListener("click", () => {
//     menuElement.classList.remove("active");
//     document.body.style.overflow = "";
//   });
// }

// window.addEventListener("scroll", () => {
//   const headerElement = document.querySelector(".header");
//   if (scrollY > 10) {
//     headerElement.classList.add("header_scrolled");
//   } else {
//     headerElement.classList.remove("header_scrolled");
//   }
// });

// Открытие модального окна с формой поиска
window.addEventListener("DOMContentLoaded", () => {
  const openSearchElement = document.querySelector(".header__right_search");
  const searchOverlay = document.querySelector(".search__overlay");
  const closeModalFormBtn = document.querySelector(".search__modal_close");

  if (!openSearchElement || !searchOverlay) return;

  openSearchElement.addEventListener("click", () => {
    searchOverlay.classList.add("is-active");
    searchOverlay.setAttribute("aria-hidden", "false");
    const input = searchOverlay.querySelector(".search__input");
    if (input) input.focus();
  });

  if (closeModalFormBtn) {
    closeModalFormBtn.addEventListener("click", () => {
      searchOverlay.classList.remove("is-active");
      searchOverlay.setAttribute("aria-hidden", "true");
    });
  }

  // Закрытие по клику на фон
  searchOverlay.addEventListener("click", (e) => {
    if (e.target === searchOverlay) {
      searchOverlay.classList.remove("is-active");
      searchOverlay.setAttribute("aria-hidden", "true");
    }
  });

  // Закрытие по Escape
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && searchOverlay.classList.contains("is-active")) {
      searchOverlay.classList.remove("is-active");
      searchOverlay.setAttribute("aria-hidden", "true");
    }
  });
});

//счетчик для корзины
// --- Cart state and helpers -------------------------------------------------

// Cлайдер через Swiper.js
const heroSlider = new Swiper(".hero__slider", {
  modules: [Navigation, Pagination],
  // Настройки для мобильных устройств (по умолчанию)
  direction: "horizontal",
  loop: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    type: "bullets",
    dynamicBullets: true,
  },

  // Адаптив
  breakpoints: {
    // Когда ширина экрана >= 768px
    768: {
      direction: "vertical",
      clickable: true,
      type: "bullets",
      dynamicBullets: true,
    },
  },

  // Обновление при изменении размера окна
  on: {
    resize: function () {
      this.update(); // Принудительно обновляем параметры при ресайзе
    },
  },
});

//Slider popular products
const sliderElementForPopular = document.querySelector(".popular__slider");
window.addEventListener("DOMContentLoaded", () => {
  const sliderPopular = new Slider(sliderElementForPopular, {
    track: "[data-slider-track]",
    prevBtn: "[data-btn-prev]",
    nextBtn: "[data-btn-next]",
    slidesToShow: 1,
    paginationContainer: ".slider__pagination",
  });
  sliderPopular.initSlider();
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
