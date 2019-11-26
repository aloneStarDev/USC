<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>امور کلاس ها</title>
    <link rel="stylesheet" href="lib/bootstrap-4.3.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.css">
    <link href="lib/fontawesome-free-5.11.2-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="ROOT/Style/ClientStyle.css">
</head>
<body>
<head>
    <h1 class="text-center text-info">امور کلاس ها</h1>
    <nav class="nav nav-header">
        <a href="somelink">سایت اصلی</a>
        <a href="somelink">سایت اصلی</a>
        <a href="somelink">سایت اصلی</a>
        <a href="somelink">سایت اصلی</a>
    </nav>
</head>
<?php
    require_once("lib/PersianCalenderLib/PersianCalendar.php");
    $config = include('Config.php');
    $Host = $config['Host'];
    $User = $config['User'];
    $Pass = $config['Pass'];
    $dbName = $config['dbName'];
    $conn = new mysqli($Host,$User,$Pass,$dbName) or die("failed");
    if($conn)
    {
        $now = mds_date("Y-m-d","now",0);
        $pre = $conn->prepare("select * from Main where Date(Date) >= ?");
        $pre->bind_param("s",$now);
        if($pre->execute())
        {
            $res = $pre->get_result();
            $count =  $res->num_rows;
            while($count > 0)
            {
                $row = $res->fetch_assoc();
                $date = str_getcsv($row['Date'],'-');
                $time = str_getcsv($row["Time"],':');
                $T =["year"=>$date[0],
                    "month"=>$date[1],
                    "day"=>$date[2],
                    "hour"=>$time[0],
                    "minutes"=>$time[1],
                    "second"=>$time[2],
                ];
                $t0 = make_time($T['hour'],$T['minutes'],$T['second'],$T['month'],$T['day'],$T['year']);
                $tres =  mds_date('l j F Y ساعت i : G',$t0,1);
                if($time[0] =="00" && $time[1] == "00")
                {
                    $tres = mds_date('l j F Y', $t0, 1);
                    echo "<p class='text-center target-text'>" . "کلیه ی کلاس های استاد " . $row['TeacherName'] . " مورخ " . $tres . " تشکیل نخواهد شد " . "</p>";
                }
                else
                    echo "<p class='text-center target-text'> کلاس ".$row['ClassName']." استاد ".$row['TeacherName']." مورخ ".$tres." تشکیل نخواهد شد "."</p>";

                $count--;
            }
        }
    }

    ?>
</body>
</html>
