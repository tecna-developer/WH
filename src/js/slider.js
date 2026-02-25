export default class Slider {
  constructor(
    rootElement,
    {
      track = "",
      nextBtn = "",
      prevBtn = "",
      slidesToShow = "",
      ANIMATION_TIME = 0.5,
      paginationContainer = "",
    } = {},
  ) {
    this.root = rootElement;
    this.track = this.root.querySelector(track);
    this.nextBtn = this.root.querySelector(nextBtn);
    this.prevBtn = this.root.querySelector(prevBtn);
    this.slides = this.root.querySelectorAll("[data-slide]");
    this.paginationContainer = this.root.querySelector(paginationContainer);
    this.ANIMATION_TIME = ANIMATION_TIME;

    this.currentIndex = 0;
    this.slidesToShow = slidesToShow;
    this.slideWidth = 0;
    this.maxIndex = this.slides.length - this.slidesToShow;

    this.initSlider();
  }
  updateDimensions() {
    this.containerWidth = this.root.offsetWidth;
    this.slideWidth = this.containerWidth / this.slidesToShow;
    this.slides.forEach((slide) => {
      slide.style.width = `${this.slideWidth}px`;
    });
    this.maxIndex = this.slides.length - this.slidesToShow;
  }

  initSlider() {
    this.checkAdaptive();

    this.bindEvents();
    this.moveSlide(false);
    this.renderPagination();
  }

  moveSlide(animate = true) {
    if (animate) {
      this.track.style.transition = `translate ${this.ANIMATION_TIME}s ease-in-out`;
    } else {
      this.track.style.transition = "none";
    }

    this.track.style.translate = `-${this.slideWidth * this.currentIndex}px`;
    this.updateDots();
  }

  // Работа кнопки "назад":
  goToPrevSlide() {
    if (this.currentIndex > 0) {
      this.currentIndex--;

      this.moveSlide();
    }
  }

  //Обработка кнопки "вперед":
  goToNextSlide() {
    if (this.currentIndex < this.maxIndex) {
      this.currentIndex++;
      this.moveSlide();
    }
  }

  //Пагинация

  renderPagination() {
    this.paginationContainer.innerHTML = "";

    this.dots = [];
    const dotsCount = this.maxIndex + 1;

    for (let i = 0; i < dotsCount; i++) {
      const dot = document.createElement("button");
      dot.classList.add("slider__pagination_dot");

      if (i === this.currentIndex) {
        dot.classList.add("active");
      }

      dot.addEventListener("click", () => {
        this.currentIndex = i;
        this.moveSlide();
      });
      this.paginationContainer.appendChild(dot);
      this.dots.push(dot);
    }
  }
  // setStylesForActive(){
  //   if ()
  // }

  updateDots() {
    // Пробегаемся по всем точкам
    this.dots.forEach((dot, index) => {
      // Если номер точки совпадает с текущим слайдом — активна
      if (index === this.currentIndex) {
        dot.classList.add("active");
      } else {
        dot.classList.remove("active");
      }
    });
  }
  //Все события
  bindEvents() {
    this.prevBtn.addEventListener("click", () => this.goToPrevSlide());

    this.nextBtn.addEventListener("click", () => this.goToNextSlide());

    window.addEventListener("resize", () => {
      this.checkAdaptive();
    });
  }

  // Проверяем размер экрана для адаптивности
  checkAdaptive() {
    const width = window.innerWidth;

    if (width >= 1000) {
      this.slidesToShow = 3;
    } else if (width >= 480) {
      this.slidesToShow = 2;
    } else {
      this.slidesToShow = 1;
    }
    this.updateDimensions();
    this.renderPagination();

    this.currentIndex = 0;
    this.moveSlide();

    if (this.currentIndex > this.maxIndex) {
      this.currentIndex = this.maxIndex;
    }

    this.moveSlide(false);
  }
}
