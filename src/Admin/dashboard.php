<?php
include("include/header.php");

$server_check_version = '1.0.4';
$start_time = microtime(TRUE);

$operating_system = PHP_OS_FAMILY;

if ($operating_system === 'Windows') {
    // Win CPU
    $wmi = new COM('WinMgmts:\\\\.');
    $cpus = $wmi->InstancesOf('Win32_Processor');
    $cpuload = 0;
    $cpu_count = 0;

    foreach ($cpus as $key => $cpu) {
        $cpuload += $cpu->LoadPercentage;
        $cpu_count++;
    }
    // WIN MEM
    $res = $wmi->ExecQuery('SELECT FreePhysicalMemory,FreeVirtualMemory,TotalSwapSpaceSize,TotalVirtualMemorySize,TotalVisibleMemorySize FROM Win32_OperatingSystem');
    $mem = $res->ItemIndex(0);
    $memtotal = round($mem->TotalVisibleMemorySize / 1000000, 2);
    $memavailable = round($mem->FreePhysicalMemory / 1000000, 2);
    $memused = round($memtotal - $memavailable, 2);
    // WIN CONNECTIONS
    $connections = shell_exec('netstat -nt | findstr :' . $_SERVER['SERVER_PORT'] . ' | findstr ESTABLISHED | find /C /V ""');
    $totalconnections = shell_exec('netstat -nt | findstr :' . $_SERVER['SERVER_PORT'] . ' | find /C /V ""');

} else {
    // Linux CPU
    $load = sys_getloadavg();
    $cpuload = $load[0];
    $cpu_count = shell_exec('nproc');
    // Linux MEM
    $free = shell_exec('free');
    $free = (string) trim($free);
    $free_arr = explode("\n", $free);
    $mem = explode(" ", $free_arr[1]);
    $mem = array_filter($mem, function ($value) {
        return ($value !== null && $value !== false && $value !== '');
    }); // removes nulls from array
    $mem = array_merge($mem); // puts arrays back to [0],[1],[2] after 
    $memtotal = round($mem[1] / 1000000, 2);
    $memused = round($mem[2] / 1000000, 2);
    $memfree = round($mem[3] / 1000000, 2);
    $memshared = round($mem[4] / 1000000, 2);
    $memcached = round($mem[5] / 1000000, 2);
    $memavailable = round($mem[6] / 1000000, 2);
    // Linux Connections
    $connections = `netstat -ntu | grep -E ':80 |443 ' | grep ESTABLISHED | grep -v LISTEN | awk '{print $5}' | cut -d: -f1 | sort | uniq -c | sort -rn | grep -v 127.0.0.1 | wc -l`;
    $totalconnections = `netstat -ntu | grep -E ':80 |443 ' | grep -v LISTEN | awk '{print $5}' | cut -d: -f1 | sort | uniq -c | sort -rn | grep -v 127.0.0.1 | wc -l`;
}

//$memusage = round(($memavailable/$memtotal)*100);
$memusage = round(($memused / $memtotal) * 100);


$phpload = round(memory_get_usage() / 1000000, 2);

$diskfree = round(disk_free_space(".") / 1000000000);
$disktotal = round(disk_total_space(".") / 1000000000);
$diskused = round($disktotal - $diskfree);

$diskusage = round($diskused / $disktotal * 100);

if ($memusage > 85 || $cpuload > 85 || $diskusage > 85) {
    $trafficlight = 'red';
} elseif ($memusage > 50 || $cpuload > 50 || $diskusage > 50) {
    $trafficlight = 'orange';
} else {
    $trafficlight = '#2F2';
}

$end_time = microtime(TRUE);
$time_taken = $end_time - $start_time;
$total_time = round($time_taken, 4);

// use servercheck.php?json=1
if (isset($_GET['json'])) {
    echo '{"ram":' . $memusage . ',"cpu":' . $cpuload . ',"disk":' . $diskusage . ',"connections":' . $totalconnections . '}';
    exit;
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
                    <p class="card-text">🌡️ RAM Usage:
                        <?php echo $memusage ?? 'Not Available'; ?>%
                    </p>
                    <p class="card-text">🖥️ CPU Usage:
                        <?php echo $cpuload ?? 'Not Available'; ?>%
                    </p>
                    <p class="card-text">💽 Hard Disk Usage:
                        <?php echo $diskusage ?? 'Not Available'; ?>%
                    </p>
                    <p class="card-text">🖧 Established Connections:
                        <?php echo $connections ?? 'Not Available'; ?>
                    </p>
                    <p class="card-text">🖧 Total Connections:
                        <?php echo $totalconnections ?? 'Not Available'; ?>
                    </p>
                    <hr>
                    <p class="card-text">🖥️ CPU Threads:
                        <?php echo $cpu_count ?? 'Not Available'; ?>
                    </p>
                    <hr>
                    <p class="card-text">🌡️ RAM Total:
                        <?php echo $memtotal ?? 'Not Available'; ?> GB
                    </p>
                    <p class="card-text">🌡️ RAM Used:
                        <?php echo $memused ?? 'Not Available'; ?> GB
                    </p>
                    <p class="card-text">🌡️ RAM Available:
                        <?php echo $memavailable ?? 'Not Available'; ?> GB
                    </p>
                    <hr>
                    <p class="card-text">💽 Hard Disk Free:
                        <?php echo $diskfree ?? 'Not Available'; ?> GB
                    </p>
                    <p class="card-text">💽 Hard Disk Used:
                        <?php echo $diskused ?? 'Not Available'; ?> GB
                    </p>
                    <p class="card-text">💽 Hard Disk Total:
                        <?php echo $disktotal ?? 'Not Available'; ?> GB
                    </p>
                    <hr>
                    <p class="card-text">📟 Server Name:
                        <?php echo $_SERVER['SERVER_NAME'] ?? 'Not Available'; ?>
                    </p>
                    <p class="card-text">💻 Server Addr:
                        <?php echo $_SERVER['SERVER_ADDR'] ?? 'Not Available'; ?>
                    </p>
                    <p class="card-text">🌀 PHP Version:
                        <?php echo phpversion() ?? 'Not Available'; ?>
                    </p>
                    <p class="card-text">🏋️ PHP Load:
                        <?php echo $phpload ?? 'Not Available'; ?> GB
                    </p>
                    <p class="card-text">⏱️ Load Time:
                        <?php echo $total_time ?? 'Not Available'; ?> sec
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6" style="padding: 2rem; padding-top: 2rem;">
            <!-- Display Memory Chart -->
            <canvas id="memoryChart" width="100" height="100"></canvas>
        </div>

        <div class="col-md-6" style="padding: 2rem; padding-top: 2rem;">
            <!-- Display CPU Chart -->
            <canvas id="cpuChart" width="300" height="300"></canvas>
        </div>

        <div class="col-md-6" style="padding: 2rem; padding-top: 2rem;">
            <!-- Display Disk Space Chart -->
            <canvas id="diskSpaceChart" width="300" height="300"></canvas>
        </div>
    </div>
</div>

<script>
    // Chart Memory
    let ctxMemory = document.getElementById('memoryChart').getContext('2d');
    let memoryChart = new Chart(ctxMemory, {
        type: 'doughnut',
        data: {
            labels: ['Used Memory', 'Free Memory'],
            datasets: [{
                data: [<?php echo $memused; ?>, <?php echo $memavailable; ?>],
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
    let ctxCpu = document.getElementById('cpuChart').getContext('2d');
    let cpuChart = new Chart(ctxCpu, {
        type: 'doughnut',
        data: {
            labels: ['CPU', 'Free CPU'],
            datasets: [{
                data: [<?php echo $cpuload; ?>, <?php echo 100 - $cpuload; ?>],
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
                text: 'CPU Usage',
            },
        }
    });
</script>

<script>
    // Chart Disk space
    let ctxDiskSpace = document.getElementById('diskSpaceChart').getContext('2d');
    let diskSpaceChart = new Chart(ctxDiskSpace, {
        type: 'doughnut',
        data: {
            labels: ['Disk Space Used', 'Free Disk Space'],
            datasets: [{
                data: [<?php echo $diskusage; ?>, <?php echo $diskfree; ?>],
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
                text: 'Disk Space Usage',
            },
        }
    });
</script>

<?php
include("include/footer.php");
?>