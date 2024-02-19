<?php
include("include/header.php");

// Execute the 'free' command to get server memory information
$memoryInfo = shell_exec('free -m');
$cpuUsage = exec("top -bn 2 -d 0.01 | grep '^%Cpu' | tail -n 1 | awk '{print $2}'");
$diskPath = '/';

// Split the output into lines and extract the second line, which contains the memory usage details
$memoryLines = explode("\n", $memoryInfo);
$memoryDetails = preg_split('/\s+/', trim($memoryLines[1])); // Use preg_split for more flexible splitting

// Get the used and total memory values
$usedMemory = intval($memoryDetails[2]);
$totalMemory = intval($memoryDetails[1]);

// Calculate the percentage of used memory
$percentageUsed = ($usedMemory / $totalMemory) * 100;

$freeSpace = disk_free_space($diskPath);
$totalSpcae = disk_total_space($diskPath);
$usedSpcae = $totalSpcae - $freeSpace;

function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= (1 << (10 * $pow));
    return round($bytes, $precision) . ' ' . $units[$pow];
}
?>

<div class="container mt-5" style="padding-left: 1rem; padding-right: 1rem; padding-bottom: 10rem;">
    <h1 class="mb-4">Server Performance</h1>

    <div class="row">
        <div class="col-md-6">
            <!-- Display Memory Information -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Memory Information</h5>
                    <p class="card-text">Used Memory: <?php echo "{$usedMemory} MB"; ?></p>
                    <p class="card-text">Total Memory: <?php echo "{$totalMemory} MB"; ?></p>
                    <p class="card-text">Percentage Used: <?php echo round($percentageUsed, 2) . "%"; ?></p>
                    <p class="card-text">CPU Usage: <?php echo $cpuUsage; ?>%</p>
                    <p class="card-text">Total Disk Space: <?php echo formatBytes($totalSpcae); ?></p>
                    <p class="card-text">Used Disk Space: <?php echo formatBytes($usedSpcae); ?></p>
                    <p class="card-text">Free Disk Space: <?php echo formatBytes($freeSpace); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6" style="padding: 1rem;">
            <!-- Display Chart -->
            <canvas id="memoryChart" width="300" height="300"></canvas>
        </div>

        <div class="col-md-6" style="padding: 2rem; padding-top: 2rem;">
            <canvas id="memoryChart1" width="300" height="300"></canvas>
        </div>

        <div class="col-md-6" style="padding: 2rem; padding-top: 2rem;">
            <canvas id="memoryChart2" width="300" height="300"></canvas>
        </div>
    </div>
</div>

<script>
    // Chart Memory
    let ctx = document.getElementById('memoryChart').getContext('2d');
    let memoryChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Used Memory', 'Free Memory'],
            datasets: [{
                data: [<?php echo $usedMemory; ?>, <?php echo $totalMemory - $usedMemory; ?>],
                backgroundColor: ['#FF6384', '#36A2EB'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'bottom',
            },
            title: {
                display: true,
                text: 'Memory Usage',
            },
        }
    });
</script>

<script>
    // Chart CPU
    let cpu = document.getElementById('memoryChart1').getContext('2d');
    let memoryChart1 = new Chart(cpu, {
        type: 'doughnut',
        data: {
            labels: ['CPU', 'Free CPU'],
            datasets: [{
                data: [<?php echo $cpuUsage; ?>, <?php echo 100 - $cpuUsage; ?>],
                backgroundColor: ['#FF6384', '#36A2EB'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'bottom',
            },
            title: {
                display: true,
                text: 'Memory Usage',
            },
        }
    });
</script>

<script>
    // Chart Disk space
    let space = document.getElementById('memoryChart2').getContext('2d');
    let memoryChart2 = new Chart(space, {
        type: 'doughnut',
        data: {
            labels: ['Disk Space', 'Free Space'],
            datasets: [{
                data: [<?php echo $usedSpcae; ?>, <?php echo $freeSpace; ?>],
                backgroundColor: ['#FF6384', '#36A2EB'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'bottom',
            },
            title: {
                display: true,
                text: 'Memory Usage',
            },
        }
    });
</script>

<?php
include("include/footer.php");
?>