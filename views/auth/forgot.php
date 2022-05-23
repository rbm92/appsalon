<h1 class="page-name">Forgot Password</h1>
<p class="page-description">A link to reset your password will be sent to your email</p>

<?php include_once __DIR__ . '/../templates/alerts.php' ?>

<form action="/forgot" method="POST" class="form">
    <div class="field">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="john@smith.com">
    </div>
    <input type="submit" value="Get Link" class="button">
</form>

<div class="actions">
    <a href="/">Already have an account?</a>
    <a href="/create-account">Don't have an account?</a>
</div>