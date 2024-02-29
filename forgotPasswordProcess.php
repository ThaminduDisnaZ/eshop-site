<?php


require "connection.php";

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if(isset($_GET["e"])){

    $email = $_GET["e"];

    $rs = Database::search("SELECT*FROM  `user` WHERE  `email`= '".$email."'");
    $n = $rs->num_rows;

    if ($n == 1) {
        
        $code = uniqid();

        Database::iud("UPDATE `user` SET `verification_code` ='".$code."' WHERE `email` = '".$email."'");

        $mail = new PHPMailer;
            $mail->IsSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'mrbadboybot@gmail.com';
            $mail->Password = 'pzmgdkigfbxxipvm';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('mrbadboybot@gmail.com', 'Reset Password');
            $mail->addReplyTo('mrbadboybot@gmail.com', 'Reset Password');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'eShop forgot password verification code';
            $bodyContent = '<h1 style="color:green">Your verification code is '.$code.'</h1>';
            $mail->Body    = $bodyContent;

            if(!$mail->send()){
                echo "Verification code sending failed";
            }else{
                echo "Success";
            }

    }else{
        echo("Invalid email address");
    }
}



?>