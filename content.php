<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
    <?php
        $url = "https://xkcd.com/154/info.0.json";
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        echo $response.'<br>';
        echo '<br>'.$data['img'].'<br>';
    ?>
</body>
</html>