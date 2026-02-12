export default class Slider {
  constructor(
    rootElement,
    {
      track = "",
      nextBtn = "",
      prevBtn = "",
      slidesToShow = "",
      ANIMATION_TIME = 0.5,
      gap = 20,
    } = {},
  ) {
    this.root = rootElement;
    this.track = document.querySelector(track);
    this.nextBtn = document.querySelector(nextBtn);
    this.prevBtn = document.querySelector(prevBtn);
    this.slides = document.querySelectorAll("[data-slide]");
    this.realSlidesCount = this.track.children.length;
    this.ANIMATION_TIME = ANIMATION_TIME;
    this.gap = gap;
    // this.track.style.columnGap = `${gap}px`;
    this.currentIndex = 0;
    this.slidesToShow = slidesToShow || 1;
    this.slideWidth = 0;
    this.maxIndex = this.slides.length - this.slidesToShow;
    // this.cloneElements();

    console.log(this.track);
    console.log(this.slide);

    this.initSlider();

    this.checkResize();
  }

  initSlider() {
    this.updatePosition();
    this.track.style.transition = `none`;
    this.track.style.translate = `-${(this.slideWidth + this.gap) * (this.currentIndex + 1)}px`;

    this.bindEvents();
  }
  updatePosition() {
    this.containerWidth = this.root.clientWidth;
    this.slideWidth = this.containerWidth / this.slidesToShow;
    this.slides.forEach((slide) => {
      slide.style.width = `${this.slideWidth}px`;
    });
  }
  moveSlide() {
    this.track.style.transition = `translate ${this.ANIMATION_TIME}s ease-in-out`;
    this.track.style.translate = `-${(this.slideWidth + this.gap) * (this.currentIndex + 1)}px`;
  }

  // Работа кнопки "назад":
  goToPrevSlide() {
    if (this.currentIndex >= 0) {
      this.currentIndex--;

      this.moveSlide();
    }

    this.track.addEventListener(
      "transitionend",
      () => {
        if (this.currentIndex < 0) {
          this.currentIndex = this.maxIndex;
          this.track.style.transition = `none`;
          this.track.style.translate = `-${(this.slideWidth + this.gap) * (this.currentIndex + 1)}px`;
          this.prevBtn.disabled = false;
        }
      },
      { once: true },
    );
  }

  //Обработка кнопки "вперед":
  goToNextSlide() {
    if (this.currentIndex < this.maxIndex) {
      this.currentIndex++;
      this.moveSlide();
    } else {
      this.nextBtn.disabled = true;
    }

    // обработать быстрый переход в первому слайду обратно
    this.track.addEventListener(
      "transitionend",
      () => {
        if (this.currentIndex >= this.maxIndex) {
          this.currentIndex = 0;
          this.track.style.transition = `none`;
          this.track.style.translate = `-${(this.slideWidth + this.gap) * (this.currentIndex + 1)}px`;
          this.nextBtn.disabled = false;
        }
      },
      { once: true },
    );
  }
  bindEvents() {
    this.prevBtn.addEventListener("click", () => this.goToPrevSlide());

    this.nextBtn.addEventListener("click", () => this.goToNextSlide());
  }
  checkResize() {
    window.addEventListener("resize", () => {
      this.initSlider();
    });
  }
}
