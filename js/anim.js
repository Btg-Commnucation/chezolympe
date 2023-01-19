export const animFrontPage = (animatedId) => {
  observer.observe(animatedId);
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      if (!sessionStorage.getItem("whiteOpener")) {
        entry.target.classList.add("anim");
        document
          .querySelector("header > .container-narrow > #logo")
          .classList.remove("transform");
        setTimeout(() => {
          entry.target.classList.add("remove");
          document
            .querySelector("header > .container-narrow > #logo")
            .classList.remove("no-background");
        }, 2000);

        setTimeout(() => {
          document.body.classList.remove("no-scroll");
          sessionStorage.setItem("whiteOpener", true);
        }, 2400);
      } else {
        document
          .querySelector("header > .container-narrow > #logo")
          .classList.remove("transform");
        entry.target.classList.add("remove");
        document
          .querySelector("header > .container-narrow > #logo")
          .classList.remove("no-background");

        document.body.classList.remove("no-scroll");
        sessionStorage.setItem("whiteOpener", true);
      }
    }
  });
});
