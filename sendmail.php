<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require  'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('ru', 'phpmailer/language/'); 
$mail->IsHTML(true);

$mail->setFrom('formEmail@mail.ru', 'Тестовое Сообщение');
$mail->addAddress('artsannik@mail.ru');
$mail->Subject = 'Привет Это тестовое Письмо!';

$hand = "Правая";
if($_POST['hand'] == "left"){
$hand = "Левая";
}

$body = '<h1>Письмо</h1>';

if(trim(!empty($_POST['name']))){
    $body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
}
if(trim(!empty($_POST['email']))){
    $body.='<p><strong>Email:</strong> '.$_POST['email'].'</p>';
}
if(trim(!empty($_POST['hand']))){
    $body.='<p><strong>Рука:</strong> '.$hand.'</p>';
}
if(trim(!empty($_POST['age']))){
    $body.='<p><strong>Возраст:</strong> '.$_POST['age'].'</p>';
}
if(trim(!empty($_POST['message']))){
    $body.='<p><strong>Сообщение:</strong> '.$_POST['message'].'</p>';
}

if(!empty($_FILES['image']['tmp_name'])){
    $filePath = __DIR__ ."/files/" . $_FILES['image']['name'];
    if(copy($_FILES['image']['tmp_name'],$filePath)){
        $fileAttach = $filePath;
        $body = '<p><strong>Фото в Форме</strong></p>';
        $mail->addAttachment($fileAttach);
    }
}

$mail->Body = $body;

if(!$mail->send()){
    $message = 'Error';
}else{
    $message = 'Mission Complate';
}

$response = ['message' => $message];

header('Content-type: application/json');
echo json_encode($response);
?>