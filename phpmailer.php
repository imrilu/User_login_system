<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = gethostbyname('smtp.gmail.com'); // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'recovery.acc.monolith@gmail.com';                 // SMTP username
    $mail->Password = 'Monolith123';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    //Recipients
    $mail->setFrom('donotreply@monolith.co.il', 'Recovery');

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Email Recovery - User Login System';


} catch (Exception $e) {
    echo "<script type='text/javascript'>alert('SetFrom email error:' + $mail->ErrorInfo);</script>";

}
