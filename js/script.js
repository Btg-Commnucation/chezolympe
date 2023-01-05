import { handleMenu } from "./nav.js";
import { handleFamily } from "./questionnaire.js";
import { animFrontPage } from "./anim.js";

const splideSelector = document.querySelector(".splide");
const frontPage = document.getElementById("front-page");
const whiteOpener = document.getElementById("white-opener");

const navMenu = document.getElementById("nav-mobile");
const clickMenu = document.getElementById("click-menu");
const btn = document.querySelectorAll(".btn");
const family = document.querySelectorAll(".famille");

const mulder = document.getElementById("mulder");
const scully = document.getElementById("scully");
const spaceShip = document.getElementById("space-ship");
const mib = document.getElementById("mib");

if (frontPage && whiteOpener) {
  document.body.classList.add("no-scroll");
  document.getElementById("left-nav").classList.add("hide");
  document.getElementById("right-nav").classList.add("hide");
  document
    .querySelector("header > .container-narrow > #logo")
    .classList.add("transform");
  document
    .querySelector("header > .container-narrow > #logo")
    .classList.add("no-background");
  animFrontPage(whiteOpener);
}

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

if (mulder && scully) {
  mulder.addEventListener("click", () => {
    mulder.classList.add("active");
    scully.classList.remove("active");

    setTimeout(() => {
      mulder.classList.remove("active");
      mulder.classList.add("vanish");
      scully.classList.add("vanish");
    }, 2000);

    setTimeout(() => {
      spaceShip.classList.add("vanish");
    }, 3000);
  });
  scully.addEventListener("click", () => {
    scully.classList.add("active");
    mulder.classList.remove("active");

    setTimeout(() => {
      scully.classList.remove("active");
      mulder.classList.add("vanish");
      scully.classList.add("vanish");
    }, 2000);

    setTimeout(() => {
      spaceShip.classList.add("vanish");
    }, 3000);
  });

  mib.addEventListener("click", () => {
    mib.classList.add("active");
    scully.classList.remove("active");
    mulder.classList.remove("active");

    setTimeout(() => {
      mib.classList.remove("active");
      mib.classList.add("vanish");
    }, 2000);

    setTimeout(() => {
      spaceShip.classList.add("vanish");
    }, 3000);
  });
}
