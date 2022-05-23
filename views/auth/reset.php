<h1 class="page-name">Reset Password</h1>
<p class="page-description">Set your new password here</p>

<?php include_once __DIR__ . '/../templates/alerts.php' ?>

<?php if ($error) return ?>

<form method="POST" class="form">
    <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="your new password">
    </div>
    <input type="submit" value="Set New Password" class="button">
</form>

<div class="actions">
    <a href="/">Already have an account? Sign In</a>
    <a href="/create-account">Don't have an account? Sign Up</a>
</div>