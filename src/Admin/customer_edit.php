<?php
include("include/header.php");

require_once("../Modules/config.php");

$userid = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM `Customers` WHERE `CustomerID` = :userid");
$stmt->bindValue(":userid", $userid, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5" style="padding-bottom: 10rem;">
    <h2>Edit customer</h2>
    
    <form action="customer_edit_process.php" method="POST">
        <?php 
        foreach($result as $row) {
        ?>
        <input type="hidden" name="customerid" value="<?php echo $userid ?>">

        <!-- Username Input -->
        <div class="form-group" style="padding-top: 1rem;">
            <label for="firstname">First name</label>
            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First name" value="<?php echo $row['FirstName']; ?>">
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <label for="lastname">Last name</label>
            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last name" value="<?php echo $row['LastName']; ?>">
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $row['Email'] ?>">
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <label for="phone">Phone number</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone number" value="<?php echo $row['PhoneNumber']; ?>">
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?php echo $row['Address']; ?>">
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <label for="city">City</label>
            <input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?php echo $row['City']; ?>">
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <label for="region">Region</label>
            <input type="text" class="form-control" id="region" name="region" placeholder="Region" value="<?php echo $row['State']; ?>">
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <label for="zipcode">Zip Code</label>
            <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Zip code" value="<?php echo $row['ZipCode']; ?>">
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <label for="country">Country</label>
            <input type="text" class="form-control" id="country" name="country" placeholder="Country" value="<?php echo $row['Country']; ?>">
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <label for="oldpassword">Current password</label>
            <input type="text" class="form-control" id="currentpassword" name="currentpassword" placeholder="Current password" value="<?php echo $row['Password']; ?>">
        </div>

        <!-- Update Button -->
        <div style="padding-top: 1rem;">
            <button type="submit" class="btn btn-outline-primary">Update Profile</button>
            <a href="dashboard.php" class="btn btn-outline-primary">Exit</a>
        </div>

        <?php
        }
        ?>
    </form>
</div>

<?php 
include("include/footer.php");
?>