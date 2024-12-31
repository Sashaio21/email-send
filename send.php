<?php
session_start(); // Начинаем сессию

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars($_POST['name-user']);
    $email = htmlspecialchars($_POST['email']);
    $seminar = htmlspecialchars($_POST["choise-seminar"]);
    
    try {
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'saschakowal1233@gmail.com';
        $mail->Password = 'onbr jidv fgzc embd';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port = 587;

        $mail->setFrom('saschakowal1233@gmail.com', 'Sascha Kowal');
        $mail->addAddress($email, $name);
        
        // Настройки письма
        $mail->isHTML(true);                            // Формат письма - HTML
        $mail->Subject = 'Приглашение на участие в семинаре';            // Тема письма
        $mail->Body    =  sprintf ('<!DOCTYPE html>
                            <html lang="ru">
                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title>Приглашение на семинар</title>
                                <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
                                <style>
                                    body {
                                        font-family: Arial, sans-serif;
                                        background-color: #f7f7f7;
                                        margin: 0;
                                        padding: 0;
                                    }
                                    .container {
                                        margin-top: 50px;
                                        background-color: #ffffff;
                                        padding: 30px;
                                        border-radius: 8px;
                                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                                    }
                                    h1 {
                                        color: #4CAF50;
                                    }
                                    .info-text {
                                        color: #555555;
                                    }
                                    .footer {
                                        margin-top: 30px;
                                        font-size: 14px;
                                        text-align: center;
                                        color: #777;
                                    }
                                    .highlight {
                                        font-weight: bold;
                                        color: #333;
                                    }
                                </style>
                            </head>
                            <body>

                            <div class="container">
                                <h1 class="text-center">Приглашение на семинар</h1>
                                <p class="info-text text-center">Уважаемый <span class="highlight">%s</span>,</p>
                                <p class="info-text text-center">Мы рады пригласить вас на семинар на тему <span class="highlight">%s</span>.</p>
                            </div>

                            </body>
                            </html>
                            ', $name, $seminar); // Тело письма в HTML
        $mail->send();
        // echo "Письмо отправлено";// Ваши действия с данными, например, вычисления или работа с базой данных
        $response = array("status" => "Письмо отправлено");
        
        // Отправка JSON-ответа
        echo json_encode($response);
        
    } catch (Exception $err) {
        echo $err;
    }
    
    // Перенаправляем пользователя обратно на форму
    // header('Location: /testproject');
    // exit;
}
