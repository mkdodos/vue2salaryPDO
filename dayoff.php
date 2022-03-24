<?php
// 防止亂碼
header("Content-Type:text/html; charset=big5");
// CROS
header("Access-Control-Allow-Origin: *");

// $abc="2005-04-18 00:00:00";
// echo substr( $abc , 0 , 10 );

//取得打卡記錄傳回
$arr = get_cardrecord();

// { text: "姓名", value: "name" },
// { text: "日期", value: "date" },
// { text: "假別", value: "type" },
// { text: "時數", value: "hours" },

$keys = ["id","name","date","type","hours","note"];
// 有資料時才轉 json
if (count($arr) > 0) {
    $json = arr_to_json($arr, $keys);
    echo $json . "\n";
}


/* FUNCTION */

//打卡記錄
function get_cardrecord()
{
    $db = new PDO("odbc:salary");  

    //程式碼文件為 utf-8, ms access 資料庫編碼為 big5, 要做轉換才能正確查詢
    //在此用%,在資料庫內用*
    // $sql = "SELECT top 884 ID,姓名,日期,假別,時數,說明 FROM 請假紀錄 order by ID desc";  

// $sql = "SELECT 說明 FROM 請假紀錄 where ID =1708";  
$sql = "SELECT ID,姓名,日期,假別,時數,說明 FROM 請假紀錄";  
 
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
            // 字串後面有空白導致無法正確輸出 json 格式, 加上 trim            
            $newarr[urlencode($keys[$j])] = urlencode(trim($value));    
                         
            $j++;
        }

        // 原始日期 2022-01-05 00:00:00 將時分秒去掉    
        $newarr["date"] = substr( $newarr["date"] , 0 , 10 );
       
        $rows[$i] = $newarr;
    }
    // array to json
    $json = json_encode($rows);
   
    // 再用urldecode把資料轉回成中文格式
    $json = urldecode($json);
    return $json;
}
