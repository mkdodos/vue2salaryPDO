<?php
// 防止亂碼
header("Content-Type:text/html; charset=big5");
// CROS
header("Access-Control-Allow-Origin: *");


//取得打卡記錄傳回
$arr = get_cardrecord();

$keys = ["id","name","note"];
// 有資料時才轉 json
if (count($arr) > 0) {
    $json = arr_to_json($arr, $keys);
    echo $json . "\n";
}


/* FUNCTION */

//打卡記錄
function get_cardrecord()
{
    $db = new PDO("odbc:vue2salary");     
   
    $sql = "SELECT top 2000 ID,姓名,說明 FROM 請假紀錄";  
    
 
    //程式碼文件為 utf-8, ms access 資料庫編碼為 big5, 要做轉換才能正確查詢
    // utf-8 to big5
    $sql = mb_convert_encoding($sql, "BIG5", "UTF-8");

    try {
        $rs = $db->query($sql);
    } catch (PDOException $err) {
        print_r($err->getMessage());
    }

    // 取得資料陣列
    $arr = $rs->fetchAll(PDO::FETCH_ASSOC);
    $rows = [];
    
    if (empty($arr)) {
        return $rows;
    }

    return $arr;
}


function arr_to_json($arr, $keys = [])
{
    $json = "";

    for ($i = 0; $i < count($arr); $i++) {
        $j = 0;
        foreach ($arr[$i] as $key => $value) {
            // urlencode 將資料編碼
            // 字串後面有空白導致無法正確輸出 json 格式, 加上 trim
            $newarr[urlencode($keys[$j])] = urlencode(trim($value));  
            // $newarr[urlencode($keys[$j])] = urlencode($value);                   
            $j++;
        }
        $rows[$i] = $newarr;
    }
    // array to json
    $json = json_encode($rows);
    // 再用urldecode把資料轉回成中文格式
    $json = urldecode($json);
    return $json;
}
