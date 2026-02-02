export default class Slider {
  constructor(
    rootElement,
    { track = "", btns = "", nextBtn = "", prevBtn = "" } = {},
  ) {
    this.root = rootElement;
    this.track = document.querySelector(track);
    this.slides = this.track.children;
    // this.btns = document.querySelectorAll(btns);
    this.slideIndex = 1;

    console.log(this.track);
  }
}
