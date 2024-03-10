<?php
include("include/header.php");
?>

<form action="system_backup_process.php" method="post">
    <div style="padding: 2rem;">
        <div class="mb-3">
            <label for="input" class="form-label">Backup title</label>
            <input type="text" name="title" id="input" class="form-control" placeholder="" require>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3" require></textarea>
        </div>
        <div class="mb-3">
            <button class="btn btn-primary" value="submit">Create backup</button>
        </div>
    </div>
</form>

<?php
include("include/footer.php");
?>