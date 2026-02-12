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
    this.realSlidesCount = this.track.children.length;
    this.ANIMATION_TIME = ANIMATION_TIME;
    this.gap = gap;
    // this.track.style.columnGap = `${gap}px`;
    this.currentIndex = 0;
    this.slidesToShow = slidesToShow || 1;

    console.log(this.track);
    console.log(this.slide);
    this.cloneElements();
    this.initSlider();
    this.bindListener();
  }

  cloneElements() {
    this.firstClone = this.track.firstElementChild.cloneNode(true);
    this.lastClone = this.track.lastElementChild.cloneNode(true);

    this.track.appendChild(this.firstClone);
    this.track.insertBefore(this.lastClone, this.track.firstElementChild);
  }

  initSlider() {
    this.slideWidth = this.track.firstElementChild.offsetWidth;
    this.track.style.transition = `none`;
    this.track.style.translate = `-${(this.slideWidth + this.gap) * (this.currentIndex + 1)}px`;
  }
  updatePosition() {
    this.slideWidth = this.track.firstElementChild.offsetWidth;
    this.track.style.transition = `translate ${this.ANIMATION_TIME}s ease-in-out`;
    this.track.style.translate = `-${(this.slideWidth + this.gap) * (this.currentIndex + 1)}px`;
  }

  // Работа кнопки "назад":
  goToPrevSlide() {
    this.currentIndex--;
    this.updatePosition();

    this.track.addEventListener(
      "transitionend",
      () => {
        if (this.currentIndex < 0) {
          this.currentIndex = this.realSlidesCount;
          this.track.style.transition = `none`;
          this.track.style.translate = `-${(this.slideWidth + this.gap) * (this.currentIndex + 1)}px`;
        }
      },
      { once: true },
    );
  }

  //Обработка кнопки "вперед":
  goToNextSlide() {
    this.currentIndex++;
    this.updatePosition();

    if (this.currentIndex >= this.realSlidesCount) {
      this.nextBtn.disabled = true;
    }

    // обработать быстрый переход в первому слайду обратно
    this.track.addEventListener(
      "transitionend",
      () => {
        if (this.currentIndex >= this.realSlidesCount) {
          this.currentIndex = 0;
          this.track.style.transition = `none`;
          this.track.style.translate = `-${(this.slideWidth + this.gap) * (this.currentIndex + 1)}px`;
          this.nextBtn.disabled = false;
        }
      },
      { once: true },
    );
  }
  bindListener() {
    this.prevBtn.addEventListener("click", () => this.goToPrevSlide());

    this.nextBtn.addEventListener("click", () => this.goToNextSlide());
  }
}
