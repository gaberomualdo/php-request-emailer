<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

include_once "config.php";

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: content-type,append,delete,entries,foreach,get,has,keys,set,values,Authorization");

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  http_response_code(405);
  exit;
}

$resulting_json = json_encode(json_decode(file_get_contents('php://input'), true), JSON_PRETTY_PRINT);

// Send email
$mail = new PHPMailer(true);

// Enable SMTP debugging.
// $mail->SMTPDebug = 3;

// Set PHPMailer to use SMTP.
$mail->isSMTP();
// Set SMTP host name
$mail->Host = "smtp.dreamhost.com";
// Set this to true if SMTP host requires authentication to send email
$mail->SMTPAuth = true;
// Provide username and password
$mail->Username = $email_from;
$mail->Password = $email_from_password;
// If SMTP requires TLS encryption then set it
$mail->SMTPSecure = "tls";
// Set TCP port to connect to
$mail->Port = 587;

$mail->From = $email_from;
$mail->FromName = $email_from_name;

$mail->addAddress($email_to);
$mail->isHTML(true);

$mail->Subject = "Request Emailer Response";
$mail->Body = "<pre><code>" . $resulting_json . "</code></pre>";
$mail->AltBody = $resulting_json;

try {
  $mail->send();
  echo $resulting_json;
} catch (Exception $e) {
  http_response_code(500);
  echo "Mailer Error: " . $mail->ErrorInfo;
}

?>