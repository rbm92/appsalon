<h1 class="page-name">Create Account</h1>
<p class="page-description">Fill up the form to create an account</p>

<?php
include_once __DIR__ . "/../templates/alerts.php";
?>

<form action="/create-account" method="POST" class="form">
    <div class="field">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" placeholder="John" value="<?php echo s($user->name) ?>">
    </div>
    <div class="field">
        <label for="surname">Surname</label>
        <input type="text" name="surname" id="surname" placeholder="Smith" value="<?php echo s($user->surname) ?>">
    </div>
    <div class="field">
        <label for="phone">Phone</label>
        <input type="tel" name="phone" id="phone" placeholder="1234567890" value="<?php echo s($user->phone) ?>">
    </div>
    <div class="field">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="john@smith.com" value="<?php echo s($user->email) ?>">
    </div>
    <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="12**56">
    </div>
    <input type="submit" value="Create Account" class="button">
</form>

<div class="actions">
    <a href="/">Already have an account? Sign In</a>
    <a href="/forgot">Forgot your password? Reset It</a>
</div>