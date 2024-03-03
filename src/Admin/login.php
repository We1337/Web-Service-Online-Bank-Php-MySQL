<?php
session_start();

require_once("../Modules/config.php");

if(isset($_SESSION['admin']['session']) && $_SESSION['admin']['session'] === true) {
    header('Location: dashboard.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';

    $stmt = $conn->prepare('SELECT `AdminID`, `Username`, `Password`, `FirstName`, `LastName`, `Email` FROM `Admins` WHERE `Username` = :username');
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $hashed_password = $result['Password'];
        if (password_verify($password, $hashed_password)) {
            // Session is active
            $_SESSION['admin']['session'] = true;

            // Information about Admin
            $_SESSION['admin']['id'] = $result['AdminID'];
            $_SESSION['admin']['username'] = $result['Username'];
            $_SESSION['admin']['firstname'] = $result['FirstName'];
            $_SESSION['admin']['lastname'] = $result['LastName'];
            $_SESSION['admin']['email'] = $result['Email'];

            // Message log
            $_SESSION['message'] = "Welcome: " . $username;

            $time = $conn->prepare('UPDATE `Admins` SET `LoginTime` = CURRENT_TIMESTAMP WHERE `Username` = :username');
            $time->bindParam(':username', $result['Username'], PDO::PARAM_STR);
            $time->execute();

            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION["message"] = "Invalid password";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION["message"] = "Invalid username";
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

    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7  mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <h2 class="text-center mb-4">Sign In</h2>
                        <?php
                        if(isset($_SESSION['message'])) {
                            echo '<p class="alert alert-warning">' . $_SESSION['message'] . '</p>';
                            unset($_SESSION['message']);
                        }
                        ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label"><b>Username</b></label>
                                <input type="text" class="form-control" name="username" placeholder="Admin" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label"><b>Password</b></label>
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Sign In</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>

</body>

</html>