<?php
include("include/header.php");

require_once("../Modules/config.php");

$query = "SELECT * FROM `Backup`";
$stmt = $conn->query($query);
?>

<div style="padding-left: 2rem; padding-top: 1rem;">
    <a class="btn btn-primary" href="backup_create.php" role="button">Create backup</a>
</div>

<div class="list-group" style="padding-top: 2rem; padding-left: 2rem; padding-right: 2rem;">
    <?php
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
        <a href="backup_information.php?id=<?php echo $row['BackupID']; ?>" class="list-group-item list-group-item-action active" style="margin: 0.2rem;" aria-current="true">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1"><?php echo $row['BackupName']; ?></h5>
                <small><?php echo $row['BackupDate']; ?></small>
            </div>
            <p class="mb-1"><?php echo $row['BackupDescription']; ?></p>
        </a>
    <?php
    } 
    ?>
</div>

<?php
include("include/footer.php");
?>