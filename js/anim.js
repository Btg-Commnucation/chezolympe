export const animFrontPage = (animatedId) => {
  observer.observe(animatedId);
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
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
      }, 2400);
    }
  });
});
