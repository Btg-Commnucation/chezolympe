import { handleMenu  } from './nav.js';
const navMenu = document.getElementById('nav-mobile');
const clickMenu = document.getElementById('click-menu');
if (navMenu && clickMenu) {
    clickMenu.addEventListener('click', () => {
        handleMenu(navMenu, clickMenu);
        // navMenu.classList.toggle('show');
        // clickMenu.classList.toggle('burger-active');
        // document.body.classList.toggle('no-scroll');
    });
}
//# sourceMappingURL=script.js.map