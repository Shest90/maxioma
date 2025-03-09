<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Получаем данные из формы
    $fio     = trim($_POST["fio"]);
    $contact = trim($_POST["company"]);
    $email   = trim($_POST["email"]);
    $review  = trim($_POST["review"]);

    // Формируем тему и текст письма
    $subject = "Новый отзыв от $fio";
    $message = "ФИО: $fio\n" .
        "Контакт (Компания): $contact\n" .
        "Email: $email\n" .
        "Отзыв: $review\n";

    $mail = new PHPMailer(true);
    try {
        // Настройки SMTP
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = 2;
        $mail->Host       = 'smtp.mail.ru';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'shest.andrey@bk.ru';
        $mail->Password   = 'ELwLaniyM515aqJyLyHW';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('shest.andrey@bk.ru', 'Andrey'); // Укажите свой адрес и имя отправителя

        $mail->addAddress('admin@maxioma.kz');                   // Основной адрес получателя

        $mail->addReplyTo($email, $fio);

        // Формат письма – простой текст
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        // Отправка письма
        $mail->send();
        header("Location: success.html");
        exit;
    } catch (Exception $e) {
        echo "Ошибка при отправке. Пожалуйста, попробуйте ещё раз. Ошибка: {$mail->ErrorInfo}";
    }
} else {
    header("Location: index.html");
    exit;
}
?>
