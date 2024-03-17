<?php
include("include/header.php");

require_once("../Modules/config.php");

$customer_id = $_SESSION["customer"]["id"];

$stmt = $conn->prepare("SELECT * FROM `Customers` WHERE `CustomerID` = :customer_id");
$stmt->bindParam(":customer_id", $customer_id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container rounded bg-white mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
            </div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile</h4>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="labels">Name</label>
                        <input type="text" class="form-control" value="<?= $result["FirstName"] ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="labels">Surname</label>
                        <input type="text" class="form-control" value="<?= $result["LastName"] ?>">
                    </div>
                </div>
                <div class="row mt-1">

                    <div class="col-md-12"><label class="labels">Telephone number</label>
                        <input type="text" class="form-control" value="<?= $result['PhoneNumber'] ?>">
                    </div>

                    <div class="col-md-12"><label class="labels">Address</label>
                        <input type="text" class="form-control" value="<?= $result['Address'] ?>">
                    </div>

                    <div class="col-md-12"><label class="labels">City</label>
                        <input type="text" class="form-control" value="<?= $result['City'] ?>">
                    </div>

                    <div class="col-md-12"><label class="labels">Region</label>
                        <input type="text" class="form-control" value="<?= $result['State'] ?>">
                    </div>

                    <div class="col-md-12"><label class="labels">Zip code</label>
                        <input type="text" class="form-control" value="<?= $result['ZipCode'] ?>">
                    </div>

                    <div class="col-md-12"><label class="labels">Country</label>
                        <input type="text" class="form-control" value="<?= $result['Country'] ?>">
                    </div>

                    <div class="col-md-12"><label class="labels">Email</label>
                        <input type="text" class="form-control" value="<?= $result['Email'] ?>">
                    </div>
                </div>
                <div class="mt-5 text-center">
                    <button class="btn btn-primary profile-button" type="button">Save Profile</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center experience"><span></span></div><br>
                <div class="col-md-12"><label class="labels">Info</label><input type="text" class="form-control" placeholder="experience" value=""></div> <br>
                <div class="col-md-12"><label class="labels">Info</label><input type="text" class="form-control" placeholder="additional details" value=""></div>
            </div>
        </div>
    </div>
</div>


<?php
include("include/footer.php");
?>