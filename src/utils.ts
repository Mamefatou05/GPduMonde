// utils.ts
export interface FormField {
    inputId: string;
    errorSpanId: string;
    validator?: (value: string) => { valid: boolean; errorMessage?: string };
}

export type SubmitCallback = (formData: { [key: string]: string }) => void;

export class Formulaire {
    private formId: string;
    private formFields: FormField[];
    private submitCallback: SubmitCallback;

    constructor(formId: string, formFields: FormField[], submitCallback: SubmitCallback) {
        this.formId = formId;
        this.formFields = formFields;
        this.submitCallback = submitCallback;
        this.initForm();
    }

    private initForm(): void {
        const form = document.getElementById(this.formId) as HTMLFormElement;
        if (form) {
            form.addEventListener('submit', (event: Event) => {
                event.preventDefault();
                this.validateForm();
            });
        }
    }

    private displayError(errorSpanId: string, errorMessage: string): void {
        const errorElement = document.getElementById(errorSpanId);
        if (errorElement) {
            errorElement.innerText = errorMessage;
        }
    }

    private resetForm(): void {
        this.formFields.forEach(field => {
            const inputElement = document.getElementById(field.inputId) as HTMLInputElement | HTMLSelectElement;
            if (inputElement) {
                if (inputElement instanceof HTMLSelectElement) {
                    inputElement.selectedIndex = 0;
                } else {
                    inputElement.value = '';
                }
            }
            this.displayError(field.errorSpanId, '');
        });
    }

    private validateForm(): void {
        let isValid = true;
        const newData: { [key: string]: string } = {};

        this.formFields.forEach(field => {
            const inputElement = document.getElementById(field.inputId) as HTMLInputElement | HTMLSelectElement;
            const value = inputElement.value.trim();
            const errorSpanId = field.errorSpanId;

            if (field.validator) {
                const validation = field.validator(value);
                if (!validation.valid) {
                    isValid = false;
                    this.displayError(errorSpanId, validation.errorMessage || 'Champ invalide');
                } else {
                    newData[field.inputId] = value;
                    this.displayError(errorSpanId, '');
                }
            }
        });

        if (isValid) {
            this.submitCallback(newData);
            this.resetForm();
        }
    }
}

export const validators = {
    isNotEmpty: (value: string) => {
        const isValid = value.trim().length > 0;
        return {
            valid: isValid,
            errorMessage: isValid ? '' : 'Ce champ ne peut pas être vide.'
        };
    },
    isPositiveNumber: (value: string) => {
        const number = parseFloat(value);
        const isValid = !isNaN(number) && number > 0;
        return {
            valid: isValid,
            errorMessage: isValid ? '' : 'Le poids doit être un nombre positif.'
        };
    },
    isPositiveNumberNull: (value: string) => {
        // Vérifiez si la chaîne est vide
        if (value.trim() === '') {
            return {
                valid: true,
                errorMessage: ''
            };
        }
        // Convertissez la valeur en nombre
        const number = parseFloat(value);
        // Vérifiez si la valeur est un nombre positif
        const isValid = !isNaN(number) && number > 0;
        return {
            valid: isValid,
            errorMessage: isValid ? '' : 'Le poids doit être un nombre positif.'
        };
    },
    
    isValidDate: (value: string) => {
        const date = new Date(value);
        const isValid = !isNaN(date.getTime());
        return {
            valid: isValid,
            errorMessage: isValid ? '' : 'La date n\'est pas valide.'
        };
    }
};
