<?php

// Start the session to manage user login state
session_start();

// Check if the user is logged in, and retrieve the username
if (isset($_SESSION['admin']['session']) && $_SESSION['admin']['session'] === true) {
    $username = $_SESSION['admin']['username'];
} else {
    // Redirect to the login page if the user is not logged in
    $_SESSION['messages'][] = ['result' => "Please login!"];
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS and Chart.js -->
    <link rel="icon" href="https://blog.getbootstrap.com/assets/img/favicons/apple-touch-icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary" style="padding: 1rem;">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php"><b>BankX</b></a>
            <!-- Toggle button for responsive navigation -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Navigation links -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="dashboard.php">Home</a>
                    </li>
                    <!-- Customer dropdown menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Customer
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="customer_create.php">New customer</a></li>
                            <li><a class="dropdown-item" href="customer.php">View customers</a></li>
                        </ul>
                    </li>
                    <!-- Support dropdown menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Support
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">New support</a></li>
                            <li><a class="dropdown-item" href="#">View supports</a></li>
                        </ul>
                    </li>
                    <!-- Server dropdown menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Server
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="system_backup_display.php">Backup</a></li>
                            <li><a class="dropdown-item" href="system_shell.php">Shell</a></li>
                            <li><a class="dropdown-item" href="system_email_view.php">Email</a></li>
                        </ul>
                    </li>
                    <!-- Profile and Settings links -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="admin_profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Settings</a>
                    </li>
                </ul>
                <!-- Logout button -->
                <div class="d-flex">
                    <a href="logout.php" class="btn btn-outline-danger">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <?php

    // Display messages if any
    if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])) {
        foreach ($_SESSION['messages'] as $message) {
            // Set alert class based on message result
            $alertClass = ($message['result'] === 'Success') ? 'alert-success' : 'alert-danger';

            // Display the alert
            echo "<div class='alert $alertClass alert-dismissible fade show' role='alert'>";
            echo $message['result'];
            echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
            echo "</div>";
        }
        // Clear the displayed messages
        unset($_SESSION['messages']);
    }

    ?>
