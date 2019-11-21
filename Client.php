<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>امور کلاس ها</title>
    <link rel="stylesheet" href="lib/bootstrap-4.3.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.css">
    <link href="lib/fontawesome-free-5.11.2-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="UserStyle.css">
</head>
<body>
<?php
    $config = include("Config.php");
    $Host = $config['Host'];
    $User = $config['User'];
    $Pass = $config['Pass'];
    $dbName = $config['dbName'];
    $conn = new mysqli($Host,$User,$Pass,$dbName);
    $conn->query("select * from Main");
?>
</body>
</html>
