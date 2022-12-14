export const handleMenu = (navMenu, clickMenu) => {
    navMenu.classList.toggle('show');
    clickMenu.classList.toggle('burger-active');
    document.body.classList.toggle('no-scroll');
}