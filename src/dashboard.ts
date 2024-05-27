import Chart from 'chart.js/auto';

fetch('api.php')
    .then(response => response.json())
    .then(data => {
        const cargoTypes: { [key: string]: number } = { maritime: 0, aerien: 0, routier: 0 };

        const cargoProducts = data.cargaisons.map((cargo: { produits: any; }) => cargo.produits);
        const cargoLabels = data.cargaisons.map((cargo: { numero: any; }) => cargo.numero);

        data.cargaisons.forEach((cargo: { type: string; }) => {
          cargoTypes[cargo.type]++;
        });

        // Pie Chart
        const ctxPie = (document.getElementById('pieChart') as HTMLCanvasElement).getContext('2d');
        if (ctxPie !== null) {
            const pieChartCanvas = document.getElementById('pieChart') as HTMLCanvasElement;
            pieChartCanvas.width = 100; // Définir la largeur du canvas
            pieChartCanvas.height = 100; // Définir la hauteur du canvas

            new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: ['Maritime', 'Aérien', 'Routier'],
                    datasets: [{
                        label: 'Types de Cargaisons',
                        data: [cargoTypes.maritime, cargoTypes.aerien, cargoTypes.routier],
                        backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56']
                    }]
                }
            });
        }
         // Bar Chart
         const ctxBar = (document.getElementById('barChart') as HTMLCanvasElement).getContext('2d');
         if (ctxBar !== null) {
             new Chart(ctxBar, {
                 type: 'bar',
                 data: {
                     labels: ['Maritime', 'Aérien', 'Routier'],
                     datasets: [{
                         label: 'Number of Cargaisons',
                         data: [cargoTypes.maritime, cargoTypes.aerien, cargoTypes.routier],
                         backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56']
                     }]
                 }
             });
         }
 
         // Bar Chart for Products
         const ctxCargo = (document.getElementById('cargoChart') as HTMLCanvasElement).getContext('2d');
         if (ctxCargo !== null) {
             new Chart(ctxCargo, {
                 type: 'bar',
                 data: {
                     labels: cargoLabels,
                     datasets: [{
                         label: 'Nombre de Produits',
                         data: cargoProducts,
                         backgroundColor: '#36A2EB'
                     }]
                 }
             });
         };

        // // Line Chart
        // const ctxLine = (document.getElementById('lineChart') as HTMLCanvasElement).getContext('2d');
        // if (ctxLine !== null) {
        //     new Chart(ctxLine, {
        //         type: 'line',
        //         data: {
        //             labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        //             datasets: [{
        //                 label: 'Cargaisons Over Time',
        //                 data: [10, 20, 15, 25, 30, 20],
        //                 borderColor: '#36A2EB',
        //                 fill: false
        //             }]
        //         }
        //     });
        // }

       

    });
