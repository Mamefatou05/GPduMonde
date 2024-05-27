// api.ts

import { ICargaison } from "./types/cargaison";



// Fonction pour lire les données du serveur
export async function readDataFromServer<T>(url: string): Promise<T | undefined> {
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error reading data:', error);
        return ;
    }
}
export async function writeDataToServer<T>(url: string, newObject: T): Promise<void> {
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(newObject),
        });

        if (!response.ok) {
            throw new Error('Failed to save data');
        }

        console.log('New object saved successfully');
    } catch (error) {
        console.error('Error writing data:', error);
    }
}


export async function saveNewCargoToServer(cargo: ICargaison): Promise<void> {
    await writeDataToServer<ICargaison>('../php/api.php', cargo);
}
