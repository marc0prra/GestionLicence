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
        const chip = document.getElementById(`chip-${id}`);
        if (chip)
            chip.remove();



        // Réactiver l'option dans la liste
        const option = select.querySelector(`option[value="${id}"]`);
        if (option)
            option.disabled = false;


    };

    document.addEventListener('DOMContentLoaded', function () {
        const selectEl = document.querySelector('select[name="{{ field.vars.full_name }}"]');
        const chipsWrapper = document.getElementById('chips-wrapper');

        // 1. Initialisation : créer des chips si des valeurs sont déjà sélectionnées (ex: modif)
        Array.from(selectEl.selectedOptions).forEach(option => {
            addChip(option.value, option.text);
        });

        // 2. Écouter les changements sur le select
        selectEl.addEventListener('change', function () {
            renderChips();
        });

        // Fonction pour rafraîchir l'affichage des chips
        function renderChips() {
            chipsWrapper.innerHTML = ''; // On vide pour reconstruire
            Array.from(selectEl.options).forEach(option => {
                if (option.selected) {
                    addChip(option.value, option.text);
                }
            });
        }

        // Fonction pour créer visuellement un chip
        function addChip(value, text) {
            if (!value) return;

            const chip = document.createElement('div');
            chip.className = 'flex items-center gap-1 px-2 py-1 bg-blue-500 text-white text-xs font-semibold rounded-md transition-all hover:bg-blue-600';
            chip.innerHTML = `
            ${text}
            <span class="cursor-pointer font-bold ml-1 hover:text-red-200" data-remove="${value}">&times;</span>
        `;

            // Supprimer au clic sur la croix
            chip.querySelector('[data-remove]').addEventListener('click', (e) => {
                e.preventDefault();
                const valToRemove = e.target.getAttribute('data-remove');

                // On décoche l'option dans le select réel
                Array.from(selectEl.options).find(opt => opt.value === valToRemove).selected = false;

                // On déclenche l'événement change pour rafraîchir
                selectEl.dispatchEvent(new Event('change'));
            });

            chipsWrapper.appendChild(chip);
        }
    });
});