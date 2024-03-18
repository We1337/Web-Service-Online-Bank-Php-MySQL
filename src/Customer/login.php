<?php
session_start();

require("../Modules/config.php");

if (isset($_SESSION["customer"]["session"]) && $_SESSION["customer"]["session"] === true) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phonenumber = isset($_POST["phonenumber"]) ? htmlspecialchars($_POST["phonenumber"]) : "";
    $password = isset($_POST["password"]) ? htmlspecialchars($_POST["password"]) : "";

    if (!is_numeric($phonenumber)) {
        $_SESSION["telephone_numeric"] = "Invalid telephone numbers";
        header("Location: login.php");
        exit();
    }

    if (empty($phonenumber)) {
        $_SESSION["phonenumber"] = "Telephone number is empty";
        header("Location: login.php");
        exit();
    }

    if (empty($password)) {
        $_SESSION["password"] = "Password is empty";
        header("Location: login.php");
        exit();
    }

    $phonenumber = preg_replace('/[^A-Za-z0-9\s]/', '', $phonenumber);

    $stmt = $conn->prepare("SELECT * FROM `Customers` WHERE `PhoneNumber`=:phonenumber");
    $stmt->bindParam(":phonenumber", $phonenumber, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $hashed_password = $result['Password'];
        if (password_verify($password, $hashed_password)) {

            unset($_SESSION['messages']);

            $_SESSION["customer"]["session"] = true;

            $_SESSION["customer"]["id"] = $result["CustomerID"];
            $_SESSION["customer"]["firstname"] = $result["FirstName"];
            $_SESSION["customer"]["lastname"] = $result["LastName"];
            $_SESSION["customer"]["email"] = $result["Email"];
            $_SESSION["customer"]["phonenumber"] = $result["PhoneNumber"];
            $_SESSION["customer"]["address"] = $result["Address"];
            $_SESSION["customer"]["city"] = $result["City"];
            $_SESSION["customer"]["state"] = $result["State"];
            $_SESSION["customer"]["zipcode"] = $result["ZipCode"];
            $_SESSION["customer"]["country"] = $result["Country"];

            $time = $conn->prepare("UPDATE `Customers` SET `LastLogin` = CURRENT_TIMESTAMP WHERE `PhoneNumber` = :phonenumber");
            $time->bindParam(":phonenumber", $result["PhoneNumber"], PDO::PARAM_STR);
            $time->execute();

            $_SESSION["messages"][] = ["result" => "Success", "message" => "Hi there " . $result['FirstName'] . ' ' . $result['LastName']];
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION["invalid_password"] = "Invalid password";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION["invalid_phone_number"] = "Invalid telephone number";
        header("Location: login.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="https://blog.getbootstrap.com/assets/img/favicons/apple-touch-icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Login</title>
</head>

<body>

    <section class="background-radial-gradient overflow-hidden">
        <style>
            .background-radial-gradient {
                background-color: hsl(218, 41%, 15%);
                background-image: radial-gradient(650px circle at 0% 0%,
                        hsl(218, 41%, 35%) 15%,
                        hsl(218, 41%, 30%) 35%,
                        hsl(218, 41%, 20%) 75%,
                        hsl(218, 41%, 19%) 80%,
                        transparent 100%),
                    radial-gradient(1250px circle at 100% 100%,
                        hsl(218, 41%, 45%) 15%,
                        hsl(218, 41%, 30%) 35%,
                        hsl(218, 41%, 20%) 75%,
                        hsl(218, 41%, 19%) 80%,
                        transparent 100%);
            }

            #radius-shape-1 {
                height: 220px;
                width: 220px;
                top: -60px;
                left: -130px;
                background: radial-gradient(#44006b, #ad1fff);
                overflow: hidden;
            }

            #radius-shape-2 {
                border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
                bottom: -60px;
                right: -110px;
                width: 300px;
                height: 300px;
                background: radial-gradient(#44006b, #ad1fff);
                overflow: hidden;
            }

            .bg-glass {
                background-color: hsla(0, 0%, 100%, 0.9) !important;
                backdrop-filter: saturate(200%) blur(25px);
            }
        </style>

        <header class="p-3 bg-dark text-white">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="#" class="nav-link px-2 text-white">BankX</a></li>
                        <li><a href="#" class="nav-link px-2 text-white">News</a></li>
                        <li><a href="#" class="nav-link px-2 text-white">Nearest Bank</a></li>
                        <li><a href="#" class="nav-link px-2 text-white">Contact</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
            <div class="row gx-lg-5 align-items-center mb-5">
                <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
                    <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
                        BankX <br />
                        <span style="color: hsl(218, 81%, 75%)">bank of the people</span>
                    </h1>
                    <p class="mb-4 opacity-70" style="color: hsl(218, 81%, 85%)">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                        Temporibus, expedita iusto veniam atque, magni tempora mollitia
                        dolorum consequatur nulla, neque debitis eos reprehenderit quasi
                        ab ipsum nisi dolorem modi. Quos?
                    </p>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
                    <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                    <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

                    <div class="card bg-glass">
                        <div class="card-body px-4 py-5 px-md-5">
                            <form method="POST">
                                <!-- Email input -->
                                <?php
                                if (isset($_SESSION['telephone_numeric'])) {
                                    echo '<p class="alert alert-warning">' . $_SESSION['telephone_numeric'] . '</p>';
                                } else if (isset($_SESSION['phonenumber'])) {
                                    echo '<p class="alert alert-warning">' . $_SESSION['phonenumber'] . '</p>';
                                } else if (isset($_SESSION['invalid_phone_number'])) {
                                    echo '<p class="alert alert-warning">' . $_SESSION['invalid_phone_number'] . '</p>';
                                }
                                ?>
                                <div class="form-outline mb-4">
                                    <input type="text" id="phonenumber" name="phonenumber" class="form-control"
                                        placeholder="+7XXX-XXX-XXXX" value="<?= '+7' ?>" required>
                                    <label class="form-label" for="phonenumber">Telephone number</label>
                                </div>

                                <!-- Password input -->
                                <?php
                                if (isset($_SESSION['password'])) {
                                    echo '<p class="alert alert-warning">' . $_SESSION['password'] . '</p>';
                                } else if ($_SESSION['invalid_password']) {
                                    echo '<p class="alert alert-warning">' . $_SESSION['invalid_password'] . '</p>';
                                }
                                ?>
                                <div class="form-outline mb-4">
                                    <input type="password" id="password" name="password" class="form-control"
                                        placeholder="Password" required>
                                    <label class="form-label" for="password">Password</label>
                                </div>

                                <!-- Submit button -->
                                <button type="submit" class="btn btn-primary btn-block mb-4">
                                    Sign in
                                </button>
                                <button type="submit" class="btn btn-primary btn-block mb-4">
                                    Sign up
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <p class="col-md-4 mb-0 text-muted">© 2024 Company, Inc</p>

            <a href="/"
                class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <svg class="bi me-2" width="40" height="32">
                    <use xlink:href="#bootstrap"></use>
                </svg>
            </a>

            <ul class="nav col-md-4 justify-content-end">
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Features</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Pricing</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">FAQs</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">About</a></li>
            </ul>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>

</body>

</html>