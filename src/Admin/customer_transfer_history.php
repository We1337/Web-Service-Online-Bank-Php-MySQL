<?php
include("include/header.php");

require("../Modules/config.php");

$userid = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM `Transfer` WHERE `CustomerID` = :userid");
$stmt->bindValue(":userid", $userid, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="list-group" style="padding-left: 2rem; padding-right: 2rem; padding-bottom: 5rem; padding-top: 1rem;">
    <?php
    foreach ($result as $row) {
    ?>
    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start " style="margin: 1px;">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1"><?php echo $row['Amount']; ?>₸</h5>
            <small><?php echo $row['TransferDate']; ?></small>
        </div>
        <p class="mb-1"></p>
        <small>To: <?php echo $row['RecipientName']; ?></small><br>
        <small>Phone: <?php echo $row['PhoneNumber']; ?></small><br>
    </a>
    <?php
    }
    ?>
</div>

<?php
include("include/footer.php");
?>