<?php include_once __DIR__ . '/../templates/bar.php' ?>

<h1 class="page-name">New Appointment</h1>
<p class="page-description">Select your services and pick up a date and time</p>

<div id="app">
    <nav class="tabs">
        <button type="button" class="current" data-step="1">Services</button>
        <button type="button" data-step="2">Appointment Info</button>
        <button type="button" data-step="3">Summary</button>
    </nav>
    <div id="step-1" class="section">
        <h2>Services</h2>
        <p class="text-center">Choose your services</p>
        <div id="services" class="service-list"></div>
    </div>
    <div id="step-2" class="section">
        <h2>Your Data & Appointment</h2>
        <p class="text-center">Fill up your data and appointment date</p>

        <form class="form">
            <div class="field">
                <label for="name">Name</label>
                <input type="text" id="name" placeholder="your name" value="<?php echo $name ?>" disabled>
            </div>

            <div class="field">
                <label for="date">Date</label>
                <input type="date" id="date" min="<?php echo date('Y-m-d', strtotime('+1 day')) ?>">
            </div>

            <div class="field">
                <label for="time">Time</label>
                <input type="time" id="time">
            </div>

            <input type="hidden" id="id" value="<?php echo $id ?>">
        </form>
    </div>
    <div id="step-3" class="section content-summary">
        <h2>Summary</h2>
        <p class="text-center">Check & verify your appointment details</p>
    </div>

    <div class="pagination">
        <button id="previous" class="button">&laquo; Previous</button>
        <button id="next" class="button">Next &raquo;</button>
    </div>
</div>

<?php $script = "
<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script src='build/js/app.js'></script>
" ?>