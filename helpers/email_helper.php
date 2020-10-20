<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

class Email
{
	public static function SendEmail($content, $toEmail, $subject)
	{
    // $target_dir = Url::getPath('config');
    // $fileName = "emailSetting.json";
		// $emailSetting = json_decode(file_get_contents( $target_dir .  $fileName )) ;
		$mail = new PHPMailer();
		try {
			$mail->IsSMTP();
			// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
			$mail->CharSet = PHPMailer::CHARSET_UTF8;
			$mail->Mailer = "smtp";
			$mail->SMTPAuth   = TRUE;
			$mail->Port       = 465;
			$mail->Host       = "yellowhk.com";
			$mail->Username   = "noreply@yellowhk.com";
			$mail->Password   = "13fS4m%v";
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
			$mail->IsHTML(true);
			$mail->SetFrom( "noreply@yellowhk.com", "Yellow Hub");
			$mail->AddAddress( $toEmail,  $toEmail);
			$mail->Subject = "=?utf-8?B?" . base64_encode($subject) . "?=";
			$mail->MsgHTML($content);

			if (!$mail->Send()) {
				// echo "Error while sending Email.";
				// var_dump($mail);
			} else {
				// echo "Email sent successfully";
			}
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
}
