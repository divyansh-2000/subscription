<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    body{
        text-align: center;
        color: darkgreen;
        background-color: lightgray;
    }
    .email{
        color:green;
        border:2px solid green;
        width: 400px;
        height: 25px;
        border-radius: 10px;
    }
    .submit-btn{
        color: darkgreen;
        height: 30px;
        border-radius: 5px;
        border: 2px solid green;
    }
    </style>
</head>
<body>
    <h1>Become A Subscriber!!</h1>
    <h2>Enter your Email and enjoy!</h2>
    <form action="index.php" method="POST">
        <?php
            include 'connection.php';
            require 'PHPMailer/PHPMailer.php';
            require 'PHPMailer/SMTP.php';
            require 'PHPMailer/Exception.php';
            
            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\SMTP;
            use PHPMailer\PHPMailer\Exception;

            include 'connection.php';
            $userErr = $successMsg = $mailSuccess = "";
            if(isset($_POST['subscribe'])){
                $userEmail = $_POST['email'];
                if(filter_var($userEmail, FILTER_VALIDATE_EMAIL)){
                    $userEmail = $connection->real_escape_string($userEmail);
                    $vkey = md5(time().$userEmail);

                    $checkUser = "SELECT * FROM `users` WHERE email='$userEmail'";
                    $response = mysqli_query($connection, $checkUser);
                    if(mysqli_num_rows($response)) {
                        while($row = mysqli_fetch_assoc($response))
                        if($row['verified']==0)
                        {
                            $userErr = "Please verify your account from the verification link provided in the email";
                        }
                        else{
                            $userErr = "User email already exists!";
                        }
                    }   
                    else{
                        
                        $vkey = md5(time().$userEmail);
                        $insertUser = "INSERT INTO users(email, vkey) VALUES ('$userEmail','$vkey')";
                        $insert = mysqli_query($connection, $insertUser) or die(mysqli_error($connection));
                        if($insert){
                            $mail = new PHPMailer();
                            // $mail->isSMTP();
                            $mail->Host = "smtp.gmail.com";
                            $mail->SMTPAuth = true;
                            $mail->SMTPSecure = "tls";
                            $mail->Port = "587";
                            $mail->Username = "lalhoori0@gmail.com";
                            $mail->Password = "Qwerty123@";
                            $mail->setFrom("lalhoori0@gmail.com");
                            $mail->addReplyTo("lalhoori0@gmail.com");
                            $mail->addAddress("$userEmail");

                            $mail->isHTML(true);

                            $mail->Subject = "Email Verification";
                            $mail->Body = "<html>
                                        <head>
                                        <title>HTML email</title>
                                        </head>
                                        <body>
                                        <p>This email contains HTML Tags</p>
                                        <p>
                                        Please verify your account by clicking below <br> <a href='https://rt-camp1.herokuapp.com/verify.php?vkey=$vkey'>Verify Account</a>
                                        </p>
                                        </body>
                                        </html>";
                            $mail->AltBody = "Try to register after 24 hours!";
                            if($mail->send()){
                                $mailSuccess = "Check your inbox to verify<br>";
                            }else{
                                $mailSuccess = "$mail->ErrorInfo Sorry, try again after 24 hours";
                            }
                            $successMsg = "Thanks : $userEmail ";
                            $userEmail = "";
                        }
                    }
                }
                else
                {
                    echo "$userEmail is incorrect";
                }
            }
        ?>
        <input class="email" type="email" placeholder="Enter your email!" name="email" id="email" required>
        <input class="submit-btn" type="submit" value="Subscribe" name="subscribe"><br>
        <span class="error"><?php echo $mailSuccess ?></span>
        <span class="error"><?php echo $successMsg ?></span>
        <span class="error"><?php echo $userErr ?></span>
    </form>

</body>
</html>