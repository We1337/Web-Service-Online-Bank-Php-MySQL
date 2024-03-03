<?php
include('include/header.php');

require_once("../Modules/config.php");

$stmt = $conn->prepare('SELECT * FROM `Admins`');
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_SESSION["message"]["admin_data_updated"])) {
    echo '<div class="alert alert-warning" role="alert"><?php echo $_SESSION["message"]; ?></div>';
}

?>

<div class="container mt-5" style="padding-bottom: 10rem;">
    <h2>Edit Profile</h2>
    
    <form action="profile_update.php" method="post">
        <?php 
        foreach($result as $row) {
        ?>
        <!-- Username Input -->
        <div class="form-group">
            <?php 
            if(isset($_SESSION["message"]["username"])) {
                echo '<div class="alert alert-warning" role="alert">This is a warning alert—check it out!</div>';
            }
            ?>
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="User name" value="<?php echo $row['Username']; ?>">
        </div>

        <!-- Email Input -->
        <div class="form-group" style="padding-top: 1rem;">
            <?php
            if(isset($_SESSION["message"]["email"])) {
                echo '<div class="alert alert-warning" role="alert">Email</div>';
            }
            ?>
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $row['Email']; ?>" required>
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <?php 
            if(isset($_SESSION["message"]["firstname"])) {
                echo '<div class="alert alert-warning" role="alert">Firstname</div>';
            }
            ?>
            <label for="firstname">First name</label> 
            <input type="firstname" class="form-control" id="firstname" name="firstname" placeholder="First name" value="<?php echo $row['FirstName'] ?>" require>
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <?php
            if(isset($_SESSION["message"]["lastname"])) {
                echo '<div class="alert alert-warning" role="alert">Lastname</div>';
            }
            ?>
            <lable for="lastname">Last name</lable> 
            <input type="lastname" class="form-control" id="lastname" name="lastname" placeholder="Last name" value="<?php echo $row['LastName']; ?>" require>
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <?php
            if(isset($_SESSION["message"]["oldpassword"])) {
                echo '<div class="alert alert-warning" role="alert">Old password</div>';
            }
            ?>
            <label for="lastname">Old Password</label>
            <input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Enter old password">
        </div>

        <!-- Password Input -->
        <div class="form-group" style="padding-top: 1rem;">
            <?php
            if(isset($_SESSION["message"]["password"])) {
                echo '<div class="alert alert-warning" role="alert">Password</div>';
            }
            ?>
            <label for="password">New Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password">
        </div>

        <!-- Confirm Password Input -->
        <div class="form-group" style="padding-top: 1rem;">
            <?php
            if(isset($_SESSION["message"]["confirmpassword"])) {
                echo '<div class="alert alert-warning" role="alert">Confirm password</div>';
            }
            ?>
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm new password">
        </div>

        <!-- Update Button -->
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