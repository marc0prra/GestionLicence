import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["modal", "trigger", "realSelect", "chipsContainer", "placeholder", "checkbox", "confirmBtn", "closeBtn"]

    connect() {
        // Initial setup
        this.syncCheckboxesFromRealSelect();
        this.updateEverything();
        
        // No need for DOMContentLoaded listener as connect() runs on Turbo load
    }

    open(event) {
        // Prevent opening if the click originated from a remove button inside the trigger
        // Although the remove buttons stopPropagation, this is a safety check.
        if (event.target.closest('.remove-chip-btn')) {
            return;
        }

        this.syncCheckboxesFromRealSelect();
        this.modalTarget.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    close() {
        this.modalTarget.classList.add('hidden');
        document.body.style.overflow = '';
    }

    closeBackground(event) {
        if (event.target === this.modalTarget) {
            this.close();
        }
    }

    confirm() {
        this.updateEverything();
        this.close();
    }

    toggleCheckbox(event) {
        // Optional: Updates logic if we want live updates, but currently we confirm on "Valider"
    }

    removeItem(event) {
        event.preventDefault();
        event.stopPropagation(); // Prevent opening the modal

        const valueToRemove = event.params.value;

        // Find the corresponding checkbox and uncheck it
        const checkbox = this.checkboxTargets.find(cb => cb.value === String(valueToRemove));
        if (checkbox) {
            checkbox.checked = false;
        }

        this.updateEverything();
    }

    updateEverything() {
        this.chipsContainerTarget.innerHTML = '';
        const selectedValues = [];

        // 1. Scan checkboxes
        this.checkboxTargets.forEach(cb => {
            if (cb.checked) {
                selectedValues.push(cb.value);
                this.createChip(cb.value, cb.getAttribute('data-label'));
            }
        });

        // 2. Update real select (multiple)
        if (this.hasRealSelectTarget) {
            Array.from(this.realSelectTarget.options).forEach(opt => {
                opt.selected = selectedValues.includes(opt.value);
            });
            // Dispatch change event
            this.realSelectTarget.dispatchEvent(new Event('change', { bubbles: true }));
        }

        // 3. Update placeholder
        if (this.hasPlaceholderTarget) {
            this.placeholderTarget.style.display = selectedValues.length > 0 ? 'none' : 'block';
        }
    }

    createChip(id, name) {
        const chip = document.createElement('div');
        chip.className = "flex items-center gap-2 px-3 py-1 text-sm font-medium text-white rounded-md shadow-sm";
        chip.style.backgroundColor = '#757575'; // Gris
        chip.style.color = '#ffffff';

        const span = document.createElement('span');
        span.textContent = name;

        const btn = document.createElement('button');
        btn.type = "button";
        btn.innerHTML = "&times;";
        btn.className = "remove-chip-btn hover:text-red-300 focus:outline-none leading-none text-lg transition-colors ml-1 text-white";
        
        // Stimulus action for removing
        btn.setAttribute('data-action', 'click->multi-select#removeItem');
        btn.setAttribute('data-multi-select-value-param', id);

        chip.appendChild(span);
        chip.appendChild(btn);
        this.chipsContainerTarget.appendChild(chip);
    }

    syncCheckboxesFromRealSelect() {
        if (!this.hasRealSelectTarget) return;

        const currentValues = Array.from(this.realSelectTarget.selectedOptions).map(o => o.value);
        this.checkboxTargets.forEach(cb => {
            cb.checked = currentValues.includes(cb.value);
        });
    }
}
