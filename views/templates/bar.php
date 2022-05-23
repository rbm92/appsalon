<div class="bar">
    <p>Hello, <?php echo $name ?? '' ?>!</p>
    <a href="/logout" class="button">Logout</a>
</div>

<?php
if (isset($_SESSION['admin'])) { ?>
    <div class="service-bar">
        <a class="button" href="/admin">Appointments</a>
        <a class="button" href="/services">Services</a>
        <a class="button" href="/services/new">New Service</a>
    </div>
<?php } ?>