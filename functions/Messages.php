<?php
class Messages
{
    public static function setMessage($message, $type = 'success')
    {
        $_SESSION['message'] = [
            'text' => $message,
            'type' => $type
        ];
    }

    public static function getMessage()
    {
        if (isset($_SESSION['message'])) {
            extract($_SESSION['message']);
            echo "<div class=\"alert alert-$type\">$text</div>";
            unset($_SESSION['message']);
        }
    }
}