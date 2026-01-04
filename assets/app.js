import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

document.addEventListener('DOMContentLoaded', () => {
        // 1. On sélectionne tous les boutons qui ont la classe "js-period-btn"
        const buttons = document.querySelectorAll('.js-period-btn');

        // Classes pour l'état ACTIF (Bleu, texte blanc)
        const activeClasses = ['bg-[#2E3B59]', 'text-white', 'shadow-sm'];
        
        // Classes pour l'état INACTIF (Gris, fond transparent ou gris clair au survol)
        const inactiveClasses = ['text-gray-500', 'hover:text-gray-700', 'hover:bg-gray-100'];

        // 2. On ajoute un écouteur d'événement sur CHAQUE bouton
        buttons.forEach(button => {
            button.addEventListener('click', () => {
                
                // A. On réinitialise TOUS les boutons (on les met en "inactif")
                buttons.forEach(btn => {
                    btn.classList.remove(...activeClasses); // Enlève le bleu
                    btn.classList.add(...inactiveClasses);  // Remet le gris
                });

                // B. On active CELUI qu'on vient de cliquer
                button.classList.remove(...inactiveClasses); // Enlève le gris
                button.classList.add(...activeClasses);      // Met le bleu
            });
        });
    });
