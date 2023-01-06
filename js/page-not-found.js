export const pageNotFound = (
  heroUn,
  heroDeux = null,
  firstImage,
  secondImage
) => {
  heroUn.classList.add("active");

  if (heroDeux) {
    setTimeout(() => {
      heroDeux.classList.add("active");
    }, 200);
  }

  setTimeout(() => {
    heroUn.classList.remove("active");
    if (heroDeux) {
      heroDeux.classList.remove("active");
    }
    heroUn.classList.add("vanish");
    if (heroDeux) {
      heroDeux.classList.add("vanish");
    }
  }, 2000);

  setTimeout(() => {
    firstImage.classList.add("vanish");
  }, 3000);

  setTimeout(() => {
    secondImage.classList.add("show");
  }, 4000);
};
