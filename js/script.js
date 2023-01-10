import { handleMenu } from "./nav.js";
import { handleFamily } from "./questionnaire.js";
import { animFrontPage } from "./anim.js";
import { pageNotFound } from "./page-not-found.js";

const splideSelector = document.querySelector(".splide");
const frontPage = document.getElementById("front-page");
const whiteOpener = document.getElementById("white-opener");

const navMenu = document.getElementById("nav-mobile");
const clickMenu = document.getElementById("click-menu");
const btn = document.querySelectorAll(".btn");
const family = document.querySelectorAll(".famille");

const mulder = document.getElementById("mulder");
const scully = document.getElementById("scully");
const mulderScully = document.getElementById("mulder-scully");
const spaceShip = document.getElementById("space-ship");
const mib = document.getElementById("mib");
const mibEnding = document.getElementById("mib-ending");

if (frontPage && whiteOpener) {
  document.body.classList.add("no-scroll");
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
    if (
      !mib.classList.contains("active") &&
      !mib.classList.contains("vanish") &&
      !mulder.classList.contains("vanish") &&
      !mulder.classList.contains("active")
    ) {
      console.log(mib.classList);
      pageNotFound(mulder, scully, spaceShip, mulderScully);
    }
  });

  scully.addEventListener("click", () => {
    if (
      !mib.classList.contains("active") &&
      !mib.classList.contains("vanish") &&
      !scully.classList.contains("vanish") &&
      !scully.classList.contains("active")
    ) {
      pageNotFound(scully, mulder, spaceShip, mulderScully);
    }
  });

  mib.addEventListener("click", () => {
    if (
      !mulder.classList.contains("vanish") &&
      !mulder.classList.contains("active") &&
      !scully.classList.contains("vanish") &&
      !scully.classList.contains("active") &&
      !mib.classList.contains("vanish") &&
      !mib.classList.contains("active")
    ) {
      pageNotFound(mib, null, spaceShip, mibEnding);
    }
  });
}
