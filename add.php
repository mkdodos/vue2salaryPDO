<?php
// 防止亂碼
header("Content-Type:text/html; charset=big5");
// CROS
header("Access-Control-Allow-Origin: *");
 

$name = $_GET["name"];
$type = $_GET["type"];
$hours = $_GET["hours"];
$note = isset($_GET["note"])?$_GET["note"]:"";


$fields = "";

$db = new PDO("odbc:salary");  
$sql = "insert into 請假紀錄  (姓名,假別,時數,說明,日期) values ('$name','$type','$hours','$note','2022-01-01')";
$sql = mb_convert_encoding($sql, "BIG5", "UTF-8");  

echo $sql;
// return; 


try {

    $statement = $db->prepare($sql);

$statement->execute();


    // $rs = $db->query($sql);
} catch (PDOException $err) {
    print_r($err->getMessage());
}

$sql = "select top 1 id from 請假紀錄 order by id desc";
$sql = mb_convert_encoding($sql, "BIG5", "UTF-8"); 
$rs = $db->query($sql); 
echo $rs->fetch()[0];


?>