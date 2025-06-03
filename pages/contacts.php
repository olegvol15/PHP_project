<h1>Contacts Us</h1>

<?php
    Messages::getMessage();
?>

<form action="/project-p22/contacts" method="post">

    <div class="form-group mt-3">
        <label for="name">Name: </label>
        <input type="text" name="name" class="form-control" value="<?= OldInput::get('name') ?>">
    </div>

    <div class="form-group mt-3">
        <label for="email">Email: </label>
        <input type="email" name="email" class="form-control" value="<?= OldInput::get('email') ?>">
    </div>

    <div class="form-group mt-3">
        <label for="message">Message: </label>
        <textarea name="message" class="form-control"><?= OldInput::get('message') ?></textarea>
    </div>

    <button class="btn btn-primary mt-3" name="action" value="sendMail">Send</button>
</form>
