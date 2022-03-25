<?php
// 防止亂碼
header("Content-Type:text/html; charset=big5");
// CROS
header("Access-Control-Allow-Origin: *");
 

$id = isset($_GET["id"])?$_GET["id"]:"";


$db = new PDO("odbc:salary");  
$sql = "delete from 請假紀錄 where id = $id" ;
$sql = mb_convert_encoding($sql, "BIG5", "UTF-8");  
echo $sql;

try {    
    $statement = $db->prepare($sql);
    $statement->execute();    
} catch (PDOException $err) {
    print_r($err->getMessage());
}
?>