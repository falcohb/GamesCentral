import './stimulus_bootstrap.js';
import './styles/app.css';

// Use turbo:load for Turbo.js compatibility (fires on initial load and after Turbo navigation)
document.addEventListener('turbo:load', function() {
    // Chart.js initialization with cyberpunk neon colors
    const ctx = document.getElementById('chartPie');
    if (ctx && typeof Chart !== 'undefined') {
        // Destroy existing chart instance if it exists (prevents memory leaks on navigation)
        const existingChart = Chart.getChart(ctx);
        if (existingChart) {
            existingChart.destroy();
        }

        const counts = JSON.parse(ctx.dataset.counts || '{}');

        // Refined color mapping per source
        const sourceColors = {
            'gamekult': '#c45c5c',
            'jvcom': '#5b9ea6',
            'ign': '#bf2b2b',
            'gameblog': '#9b7bb0',
            'jeuxonline': '#c9a66b',
            'gamergen': '#5eb8a2'
        };

        const labels = Object.keys(counts);
        const data = Object.values(counts);
        const colors = labels.map(label => sourceColors[label] || '#5b9ea6');

        // Check if there's at least some data to display
        const hasData = data.some(value => value > 0);

        if (hasData) {
            new Chart(ctx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: colors,
                        borderWidth: 2,
                        borderColor: '#0a0a0f',
                        hoverBorderWidth: 3,
                        hoverBorderColor: '#fff',
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '55%',
                    radius: '95%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(13, 15, 18, 0.95)',
                            titleColor: '#5b9ea6',
                            bodyColor: '#e8eaed',
                            borderColor: '#2a2f38',
                            borderWidth: 1,
                            titleFont: {
                                family: "'Orbitron', monospace",
                                size: 12
                            },
                            bodyFont: {
                                family: "'Share Tech Mono', monospace",
                                size: 13
                            },
                            padding: 12,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.parsed + ' articles';
                                }
                            }
                        }
                    }
                }
            });
        } else {
            // Display a message when no data
            ctx.parentElement.innerHTML = '<div class="text-center text-gray-500 font-mono text-sm py-8">NO_DATA</div>';
        }
    }

    // Source filters
    document.querySelectorAll('.source-filter').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const source = this.dataset.source;
            document.querySelectorAll('article[data-source="' + source + '"]').forEach(function(article) {
                article.style.display = checkbox.checked ? 'block' : 'none';
            });
        });
    });

    // Article expand/collapse with animation
    document.querySelectorAll('.article-title').forEach(function(title) {
        title.addEventListener('click', function() {
            const panel = this.nextElementSibling;
            panel.classList.toggle('open');
        });
    });

    // Staggered animation for articles
    document.querySelectorAll('.article-cyber').forEach(function(article, index) {
        article.style.opacity = '0';
        article.style.transform = 'translateY(20px)';
        setTimeout(function() {
            article.style.transition = 'all 0.4s ease-out';
            article.style.opacity = '1';
            article.style.transform = 'translateY(0)';
        }, 100 + (index * 50));
    });
});