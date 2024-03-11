<?php
include("include/header.php");
?>

<div class="container mt-5" style="padding-bottom: 8rem;">
    <h2>Create customer</h2>
    
    <form action="customer_create_process.php" method="POST">

        <div class="form-group" style="padding-top: 1rem;">
            <label for="firstname">First name</label>
            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First name">
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <label for="lastname">Last name</label>
            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last name">
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Email">
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <label for="phone">Phone number</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone number">
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Address">
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <label for="city">City</label>
            <input type="text" class="form-control" id="city" name="city" placeholder="City">
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <label for="region">Region</label>
            <input type="text" class="form-control" id="region" name="region" placeholder="Region">
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <label for="zipcode">Zip Code</label>
            <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Zip code">
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <label for="country">Country</label>
            <input type="text" class="form-control" id="country" name="country" placeholder="Country">
        </div>

        <div class="form-group" style="padding-top: 1rem;">
            <label for="oldpassword">Current password</label>
            <input type="text" class="form-control" id="currentpassword" name="currentpassword" placeholder="Current password">
        </div>

        <!-- Update Button -->
        <div style="padding-top: 1rem;">
            <button type="submit" class="btn btn-outline-primary">Update Profile</button>
            <a href="dashboard.php" class="btn btn-outline-primary">Exit</a>
        </div>
    </form>

</div>

<?php 
include("include/footer.php");
?>