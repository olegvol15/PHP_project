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


function sendMail(){    // отправка эмейла в contacts
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    if(empty($name) || empty($email) || empty($message)){
        Messages::setMessage("All fields are required", 'danger');
        OldInput::set($_POST);
        redirect("contacts");
    }
    
    Messages::setMessage("Message sent successfully");
    redirect("contacts");
}


function uploadImage(){   // загрузка изображения в галерею
    //echo "<pre>" . print_r($_FILES, true) . "</pre>";
    extract($_FILES['image']);

    if($error){
        Messages::setMessage("File upload error", 'danger');
        redirect("gallery");
    }

    $fileExt = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    $allowedExt = ['jpg', 'png', 'jpeg', 'gif', 'webp', 'aviff'];
    
    if(!in_array($fileExt, $allowedExt)){
        Messages::setMessage("Invalid file type", 'danger');
        redirect("gallery");
    }

    if($size > 2 * 1024 * 1024){
        Messages::setMessage("File size must be less than 2MB", 'danger');
        redirect("gallery");
    }

    if( getimagesize($tmp_name) === false){
        Messages::setMessage("Invalid file type", 'danger');
        redirect("gallery");
    }


    $fileName = uniqid("img_") . "." . $fileExt;
    
    if(!file_exists("uploads"))
        mkdir("uploads", 0755, true);

   if( move_uploaded_file($tmp_name, "uploads/$fileName") ){
       Messages::setMessage("File uploaded successfully", 'success');
       redirect("gallery");
   }

   Messages::setMessage("File upload error", 'danger');
   redirect("gallery");

}

function registerUser() {  // тут валидация полей и проверка совпадения паролей
   $email = $_POST['email'] ?? '';
   $password = $_POST['password'] ?? '';
   $repeated_password = $_POST['repeated_password'] ?? '';

   // проверка заполненности полей
   if(empty($email) || empty($password) || empty($repeated_password)){
       Messages::setMessage("All fields are required", 'danger');
       OldInput::set($_POST);
       redirect("register");
   }
   
   // проверка email
   if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
       Messages::setMessage("Invalid email format", 'danger');
       OldInput::set($_POST);
       redirect("register");
   }

   // проверка пароля
   if(strlen($password) < 8 || !preg_match('/[0-9]/', $password) || !preg_match('/[^a-zA-Z0-9]/', $password)) {
       Messages::setMessage("Password must be at least 6 characters and contain at least one digit and one special character", 'danger');
       OldInput::set($_POST);
       redirect("register");
   }

   // проверка совпадения паролей
   if($password !== $repeated_password){
       Messages::setMessage("Passwords do not match", 'danger');
       OldInput::set($_POST);
       redirect("register");
   }

   Messages::setMessage("Registration successful", 'success');
   redirect("login");

}

function loginUser(){
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if(empty($email) || empty($password)){
        Messages::setMessage("All fields are required", 'danger');
        OldInput::set($_POST);
        redirect("login");
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        Messages::setMessage("Invalid email format", 'danger');
        OldInput::set($_POST);
        redirect("login");
    }

    if($email == "admin@gmail.com" && $password == "admin25!"){
        $_SESSION['user'] = [
            'email' => $email,
            'role' => 'admin'
        ];

        Messages::setMessage("Login successful", 'success');
        redirect("home");
    }

    Messages::setMessage("Invalid login or password", 'danger');
    OldInput::set($_POST);
    redirect("login");

}

function sendReview()
{
    $name = $_POST['name'] ?? '';
    $message = $_POST['message'] ?? '';
    $captcha = $_POST['captcha'] ?? '';

    if (empty($name) || empty($message || empty($captcha))) {
        Messages::setMessage("All fields are required", 'danger');
        OldInput::set($_POST);
        redirect("reviews");
    }

    if ($captcha !== $_SESSION['captcha']) {
        Messages::setMessage("Invalid captcha", 'danger');
        OldInput::set($_POST);
        redirect("reviews");
    }

    $time = time();

    $reviews = json_decode(file_get_contents("reviews.json"), true);
    $reviews[] = compact('name', 'message', 'time');

    $f = fopen("reviews.json", "w");
    fwrite($f, json_encode($reviews));
    fclose($f);

    Messages::setMessage("Review sent successfully");
    redirect("reviews");
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