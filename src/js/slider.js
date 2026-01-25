export default class Slider {
  constructor({ track = "", btns = "", nextBtn = "", prevBtn = "" } = {}) {
    this.track = document.querySelector(track);
    this.slides = this.track.children;
    // this.btns = document.querySelectorAll(btns);
    this.slideIndex = 1;
    console.log(this.track);
  }
}
