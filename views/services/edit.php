<?php include_once __DIR__ . '/../templates/bar.php' ?>
<h1 class="page-name">Edit Service</h1>
<p class="page-description">Edit the service on this form</p>

<?php include_once __DIR__ . '/../templates/alerts.php' ?>

<form method="POST" class="form">
    <?php include_once __DIR__ . '/form.php' ?>
    <input type="submit" value="Update" class="button">
</form>