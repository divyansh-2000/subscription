<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unsubscribe</title>
    <style>
    body{
        text-align: center;
        color: darkgreen;
        background-color: lightgray;
        margin-top: 30px;
        font-size: 30px;
    }
    .unsubsuccess{
        border: 3px solid lightsalmon;
    }
</style>
</head>
<body>
    
<?php

include 'connection.php';

if(isset($_GET['vkey']))
{
    $vkey = $_GET['vkey'];

    $searchUser = "SELECT vkey FROM  users WHERE verified='1' AND vkey = '$vkey' LIMIT 1";
    $search = mysqli_query($connection, $searchUser) or die(mysqli_error($connection));

    if($search->num_rows == 1){
        $deleteUser = "DELETE FROM users WHERE vkey = '$vkey'";
        $delete = mysqli_query($connection, $deleteUser);

        if($delete){
            echo "<div class='unsubsuccess'>Your account has been unsubcribed. Thanks";
        }
        else{
            echo $connection->error;
        }
    }
    else{
        echo "<div class='unsubsuccess'>This account is already unsubscribed";
    }

}
else
{
    die("Unable to delete. Try again");
}

?>
</body>
</html>