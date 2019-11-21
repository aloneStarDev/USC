<?php
// Redirect Problem
session_start(); ?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>کاربر</title>
    <link rel="stylesheet" href="lib/bootstrap-4.3.1-dist/css/bootstrap.css">
    <link href="lib/fontawesome-free-5.11.2-web/css/all.css" rel="stylesheet">

    <!--     ClockPicker Stylesheet-->
    <link rel="stylesheet" type="text/css" href="lib/ClockAndCalender/bootstrap-clockpicker.min.css">


    <link rel="stylesheet" href="UserStyle.css">

    <!--    Calender    -->

    <link href="lib/ClockAndCalender/Content/bootstrap.min.css" rel="stylesheet" />
    <link href="lib/ClockAndCalender/Content/bootstrap-theme.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="lib/ClockAndCalender/Content/MdBootstrapPersianDateTimePicker/jquery.Bootstrap-PersianDateTimePicker.css" />

    <script src="lib/ClockAndCalender/Scripts/jquery-2.1.4.js" type="text/javascript"></script>
    <script src="lib/ClockAndCalender/Scripts/bootstrap.min.js" type="text/javascript"></script>

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
                    <div id='AddForm'>
                        <form action='User.php' method='post' class='form-group'>
                            <span onclick=\"show('AddForm','btnAdd')\" id='closeForm'>
                            &times;
                            </span>
                            <input type='hidden' name='Type' value='AddUser'/>
                            <input type='text' placeholder='نام' class='input-group input-group-text' name='Name'>
                            <input type='text' placeholder='نام کاربری' class='input-group input-group-text' name='UserName'>
                            <input type='text' placeholder='گذرواژه' class='input-group input-group-text' name='PassWord'>
                            <input type='text' placeholder='آیدی تلگرام' class='input-group input-group-text' name='TelID'>
                            <input type='submit' class='btn btn-success form-control' onclick=\"show('AddForm','btnAdd')\" value='تایید'>
                        </form>
                    </div>
                    <button id='btnAdd' class='btn-success form-control' onclick=\"show('AddForm','btnAdd')\">اضافه کردن کاربر</button>
    
";
            }
    }
    function showTableMessage(){
        echo "<h1 class='text-center'> خوش آمدید ".$_SESSION['Name']."</h1>
        <div id='AddMessage' style='display: none'>
            <form action='User.php' method='post' class='form-group'>
                <span onclick=\"show('AddMessage','btnAddMessage')\" id='closeForm'>
                &times;
                </span><br>
                <input type='hidden' name='Type' value='AddMessage'/>
                <input type='text'  name='TeacherName' class='input-group input-group-text' placeholder='نام استاد'>
                <input type='text'  name='ClassName' class='input-group input-group-text' placeholder='نام کلاس'>
                <input type='text' name='Time' class='btn btn-dark form-control' placeholder='انتخاب زمان' id='demo-input'>
                <input type='text' name='Date' class='btn btn-dark form-control' placeholder='انتخاب تاریخ' data-mddatetimepicker='true' data-placement='bottom' data-englishnumber='true'>
                            
               <input type='submit' class='btn btn-success form-control' onclick=\"show('AddMessage','btnAddMessage')\" value='تایید'>
            </form>
        </div>
        <button id='btnAddMessage' class='btn-success form-control' onclick=\"show('AddMessage','btnAddMessage')\">اضافه کردن پیام</button>
        <script src=\"lib/ClockAndCalender/Scripts/MdBootstrapPersianDateTimePicker/calendar.js\" type=\"text/javascript\"></script>
        <script src=\"lib/ClockAndCalender/Scripts/MdBootstrapPersianDateTimePicker/jquery.Bootstrap-PersianDateTimePicker.js\" type=\"text/javascript\"> </script >        
        <script src=\"lib/ClockAndCalender/bootstrap-clockpicker.min.js\"></script>
        <script type='text/javascript'>
            $('.clockpicker').clockpicker()
                .find('input').change(function(){
                // TODO: time changed
                console.log(this.value);
            });
        $('#demo-input').clockpicker({
            autoclose: true
        });
    </script>
 
       
        ";
    }
    function delUser(){
        global $conn,$config;
        $x = $_GET['delete'];
        $pre = $conn->prepare("delete from User where UserID = ?");
        $pre->bind_param('s',$x);
        if($pre->execute()){
            if($conn->affected_rows == 1)
                echo "<script>alert('با موفقیت حذف شد')</script>";
            else
                echo "<script>alert('یافت نشد')</script>";
        }
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
            echo "<script>alert('با موفقیت اضافه شد');</script>";
        }
    else
        echo "<script>alert('خطایی رخ داد لطفا دوباره امتحان کنید')</script>";
    }
    function addMessages(){
        global $conn;
        $TeacherName=$_POST['TeacherName'];
        $ClassTime=$_POST['ClassTime'];
        $ClassDate=$_POST['ClassTime'];
        $ClassName=$_POST['ClassName'];
        $ByHow = $_SESSION['Name'];
        $pre = $conn->prepare("insert into Main(TeacherName,ClassName,Date,Time,byHow) values (?,?,?,?)");
        $pre->bind_param("sssss",$TeacherName,$ClassName,$ClassDate,$ClassTime,$ByHow);
        $pre->execute() or die("خطایی رخ داد");
    }
    function showMessages(){

    }
    if(is_null($_SESSION['Name']) && !isset($_SESSION['Name'])){
        session_destroy();
        header("Location:Login.php");
    }
    else if($_SESSION['UserName']==$config["Admin"]){
        showTable();
        if($_SERVER['REQUEST_METHOD']='get')
        {
            if(isset($_GET['delete']) && !is_null($_GET['delete']))
                delUser();
            if(isset($_GET['update']) && !is_null($_GET['update']))
                updateUser();
        }
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(isset($_POST['Name']) && $_POST['Name']!='' && isset($_POST['UserName']) && $_POST['UserName']!='' && isset($_POST['PassWord']) && $_POST['PassWord']!='')
                    addUser();
        }
    }
    else{
        if($_SERVER['REQUEST_METHOD']=='POST') {

        }
        showTableMessage();
    }
    ?>
    <script>
        function show(formId,formbtn) {
            $("#"+formId).fadeToggle(2000);
            $("#"+formbtn).fadeToggle(2000);
        }
    </script>

    <script src="lib/jquery-3.4.1.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>