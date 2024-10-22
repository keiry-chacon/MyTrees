<?php 
include 'inc/header_admin.php';
include 'utils/functions.php';
$genders = getFriends(); 
$availableTreesCount = getAvailableTreesCount(); 
$soldTreesCount = getSoldTreesCount(); 
?>

<main>
    <div class="statistics" style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div class="stat" style="flex: 1; margin-right: 20px;">
            <div style="display: flex; align-items: center;">
                <canvas id="genderChart" width="300" height="300"></canvas>
                <div style="margin-left: 20px;">
                    <h3>Detalles:</h3>
                    <p><strong>Femenino:</strong> <?php echo $genders['F']; ?></p>
                    <p><strong>Masculino:</strong> <?php echo $genders['M']; ?></p>
                    <p><strong>Otro:</strong> <?php echo $genders['O']; ?></p>
                </div>
            </div>
        </div>
        
        <div class="stat" style="flex: 1;">
            <canvas id="treesComparisonChart" width="400" height="400"></canvas>
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
    type: 'bar', // Tipo de gráfico: barras
    data: {
        labels: ['Árboles'], // Etiqueta para el eje X
        datasets: [
            {
                label: 'Árboles Disponibles',
                data: [availableTreesCount], // Datos de árboles disponibles
                backgroundColor: 'rgba(0, 255, 0, 0.5)', // Color de fondo para disponibles
                borderColor: 'rgba(0, 255, 0, 1)', // Color del borde para disponibles
                borderWidth: 2 // Ancho del borde
            },
            {
                label: 'Árboles Vendidos',
                data: [soldTreesCount], // Datos de árboles vendidos
                backgroundColor: 'rgba(255, 0, 0, 0.5)', // Color de fondo para vendidos
                borderColor: 'rgba(255, 0, 0, 1)', // Color del borde para vendidos
                borderWidth: 2 // Ancho del borde
            }
        ]
    },
    options: {
        responsive: true, // Gráfico adaptable a diferentes tamaños de pantalla
        plugins: {
            legend: {
                position: 'top', // Posición de la leyenda
            },
            title: {
                display: true,
                text: 'Comparación de Árboles Disponibles y Vendidos' // Título del gráfico
            }
        },
        scales: {
            y: {
                beginAtZero: true, // El eje Y comienza en 0
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
                    position: 'top', // Posición de la leyenda
                },
                title: {
                    display: true,
                    text: 'Distribución de Amigos por Género' // Título del gráfico
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
<link rel="stylesheet" href="/css/graphics.css"> 

<?php include 'inc/footer.php'; ?>
