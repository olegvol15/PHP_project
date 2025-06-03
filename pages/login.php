<h1>Login</h1>

<?php
    Messages::getMessage();
?>

<form action="?page=login" method="post">
  <input type="hidden" name="action" value="loginUser">

    <div class="form-group mt-3">
        <label for="email">Email: </label>
        <input type="email" name="email" class="form-control" value="<?= OldInput::get('email') ?>">
    </div>

    <div class="form-group mt-3">
        <label for="password">Password:</label>
        <input type="password" name="password" class="form-control">
    </div>

    <button class="btn btn-primary mt-3" name="action" value="loginUser">Login</button>
</form>