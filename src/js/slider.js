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
    this.slide = document.querySelector("[data-slide]");
    this.realSlidesCount = this.slide.children.length;
    this.ANIMATION_TIME = ANIMATION_TIME;
    this.gap = gap;
    this.slide.style.columnGap = `${gap}px`;
    this.currentIndex = 0;
    this.slidesToShow = slidesToShow || 1;

    console.log(this.track);
    console.log(this.slide);
    this.initSlider();

    this.prevBtn.addEventListener("click", () => this.goToPrevSlide());
    this.nextBtn.addEventListener("click", () => this.goToNextSlide());
  }

  cloneElements() {
    this.firstClone = this.slide.firstElementChild.cloneNode(true);
    this.lastClone = this.slide.lastElementChild.cloneNode(true);

    this.slide.appendChild(this.firstClone);
    this.slide.insertBefore(this.lastClone, this.slide.firstElementChild);
  }
  initSlider() {
    this.cloneElements();
    this.slideWidth = this.slide.firstElementChild.offsetWidth;
    this.slide.style.transition = `none`;
    this.slide.style.translate = `-${(this.slideWidth + this.gap) * (this.currentIndex + 1)}px`;
  }
  updatePosition() {
    this.slideWidth = this.slide.firstElementChild.offsetWidth;
    this.slide.style.transition = `translate ${this.ANIMATION_TIME}s ease-in-out`;
    this.slide.style.translate = `-${(this.slideWidth + this.gap) * (this.currentIndex + 1)}px`;
  }

  // Работа кнопки "назад":
  goToPrevSlide() {
    this.currentIndex--;
    this.updatePosition();

    this.slide.addEventListener(
      "transitionend",
      () => {
        if (this.currentIndex < 0) {
          this.currentIndex = this.realSlidesCount - 1;
          this.slide.style.transition = `none`;
          this.slide.style.translate = `-${(this.slideWidth + this.gap) * (this.currentIndex + 1)}px`;
        }
      },
      { once: true },
    );
  }

  //Обработка кнопки "вперед":
  goToNextSlide() {
    this.currentIndex++;
    this.updatePosition();

    if (this.currentIndex >= this.realSlidesCount - 1) {
      this.nextBtn.disabled = true;
    }

    // обработать быстрый переход в первому слайду обратно

    this.slide.addEventListener(
      "transitionend",
      () => {
        if (this.currentIndex >= this.realSlidesCount - 1) {
          this.currentIndex = 0;
          this.slide.style.transition = `none`;
          this.slide.style.translate = `-${(this.slideWidth + this.gap) * (this.currentIndex + 1)}px`;
          this.nextBtn.disabled = false;
        }
      },
      { once: true },
    );
  }
}
