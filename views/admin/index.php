<?php include_once __DIR__ . '/../templates/bar.php' ?>

<h1 class="page-name">Admin Panel</h1>
<h2>Appointment Searcher</h2>

<div class="search">
    <form class="form">
        <div class="field">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" value="<?php echo $date ?>">
        </div>
    </form>
</div>

<?php if (count($appointments) === 0) echo "<p>No appointments on this date</p>" ?>

<div id="admin-appointment">
    <ul class="appointments">
        <?php
        $appointmentId = 0;
        foreach ($appointments as $key => $appointment) {
            if ($appointmentId !== $appointment->id) {
                $total = 0;
        ?>
                <li>
                    <p>ID: <span><?php echo $appointment->id ?></span></p>
                    <p>Time: <span><?php echo $appointment->time ?></span></p>
                    <p>Customer: <span><?php echo $appointment->customer ?></span></p>
                    <p>Email: <span><?php echo $appointment->email ?></span></p>
                    <p>Phone: <span><?php echo $appointment->phone ?></span></p>

                    <h3>Services</h3>
                <?php
                $appointmentId = $appointment->id;
            } // End if 
            $total += $appointment->price;
                ?>
                <p class="service"><?php echo $appointment->service . " $" . $appointment->price ?></p>

                <?php
                $current = $appointment->id;
                $next = $appointments[$key + 1]->id ?? 0;

                if (isLast($current, $next)) { ?>
                    <p class="total">Total: <span>$<?php echo $total ?></span></p>

                    <form action="/api/delete" method="POST">
                        <input type="hidden" name="id" value="<?php echo $appointment->id ?>">
                        <input type="submit" value="Delete" class="delete-button">
                    </form>
            <?php }
            } // End foreach 
            ?>
    </ul>
</div>

<?php $script = "<script src='build/js/searcher.js'></script>" ?>