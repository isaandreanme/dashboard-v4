<div class="chart-container">
    <canvas id="jobChart"></canvas>
    <button id="saveChartButton" class="btn btn-primary mt-2">Save as PNG</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Pastikan Chart.js di-load -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('jobChart').getContext('2d');
        const jobChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!}, // Data labels dari PHP
                datasets: {!! json_encode($datasets) !!} // Data datasets dari PHP 
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Dapat Job per Kantor'
                    }
                }
            }
        });

        // Tambahkan event listener untuk menyimpan chart sebagai PNG
        document.getElementById('saveChartButton').addEventListener('click', function () {
            const link = document.createElement('a');
            link.href = jobChart.toBase64Image(); // Mengambil gambar dari canvas chart
            link.download = 'dapat_job_chart.png'; // Nama file yang akan diunduh
            link.click(); // Eksekusi klik tombol untuk mendownload
        });
    });
</script>
