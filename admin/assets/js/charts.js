// =================================================================
// UCAO ADMIN — Chart.js Initialization
// =================================================================

/**
 * Initialiser le graphique barres des métiers les plus demandés
 */
function initMetiersChart(canvasId, labels, data) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Demandes',
                data: data,
                backgroundColor: [
                    'rgba(24, 3, 145, 0.85)',
                    'rgba(42, 21, 179, 0.80)',
                    'rgba(139, 0, 0, 0.80)',
                    'rgba(255, 215, 0, 0.80)',
                    'rgba(16, 185, 129, 0.80)',
                    'rgba(59, 130, 246, 0.80)',
                    'rgba(245, 158, 11, 0.80)',
                    'rgba(139, 92, 246, 0.80)',
                    'rgba(236, 72, 153, 0.80)',
                    'rgba(14, 165, 233, 0.80)',
                ],
                borderRadius: 8,
                borderSkipped: false,
                barThickness: 28,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1a1a2e',
                    titleFont: { family: "'Poppins', sans-serif", size: 13, weight: '600' },
                    bodyFont: { family: "'Open Sans', sans-serif", size: 12 },
                    padding: 12,
                    cornerRadius: 10,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' demande(s)';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: { family: "'Open Sans', sans-serif", size: 11 },
                        color: '#636e72',
                        stepSize: 1,
                    },
                    grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false },
                    border: { display: false },
                },
                x: {
                    ticks: {
                        font: { family: "'Open Sans', sans-serif", size: 10 },
                        color: '#636e72',
                        maxRotation: 45,
                    },
                    grid: { display: false },
                    border: { display: false },
                }
            },
            animation: {
                duration: 1200,
                easing: 'easeOutQuart',
            }
        }
    });
}

/**
 * Initialiser le graphique camembert des filières recommandées
 */
function initFilieresChart(canvasId, labels, data) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return;

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: [
                    '#180391',
                    '#8B0000',
                    '#FFD700',
                    '#10b981',
                    '#3b82f6',
                    '#f59e0b',
                    '#8b5cf6',
                    '#ec4899',
                ],
                borderWidth: 3,
                borderColor: '#ffffff',
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { family: "'Open Sans', sans-serif", size: 11 },
                        color: '#636e72',
                        padding: 16,
                        usePointStyle: true,
                        pointStyleWidth: 10,
                    }
                },
                tooltip: {
                    backgroundColor: '#1a1a2e',
                    titleFont: { family: "'Poppins', sans-serif", size: 13, weight: '600' },
                    bodyFont: { family: "'Open Sans', sans-serif", size: 12 },
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percent = Math.round((context.parsed / total) * 100);
                            return context.label + ': ' + context.parsed + ' (' + percent + '%)';
                        }
                    }
                }
            },
            animation: {
                animateRotate: true,
                duration: 1500,
                easing: 'easeOutQuart',
            }
        }
    });
}

/**
 * Initialiser le graphique camembert des séries de BAC
 */
function initSeriesChart(canvasId, labels, data) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return;

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: [
                    '#FFD700', '#180391', '#8B0000', '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6'
                ],
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: { font: { family: "'Open Sans', sans-serif", size: 11 }, usePointStyle: true }
                },
                tooltip: {
                    backgroundColor: '#1a1a2e', titleFont: { family: "'Poppins', sans-serif" }, padding: 10
                }
            }
        }
    });
}

/**
 * Initialiser le graphique d'évolution temporelle (Orientations vs Préinscriptions)
 */
function initEvolutionChart(canvasId, labels, dataO, dataP) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Orientations',
                    data: dataO,
                    borderColor: '#180391',
                    backgroundColor: 'rgba(24, 3, 145, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#180391',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Préinscriptions',
                    data: dataP,
                    borderColor: '#8B0000',
                    backgroundColor: 'transparent',
                    borderWidth: 3,
                    tension: 0.4,
                    borderDash: [5, 5],
                    fill: false,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#8B0000',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: { position: 'top', labels: { usePointStyle: true, font: { family: "'Open Sans', sans-serif" } } },
                tooltip: { backgroundColor: '#1a1a2e', padding: 12, cornerRadius: 8, titleFont: { family: "'Poppins', sans-serif" }, bodyFont: { family: "'Open Sans', sans-serif" } }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)', borderDash: [5, 5] },
                    ticks: { stepSize: 1, color: '#636e72', font: { family: "'Open Sans', sans-serif" } }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#636e72', font: { family: "'Open Sans', sans-serif" }, maxTicksLimit: 10 }
                }
            }
        }
    });
}
