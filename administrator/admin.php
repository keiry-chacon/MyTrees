<?php

/*
* Admin Interface
*/

session_start();

require('../utils/functions.php');

if (empty(isset($_SESSION['Username']))) {
    header('Location: ../index.php'); 
    exit(); 
} elseif (!isset($_SESSION['Username']) || $_SESSION['Role_id'] != 1) {
    header('Location: ../access_denied.php'); 
    exit(); 
}

include '../inc/header_admin.php';

$genders = getFriends(); 
$availableTreesCount = getAvailableTreesCount(); 
$soldTreesCount = getSoldTreesCount(); 
?>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<main class="container mx-auto mt-10 p-4">
    <!-- Título y descripción principal -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <h1 class="text-4xl font-bold text-center mb-4">¡Welcome!</h1>
        <p class="text-lg text-gray-700 text-center">
            Welcome to the administration panel. Here you can view detailed statistics on registered friends and available and sold trees. 
            Use this information to make informed decisions and manage resources efficiently.
        </p>
    </div>

    <!-- Contenedores de estadísticas en flexbox -->
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Gráfico de Distribución de Amigos por Género -->
        <div class="bg-white shadow-lg rounded-lg p-6 w-full lg:w-1/2">
            <h2 class="text-xl font-semibold mb-4 text-center">Distribution of Friends by Gender</h2>
            <p class="text-gray-600 mb-6 text-sm text-center">
                This graph shows the distribution of registered friends according to gender. Use this information to understand the diversity in our community of friends.
            </p>
            <div class="flex flex-col items-center">
                <canvas id="genderChart" class="w-full h-60"></canvas>
                <div class="mt-6 text-left bg-gray-50 p-4 rounded-md w-full">
                    <h3 class="text-lg font-semibold text-center">Gender Details:</h3>
                    <div class="mt-4 flex justify-around text-gray-700">
                        <p><strong>Female:</strong> <?php echo $genders['F']; ?></p>
                        <p><strong>Male:</strong> <?php echo $genders['M']; ?></p>
                        <p><strong>Other:</strong> <?php echo $genders['O']; ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Gráfico de Comparación de Árboles Disponibles y Vendidos -->
        <div class="bg-white shadow-lg rounded-lg p-6 w-full lg:w-1/2">
            <h2 class="text-xl font-semibold mb-4 text-center">Comparison of Available and Sold Trees</h2>
            <p class="text-gray-600 mb-6 text-sm text-center">
                This graph compares the number of trees currently available and trees sold. Useful for monitoring inventories and evaluating the popularity of our offerings.
            </p>
            <canvas id="treesComparisonChart" class="w-full h-60"></canvas>
        </div>
    </div>

    <!-- Sección de mensajes adicionales -->
    <div class="bg-blue-50 shadow rounded-lg p-6 mt-8">
        <h2 class="text-xl font-semibold text-center text-blue-600">Aditional Information</h2>
        <p class="text-gray-700 mt-4">
            This statistics section allows managers to better understand the distribution of the community and the status of tree resources. The information gathered
            can assist in future management and planning decisions. It also fosters an inclusive and well-informed environment about the diversity of registered friends.
        </p>
        <p class="text-gray-700 mt-4">
            If you wish to make adjustments to the statistics displayed or update the data, you can go to the configuration section or contact technical support.
        </p>
    </div>
</main>

<script>
// Gráfico de comparación de árboles disponibles y vendidos
const availableTreesCount = <?php echo $availableTreesCount; ?>;
const soldTreesCount = <?php echo $soldTreesCount; ?>;

const ctxComparison = document.getElementById('treesComparisonChart').getContext('2d');
const treesComparisonChart = new Chart(ctxComparison, {
    type: 'bar',
    data: {
        labels: ['Trees'],
        datasets: [
            {
                label: 'Available Trees',
                data: [availableTreesCount],
                backgroundColor: 'rgba(0, 255, 0, 0.5)',
                borderColor: 'rgba(0, 255, 0, 1)',
                borderWidth: 2
            },
            {
                label: 'Trees Sold',
                data: [soldTreesCount],
                backgroundColor: 'rgba(255, 0, 0, 0.5)',
                borderColor: 'rgba(255, 0, 0, 1)',
                borderWidth: 2
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Comparison of Available and Sold Trees'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
            }
        }
    }
});
</script>

<script>
// Gráfico de distribución de amigos por género
const genders = {
    female: <?php echo $genders['F']; ?>,
    male: <?php echo $genders['M']; ?>,
    other: <?php echo $genders['O']; ?>
};

const ctx = document.getElementById('genderChart').getContext('2d');
const genderChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Female', 'Male', 'Other'],
        datasets: [{
            label: 'Number of Registered Friends',
            data: [genders.female, genders.male, genders.other],
            backgroundColor: [
                'rgba(255, 0, 0, 0.8)',
                'rgba(0, 0, 255, 0.8)',
                'rgba(0, 255, 0, 0.8)'
            ],
            borderColor: [
                'rgba(255, 0, 0, 1)',
                'rgba(0, 0, 255, 1)',
                'rgba(0, 255, 0, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Distribution of Friends by Gender'
            }
        }
    }
});
</script>
