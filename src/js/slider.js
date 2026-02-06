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
    this.images = this.slide.children;
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
    this.slide.style.translate = `-${this.slideWidth * (this.currentIndex + 1)}px`;
  }
  updatePosition() {
    this.slideWidth = this.slide.firstElementChild.offsetWidth;
    this.slide.transition = `translate ${this.ANIMATION_TIME}s ease-in-out`;
    this.slide.style.translate = `-${this.slideWidth * (this.currentIndex + 1)}px`;
  }

  // Работа кнопки "назад":
  goToPrevSlide() {
    this.currentIndex--;
    this.updatePosition();
  }

  //Обработка кнопки "вперед":
  goToNextSlide() {
    this.nextBtn.disabled = true;
    this.currentIndex++;
    this.updatePosition();

    // обработать быстрый переход в первому слайду обратно

    this.slide.addEventListener(
      "transitionend",
      () => {
        if (this.currentIndex >= this.images.length) {
          this.currentIndex = 0;
          this.slide.style.transition = `none`;
          this.slide.style.translate = `-${this.slideWidth * this.currentIndex}px`;
          this.nextBtn.disabled = false;
        }
      },
      { once: true },
    );
  }
}
