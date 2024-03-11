<?php
include("include/header.php");

require("../Modules/config.php");

$userid = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM `Deposit` WHERE `CustomerID` = :userid");
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

<div style="padding: 1rem; padding-right: 1rem; padding-left: 1rem;">
    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <h4 class="my-0 font-weight-normal">Deposit</h4>
        </div>
        <div class="card-body">
            <?php if ($result): ?>
                <h1 class="card-title pricing-card-title">
                    <?php echo $result['Amount']; ?>₸
                </h1>
                <ul class="list-unstyled mt-3 mb-4">
                    <li>Created Time:
                        <?php echo $result['DepositDate']; ?>
                    </li>
                </ul>
            <?php else: ?>
                <p>No deposit information found for the specified user.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
include("include/footer.php");
?>