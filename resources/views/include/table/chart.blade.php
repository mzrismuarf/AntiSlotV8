<canvas id="resultScanChart"></canvas>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('resultScanChart').getContext('2d');
        var resultScanChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Directory Safe',
                    data: @json($chartData['safeCounts']),
                    backgroundColor: '#5ddab4'
                }, {
                    label: 'Directory Infected',
                    data: @json($chartData['infectedCounts']),
                    backgroundColor: '#ff7976'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Directory Safety Analysis'
                    },
                    legend: {
                        position: 'bottom' // Ubah posisi legenda ke bawah
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1, // Menentukan langkah tick
                            max: 5, // Menentukan nilai maksimum
                            callback: function(value) {
                                return Number.isInteger(value) ? value : null; // Menampilkan hanya angka bulat
                            }
                        }
                    }
                }
            }
        });
    });
</script>