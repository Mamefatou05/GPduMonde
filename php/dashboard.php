<div class="w-full flex flex-col justify-between p-5">
    <h1 class="text-2xl font-bold">Dashboard</h1>
    <div class="m-1 flex w-full flex-wrap flex-col md:flex-row gap-4">
        <div class="bg-white rounded-lg shadow p-2 w-full md:w-1/3 lg:w-1/4">
            <div class="flex flex-col justify-between items-center">
                <img class=" h-32 md:h-24" src="./assets/avion.jpeg" alt="">
                <h2 class="text-lg font-bold text-gray-500">Aérienne</h2>
            </div>
            <div class="flex flex-wrap gap-2 mt-2">
                <span class="text-sm bg-blue-200 text-blue-700 px-2 py-1 rounded">Alimentaire</span>
                <span class="text-sm bg-orange-200 text-orange-700 px-2 py-1 rounded">Fragile</span>
                <span class="text-sm bg-orange-500 text-orange-200 px-2 py-1 rounded">Incassable</span>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-600">nombre de cargaison :</span>
                <span>10</span>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-2 w-full md:w-1/3 lg:w-1/4">
            <div class="flex flex-col justify-between items-center">
                <img class="h-32 md:h-24" src="./assets/bateau.jpg" alt="">
                <h2 class="text-lg font-bold text-gray-500">Maritime</h2>
            </div>
            <div class="flex flex-wrap gap-2 mt-2">
                <span class="text-sm bg-blue-200 text-blue-700 px-2 py-1 rounded">Alimentaire</span>
                <span class="text-sm bg-orange-200 text-orange-700 px-2 py-1 rounded">chimique</span>
                <span class="text-sm bg-orange-500 text-orange-200 px-2 py-1 rounded">Incassable</span>

            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-600">nombre de cargaison :</span>
                <span>10</span>
            </div>
        </div>


        <div class="bg-white rounded-lg shadow p-2 w-full md:w-1/3 lg:w-1/4">
            <div class="flex flex-col justify-between items-center">
                <img class="h-32 md:h-24" src="./assets/camion.jpg" alt="">
                <h2 class="text-lg font-bold text-gray-500">Routière</h2>
            </div>
            <div class="flex flex-wrap gap-2 mt-2">
                <span class="text-sm bg-blue-200 text-blue-700 px-2 py-1 rounded">Alimentaire</span>
                <span class="text-sm bg-orange-200 text-orange-700 px-2 py-1 rounded">Fragile</span>
                <span class="text-sm bg-orange-500 text-orange-200 px-2 py-1 rounded">Incassable</span>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-600">nombre de cargaison :</span>
                <span>10</span>
            </div>
        </div>
    </div>
    <div class="mt-20">
        <div class="flex w-full">
            <div class="bg-white m-2 w-1/4"><canvas class="w-full" id="pieChart"></canvas></div>
            <div class="bg-white m-2"><canvas class="w-full" id="barChart"></canvas></div>
        </div>
        <div class="bg-white h-1/3 w-3/4 m-2"><canvas id="cargoChart"></canvas></div>

    </div>

</div>
<script src="path/to/chartjs/dist/chart.umd.js"></script>
<script src="../dist/dashboard.js"></script>

<!-- <div class="bg-white p-5"><canvas id="lineChart"></canvas></div> -->