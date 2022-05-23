<h1 class="page-name">New Service</h1>
<p class="page-description">Fill up the form to Add a new service</p>

<?php include_once __DIR__ . '/../templates/alerts.php' ?>

<form action="/services/new" method="POST" class="form">
    <?php include_once __DIR__ . '/form.php' ?>
    <input type="submit" value="Add Service" class="button">
</form>