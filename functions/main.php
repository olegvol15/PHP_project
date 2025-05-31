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
    //echo "<pre>" . print_r($_FILES, true) . "</pre>";
    extract($_FILES['image']);

    if($error){
        Messages::setMessage("File upload error", 'danger');
        redirect("/gallery");
    }

    $fileExt = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    $allowedExt = ['jpg', 'png', 'jpeg', 'gif', 'webp', 'aviff'];
    
    if(!in_array($fileExt, $allowedExt)){
        Messages::setMessage("Invalid file type", 'danger');
        redirect("/gallery");
    }

    if($size > 2 * 1024 * 1024){
        Messages::setMessage("File size must be less than 2MB", 'danger');
        redirect("/gallery");
    }

    if( getimagesize($tmp_name) === false){
        Messages::setMessage("Invalid file type", 'danger');
        redirect("/gallery");
    }


    $fileName = uniqid("img_") . "." . $fileExt;
    
    if(!file_exists("uploads"))
        mkdir("uploads", 0755, true);

   if( move_uploaded_file($tmp_name, "uploads/$fileName") ){
       Messages::setMessage("File uploaded successfully", 'success');
       redirect("/gallery");
   }

   Messages::setMessage("File upload error", 'danger');
   redirect("/gallery");

}


/* 

Array
(
    [image] => Array
        (
            [name] => modulnyy-parket-model-8-85642494.jpg
            [full_path] => modulnyy-parket-model-8-85642494.jpg
            [type] => image/jpeg
            [tmp_name] => C:\OSPanel\userdata\temp\upload\phpBD55.tmp
            [error] => 0
            [size] => 121064
        )

)
*/