export default class Slider {
  constructor(
    rootElement,
    { track = "", nextBtn = "", prevBtn = "", slidesToShow = 1 } = {},
  ) {
    this.root = rootElement;
    this.track = document.querySelector(track);
    this.nextBtn = document.querySelector(nextBtn);
    this.nextBtn = document.querySelector(prevBtn);
    this.slides = this.track.children;
    this.currentIndex = 0;
    this.slidesToShow = slidesToShow || 1;
    nextBtn.addEventListener("click", goToNextSlide);
    prevBtn.addEventListener("click", goToPrevSlide);
    console.log(this.track);
  }

  goToNextSlide() {
    // this.slideIndex++;
    console.log("листаем этот слайдер");
  }
}
