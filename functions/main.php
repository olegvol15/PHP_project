<?php
session_start();
require_once "functions/Messages.php";
require_once "functions/OldInput.php";

$action = $_POST['action'] ?? null; // 'sendMail'
if(!empty($action)){
    $action(); // sendMail()
}

function redirect($url){
    header("Location: $url");
    exit;
}


function sendMail(){
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    if(empty($name) || empty($email) || empty($message)){
        Messages::setMessage("All fields are required", 'danger');
        OldInput::set($_POST);
        redirect("/contacts");
    }
    
    Messages::setMessage("Message sent successfully");
    redirect("/contacts");
}


function uploadImage(){
    
}