<?php
// 防止亂碼
header("Content-Type:text/html; charset=big5");
// CROS
header("Access-Control-Allow-Origin: *");
 
$name = $_GET["name"];
$date = isset($_GET["date"])?$_GET["date"]:"";
$type = isset($_GET["type"])?$_GET["type"]:"";
$hours = $_GET["hours"];
$note = isset($_GET["note"])?$_GET["note"]:"";
$id = isset($_GET["id"])?$_GET["id"]:"";


$db = new PDO("odbc:salary");  
$sql = "update 請假紀錄 set 姓名='$name',假別='$type',日期='$date',時數='$hours',說明='$note' where id = $id" ;
$sql = mb_convert_encoding($sql, "BIG5", "UTF-8");  
echo $sql;

try {    
    $statement = $db->prepare($sql);
    $statement->execute();    
} catch (PDOException $err) {
    print_r($err->getMessage());
}
?>