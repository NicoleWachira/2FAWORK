document.addEventListener("DOMContentLoaded", function () {
    // Get data from PHP
    const eventLabels = JSON.parse('<?php echo json_encode(array_column($revenueData, "event_name")); ?>');
    const revenueData = JSON.parse('<?php echo json_encode(array_column($revenueData, "revenue")); ?>');

    // Revenue Bar Chart
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: eventLabels,
            datasets: [{
                label: 'Revenue (Ksh)',
                data: revenueData,
                backgroundColor: 'yellow',
                borderColor: 'black',
                borderWidth: 2
            }]
        },
        options: {
            plugins: {
                legend: {
                    labels: {
                        color: 'yellow'
                    }
                }
            },
            scales: {
                x: {
                    ticks: { color: 'yellow' },
                    grid: { color: 'gray' }
                },
                y: {
                    ticks: { color: 'yellow' },
                    grid: { color: 'gray' }
                }
            }
        }
    });

    // Sales Pie Chart
    new Chart(document.getElementById('salesPieChart'), {
        type: 'pie',
        data: {
            labels: eventLabels,
            datasets: [{
                label: 'Ticket Sales',
                data: revenueData,
                backgroundColor: ['yellow', 'black', 'gray', '#FFD700', '#FFA500'],
                borderColor: 'black'
            }]
        },
        options: {
            plugins: {
                legend: {
                    labels: {
                        color: 'yellow'
                    }
                }
            }
        }
    });
});
