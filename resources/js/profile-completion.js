/**
 * Profile Completion Form Enhancements
 *
 * Provides dynamic form behavior including:
 * - Dynamic ID number patterns based on selected type
 * - Form submission loading state
 * - Unsaved changes warning
 */

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const submitButton = form?.querySelector('button[type="submit"]');
    const idTypeSelect = document.getElementById('identification_type');
    const idNumberInput = document.getElementById('identification_number');
    const idNumberHint = document.getElementById('id-number-hint');

    let formChanged = false;

    // Track form changes for unsaved warning
    if (form) {
        form.addEventListener('change', function () {
            formChanged = true;
        });

        form.addEventListener('input', function () {
            formChanged = true;
        });
    }

    // Warn before leaving with unsaved changes
    window.addEventListener('beforeunload', function (e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = ''; // Required for Chrome
            return ''; // For other browsers
        }
    });

    // Handle form submission
    if (form && submitButton) {
        form.addEventListener('submit', function () {
            formChanged = false; // Don't warn on submit

            // Disable button and show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
            `;
        });
    }

    // Dynamic ID number pattern and placeholder based on type
    if (idTypeSelect && idNumberInput && idNumberHint) {
        const patterns = {
            'ssn': {
                pattern: '[0-9]{3}-[0-9]{2}-[0-9]{4}',
                placeholder: 'XXX-XX-XXXX',
                hint: 'Format: XXX-XX-XXXX (e.g., 123-45-6789)'
            },
            'passport': {
                pattern: '[A-Z0-9]{6,9}',
                placeholder: 'Enter passport number',
                hint: 'Enter your passport number (6-9 characters)'
            },
            'dni': {
                pattern: '[0-9]{8}[A-Z]',
                placeholder: 'XXXXXXXXA',
                hint: 'Format: 8 digits followed by a letter (e.g., 12345678A)'
            },
            'driver_license': {
                pattern: '[A-Z0-9]{5,20}',
                placeholder: 'Enter driver\'s license number',
                hint: 'Enter your driver\'s license number'
            },
            'national_id': {
                pattern: '[A-Z0-9]{5,20}',
                placeholder: 'Enter national ID number',
                hint: 'Enter your national ID number'
            },
            'other': {
                pattern: '',
                placeholder: 'Enter identification number',
                hint: 'Enter your identification number'
            }
        };

        idTypeSelect.addEventListener('change', function () {
            const selectedType = this.value;

            if (selectedType && patterns[selectedType]) {
                const config = patterns[selectedType];

                // Update pattern (if supported)
                if (config.pattern) {
                    idNumberInput.setAttribute('pattern', config.pattern);
                } else {
                    idNumberInput.removeAttribute('pattern');
                }

                // Update placeholder
                idNumberInput.setAttribute('placeholder', config.placeholder);

                // Update hint text
                idNumberHint.textContent = config.hint;

                // Focus on the input
                idNumberInput.focus();
            } else {
                // Reset to default
                idNumberInput.removeAttribute('pattern');
                idNumberInput.setAttribute('placeholder', 'Enter your identification number');
                idNumberHint.textContent = 'Enter the number for your selected ID type';
            }
        });
    }
});
