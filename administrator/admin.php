<?php
session_start();
require('../utils/functions.php');

if (empty(isset($_SESSION['Username']))) {
    header('Location: ../index.php'); 
    exit(); 
}
elseif (!isset($_SESSION['Username']) || $_SESSION['Role_id'] != 1) {
    header('Location: ../access_denied.php'); 
    exit(); 
}

include '../inc/header_admin.php';

$genders = getFriends(); 
$availableTreesCount = getAvailableTreesCount(); 
$soldTreesCount = getSoldTreesCount(); 
?>

<main>
    <div class="statistics" style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div class="stat" style="flex: 1; margin-right: 20px;">
            <div style="display: flex; align-items: center;">
                <canvas id="genderChart" width="350" height="300"></canvas>
                <div style="margin-left: 20px;">
                    
                </div>
            </div>
        </div>
        
        <div class="stat" style="flex: 1;">
            <canvas id="treesComparisonChart" width="400" height="300"></canvas>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Gráfico de comparación de árboles disponibles y vendidos
const availableTreesCount = <?php echo $availableTreesCount; ?>;
const soldTreesCount = <?php echo $soldTreesCount; ?>;

const ctxComparison = document.getElementById('treesComparisonChart').getContext('2d');
const treesComparisonChart = new Chart(ctxComparison, {
    type: 'bar',
    data: {
        labels: ['Árboles'],
        datasets: [
            {
                label: 'Árboles Disponibles',
                data: [availableTreesCount],
                backgroundColor: 'rgba(0, 255, 0, 0.5)',
                borderColor: 'rgba(0, 255, 0, 1)',
                borderWidth: 2
            },
            {
                label: 'Árboles Vendidos',
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
                labels: {
                    color: '#0a0a0a' // Color blanco para las etiquetas de la leyenda
                }
            },
            title: {
                display: true,
                text: 'Comparación de Árboles Disponibles y Vendidos',
                color: '#0a0a0a' // Color blanco para el título
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#0a0a0a' // Color blanco para las etiquetas del eje Y
                }
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
        type: 'pie', // Tipo de gráfico: circular
        data: {
            labels: ['Femenino', 'Masculino', 'Otro'], // Etiquetas del gráfico
            datasets: [{
                label: 'Cantidad de Amigos Registrados',
                data: [genders.female, genders.male, genders.other], // Datos de amigos por género
                backgroundColor: [
                    'rgba(255, 0, 0, 0.8)', // Color para femenino
                    'rgba(0, 0, 255, 0.8)', // Color para masculino
                    'rgba(0, 255, 0, 0.8)'  // Color para otro
                ],
                borderColor: [
                    'rgba(255, 0, 0, 1)',
                    'rgba(0, 0, 255, 1)',
                    'rgba(0, 255, 0, 1)'
                ],
                borderWidth: 2 // Ancho del borde
            }]
        },
        options: {
            responsive: true, // Gráfico adaptable
            plugins: {
                legend: {
                    position: 'top', 
                    labels: {
                    color: '#0a0a0a' // Color blanco para las etiquetas de la leyenda
                }
                },
                title: {
                    display: true,
                    text: 'Distribución de Amigos por Género',
                    color: '#0a0a0a'
                }
            }
        }
    });
</script>

<style>
    #soldTreesIcons {
        display: flex;
        flex-wrap: wrap; /* Permite que los íconos se ajusten a la línea */
        justify-content: flex-start; /* Alinea los íconos al inicio */
    }
</style>
<link rel="stylesheet" href="../css/dashboard.css"> 

