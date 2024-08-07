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
        if (value.trim() === '') {
            return {
                valid: true,
                errorMessage: ''
            };
        }
        const number = parseFloat(value);
        const isValid = !isNaN(number) && number > 0;
        return {
            valid: isValid,
            errorMessage: isValid ? '' : 'Le poids doit être un nombre positif.'
        };
    },
    isValidDate: (value: string) => {
        const today = new Date().toISOString().split("T")[0];
        const date = new Date(value);
        const isValid = !isNaN(date.getTime());
        let errorMessage = '';

        if (!isValid) {
            errorMessage = "La date n'est pas valide.";
        } else if (value < today) {
            errorMessage = "Date de départ doit être aujourd'hui ou plus tard.";
        }

        return {
            valid: isValid && value >= today,
            errorMessage: errorMessage
        };
    },
    
};

export const isDateAfter = (startDate: string, endDate: string) => {
    const start = new Date(startDate);
    const end = new Date(endDate);
    const isValid = start < end;
    return {
        valid: isValid,
        errorMessage: isValid ? '' : "Date d'arrivée doit être après la date de départ."
    };
};
