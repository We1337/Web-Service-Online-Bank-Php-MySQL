<?php
include("include/header.php");

require_once("../Modules/config.php");

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM `Backup` WHERE `BackupID` = :id");
$stmt->bindParam('id', $id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php
foreach ($result as $row) {
?>
    <div style="padding: 3rem;">
        <div class="card text-center">
            <div class="card-header">
                <?php echo $row['BackupLocation']; ?>
                1
            </div>
            <div class="card-body" style="margin: 3rem;">
                <h5 class="card-title"><?php echo $row['BackupName']; ?></h5>
                <p class="card-text"><?php echo $row['BackupDescription']; ?></p>
                <a href="backup_download.php?id=<?php echo $id; ?>" class="btn btn-primary">Download</a>
                <a href="backup_delete.php?id=<?php echo $id; ?>" class="btn btn-danger">Delete</a>
            </div>
            <div class="card-footer text-body-secondary">
                <?php echo $row['BackupDate']; ?>
            </div>
        </div>
    </div>
<?php
}
?>

<?php
include("include/footer.php");
?>