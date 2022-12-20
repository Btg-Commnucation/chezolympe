import { handleMenu } from "./nav.js";
import { handleFamily } from "./questionnaire.js";

const splideSelector = document.querySelector(".splide");

const navMenu = document.getElementById("nav-mobile");
const clickMenu = document.getElementById("click-menu");
const btn = document.querySelectorAll(".btn");
const family = document.querySelectorAll(".famille");

if (btn && family) {
  btn.forEach((item) => {
    item.addEventListener("click", () => {
      btn.forEach((item) => item.classList.remove("active"));
      item.classList.add("active");
      handleFamily(item.id, family);
    });
  });
}

if (navMenu && clickMenu) {
  clickMenu.addEventListener("click", () => {
    handleMenu(navMenu, clickMenu);
    // navMenu.classList.toggle('show');
    // clickMenu.classList.toggle('burger-active');
    // document.body.classList.toggle('no-scroll');
  });
}

if (splideSelector) {
  new Splide(splideSelector, {
    type: "loop",
    perPage: 4,
    arrows: false,
    perMove: 1,
    autoplay: true,
    interval: 5000,
    breakpoints: {
      1320: {
        perPage: 3,
      },
      1000: {
        perPage: 2,
      },
      624: {
        perPage: 1,
      },
    },
  }).mount();
}
