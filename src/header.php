<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <style>
        body {
            margin-bottom: 100px; /* Adjust this value based on your footer height */
            position: relative;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            padding: 2rem;
        }
    </style>
</head>

<body>

    <nav class="navbar bg-body-tertiary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="homepage.php">BankX</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">BankX</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3"> 
                        <li class="nav-item">
                            <a class="nav-link" href="Admin/login.php">Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Support/index.php">Support</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Customer/index.php">Customer</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>