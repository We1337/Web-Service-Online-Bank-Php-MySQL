<?php
include("include/header.php");
require_once("../Modules/config.php");

$userid = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';

$stmt = $conn->prepare("SELECT * FROM `Customers` WHERE `CustomerID` = :userid");
$stmt->bindValue(":userid", $userid, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div style="padding-right: 1rem; padding-top: 1rem;">
	<ul class="nav justify-content-end">
		<li class="nav-item">
			<a class="btn btn-outline-primary" href="customer.php">View customer</a>
		</li>
	</ul>
</div>

<div style="padding: 1rem; padding-right: 1rem; padding-left: 1rem; padding-bottom: 8rem;">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">
				<?php echo $result['FirstName']; ?>
				<?php echo $result['LastName']; ?>
			</h4>
			<p class="card-text">Email:
				<?= $result['Email']; ?>
			</p>
			<p class="card-text">Phone:
				<?= $result['PhoneNumber']; ?>
			</p>
			<p class="card-text">Password:
				<?= $result['Password']; ?>
			</p>
			<p class="card-text">Address:
				<?= $result['Address']; ?>
			</p>
			<p class="card-text">City:
				<?= $result['City']; ?>
			</p>
			<p class="card-text">Region:
				<?= $result['State']; ?>
			</p>
			<p class="card-text">Zip code:
				<?= $result['ZipCode']; ?>
			</p>
			<p class="card-text">Country
				<?= $result['Country']; ?>
			</p>
			<p class="card-text"><small class="text-muted">Profile created at:
					<?php echo $result['RegistrationDate']; ?>
				</small></p>
		</div>
	</div>
</div>


<?php
include("include/footer.php");
?>