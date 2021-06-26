<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification</title>
</head>
<style>
    body{
        text-align: center;
        color: darkgreen;
        background-color: lightgray;
        margin-top: 30px;
        font-size: 30px;
    }
    .vsuccess{
        border: 3px solid lightsalmon;
    }
</style>
<body>
    

<?php
include 'connection.php';
if(isset($_GET['vkey']))
{
    $vkey = $_GET['vkey'];
    $searchUser = "SELECT verified,vkey FROM  users WHERE verified='0' AND vkey = '$vkey' LIMIT 1";
    $search = mysqli_query($connection, $searchUser) or die(mysqli_error($connection));

    if($search->num_rows == 1){
        
        $updateUser = "UPDATE users SET verified = '1' WHERE vkey = '$vkey' LIMIT 1";
        $update = mysqli_query($connection, $updateUser);

        if($update){
            echo "<div class='vsuccess'>Your account has been verified and subscribed to our service</div>";
        }
        else{
            echo $connection->error;
        }
    }
    else{
        echo "<div class='vsuccess'>This account is already verified</div>";
    }

}
else
{
    die("Unable to verify");
}

?>

</body>
</html>