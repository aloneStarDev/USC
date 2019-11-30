<?php

$arr = array(
    'Host'=>"localhost",
    'User'=>"Star",
    'Pass'=>"Amirhossein13781206",
    'dbName'=>"USC",
    "Admin"=>"Admin",
    "Path"=>"localhost/USC_Project",
    "BotToken"=>"1060492186:AAE_751AeUF7g6AnybLYSGHXwaO9LTBuZzI",
    "channelId"=>"-1001423453646"
);
function start()
{
    global $arr;
    $conn = new mysqli($arr['Host'], $arr['User'], $arr['Pass'], $arr['dbName']);
    $conn->query("CREATE TABLE Main ( `ID` BIGINT NOT NULL AUTO_INCREMENT , `TeacherName` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL , `Time` TIME NOT NULL , `Date` DATE NOT NULL , `ClassName` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL , `ByHow` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL , PRIMARY KEY (`ID`)) ENGINE = MyISAM;");
    $conn->query("CREATE TABLE User ( `UserID` BIGINT NOT NULL AUTO_INCREMENT , `UserName` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL , `PassWord` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL , `Name` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL , `TelegramID` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL , PRIMARY KEY (`UserID`)) ENGINE = MyISAM;");
    $pre = $conn->prepare("insert into User (UserName,PassWord,Name,TelegramID) value (?,'Admin__','ادمین','-')");
    $pre->bind_param("s", $arr["Admin"]);
    $pre->execute();
    echo "okay</br>All done...";
}
//start();
/*
 * to start run this script in your host
 */
return $arr;


