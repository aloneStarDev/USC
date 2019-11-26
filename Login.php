<?php
session_start();
session_destroy();
session_start();
?>
<!DOCTYPE html>
<html lang="">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="lib/bootstrap-4.3.1-dist/css/bootstrap.css">
        <link rel="stylesheet" href="lib/bootstrap-4.3.1-dist/css/bootstrap.min.css">
        <link href="lib/fontawesome-free-5.11.2-web/css/all.css" rel="stylesheet">
        <link rel="stylesheet" href="ROOT/Style/LoginStyle.css">
        <title>امور کلاس ها</title>
    </head>
    <body>
    <div class="container">
        <div class="formCenter">
            <form method="post" action="Login.php">
                <input id="user_" class="input-group input-group-text " type="text" placeholder="نام کاربری" name="UserName" />
                <i class="far fa-eye" id="passVisible" onclick="ch()"></i>
                <input id="pass_" class="input-group input-group-text " type="password" placeholder="گذرواژه" name="PassWord" />
                <input class="input-group-text btn-login" type="submit" value="ورود"/>

            </form>
        </div>
    </div>
    <?php

    class Main{
        public $ID,$UserName,$PassWord,$Name,$TelegramId;
    }
    $config = include('Config.php');
    $Host = $config['Host'];
    $User = $config['User'];
    $Pass = $config['Pass'];
    $dbName = $config['dbName'];
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $conn = new mysqli($Host, $User, $Pass, $dbName) or die("Enable to connect");
        $user = $_POST['UserName'];
        $pass = $_POST['PassWord'];
        if($user != "" and $pass != ""){

            if ($conn) {
                $pre = $conn->prepare("select * from User where UserName = ?");
                $pre->bind_param('s', $user);
                $pre->execute();
                $select = $pre->get_result();
                $res = null;
                if ($select->num_rows == 1) {
                    $res = $select->fetch_object('Main');
                    if ($res->PassWord == $pass) {
                        $_SESSION['Name']=$res->Name;
                        $_SESSION['UserName']=$res->UserName;
                        header("Location:User.php"); /* Redirect browser */
                        exit();
                    } else{
                        session_destroy();
                        echo "<script>alert('گذرواژه اشتباه است');</script>";
                    }
                } else{
                    session_destroy();
                    echo "<script>alert('نام کاربری اشتباه است');</script>";
                }
            }
            else{
                session_destroy();
                echo "<script>alert('مشکلی در اتصال به دیتابیس وجود دارد');</script>";
            }
        }
        else{
            session_destroy();
            echo "<script>alert('هر دو فیلد باید پر شوند');</script>";
        }
    }
    ?>
    </body>
    <script src="lib/jquery-3.4.1.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <script>
        function ch() {
            var str="";
            if($('#pass_').prop('type') == 'password')
                str = "text";
            else
                str = "password";
            $("#pass_").prop('type', str);
        }
    </script>
</html>
