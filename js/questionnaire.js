export const handleFamily = (id, family) => {
  for (const item of family) {
    item.classList.remove("active");
    if (item.id === id) {
      item.classList.add("active");
    }
  }
};
