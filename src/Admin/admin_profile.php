<?php
include('include/header.php');

require_once("../Modules/config.php");

$stmt = $conn->prepare('SELECT * FROM `Admins`');
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5" style="padding-bottom: 10rem;">
    <h2>Edit Profile</h2>
    
    <form action="admin_profile_update.php" method="POST">
        <?php 
        foreach($result as $row) {
        ?>

        <div class="form-group">
            <?php 
            if(isset($_SESSION["message"]["username"])) {
                echo '<div class="alert alert-warning" role="alert">Please enter username</div>';
            }
            ?>
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="User name" value="<?= $row['Username']; ?>">
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <?php
            if(isset($_SESSION["message"]["email"])) {
                echo '<div class="alert alert-warning" role="alert">Please enter email</div>';
            }
            ?>
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?= $row['Email']; ?>" required>
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <?php 
            if(isset($_SESSION["message"]["firstname"])) {
                echo '<div class="alert alert-warning" role="alert">Please enter firstname</div>';
            }
            ?>
            <label for="firstname">First name</label> 
            <input type="firstname" class="form-control" id="firstname" name="firstname" placeholder="First name" value="<?= $row['FirstName'] ?>" required>
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <?php
            if(isset($_SESSION["message"]["lastname"])) {
                echo '<div class="alert alert-warning" role="alert">Please enter lastname</div>';
            }
            ?>
            <lable for="lastname">Last name</lable> 
            <input type="lastname" class="form-control" id="lastname" name="lastname" placeholder="Last name" value="<?= $row['LastName']; ?>" required>
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <?php
            if(isset($_SESSION["message"]["oldpassword"])) {
                echo '<div class="alert alert-warning" role="alert">Please enter old password</div>';
            } else if(isset($_SESSION['message']['password_verification'])) {
                echo '<div class="alert alert-warning" role="alert">Old password is wrong</div>';
            }
            ?>
            <label for="oldpassword">Old Password</label>
            <input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Enter old password" required>
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <?php
            if(isset($_SESSION["message"]["password"])) {
                echo '<div class="alert alert-warning" role="alert">Password</div>';
            } else if(isset($_SESSION['message']['password_is_not_same'])) {
                echo '<div class="alert alert-warning" role="alert">Password it is not the same</div>';
            } else if(isset($_SESSION['message']['password_lenght'])) {
                echo '<div class="alert alert-warning" role="alert">Password length must be 8 characters</div>';
            }
            ?>
            <label for="password">New Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password" required>
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <?php
            if(isset($_SESSION["message"]["confirmpassword"])) {
                echo '<div class="alert alert-warning" role="alert">Confirm password</div>';
            } else if(isset($_SESSION['message']['password_is_not_same'])) {
                echo '<div class="alert alert-warning" role="alert">Password it is not the same</div>';
            }
            ?>
            <label for="confirmpassword">Confirm Password</label>
            <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm new password" required>
        </div>

        <div style="padding-top: 1rem;">
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
        <?php
        }
        ?>
    </form>
</div>

<?php
include('include/footer.php');
?>