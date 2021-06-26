<?php

include 'connection.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

set_time_limit(0);
while(true) {
    echo "Welcome";
    mailer();
    sleep(300);
}
// mailer();
function mailer(){
    global $connection;
    $select = "SELECT * FROM users WHERE verified = '1'";
    $selectSubscribers = mysqli_query($connection, $select) or die("Unable to send. Check your connectio");
    if(mysqli_num_rows($selectSubscribers)>0)
    {
        while($row = mysqli_fetch_assoc($selectSubscribers))
        {
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Port = "587";
            $mail->Username = "lalhoori0@gmail.com";
            $mail->Password = "Qwerty123@";
            $mail->setFrom("lalhoori0@gmail.com");
            $mail->addReplyTo("lalhoori0@gmail.com");
            
            // echo $row['email']." ".$row['vkey'].date("h:i:sa");
            // echo "<br>";
            $userEmail = $row['email'];
            $vkey = $row['vkey'];
            $mail->addAddress("$userEmail");
            $url = "https://xkcd.com/154/info.0.json";
            $response = file_get_contents($url);
            $data = json_decode($response, true);
            $img = $data['img'];
            
            $dir = 'images/';
            $filname = basename($img);
            $complete_location = $dir.$filname;
            file_put_contents($complete_location,file_get_contents($img));
            $mail->addBCC("$userEmail");
            $mail->isHTML(true);
            $mail->addAttachment("$complete_location","Comic image");

            
            $mail->Subject = "Xkcd Comics";
            $mail->Body = " <html>
                            <head>
                            <title>HTML email</title>
                            </head>
                            <body>
                            <p>This email contains HTML Tags</p>
                            <img src = '$img' width='50px' height='50px'></img>
                            <p>Unsubscribe by cliking the link <a href='http://localhost/assignment/unsubscribe.php?vkey=$vkey'>Unsubscribe</a></p>
                            </body>
                            </html>";
            $mail->AltBody = "Change your system";

            if($mail->send()){
                if(unlink($complete_location))
                {
                    echo "Success mail";
                }
            }else{
                echo "Failure Mail";
            }
        }
    }
}
// function sendmail(){
//     global $connection;
//     $select = "SELECT email,vkey FROM users WHERE verified = '1'";
//     $selectSubscribers = mysqli_query($connection, $select) or die("Unable to send. Check your connectio");
//     while($row = mysqli_fetch_assoc($selectSubscribers))
//     {
//     echo $row['email']." ".$row['vkey'].date("h:i:sa");
//     echo "<br>";
//     $userEmail = $row['email'];
//     $vkey = $row['vkey'];
//     $url = "https://xkcd.com/154/info.0.json";
//     $response = file_get_contents($url);
//     $data = json_decode($response, true);
//     $img = $data['img'];
//     $subject = "Email Verification";
//     $message = "<html>
//                 <head>
//                 <title>HTML email</title>
//                 </head>
//                 <body>
//                 <p>This email contains HTML Tags</p>
//                 <img src = '$img'></img>
//                 <p>Unsubscribe by cliking the link <a href='http://localhost/assignment/unsubscribe.php?vkey=$vkey'>Unsubscribe</a></p>
//                 </body>
//                 </html>";
//     // $sender = "From: divyansh200g@gmail.com";
//     $headers = "From: divyansh200g@gmail.com \r\n";
//     $headers .= "MIME-Version: 1.0" . "\r\n";
//     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
//     if(mail($userEmail, $subject, $message, $headers )){
//     }else{
//         echo "not send why";
//     }
//     }

// }

?>