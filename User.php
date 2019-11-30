<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>کاربر</title>
    <link rel="stylesheet" href="lib/bootstrap-4.3.1-dist/css/bootstrap.css">
    <link href="lib/fontawesome-free-5.11.2-web/css/all.css" rel="stylesheet">

    <!--     ClockPicker Stylesheet-->
    <link rel="stylesheet" type="text/css" href="lib/ClockAndCalender/bootstrap-clockpicker.min.css">


    <link rel="stylesheet" href="ROOT/Style/UserStyle.css">

    <!--    Calender    -->

    <link href="lib/ClockAndCalender/Content/bootstrap.min.css" rel="stylesheet" />
    <link href="lib/ClockAndCalender/Content/bootstrap-theme.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="lib/ClockAndCalender/Content/MdBootstrapPersianDateTimePicker/jquery.Bootstrap-PersianDateTimePicker.css" />

    <script src="lib/ClockAndCalender/Scripts/jquery-2.1.4.js" type="text/javascript"></script>
    <script src="lib/ClockAndCalender/Scripts/bootstrap.min.js" type="text/javascript"></script>

</head>
<body>

<button class="btn-link btn-outline-success"><a href='Login.php'>خروج از حساب کاربری </a></button>
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
                <button id='btnAdd' class='btn btn-success input-group' onclick='showAddUser()'>اضافه کردن کاربر</button>
                            <table class='table table-hover' id='userTable'>
                                <thead>
                                    <tr>
                                        <th>حذف</th>
                                        <th>ویرایش</th>
                                        <th>شناسه</th>
                                        <th>آیدی تلگرام</th>
                                        <th>گذرواژه</th>
                                        <th>نام کاربری</th>
                                        <th>نام</th>
                                    </tr>
                                </thead>
                                <tbody>
                         ";
                $counter = $res->num_rows;
                while($counter > 0){
                    $row = $res->fetch_assoc();
                    echo "
                        <tr id='r".($res->num_rows-$counter+1)."'>
                            <td>
                                <form action='User.php' method='get'>
                                    <input type='hidden' name='DelID' value='".$row['UserID']."'/>
                                    <input type='submit' value='&times;' class='btn btn-mini'/>
                                </form>
                            </td>
                            <td>
                                <button type='submit' class='btn btn-mini' onclick='setIDforUpdate(".$row['UserID'].");'>&cularr;</button>
                            </td>
                            <td>".$row['UserID']."</td>
                            <td>".$row['TelegramID']."</td>
                            <td>".$row['PassWord']."</td>
                            <td>".$row['UserName']."</td>
                            <td>".$row['Name']."</td>
                        </tr>
                        ";
                    $counter--;
                }
                echo "</tbody></table></div>
<div id='AddForm'>
    <h3 class='text-center text-white'>اضافه کردن کاربر</h3>
    <form action='User.php' method='post' class='form-group' id='AddForm__'>
        <span onclick=\"showAddUser()\" class='closeForm'>
        &times;
        </span>
        <input type='hidden' name='Type' value='AddUser' id='formType'/>
        <input type='text' placeholder='نام' class='input-group input-group-text' name='Name'>
        <input type='text' placeholder='نام کاربری' class='input-group input-group-text' name='UserName'>
        <input type='text' placeholder='گذرواژه' class='input-group input-group-text' name='PassWord'>
        <input type='text' placeholder='آیدی تلگرام' class='input-group input-group-text' name='TelID'>
        <input type='submit' class='btn btn-success form-control' onclick=\"showAddUser()\" value='تایید'>
    </form>
</div>
<div id='UpdateForm'>
    <span onclick='showUpdateUser()' class='closeForm'>
        &times;
    </span>
    <h3 class='text-center text-white'>ویرایش کاربر</h3>
    <form action='User.php' method='get' class='form-group'>
        <input type='hidden' name='UpdateID' id='UpdateID'/>
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
    function showAddMessageForm(){
        echo "
            <div id='AddMessage'>
                <form action='User.php' method='post' class='form-group'>
                    <span onclick='showAddMessage()' id='closeForm' class='closeForm'>
                    &times;
                    </span>
                    <input type='text'  name='TeacherName' class='input-group input-group-text' placeholder='نام استاد'>
                    <input type='text'  name='ClassName' class='input-group input-group-text' placeholder='نام کلاس'>
                    <input type='text' name='Time' class='btn btn-dark form-control' placeholder='انتخاب زمان' id='demo-input'>
                    <input type='text' name='Date' class='btn btn-dark form-control' placeholder='انتخاب تاریخ' data-mddatetimepicker='true' data-placement='bottom' data-englishnumber='true'>
                   <input type='submit' class='btn btn-success form-control' value='تایید'>
                </form>
            </div>
        <button id='btnAddMessage' class='btn-success form-control' onclick='showAddMessage()'>اضافه کردن پیام</button>
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
        global $conn;
        $x = $_GET['DelID'];
        $pre = $conn->prepare("delete from User where UserID = ?");
        $pre->bind_param('s',$x);
        if($pre->execute()){
            if($conn->affected_rows == 1){
                echo "<script> 
                            window.location='User.php';
                      </script>";

            }
            else
                echo "<script>alert('یافت نشد');</script>";
        }
    }
    function delMessage(){
        global $conn;
        $pre = $conn->prepare("delete from Main where ID=?");
        $pre->bind_param('i',$_GET['DelID']);
        if($pre->execute())
            echo "<script>window.location = 'User.php';</script>";
    }
    function updateUser(){
        $counter =0;
        global $conn;

        if(isset($_GET['Name']) && !is_null($_GET['Name']) && $_GET['Name'] !=""){
            $pre=$conn->prepare("Update User set Name=? WHERE UserID=?");
            $pre->bind_param("si",$_GET['Name'],$_GET['UpdateID']);
            if($pre->execute())
                echo "<script>window.location = 'User.php'</script>";
            $counter++;
        }
        if(isset($_GET['UserName']) && !is_null($_GET['UserName'])&& $_GET['UserName']!=""){
            $pre=$conn->prepare("Update User set UserName=? WHERE UserID=?");
            $pre->bind_param("si",$_GET['UserName'],$_GET['UpdateID']);
            if($pre->execute())
                echo "<script>window.location = 'User.php'</script>";
            $counter++;
        }
        if(isset($_GET['PassWord']) && !is_null($_GET['PassWord'])&& $_GET['PassWord']!=""){
            $pre=$conn->prepare("Update User set PassWord=? WHERE UserID=?");
            $pre->bind_param("si",$_GET['PassWord'],$_GET['UpdateID']);
            if($pre->execute())
                echo "<script>window.location = 'User.php'</script>";
            $counter++;
        }
        if(isset($_GET['TelID']) && !is_null($_GET['TelID'])&& $_GET['TelID']!=""){
            $pre=$conn->prepare("Update User set TelegramID=? WHERE UserID=?");
            $pre->bind_param("si",$_GET['TelID'],$_GET['UpdateID']);
            if($pre->execute())
                echo "<script>window.location = 'User.php'</script>";
            $counter++;
        }
        if($counter == 0)
            echo "<script>alert('حداقل یکی از فیلد ها باید پر باشند')</script>";

    }
    function updateMessage(){
        $counter =0;
        global $conn;
        if(isset($_GET['TeacherName']) && !is_null($_GET['TeacherName']) && $_GET['TeacherName'] !=""){
            $pre=$conn->prepare("Update Main set TeacherName=? WHERE ID=?");
            $pre->bind_param("ss",$_GET["TeacherName"],$_GET['UpdateID']);
            if($pre->execute())
                echo "<script>window.location = 'User.php'</script>";
            else
                echo "<script>alert('خطایی در تغییر نام رخ داد')</script>";
            $counter++;
        }//ok
        if(isset($_GET['ClassName']) && !is_null($_GET['ClassName'])&& $_GET['ClassName']!=""){
            echo "<script>console.log('".$_GET['ClassName']."');</script>";
            $text = $_GET['ClassName'];
            $pre=$conn->prepare("Update Main set ClassName=? WHERE ID=?");
            $pre->bind_param("ss",$text,$_GET['UpdateID']);
            if($pre->execute())
                echo "<script>window.location = 'User.php';</script>";
            else
                echo "<script>alert('خطایی در تغییر نام کلاس رخ داد')</script>";
        $counter++;
        }//dont work correct correctly
        if(isset($_GET['Date']) && !is_null($_GET['Date'])&& $_GET['Date']!=""){
            $pre=$conn->prepare("Update Main set Date=? WHERE ID=?");
            $pre->bind_param("ss",$_GET['Date'],$_GET['UpdateID']);
            if($pre->execute())
                echo "<script>window.location = 'User.php'</script>";
            else
                echo "<script>alert('خطایی در تغییر تاریخ رخ داد')</script>";
        $counter++;
        }
        if(isset($_GET['Time']) && !is_null($_GET['Time'])&& $_GET['Time']!=""){
            $pre=$conn->prepare("Update Main set Time=? WHERE ID=?");
            $pre->bind_param("ss",$_GET['Time'],$_GET['UpdateID']);
            if($pre->execute())
                echo "<script>window.location = 'User.php'</script>";
            else
                echo "<script>alert('خطایی در تغییر زمان رخ داد')</script>";
            $counter++;
        }
        if($counter == 0)
            echo "<script>alert('حداقل یکی از فیلد ها باید پر باشند')</script>";
    }
    function addUser(){
        global $conn;
        $name = $_POST['Name'];
        $username = $_POST['UserName'];
        $password = $_POST['PassWord'];
        $tel = $_POST['TelID'];
        $pre = $conn->prepare('insert into User (Name,UserName,PassWord,TelegramID) values (?,?,?,?)');
        $pre->bind_param('ssss',$name,$username,$password,$tel);
        unset($_POST['Type']);
        unset($_POST['Name']);
        unset($_POST['UserName']);
        unset($_POST['PassWord']);
        unset($_POST['TelID']);
        $_POST['Type'] = '';
        $_POST['UserName'] = '';
        $_POST['PassWord'] = '';
        $_POST['TelID'] = '';
        if($pre->execute()){
            echo "<script>
                          window.location = 'User.php';
                  </script>";

        }
    else
        echo "<script>alert('خطایی رخ داد لطفا دوباره امتحان کنید')</script>";
    }
    function addMessages(){
        global $conn,$config;
        $TeacherName=$_POST['TeacherName'];
        $ClassTime=$_POST['Time'];
        $ClassDate=$_POST['Date'];
        $ClassName=$_POST['ClassName'];
        $ByHow = $_SESSION['Name'];
        $pre = $conn->prepare("insert into Main(TeacherName,ClassName,Date,Time,byHow) values (?,?,?,?,?)");
        $pre->bind_param("sssss",$TeacherName,$ClassName,$ClassDate,$ClassTime,$ByHow);
        if($pre->execute() or die("خطایی رخ داد"))
        {
            require_once("lib/PersianCalenderLib/PersianCalendar.php");
            include("lib/Telegram/TelegramBotPHP-master/Telegram.php");
            $text = "";
            $date = str_getcsv($ClassDate,'/');//1378/12/06
            $time = str_getcsv($ClassTime.":00",':');//12:13
            $T =["year"=>$date[0],
                "month"=>$date[1],
                "day"=>$date[2],
                "hour"=>$time[0],
                "minutes"=>$time[1],
                "second"=>$time[2],
            ];
            $t0 = make_time($T['hour'],$T['minutes'],$T['second'],$T['month'],$T['day'],$T['year']);
            $tres =  mds_date('l j F y ساعت i : G',$t0,1);
            if($time[0] =="00" && $time[1] == "00")
            {
                $tres = mds_date('l j F y', $t0, 1);
                $text = "کلیه ی کلاس های استاد " ."<strong>".$TeacherName ."</strong>". " مورخ " . $tres . " تشکیل نخواهد شد ";
            }
            else
                $text = " کلاس "."<strong>".$ClassName."</strong>"." استاد "."<strong>".$TeacherName."</strong>"." مورخ ".$tres." تشکیل نخواهد شد ";

            $bot = new Telegram($config['BotToken']);
            $content = array(
                    "chat_id"=>$config['channelId'],
                    "text"=>$text,
                    "parse_mode"=>"HTML"
            );
            $bot->sendMessage($content);
        }
    }
    function showTableMessages(){
        global $conn;
        if($conn){
            echo "
        <div class='table-responsive'>
                <table class='table table-hover' id='userTable'>
                    <thead>
                        <tr class='tr'>
                            <th>حذف</th>
                            <th>ویرایش</th>
                            <th>شناسه</th>
                            <th>تاریخ کلاس</th>
                            <th>زمان کلاس</th>
                            <th>نام کلاس</th>
                            <th>نام استاد</th>
                        </tr>
                    </thead>
                    <tbody>
             ";
            $res = $conn->query("select * from Main");
            $count = $res->num_rows;
            while($count>0)
            {
                $row=$res->fetch_assoc();
                echo "
                    <tr>
                        <td>
                            <form action='User.php' method='get'>
                                <input type='hidden' name='DelID' value='".$row['ID']."'>
                                <input type='submit' class='btn' value='&times;'>
                            </form>
                        </td>
                        <td>
                            <button class='btn' onclick='showUpdateMessage(\"".$row['ID']."\");'>&cudarrl;</button>
                        </td>
                        <td>".$row['ID']."</td>
                        <td>".$row['Date']."</td>
                        <td>".$row['Time']."</td>
                        <td>".$row['ClassName']."</td>
                        <td>".$row['TeacherName']."</td>
                    </tr>
                ";
                $count--;
            }
            echo "</tbody></table></div>
            <form action='User.php' method='get' id='UpdateMessageForm'>
                <h3 class='text-center text-white'>ویرایش پیام</h3>
                <span class='closeForm' onclick='showUpdateMessage(0)'>&times;</span>
                <input type='hidden' name='UpdateID' class='input-group input-group-text' id='UpdateMessageID'>
                <input type='text' name='TeacherName' class='input-group input-group-text' placeholder='نام استاد'/>
                <input type='text' name='ClassName' class='input-group input-group-text' placeholder='نام کلاس'/>
                <input type='text' name='Time' class='input-group input-group-text' placeholder='زمان کلاس'/>
                <input type='text' name='Date' class='input-group input-group-text' placeholder='تاریخ کلاس'/>
                <input type='submit' value='تایید' class='btn-success input-group form-control'/>
            </form>
";

        }
        else
            echo "<script>alert('مشکلی در ارتباط به وجود آمده است')</script>";

    }
    function init(){
        global $config;
        if(is_null($_SESSION['Name']) && !isset($_SESSION['Name'])){
            session_destroy();
            header("Location:Login.php");
        }
        else {
            echo "<h1 class='text-center text-white'> خوش آمدید ".$_SESSION['Name']."</h1>";
            if ($_SESSION['UserName'] == $config["Admin"]) {
                showTable();
                if ($_SERVER['REQUEST_METHOD'] = 'get') {
                    if (isset($_GET['DelID']) && !is_null($_GET['DelID']) && $_GET['DelID'] != "")
                        delUser();
                    if (isset($_GET['UpdateID']) && !is_null($_GET['UpdateID']) && $_GET['UpdateID'] != "") {
                        updateUser();
                    }
                }
                if ($_SERVER['REQUEST_METHOD'] = 'POST') {
                    if (isset($_POST['Type']) && !is_null($_POST['Type']) && $_POST['Type'] == "AddUser") {
                        if (isset($_POST['Name']) && $_POST['Name'] != '' && isset($_POST['UserName']) && $_POST['UserName'] != '' && isset($_POST['PassWord']) && $_POST['PassWord'] != '')
                            addUser();
                    }
                }
            }
            else {
                if ($_SERVER['REQUEST_METHOD'] = 'get') {
                    if (isset($_GET['DelID']) && !is_null($_GET['DelID']))
                        delMessage();
                    if (isset($_GET['UpdateID']) && !is_null($_GET['UpdateID']) && $_GET['UpdateID'] != null)
                        updateMessage();
                }
                if ($_SERVER['REQUEST_METHOD'] = 'POST') {
                    if (isset($_POST['TeacherName']) && isset($_POST['ClassName']) && isset($_POST['Time']) && isset($_POST['Date'])) {
                        if ($_POST['TeacherName'] != "" && $_POST['ClassName'] != "" && $_POST['Time'] != "" && $_POST['Date'] != "") {
                            addMessages();
                        } else
                            echo "<script>alert('پیام شما ثبت نشد.... لطفا تمام فیلدها را پر کنید');</script>";
                    }
                }
                showAddMessageForm();
                showTableMessages();
            }
        }
    }
    init();
    ?>
<script>
        function setIDforUpdate(UpdateID) {
            showUpdateUser();
            $('#UpdateID').attr('value',UpdateID+'');
        }
        function showAddUser() {
            $("#AddForm").fadeToggle(2000);
            $("#btnAdd").fadeToggle(2000);
        }
        function showUpdateUser() {
            $("#UpdateForm").fadeToggle(2000);
        }
        function showAddMessage() {
            $('#AddMessage').fadeToggle(2000);
            $('#btnAddMessage').fadeToggle(2000);
        }
        function showUpdateMessage(n){
            $('#UpdateMessageForm').fadeToggle(2000);
            $('#UpdateMessageID').attr('value',n+"");
        }
        $('#AddMessage').css('display','none');
</script>
    <script src="lib/jquery-3.4.1.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>