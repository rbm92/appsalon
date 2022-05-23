<h1 class="page-name">Login</h1>
<p class="page-description">Login with your credentials</p>

<?php
include_once __DIR__ . "/../templates/alerts.php";
?>

<form action="/" method="POST" class="form">
    <div class="field">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="john@smith.com">
    </div>
    <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="12**56">
    </div>

    <input type="submit" value="Login" class="button">
</form>

<div class="actions">
    <a href="/create-account">Don't have an account? Sign Up</a>
    <a href="/forgot">Forgot your password? Reset It</a>
</div>