<?php

include("include/header.php");
require_once("../Modules/config.php");

$query = "SELECT * FROM `AdminEmail`";
$stmt = $conn->query($query);
?>

<div style="padding-left: 2rem; padding-top: 1rem;">
    <a class="btn btn-primary" href="system_email.php" role="button">Send Email</a>
</div>

<div class="list-group" style="padding-top: 2rem; padding-left: 2rem; padding-right: 2rem;">
    <?php
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
        <a href="system_email_display.php?id=<?php echo $row['EmailID']; ?>" class="list-group-item list-group-item-action" style="margin: 0.2rem;" aria-current="true">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1"><?php echo $row['EmailTitle']; ?></h5>
                <small><?php echo $row['EmailTime']; ?></small>
            </div>
            <p class="mb-1"><?php echo $row['EmailReciver']; ?></p>
        </a>
    <?php
    } 
    ?>
</div>


<?php
include("include/footer.php");
?>