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

document.addEventListener('DOMContentLoaded', function () {
const select = document.getElementById('intervenant-select');
const container = document.getElementById('chips-container');

select.addEventListener('change', function () {
const option = select.options[select.selectedIndex];
const id = option.value;
const name = option.getAttribute('data-name');

if (id) {
addChip(id, name);
option.disabled = true; // Empêche de choisir deux fois le même
select.value = ""; // Reset le sélecteur
}
});

function addChip(id, name) { // Création du jeton avec les classes Tailwind
const chip = document.createElement('div');
chip.id = `chip-${id}`;
// Design : gris foncé (zinc-600), texte blanc, arrondi complet
chip.className = "flex items-center gap-2 px-3 py-1 text-sm font-medium text-white transition-colors bg-zinc-600 rounded-full";

chip.innerHTML = `
            <span>${name}</span>
            <button type="button" onclick="removeChip('${id}')" class="flex items-center justify-center w-4 h-4 text-white transition-colors hover:text-red-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        `;

container.appendChild(chip);
}

window.removeChip = function (id) { // Supprimer le jeton visuellement
const chip = document.getElementById (`chip-${id}`);
if (chip) 
chip.remove();



// Réactiver l'option dans la liste
const option = select.querySelector (`option[value="${id}"]`);
if (option) 
option.disabled = false;


};
});