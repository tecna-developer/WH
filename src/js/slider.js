export default class Slider {
  constructor(
    rootElement,
    { track = "", nextBtn = "", prevBtn = "", slidesToShow = 1 } = {},
  ) {
    this.root = rootElement;
    this.track = document.querySelector(track);
    this.nextBtn = document.querySelector(nextBtn);
    this.nextBtn = document.querySelector(prevBtn);
    this.slide = document.querySelector("[data-slide]");
    this.currentIndex = 0;
    this.slidesToShow = slidesToShow || 1;
    this.firstClone = this.slide.firstElementChild.cloneNode(true);
    this.lastClone = this.slide.lastElementChild.cloneNode(true);
    this.slide.appendChild(this.firstClone);

    this.slide.insertBefore(this.lastClone, this.slide.firstElementChild);

    console.log(this.track);
    console.log(this.slide);

    // nextBtn.addEventListener("click", goToNextSlide);
    // prevBtn.addEventListener("click", goToPrevSlide);
  }
}
