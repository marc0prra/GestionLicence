import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

// CALENDRIER & NAVIGATION
document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialisation du Calendrier
    const calendarEl = document.getElementById('calendar');
    let calendar;

    if (calendarEl) {

        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek', // Vue par défaut : Semaine avec heures
            firstDay: 1, // La semaine commence le lundi (0 = dimanche, 1 = lundi)
            headerToolbar: {
                left: 'title',
                center: '',
                right: ''
            },
            locale: 'fr',
            buttonText: {
                today: "Aujourd'hui",
                month: 'Mois',
                week: 'Semaine',
                day: 'Jour'
            },
            // Configuration des heures
            slotMinTime: '08:00:00', // Heure de début : 8h
            slotMaxTime: '19:00:00', // Heure de fin : 18h
            slotDuration: '01:00:00', // Intervalle d'une heure
            allDaySlot: false, // Masquer la ligne "toute la journée"
            nowIndicator: true, // Afficher l'indicateur de l'heure actuelle
            slotLabelFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false // Format 24h
            },


            events: '/api/calendar',

            // Personnalisation de l'affichage des événements
            eventContent: function (arg) {
                const startDate = arg.event.extendedProps.start;
                const endDate = arg.event.extendedProps.end;
                const module = arg.event.extendedProps.module;
                const type = arg.event.extendedProps.type;
                const instructors = arg.event.extendedProps.instructors;

                // Création du conteneur principal
                const container = document.createElement('div');
                container.className = 'p-2 h-full flex flex-col';
                container.style.fontSize = '0.875rem';
                container.style.lineHeight = '1.3';

                // Heure (uniquement début)
                const timeDiv = document.createElement('div');
                timeDiv.className = 'font-semibold mb-1';
                const startTime = arg.timeText;
                timeDiv.textContent = startTime;
                container.appendChild(timeDiv);

                // Module (titre du cours)
                if (module) {
                    const moduleDiv = document.createElement('div');
                    moduleDiv.className = 'font-semibold mb-1';
                    moduleDiv.textContent = module;
                    container.appendChild(moduleDiv);
                }

                // Instructeur
                if (instructors) {
                    const instructorDiv = document.createElement('div');
                    instructorDiv.className = 'mb-1';
                    instructorDiv.textContent = instructors.map(i => i.name).join(', ');
                    container.appendChild(instructorDiv);
                }

                // Type d'intervention
                if (type) {
                    const typeDiv = document.createElement('div');
                    typeDiv.className = 'mt-auto';
                    typeDiv.textContent = type;
                    container.appendChild(typeDiv);
                }

                return { domNodes: [container] };
            },

        });

        // Affiche le calendrier
        calendar.render();
    }

    // 2. Gestion des boutons périodes (Jour/Semaine/Mois)
    const periodButtons = document.querySelectorAll('.js-period-btn');
    const periodActive = ['bg-[#2E3B59]', 'text-white', 'shadow-sm'];
    const periodInactive = ['text-gray-700', 'hover:text-gray-900'];

    periodButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Changement de style
            periodButtons.forEach(btn => {
                btn.classList.remove(...periodActive);
                btn.classList.add(...periodInactive);
            });
            button.classList.remove(...periodInactive);
            button.classList.add(...periodActive);

            // Changement de vue Calendrier
            if (calendar) {
                const viewName = button.getAttribute('data-period');
                if (viewName) {
                    calendar.changeView(viewName);
                }
            }
        });
    });

    // 3. Gestion des boutons de navigation (Précédent / Suivant)
    const prevBtn = document.getElementById('js-calendar-prev');
    const nextBtn = document.getElementById('js-calendar-next');

    if (prevBtn && calendar) {
        prevBtn.addEventListener('click', () => {
            calendar.prev();
        });
    }

    if (nextBtn && calendar) {
        nextBtn.addEventListener('click', () => {
            calendar.next();
        });
    }


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


// Champs multi_select formulaire
document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.getElementById('instructor-wrapper');
    if (!wrapper) return; // Sécurité si l'élément n'est pas sur la page

    const fieldId = wrapper.getAttribute('data-field-id');
    const realSelect = document.getElementById(fieldId);

    const modal = document.getElementById('instructor-modal');
    const trigger = document.getElementById('modal-trigger');
    const closeButtons = document.querySelectorAll('.close-modal');
    const confirmBtn = document.getElementById('confirm-selection');
    const chipsContainer = document.getElementById('chips-container');
    const placeholder = document.getElementById('placeholder-text');
    const checkboxes = document.querySelectorAll('.instructor-checkbox');

    // Ouverture modale
    trigger.addEventListener('click', (e) => {
        if (!e.target.closest('.remove-chip-btn')) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    });

    // Fermer la modale au clic sur l'arrière-plan (en dehors de la boîte blanche)
    modal.addEventListener('click', (e) => {
        // Si l'élément cliqué est exactement le conteneur 'instructor-modal' 
        // (le fond noir transparent) et non son contenu blanc
        if (e.target === modal) {
            closeModal();
        }
    });

    // Fermeture modale
    const closeModal = () => {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        syncCheckboxesFromRealSelect();
    };

    closeButtons.forEach(btn => btn.addEventListener('click', closeModal));

    confirmBtn.addEventListener('click', () => {
        updateEverything();
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    });

    function updateEverything() {
        chipsContainer.innerHTML = '';
        const selectedValues = [];

        checkboxes.forEach(cb => {
            if (cb.checked) {
                selectedValues.push(cb.value);
                createChip(cb.value, cb.getAttribute('data-label'));
            }
        });

        Array.from(realSelect.options).forEach(opt => {
            opt.selected = selectedValues.includes(opt.value);
        });

        placeholder.style.display = selectedValues.length > 0 ? 'none' : 'block';
    }

    function createChip(id, name) {
        const chip = document.createElement('div');
        chip.className = "flex items-center gap-2 px-3 py-1 text-sm font-medium text-white rounded-md shadow-sm";

        // Style forcé pour éviter le bug du "tout blanc"
        chip.style.backgroundColor = '#757575';
        chip.style.color = '#ffffff';

        const span = document.createElement('span');
        span.textContent = name;

        const btn = document.createElement('button');
        btn.type = "button";
        btn.innerHTML = "&times;";
        btn.className = "remove-chip-btn hover:text-red-300 focus:outline-none leading-none text-lg transition-colors ml-1 text-white";

        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            removeInstructorSelection(id);
        });

        chip.appendChild(span);
        chip.appendChild(btn);
        chipsContainer.appendChild(chip);
    }

    function removeInstructorSelection(id) {
        const cb = document.querySelector(`.instructor-checkbox[value="${id}"]`);
        if (cb) cb.checked = false;
        updateEverything();
    }

    function syncCheckboxesFromRealSelect() {
        const currentValues = Array.from(realSelect.selectedOptions).map(o => o.value);
        checkboxes.forEach(cb => {
            cb.checked = currentValues.includes(cb.value);
        });
    }

    // Initialisation
    syncCheckboxesFromRealSelect();
    updateEverything();
});