<?php

// Start the session to manage user login state
session_start();

// Check if the user is logged in, and retrieve the username
if (isset($_SESSION['customer']['session']) && $_SESSION['customer']['session'] === true) {
     
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
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="news.php">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="nearestbank.php">Nearest Bank</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Settings</a>
                    </li>
                </ul>
                <a href="customer_profile.php">
                    <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                </a>
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
            echo $message['message'];
            echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
            echo "</div>";
        }
        // Clear the displayed messages
        unset($_SESSION['messages']);
    }

    ?>