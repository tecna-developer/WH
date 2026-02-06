export default class Slider {
  constructor(
    rootElement,
    {
      track = "",
      nextBtn = "",
      prevBtn = "",
      slidesToShow = 1,
      ANIMATION_TIME = 0.5,
    } = {},
  ) {
    this.root = rootElement;
    this.track = document.querySelector(track);
    this.nextBtn = document.querySelector(nextBtn);
    this.prevBtn = document.querySelector(prevBtn);
    this.slide = document.querySelector("[data-slide]");
    this.ANIMATION_TIME = ANIMATION_TIME;
    this.currentIndex = 0;
    this.slidesToShow = slidesToShow || 1;
    this.firstClone = this.slide.firstElementChild.cloneNode(true);
    this.lastClone = this.slide.lastElementChild.cloneNode(true);
    this.slide.appendChild(this.firstClone);

    this.slide.insertBefore(this.lastClone, this.slide.firstElementChild);

    console.log(this.track);
    console.log(this.slide);
    this.initSlider();

    this.nextBtn.addEventListener("click", () => this.goToNextSlide());
    // prevBtn.addEventListener("click", goToPrevSlide);
  }
  initSlider() {
    this.slideWidth = this.slide.firstElementChild.offsetWidth;
    console.log(this.slideWidth);
    this.currentIndex++;
    this.slide.style.transition = `none`;
    this.slide.style.translate = `-${this.slideWidth * (this.currentIndex + 1)}px`;
  }

  //Обработка кнопки " вперед":
  goToNextSlide() {
    this.slideWidth = this.slide.firstElementChild.offsetWidth;

    this.currentIndex++;
    this.slide.style.transition = `translate ${this.ANIMATION_TIME}s ease-in-out`;
    this.slide.style.translate = `-${this.slideWidth * (this.currentIndex + 1)}px`;
  }
}
