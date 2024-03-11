<?php
include("include/header.php");
?>

<div style="padding: 2rem;">
    <h3>Email Sending</h3>
    <form action="system_email_process.php" method="POST">
        <div class="mb-3">
            <label for="recipient" class="form-label">Email address</label>
            <input type="email" class="form-control" name="recipient" id="recipient" placeholder="name@example.com" required>
        </div>
        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" name="subject" id="subject" placeholder="Simple title" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" name="message" id="message" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <button class="btn btn-outline-primary" type="submit">Send</button>
        </div>
    </form>
</div>

<?php
include("include/footer.php");
?>
