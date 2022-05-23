<?php include_once __DIR__ . '/../templates/bar.php' ?>

<h1 class="page-name">Services</h1>
<p class="page-description">Service Management</p>

<ul class="services">
    <?php foreach ($services as $service) { ?>
        <li>
            <p>Name: <span><?php echo $service->name ?></span></p>
            <p>Price: <span>$<?php echo $service->price ?></span></p>

            <div class="actions">
                <a class="button" href="/services/edit?id=<?php echo $service->id ?>">Edit</a>

                <form action="/services/delete" method="POST">
                    <input type="hidden" name="id" value="<?php echo $service->id ?>">
                    <input type="submit" value="Delete" class="delete-button">
                </form>
            </div>
        </li>
    <?php } ?>
</ul>