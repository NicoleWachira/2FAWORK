

// document.addEventListener("DOMContentLoaded", function () {
//     if (typeof eventLabels === "undefined" || typeof revenueData === "undefined") {
//         console.error("Chart data is missing. Check PHP script.");
//         return;
//     }

//     if (!eventLabels.length || !revenueData.length) {
//         console.warn("No revenue data available.");
//         return;
//     }

//     // Revenue Bar Chart
//     new Chart(document.getElementById("revenueChart"), {
//         type: "bar",
//         data: {
//             labels: eventLabels,
//             datasets: [{
//                 label: "Revenue (Ksh)",
//                 data: revenueData,
//                 backgroundColor: "yellow",
//                 borderColor: "black",
//                 borderWidth: 2
//             }]
//         },
//         options: {
//             plugins: {
//                 legend: { labels: { color: "yellow" } }
//             },
//             scales: {
//                 x: { ticks: { color: "yellow" }, grid: { color: "gray" } },
//                 y: { ticks: { color: "yellow" }, grid: { color: "gray" } }
//             }
//         }
//     });

//     // Sales Pie Chart
//     new Chart(document.getElementById("salesPieChart"), {
//         type: "pie",
//         data: {
//             labels: eventLabels,
//             datasets: [{
//                 label: "Ticket Sales",
//                 data: revenueData,
//                 backgroundColor: ["yellow", "black", "gray", "#FFD700", "#FFA500"],
//                 borderColor: "black"
//             }]
//         },
//         options: {
//             plugins: {
//                 legend: { labels: { color: "yellow" } }
//             }
//         }
//     });
// });


document.addEventListener("DOMContentLoaded", function () {
    // Line Graph for purchases per month
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Number of Purchases',
                data: totalPurchases,
                backgroundColor: 'rgba(255, 193, 7, 0.5)',
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { labels: { color: 'black' } }
            },
            scales: {
                x: { ticks: { color: 'black' }, grid: { color: 'gray' } },
                y: { ticks: { color: 'black' }, grid: { color: 'gray' } }
            }
        }
    });

    // Pie Chart for ticket sales per month
    new Chart(document.getElementById('salesPieChart'), {
        type: 'pie',
        data: {
            labels: months,
            datasets: [{
                data: totalPurchases,
                backgroundColor: ['yellow', 'black', 'gray', '#FFD700', '#FFA500'],
                borderColor: 'black'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { labels: { color: 'black' } }
            }
        }
    });
});


