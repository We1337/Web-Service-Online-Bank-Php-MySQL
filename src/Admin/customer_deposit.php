<?php
include("include/header.php");

require("../Modules/config.php");

$userid = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM `Deposit` WHERE `CustomerID` = :userid");
$stmt->bindValue(":userid", $userid, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="card mb-4 shadow-sm" style="padding: 5rem;">
    <div class="card-header">
        <h4 class="my-0 font-weight-normal">Deposit</h4>
    </div>
    <div class="card-body">
        <?php if ($result) : ?>
            <h1 class="card-title pricing-card-title"><?php echo $result['Amount']; ?>₸</h1>
            <ul class="list-unstyled mt-3 mb-4">
                <li>Created Time: <?php echo $result['DepositDate']; ?></li> 
            </ul>
            <button type="button" class="btn btn btn-block btn-danger">Delete</button>
        <?php else : ?>
            <p>No deposit information found for the specified user.</p>
        <?php endif; ?>
    </div>
</div>

<?php
include("include/footer.php");
?>