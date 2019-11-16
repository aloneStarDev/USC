<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>کاربر</title>
    <link rel="stylesheet" href="lib/bootstrap-4.3.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.css">
    <link href="lib/fontawesome-free-5.11.2-web/css/all.css" rel="stylesheet">
<!--    <link rel="stylesheet" href="Style.css">-->
</head>
<body>
    <?php

    $config = include('Config.php');
    $Host = $config['Host'];
    $User = $config['User'];
    $Pass = $config['Pass'];
    $dbName = $config['dbName'];
    $conn = new mysqli($Host, $User, $Pass, $dbName) or die("Enamble to connect");
    function showTable(){
        global $conn;
        if($conn){
                $res = $conn->query("select * from User");
                echo "<div class='table-responsive'>
                            <table class='table table-hover' id='userTable'>
                                <thead>
                                    <tr>
                                        <th>نام</th>
                                        <th>نام کاربری</th>
                                        <th>گذرواژه</th>
                                        <th>آیدی تلگرام</th>
                                        <th>شناسه</th>
                                        <th>حذف</th>
                                        <th>ویرایش</th>
                                    </tr>
                                </thead>
                                <tbody>
                         ";
                $counter = $res->num_rows;
                while($counter > 0){
                    $row = $res->fetch_assoc();
                    echo "
                        <tr id='r".($res->num_rows-$counter+1)."'>
                            <td>".$row['Name']."</td>
                            <td>".$row['UserName']."</td>
                            <td>".$row['PassWord']."</td>
                            <td>".$row['TelegramID']."</td>
                            <td>".$row['UserID']."</td>
                            
                            <form action=\"User.php\" method=\"get\">
                                <input type='hidden' name='delete' value=".$row['UserID'].">
                                <td><input type='submit' class='btn-danger form-control-sm' value='x'></td>
                            </form>
                            <form action=\"User.php\" method=\"get\">
                                <input type='hidden' name='update' value=".$row['UserID'].">
                                <td><input type='submit' class='btn form-control-sm' value='o'></td>
                            </form>
                        </tr>
                        ";
                    $counter--;
                }
                echo "</tbody></table></div>
                    <button id='btnAdd' class='btn-success form-control'>اضافه کردن کاربر</button>
                    <div id='addform'>
                        <form action='User.php' method='post' class='form-group'>
                            <input type='text' placeholder='نام' class='input-group input-group-text' name='Name'>
                            <input type='text' placeholder='نام کاربری' class='input-group input-group-text' name='UserName'>
                            <input type='text' placeholder='گذرواژه' class='input-group input-group-text' name='PassWord'>
                            <input type='text' placeholder='آیدی تلگرام' class='input-group input-group-text' name='TelID'>
                            <input type='submit' class='btn btn-success form-control' value='تایید'>
                        </form>
                    </div>
";
            }
    }
    function delUser(){
        global $conn;
        $x = $_GET['delete'];
        $pre = $conn->prepare("delete from User where UserID = ?");
        $pre->bind_param('s',$x);
        $pre->execute();
        header("Refresh:0;url=User.php");
    }
    function updateUser(){
        echo "<script>alert('in edit')</script>";
    }
    function addUser(){
        global $conn;
        $name = $_POST['Name'];
        $username = $_POST['UserName'];
        $password = $_POST['PassWord'];
        $tel = $_POST['TelID'];
        $pre = $conn->prepare('insert into User (Name,UserName,PassWord,TelegramID) values (?,?,?,?)');
        $pre->bind_param('ssss',$name,$username,$password,$tel);
        if($pre->execute()){
            echo "<script>alert('با موفقیت اضافه شد')</script>";
            header("Refresh:0;url=User.php");
        }
    else
        echo "<script>alert('خطایی رخ داد لطفا دوباره امتحان کنید')</script>";
    }
    if(is_null($_SESSION['Name']) && !isset($_SESSION['Name']))
            header("Location:Login.php");
    else if($_SESSION['UserName']==$config["Admin"]){
        showTable();
        if($_SERVER['REQUEST_METHOD']='get')
        {
            if(isset($_GET['delete']) && !is_null($_GET['delete']))
                delUser();
            if(isset($_GET['update']) && !is_null($_GET['update']))
                updateUser();
        }
        if($_SERVER['REQUEST_METHOD']='POST'){
            if(isset($_POST['Name']) && $_POST['Name']!='' && isset($_POST['UserName']) && $_POST['UserName']!='' && isset($_POST['PassWord']) && $_POST['PassWord']!='')
                addUser();
        }
    }
    else{

    }
    ?>
    <script src="lib/jquery-3.4.1.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>