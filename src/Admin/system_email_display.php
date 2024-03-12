<?php
include("include/header.php");
require_once("../Modules/config.php");

$id = $_GET["id"];

$stmt = $conn->prepare("SELECT * FROM `AdminEmail` WHERE `EmailID` = :id");
$stmt->bindParam(":id", $id, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container" style="padding: 3rem; paddin-bottom: 8rem;">
    <div class="blog-post">
        <h2 class="blog-post-title">
            <?= $result['EmailTitle'] ?>
        </h2>
        <p class="blog-post-meta">
            <?= $result['EmailTime'] ?> by <b><?= $result['EmailSender']; ?>/<?= $result['EmailFromWho'] ?></b>
        </p>

        <p>
            <?= $result['EmailMessage'] ?>
        </p>
        <blockquote>
            Reciver:
            <b><?= $result['EmailReciver'] ?></b>
        </blockquote>
    </div>
</div>

<?php
include("include/footer.php");
?>