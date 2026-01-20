import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

document.addEventListener('DOMContentLoaded', () => {

    // GESTION DES BOUTONS PERIODES (Jour/Semaine/Mois)
    const periodButtons = document.querySelectorAll('.js-period-btn');
    const periodActive = ['bg-[#2E3B59]', 'text-white', 'shadow-sm'];
    const periodInactive = ['text-gray-500', 'hover:text-gray-700', 'hover:bg-gray-100'];

    periodButtons.forEach(button => {
        button.addEventListener('click', () => {
            periodButtons.forEach(btn => {
                btn.classList.remove(...periodActive);
                btn.classList.add(...periodInactive);
            });
            button.classList.remove(...periodInactive);
            button.classList.add(...periodActive);
        });
    });

    // GESTION DE LA SIDEBAR (Menu latéral)
    const sidebarLinks = document.querySelectorAll('.js-sidebar-link');
    const sidebarActive = ['bg-[#2E3B59]', 'text-white', 'shadow-sm'];
    // Ces classes correspondent exactement à ton design HTML précédent
    const sidebarInactive = ['text-[#718096]', 'hover:bg-[#2E3B59]', 'hover:text-white', 'hover:shadow-sm'];

    sidebarLinks.forEach(link => {
        link.addEventListener('click', () => {
            sidebarLinks.forEach(l => {
                l.classList.remove(...sidebarActive);
                l.classList.add(...sidebarInactive);
            });
            link.classList.remove(...sidebarInactive);
            link.classList.add(...sidebarActive);
        });
    });
});
